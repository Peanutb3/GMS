<?php

namespace App\Http\Controllers;

use App\Models\SafeLoanRequest;
use Illuminate\Http\Request;

class SafeLoanRequestController extends Controller
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
            'loan_amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Generate reference number: YYYYMM-####
        $yearMonth = now()->format('Ym'); // e.g., 202511
        $count = SafeLoanRequest::whereRaw("reference_no LIKE '{$yearMonth}-%'")->count() + 1;
        $data['reference_no'] = $yearMonth . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $req = SafeLoanRequest::create($data);

        return redirect()->route('request')
            ->with('success', 'safe-loan')
            ->with('pdf_url', route('safe-loan.print', $req));
    }

    public function show(SafeLoanRequest $requestModel)
    {
        // simple view of submission (you can style later)
        return view('safe-loan.show', ['requestModel' => $requestModel]);
    }

    public function print(SafeLoanRequest $requestModel)
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
            'copies' => 0, // No good moral copies for safe loan
            'safe_loan_amount' => $requestModel->loan_amount ?? 0,
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

        // Generate PDF like Good Moral does
        $pdf = \PDF::loadView('print', compact('req'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('safe-loan-request-' . $requestModel->reference_no . '.pdf');
    }

    public function enterOrNumber(Request $request, $id)
    {
        $request->validate([
            'or_number' => ['required', 'string', 'max:100'],
        ]);

        $safeLoanRequest = SafeLoanRequest::findOrFail($id);

        $safeLoanRequest->update([
            'or_number' => $request->or_number,
            'or_entered_at' => now(),
        ]);

        \App\Models\AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'or_entered',
            'user_id' => optional($request->user())->id,
            'staff_id' => optional($request->user()->staff ?? null)->id,
            'old_values' => ['or_number' => null],
            'new_values' => ['or_number' => $request->or_number],
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true]);
    }

    public function markDone($id)
    {
        $safeLoanRequest = SafeLoanRequest::findOrFail($id);
        $oldStatus = $safeLoanRequest->status;

        $safeLoanRequest->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        \App\Models\AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'marked_done',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => 'completed'],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('osas-gmc.requests', ['tab' => 'safeloan'])
            ->with('status', 'Safe loan request marked as completed.');
    }

    public function changeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,completed'],
        ]);

        $safeLoanRequest = SafeLoanRequest::findOrFail($id);
        $oldStatus = $safeLoanRequest->status;

        $updateData = ['status' => $request->status];
        if ($request->status === 'completed' && !$safeLoanRequest->completed_at) {
            $updateData['completed_at'] = now();
        }

        $safeLoanRequest->update($updateData);

        \App\Models\AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'status_changed',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $request->status],
            'ip_address' => request()->ip(),
        ]);

        return redirect()->route('osas-gmc.requests', ['tab' => 'safeloan'])
            ->with('status', 'Safe loan request status updated.');
    }

    public function destroy($id)
    {
        $safeLoanRequest = SafeLoanRequest::findOrFail($id);

        \App\Models\AuditLog::create([
            'auditable_type' => SafeLoanRequest::class,
            'auditable_id' => $safeLoanRequest->id,
            'action' => 'soft_deleted',
            'user_id' => auth()->id(),
            'staff_id' => optional(auth()->user())->staff_id,
            'old_values' => $safeLoanRequest->toArray(),
            'new_values' => ['deleted_at' => now()],
            'ip_address' => request()->ip(),
        ]);

        // Soft delete
        $safeLoanRequest->delete();

        return redirect()->route('osas-gmc.requests', ['tab' => 'safeloan'])
            ->with('status', 'Safe loan request deleted successfully.');
    }
}
