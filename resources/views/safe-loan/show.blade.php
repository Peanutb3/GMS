<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Safe Loan Request</title>
  @vite('resources/css/app.css')
</head>
<body class="p-6 bg-gray-50 text-sm text-gray-700">
  <h1 class="text-2xl font-bold mb-4" style="color:#8B0000;">Safe Loan Request Submitted</h1>
  <div class="bg-white shadow rounded p-4 space-y-2 max-w-xl">
    <p><span class="font-semibold">Name:</span> {{ $requestModel->last_name }}, {{ $requestModel->first_name }} {{ $requestModel->middle_name }}</p>
    <p><span class="font-semibold">Email:</span> {{ $requestModel->email ?? '—' }}</p>
    <p><span class="font-semibold">Contact:</span> {{ $requestModel->contact ?? '—' }}</p>
    <p><span class="font-semibold">Gender:</span> {{ $requestModel->gender ?? '—' }}</p>
    <p><span class="font-semibold">Program & Year:</span> {{ $requestModel->program_year ?? '—' }}</p>
    <p><span class="font-semibold">Student Status:</span> {{ $requestModel->student_status === 'currently_enrolled' ? 'Currently Enrolled' : ($requestModel->student_status === 'not_enrolled' ? 'Not Enrolled' : '—') }}</p>
    @if($requestModel->last_semester)
      <p><span class="font-semibold">Last Semester:</span> {{ $requestModel->last_semester }}</p>
    @endif
    @if($requestModel->year_graduated)
      <p><span class="font-semibold">Year Graduated:</span> {{ $requestModel->year_graduated }}</p>
    @endif
    <p><span class="font-semibold">Purpose:</span> {{ $requestModel->purpose ?? '—' }}</p>
    <p><span class="font-semibold">Loan Amount:</span> ₱{{ number_format($requestModel->loan_amount,2) }}</p>
    <p><span class="font-semibold">Status:</span> <span class="px-2 py-0.5 rounded text-white" style="background-color:#8B0000;">{{ ucfirst($requestModel->status) }}</span></p>
  </div>
  <div class="mt-6">
    <a href="{{ route('request') }}" class="inline-block px-4 py-2 rounded border" style="border-color:#8B0000;color:#8B0000;">Back to Request Page</a>
  </div>
</body>
</html>
