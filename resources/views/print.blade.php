<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Certificate Request Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
      font-family: 'Times New Roman', serif;
      font-size: 13px;
      margin: 40px;
      color: #000;
    }
  /* Font specification classes */
  .font-calibri-8 { font-family: Calibri, Arial, sans-serif; font-size:8pt; font-weight:normal; }
  .font-calibri-8-bold { font-family: Calibri, Arial, sans-serif; font-size:8pt; font-weight:bold; }
  .font-oldenglish-10 { font-family: 'Old English Text MT', 'Times New Roman', serif; font-size:10pt; font-weight:normal; }
  .font-arial-8 { font-family: Arial, Calibri, sans-serif; font-size:8pt; font-weight:normal; }
  .font-arial-12-bold { font-family: Arial, Calibri, sans-serif; font-size:12pt; font-weight:bold; }
  .form-label { font-family: Arial, Calibri, sans-serif; font-size:10pt; font-weight:bold; }
        .note {
        font-size: 12px;
        margin: 6px 0;
        font-style: italic;
        color: #a11616;
        padding: 4px 2px;
      }
      
      .cutline { position: relative; margin: 6px 0 10px; border-top: 2px dotted #000; }
      .cutline .scissors { position:absolute; top:-12px; left:-2px; font-size:14px; }
    </style>
  </head>
  <body class="bg-white p-4">
    @php
      $student = $req->student ?? null;
    @endphp
    <table class="w-full border-collapse border border-gray-400 font-sans text-base">
      <tr>
        <td class="w-60 border border-gray-400 bg-white p-3 align-top text-black">
          <img src="{{ asset('images/osas_logo.png') }}" alt="OSAS Logo" class="mx-auto h-16 w-16 object-contain" />
        </td>
        <td colspan="2" class="w-128 border border-gray-400 bg-white p-3 text-center text-black">
          <span class="font-calibri-8">Republic of the Philippines</span><br />
          <span class="font-oldenglish-10">University of Southeastern Philippines</span><br />
          <span class="font-calibri-8-bold">Office of Student Affairs and Services</span><br />
          <span class="font-calibri-8">Iñigo St., Bo. Obrero Davao City</span>
        </td>
        <td class="border border-gray-400 bg-white p-3 text-black font-arial-8">Reference No. {{ $req->reference_no ?? '__________' }}</td>
      </tr>
      <tr style="background-color: yellow;">
        <td colspan="4" class="border border-gray-400 p-3 text-center text-black font-arial-12-bold">REQUEST FOR CERTIFICATE OF GOOD MORAL CHARACTER / SAFE LOAN</td>
      </tr>
      <tr>
        <td colspan="4" class="h-2 border border-gray-400 bg-white p-3"></td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Date</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ now()->format('F d, Y') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Email</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ $student->email ?? ($req->email ?? '') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Contact</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ $student->contact ?? ($req->contact ?? '') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Student's Name</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">
          {{ $student->last_name ?? ($req->last_name ?? '') }} {{ $student->first_name ?? ($req->first_name ?? '') }} {{ $student->middle_name ?? ($req->middle_name ?? '') }}
        </td>
      </tr>
      <tr style="height: 5px; font-size: 10px; border-bottom: dashed 1px gray;">
        <td class="border border-gray-400 bg-white p-3 text-black"></td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black"></td>
        <td colspan="2" class="border border-gray-400 bg-white p-1 text-black">(Last Name) (First Name) (Middle Name).</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Gender</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">
          ({{ (($student->gender ?? $req->gender ?? '') === 'Female') ? '✔' : ' ' }}) Female
          ({{ (($student->gender ?? $req->gender ?? '') === 'Male') ? '✔' : ' ' }}) Male
          ({{ (($student->gender ?? $req->gender ?? '') === 'Prefer not to say') ? '✔' : ' ' }}) Prefer not to Say
        </td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Course and Year</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ $student->program ?? ($req->program_year ?? '') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Student's Status</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">
          ({{ (($student->status ?? null) === 'Currently Enrolled' || ($req->student_status ?? null) === 'currently_enrolled') ? '✔' : ' ' }}) Currently Enrolled<br />
          ({{ (($student->status ?? null) === 'Not Enrolled' || ($req->student_status ?? null) === 'not_enrolled') ? '✔' : ' ' }}) Not Enrolled (pls. specify last Sem. &amp; SY) {{ $req->last_sem_sy ?? '________________' }}
        </td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Year Graduated (If Applicable)</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ $student->year_graduated ?? ($req->year_graduated ?? '') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Purpose</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
  <td colspan="2" class="border border-gray-400 bg-white p-3 text-black">{{ $req->purpose ?? '' }}</td>
      </tr>
    </table>
    <p class="note">NOTE: Attach Official Receipt (OR) issued by the University Cashier’s Office and present the OR to the OSAS Staff.</p>

    <div class="cutline"><span class="scissors">✂</span></div>

    <table class="mt-6 w-full border-collapse border border-gray-400 font-sans text-base">
      <tr>
        <td class="w-60 border border-gray-400 bg-white p-3 align-top text-black">
          <img src="{{ asset('images/osas_logo.png') }}" alt="OSAS Logo" class="mx-auto h-16 w-16 object-contain" />
        </td>
        <td colspan="4" class="w-128 border border-gray-400 bg-white p-3 text-center text-black">
          <span class="font-calibri-8">Republic of the Philippines</span><br />
          <span class="font-oldenglish-10">University of Southeastern Philippines</span><br />
          <span class="font-calibri-8-bold">Office of Student Affairs and Services</span><br />
          <span class="font-calibri-8">Iñigo St., Bo. Obrero Davao City</span>
        </td>
        <td class="border border-gray-400 bg-white p-3 text-black font-arial-8">Reference No. {{ $req->reference_no ?? '__________' }}</td>
      </tr>
      <tr style="background-color: maroon;">
        <td colspan="6" class="border border-gray-400 p-3 text-center text-white font-arial-12-bold">PAYMENT ORDER SLIP</td>
      </tr>
      <tr>
        <td colspan="6" class="h-2 border border-gray-400 bg-white p-3"></td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Date</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="4" class="border border-gray-400 bg-white p-3 text-black">{{ now()->format('F d, Y') }}</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Student's Name</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="4" class="border border-gray-400 bg-white p-3 text-black">
          {{ $student->last_name ?? ($req->last_name ?? '') }} {{ $student->first_name ?? ($req->first_name ?? '') }} {{ $student->middle_name ?? ($req->middle_name ?? '') }}
        </td>
      </tr>
      <tr style="height: 5px; font-size: 10px; border-bottom: dashed 1px gray;">
        <td class="border border-gray-400 bg-white p-3 text-black"></td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black"></td>
        <td colspan="4" class="border border-gray-400 bg-white p-1 text-black">(Last Name) (First Name) (Middle Name).</td>
      </tr>
      <tr style="border-bottom: dashed 1px gray;">
  <td class="border border-gray-400 bg-white p-3 text-black form-label">Course and Year</td>
        <td class="w-4 border border-gray-400 bg-white p-3 text-black">:</td>
        <td colspan="4" class="border border-gray-400 bg-white p-3 text-black">{{ $student->program ?? ($req->program_year ?? '') }}</td>
      </tr>
      </table>

      @php
        $copies = $req->copies ?? 1;
        $gmCost = 70 * $copies;
        $safeLoan = $req->safe_loan_amount ?? 0;
        $total = $gmCost + $safeLoan;
      @endphp
      <table class="w-full border-collapse border border-gray-400 font-sans text-base">
        <tr>
          <td rowspan="4" colspan="" class="w-160 border border-gray-400 bg-white p-3 text-black"></td>
          <!-- <td class="border border-gray-400 bg-white p-3 text-black"></td> -->
          <td class="w-100 border border-gray-400 bg-white p-3 text-right text-black">Description</td>
          <td class="border border-gray-400 bg-white p-3 text-center text-black">Cost</td>
        </tr>
        <tr>
          <!-- <td class="border border-gray-400 bg-white p-3 text-black"></td> -->
          <td class="border border-gray-400 bg-white p-3 text-right text-black">Certificate of Good Moral Character (70.00 per copy)</td>
          <td class="border border-gray-400 bg-white p-3 text-black">₱{{ number_format($gmCost, 2) }}</td>
        </tr>
        <tr>
          <!-- <td class="border border-gray-400 bg-white p-3 text-black"></td> -->
          <td class="border border-gray-400 bg-white p-3 text-right text-black">Safe Loan</td>
          <td class="border border-gray-400 bg-white p-3 text-black">₱{{ number_format($safeLoan, 2) }}</td>
        </tr>
        <tr>
          <!-- <td class="border border-gray-400 bg-white p-3 text-black"></td> -->
          <td class="border border-gray-400 bg-white p-3 text-right text-black">Total Amount</td>
          <td class="border border-gray-400 bg-white p-3 text-black">₱{{ number_format($total, 2) }}</td>
        </tr>
      </table>
    <div class="sign">
      <p class="p-3 text-center text-base">By: _________________________________________<br />OSAS Staff</p>
    </div>
  </body>
</html>


