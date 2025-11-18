<?php

namespace App\Http\Controllers;

use App\Models\GoodMoralRequest;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GoodMoralRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['nullable','exists:students,id'],
            'staff_id' => ['nullable','exists:staff,id'],
            'date_needed' => ['nullable', 'date'],
            'email' => ['nullable', 'email'],
            'contact' => ['nullable', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['nullable', 'in:Female,Male,Prefer not to say'],
            'program_year' => ['nullable', 'string', 'max:150'],
            'student_status' => ['nullable', 'in:currently_enrolled,not_enrolled'],
            'last_semester' => ['nullable', 'string', 'max:150'],
            'year_graduated' => ['nullable', 'string', 'max:20'],
            'purpose' => ['nullable', 'string', 'max:500'],
            'copies' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        // Generate reference number: GMR-YYYY-XXX
        $next = GoodMoralRequest::count() + 1;
        $data['reference_no'] = 'GMR-' . now()->format('Y') . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);

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

        return redirect()->route('good-moral.print', $req);
    }

    public function print(GoodMoralRequest $requestModel)
    {
        // Reuse existing print.blade with $req variable expected
        $req = (object) [
            'reference_no' => $requestModel->reference_no,
            'student' => (object) [
                'email' => $requestModel->email,
                'contact' => $requestModel->contact,
                'last_name' => $requestModel->last_name,
                'first_name' => $requestModel->first_name,
                'middle_name' => $requestModel->middle_name,
                'gender' => $requestModel->gender,
                'program' => $requestModel->program_year,
                'year_level' => null,
                'status' => $requestModel->student_status === 'currently_enrolled' ? 'Currently Enrolled' : 'Not Enrolled',
                'year_graduated' => $requestModel->year_graduated,
            ],
            'purpose' => $requestModel->purpose,
            'copies' => $requestModel->copies,
        ];

        return view('print', compact('req'));
    }
}



