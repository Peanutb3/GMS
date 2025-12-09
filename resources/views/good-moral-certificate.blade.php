<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Good Moral Character</title>
    <style>
        @page {
            size: A4;
            margin: 1.0in 1.0in 0.25in 1.1in;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            /* line-height: 1.0; */
        }

        .header {
            text-align: center;
            margin-top: 10pt;
            /* reduced to match actual certificate */
        }

        .logo {
            width: 80pt;
            height: auto;
            margin-bottom: 4pt;
        }


        .university-name {
            font-size: 18pt;
            font-family: 'Cinzel', serif;
            font-weight: bold;
            margin: 0;
            padding: 0;
        }

        .office-name {
            font-size: 14pt;
            font-family: 'Times New Roman', serif;
            font-style: italic;
            margin: 0;
        }

        .title {
            font-size: 18pt;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            text-align: center;
            margin: 25pt 0 18pt 0;
            /* Adjusted spacing */
        }

        .to-whom {
            font-size: 14pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: left;
            margin: 0 0 12pt 0;
        }

        .content p {
            font-family: Arial, sans-serif;
            font-size: 13pt;
            text-align: justify;
            text-indent: 0.5in;
            margin: 0 0 12pt 0;
            line-height: 115%;
        }

        .student-name {
            font-weight: bold;
            text-transform: uppercase;
        }

        .signature-section {
            margin-top: 24pt;
            text-align: right;
        }

        .director-name {
            font-size: 12pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
            margin: 0;
        }

        .director-title {
            font-size: 12pt;
            font-family: Arial, sans-serif;
            text-align: center;
            /* margin: 0; */
            margin-right: 70px;
            text-align: right;
        }

        .validation-section {
            margin-top: 24pt;
            font-size: 14pt;
            font-family: 'Times New Roman', serif;
        }

        .validation-left {
            line-height: 1.2;
        }

        .signature-block {
            float: right;
            text-align: right;
            margin-right: 0;
        }

        .signature-line {
            font-size: 10pt;
            margin-bottom: 0;
            text-align: center;
        }

        .signature-label {
            font-size: 8pt;
            font-family: 'Century Gothic', sans-serif;
            font-weight: bold;
            font-style: italic;
            margin: 0;
        }

        .date-line {
            font-size: 7.5pt;
            font-family: 'Century Gothic', sans-serif;
            font-weight: bold;
            font-style: italic;
            margin: 4pt 0;
        }

        .contact-line {
            font-size: 7.5pt;
            font-family: 'Century Gothic', sans-serif;
            font-weight: bold;
            font-style: italic;
            margin: 0;
        }

        .footer {
            width: 100%;
            margin-top: 40pt;
            font-size: 9pt;
            font-family: 'Arial Narrow', Arial, sans-serif;
        }

        .footer-line {
            width: 100%;
            border-bottom: 1px solid #000;
            margin-bottom: 6pt;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }

        .footer-text {
            line-height: 1.3;
            width: 65%;
        }

        .footer-logos {
            display: flex;
            gap: 10px;
            align-items: flex-end;
        }

        .footer-logos img {
            height: 0.78in;
            object-fit: contain;
        }

        .footer-logos img:last-child {
            height: 0.70in;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/USeP_logo.png') }}" alt="USeP Logo" class="logo">
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

        <p>
            Issued this {{ now()->format('jS') }} day of {{ now()->format('F Y') }}.
        </p>
    </div>

    <div class="signature-section">
        <div class="director-name">JOSE ALTHER M. RIVERA, Ed.D</div>
        <div class="director-title">Director</div>
    </div>

    <div class="validation-section">
        <div class="validation-left">
            Not valid without<br>University Seal<br><strong>OR No.: {{ $request->or_number }}</strong>
        </div>

        <div class="signature-block">
            <div class="signature-line">______________________</div>
            <div class="signature-label">Signature over Printed Name</div>
            <div class="date-line">Date: _____________________</div>
            <div class="contact-line">Contact No. _________________</div>
        </div>
    </div>

    <div class="footer">
        <div class="footer-line"></div>

        <div class="footer-content">

            <div class="footer-text">
                <strong>VISION: PREMIER RESEARCH UNIVERSITY TRANSFORMING<br>
                    COMMUNITIES IN THE ASEAN AND BEYOND</strong><br>
                University of Southeastern Philippines &nbsp;&nbsp; (082) 227-8192 local 207<br>
                Iñigo St., Bo. Obrero, Davao City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; www.usep.edu.ph<br>
                Philippines 8000 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; osas@usep.edu.ph
            </div>

            <div class="footer-logos">
                <img src="{{ public_path('images/footer_logo.png') }}" alt="Footer Logo">
                <img src="{{ public_path('images/ISO_logo.png') }}" alt="ISO Logo">
            </div>

        </div>
    </div>
</body>

</html>