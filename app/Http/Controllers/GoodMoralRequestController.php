<?php

namespace App\Http\Controllers;

use App\Models\GoodMoralRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class GoodMoralRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['nullable', 'exists:students,id'],
            'staff_id' => ['nullable', 'exists:staff,id'],
            'date_needed' => ['nullable', 'date'],
            'email' => ['nullable', 'email'],
            'contact' => ['nullable', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['nullable', 'in:Female,Male,Prefer not to say'],
            'college' => ['nullable', 'string', 'max:150'],
            'program' => ['nullable', 'string', 'max:150'],
            'year' => ['nullable', 'string', 'max:50'],
            'student_status' => ['nullable', 'in:currently_enrolled,not_enrolled'],
            'last_semester' => ['nullable', 'string', 'max:150'],
            'from_sy' => ['nullable', 'string', 'max:50'],
            'to_sy' => ['nullable', 'string', 'max:50'],
            'year_graduated' => ['nullable', 'string', 'max:20'],
            'purpose' => ['nullable', 'string', 'max:500'],
            'copies' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        // Generate reference number: YYYYMM-####
        $yearMonth = now()->format('Ym'); // e.g., 202511
        $count = GoodMoralRequest::whereRaw("reference_no LIKE '{$yearMonth}-%'")->count() + 1;
        $data['reference_no'] = $yearMonth . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $req = GoodMoralRequest::create($data);

        AuditLog::create([
            'auditable_type' => GoodMoralRequest::class,
            'auditable_id' => $req->id,
            'action' => 'created',
            'user_id' => optional($request->user())->id,
            'staff_id' => optional($request->user()->staff ?? null)->id,
            'old_values' => null,
            'new_values' => $req->snapshot(),
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('request')
            ->with('success', 'good-moral')
            ->with('pdf_url', route('good-moral.print', $req));
    }

    public function print(GoodMoralRequest $requestModel)
    {
        // Reuse existing print.blade with $req variable expected
        $req = (object) [
            'reference_no' => $requestModel->reference_no,
            'date_needed' => $requestModel->date_needed,
            'email' => $requestModel->email,
            'contact' => $requestModel->contact,
            'last_name' => $requestModel->last_name,
            'first_name' => $requestModel->first_name,
            'middle_name' => $requestModel->middle_name,
            'gender' => $requestModel->gender,
            'college' => $requestModel->college,
            'program' => $requestModel->program,
            'year' => $requestModel->year,
            'student_status' => $requestModel->student_status,
            'last_semester' => $requestModel->last_semester,
            'from_sy' => $requestModel->from_sy,
            'to_sy' => $requestModel->to_sy,
            'year_graduated' => $requestModel->year_graduated,
            'purpose' => $requestModel->purpose,
            'copies' => $requestModel->copies,
            'safe_loan_amount' => $requestModel->safe_loan_amount ?? 0,
            'student' => (object) [
                'email' => $requestModel->email,
                'contact' => $requestModel->contact,
                'last_name' => $requestModel->last_name,
                'first_name' => $requestModel->first_name,
                'middle_name' => $requestModel->middle_name,
                'gender' => $requestModel->gender,
                'program' => $requestModel->program,
                'year' => $requestModel->year,
                'year_level' => null,
                'status' => $requestModel->student_status === 'currently_enrolled' ? 'Currently Enrolled' : 'Not Enrolled',
                'year_graduated' => $requestModel->year_graduated,
            ],
        ];

        // Generate PDF
        $pdf = \PDF::loadView('print', compact('req'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('good-moral-request-' . $requestModel->reference_no . '.pdf');
    }

    public function enterOrNumber(Request $request, GoodMoralRequest $goodMoralRequest)
    {
        $request->validate([
            'or_number' => ['required', 'string', 'max:100'],
        ]);

        $goodMoralRequest->update([
            'or_number' => $request->or_number,
            'or_entered_at' => now(),
        ]);

        AuditLog::create([
            'auditable_type' => GoodMoralRequest::class,
            'auditable_id' => $goodMoralRequest->id,
            'action' => 'or_entered',
            'user_id' => optional($request->user())->id,
            'staff_id' => optional($request->user()->staff ?? null)->id,
            'old_values' => ['or_number' => null],
            'new_values' => ['or_number' => $request->or_number],
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('good-moral.certificate', $goodMoralRequest);
    }

    public function showCertificate(GoodMoralRequest $goodMoralRequest)
    {
        if (!$goodMoralRequest->or_number) {
            return redirect()->route('osas-gmc.requests')
                ->with('error', 'OR number must be entered first.');
        }

        $pdf = Pdf::loadView('good-moral-certificate', ['request' => $goodMoralRequest])
            ->setPaper('a4', 'portrait');

        return response($pdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Good_Moral_Certificate_' . $goodMoralRequest->reference_no . '.pdf"');
    }

    public function markCompleted(GoodMoralRequest $goodMoralRequest)
    {
        $goodMoralRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        AuditLog::create([
            'auditable_type' => GoodMoralRequest::class,
            'auditable_id' => $goodMoralRequest->id,
            'action' => 'completed',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => ['status' => 'pending'],
            'new_values' => ['status' => 'completed'],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('osas-gmc.requests', ['tab' => 'history'])
            ->with('status', 'Request marked as completed.');
    }

    public function destroy(GoodMoralRequest $goodMoralRequest)
    {
        AuditLog::create([
            'auditable_type' => GoodMoralRequest::class,
            'auditable_id' => $goodMoralRequest->id,
            'action' => 'deleted',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => $goodMoralRequest->snapshot(),
            'new_values' => null,
            'ip_address' => request()->ip(),
        ]);

        $goodMoralRequest->delete();

        return redirect()->route('osas-gmc.requests')
            ->with('status', 'Good moral request deleted successfully.');
    }
}
