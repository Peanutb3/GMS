<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Good Moral Character</title>
    <style>
        @page {
            size: A4;
            margin: 0.4in 1.0in 0.3in 1.1in;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 13pt;
            /* margin: 0; */
            padding: 0;
            /* line-height: 1.0; */
        }

        .header {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10pt;
        }

        .logo {
            width: 1.1in;
            height: 1.1in;
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
            margin-bottom: 43pt;
        }

        .title {
            font-size: 18pt;
            font-family: 'Times New Roman', serif;
            font-weight: bold;
            text-align: center;
            /* margin: 25pt 0 18pt 0; */
            margin-bottom: 28pt;
            /* Adjusted spacing */
        }

        .to-whom {
            font-size: 14pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
            text-align: left;
            margin: 0 0 24pt 0;
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
            margin-top: 35pt;
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
            margin-top: 36pt;
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
            margin-top: 14pt;
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
            width: calc(100% + 0.48in);
            margin-left: -0.38in;
            padding-top: 40pt;
            font-size: 9pt;
            font-family: Arial, sans-serif;
            padding-top: 840px;
            position: fixed;
        }

        .footer-line {
            width: 54%;
            border-bottom: 1px solid #000;
            margin-bottom: 4pt;
            padding-bottom: 110px;
        }

        .footer-content {
            display: table;
            width: 105%;
            table-layout: auto;
            /* margin-bottom: 20px; */
        }

        .footer-text {
            display: table-cell;
            line-height: 1.3;
            width: 55%;
            text-align: left;
            vertical-align: bottom;
        }

        .footer-text-inner {
            transform: scaleX(0.85);
            transform-origin: left center;
        }

        .footer-logos {
            display: table-cell;
            width: 50%;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-logos img {
            display: inline-block;
            height: 0.79in;
            width: 1.69in;
            vertical-align: bottom;
            /* margin-left: 5px; */
        }

        .footer-logos img:first-child {
            margin-left: 0;
        }

        .footer-logos img:last-child {
            height: 0.72in;
            width: 1.42in;
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
            This is to certify that <strong>{{ $request->gender === 'Male' ? 'Mr.' : 'Ms.' }}</strong> <span class="student-name">{{ strtoupper($request->first_name) }} {{ $request->middle_name ? strtoupper(substr($request->middle_name, 0, 1)) . '.' : '' }} {{ strtoupper($request->last_name) }}</span>
            is a bonafide student of the {{ $request->college ?? 'University' }}{{ $request->program ? ', enrolled in the program <strong>' . $request->program . '</strong>' : '' }}, at the University of Southeastern Philippines, Bo. Obrero St., Davao City{{ ($request->from_sy && $request->to_sy) ? ', from SY ' . $request->from_sy . ' to SY ' . $request->to_sy : '' }}.
        </p>

        <p>
            During {{ $request->gender === 'Male' ? 'his' : 'her' }} stay at the University, {{ $request->gender === 'Male' ? 'he' : 'she' }} has not engaged in any activity
            that is derogatory to {{ $request->gender === 'Male' ? 'his' : 'her' }} character. Furthermore, {{ $request->gender === 'Male' ? 'he' : 'she' }} has not violated any rules
            and regulations of the institution.
        </p>

        <p>
            This certification is issued upon the request of <strong>{{ $request->gender === 'Male' ? 'Mr.' : 'Ms.' }} {{ ucfirst(strtolower($request->last_name)) }}</strong>
            for {{ strtolower($request->purpose) }} only.
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
                <div class="footer-text-inner">
                    <strong>VISION: PREMIER RESEARCH UNIVERSITY TRANSFORMING<br>
                        COMMUNITIES IN THE ASEAN AND BEYOND</strong><br>
                    University of Southeastern Philippines &nbsp;&nbsp; (082) 227-8192 local 207<br>
                    Iñigo St., Bo. Obrero, Davao City &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; www.usep.edu.ph<br>
                    Philippines 8000 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; osas@usep.edu.ph
                </div>
            </div>

            <div class="footer-logos">
                <img src="{{ public_path('images/footer_logo.png') }}" alt="Footer Logo">
                <img src="{{ public_path('images/ISO_logo.png') }}" alt="ISO Logo">
            </div>

        </div>
    </div>
</body>

</html>
