<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Good Moral Character</title>
    <style>
        @page { size: A4; margin: 0; }
        body { 
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 40px 60px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }
        .university-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .office-name {
            font-size: 14px;
            font-style: italic;
            margin: 5px 0;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin: 30px 0;
            letter-spacing: 2px;
        }
        .to-whom {
            font-weight: bold;
            margin: 20px 0;
        }
        .content {
            text-align: justify;
            font-size: 14px;
            margin: 20px 0;
        }
        .student-name {
            font-weight: bold;
            text-transform: uppercase;
        }
        .issued-date {
            margin: 30px 0;
        }
        .signature-section {
            margin-top: 50px;
            text-align: right;
        }
        .director-name {
            font-weight: bold;
            margin-top: 50px;
        }
        .director-title {
            font-size: 13px;
        }
        .footer {
            margin-top: 40px;
            font-size: 12px;
        }
        .or-info {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 12px;
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #800000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }
        .print-button:hover {
            background: #600000;
        }
        @media print {
            .print-button { display: none; }
            .complete-button { display: none; }
            body { padding: 20px 40px; }
        }
        .complete-button {
            margin: 20px auto;
            padding: 12px 30px;
            background-color: #15803d;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .complete-button:hover {
            background-color: #166534;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Certificate</button>
    <form method="POST" action="{{ route('good-moral.mark-completed', $request->id) }}" style="text-align: center;">
        @csrf
        <button type="submit" class="complete-button"
                onclick="return confirm('Mark this request as completed? It will be moved to history.')">
            ✓ Mark as Completed
        </button>
    </form>

    <div class="header">
        <img src="{{ asset('images/Logo_GMS.png') }}" alt="USeP Logo" class="logo">
        <div class="university-name">University of Southeastern Philippines</div>
        <div class="office-name">Office of Student Affairs and Services</div>
    </div>

    <div class="title">CERTIFICATE OF GOOD MORAL CHARACTER</div>

    <div class="to-whom">To Whom It May Concern:</div>

    <div class="content">
        <p>
            This is to certify that <span class="student-name">{{ strtoupper($request->last_name) }}, {{ strtoupper($request->first_name) }} {{ $request->middle_name ? strtoupper(substr($request->middle_name, 0, 1)) . '.' : '' }}</span> 
            is a bonafide student of the {{ $request->program_year ?? 'University' }}, 
            at the University of Southeastern Philippines, Bo. Obrero St., Davao City.
        </p>

        <p>
            During {{ $request->gender === 'Male' ? 'his' : 'her' }} stay at the University, {{ $request->gender === 'Male' ? 'he' : 'she' }} has not engaged in any activity 
            that is derogatory to {{ $request->gender === 'Male' ? 'his' : 'her' }} character. Furthermore, {{ $request->gender === 'Male' ? 'he' : 'she' }} has not violated any rules 
            and regulations of the institution.
        </p>

        <p>
            This certification is issued upon the request of <span class="student-name">{{ $request->gender === 'Male' ? 'Mr.' : 'Ms.' }} {{ ucfirst($request->last_name) }}</span> 
            for {{ strtolower($request->purpose) }}.
        </p>

        <p class="issued-date">
            Issued this {{ now()->format('jS') }} day of {{ now()->format('F Y') }}.
        </p>
    </div>

    <div class="signature-section">
        <div class="director-name">JOSE ALTHER M. RIVERA, Ed.D</div>
        <div class="director-title">Director</div>
    </div>

    <div class="footer">
        <strong>Not valid without<br>University Seal<br>OR No.: {{ $request->or_number }}</strong>
        
        <div class="or-info">
            <div>
                <strong>VISION: PREMIER RESEARCH UNIVERSITY TRANSFORMING<br>
                COMMUNITIES IN THE ASEAN AND BEYOND</strong><br>
                University of Southeastern Philippines (082) 227-8192 local 207<br>
                Inigo St., Bo. Obrero, Davao City www.usep.edu.ph<br>
                Philippines 8000 osas@usep.edu.ph
            </div>
        </div>
    </div>
</body>
</html>
