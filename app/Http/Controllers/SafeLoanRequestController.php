<?php

namespace App\Http\Controllers;

use App\Models\SafeLoanRequest;
use Illuminate\Http\Request;

class SafeLoanRequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => ['nullable','exists:students,id'],
            'staff_id' => ['nullable','exists:staff,id'],
            'date_needed' => ['nullable','date'],
            'email' => ['nullable','email'],
            'contact' => ['nullable','string','max:50'],
            'first_name' => ['required','string','max:100'],
            'middle_name' => ['nullable','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'gender' => ['nullable','in:Female,Male,Prefer not to say'],
            'program_year' => ['nullable','string','max:150'],
            'student_status' => ['nullable','in:currently_enrolled,not_enrolled'],
            'last_semester' => ['nullable','string','max:150'],
            'year_graduated' => ['nullable','string','max:20'],
            'purpose' => ['nullable','string','max:500'],
            'loan_amount' => ['nullable','numeric','min:0'],
        ]);

        // Generate reference number: YYYYMM-####
        $yearMonth = now()->format('Ym'); // e.g., 202511
        $count = SafeLoanRequest::whereRaw("reference_no LIKE '{$yearMonth}-%'")->count() + 1;
        $data['reference_no'] = $yearMonth . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $req = SafeLoanRequest::create($data);

        return redirect()->route('safe-loan.show', $req);
    }

    public function show(SafeLoanRequest $requestModel)
    {
        // simple view of submission (you can style later)
        return view('safe-loan.show', ['requestModel' => $requestModel]);
    }

    public function print(SafeLoanRequest $requestModel)
    {
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
            // Copies not applicable to safe loan; keep 1 for payment row compatibility
            'copies' => 1,
        ];

        return view('print', compact('req'));
    }
}
