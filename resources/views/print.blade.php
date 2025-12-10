<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Certificate Request Form</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 0.3in;
        }

        body {
            margin: 0;
            padding: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }

        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s49 {
            border-bottom: 2px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s25 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s1 {
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s23 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: normal;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s8 {
            border-bottom: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s10 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s24 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s29 {
            border-bottom: 1px DASHED #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            font-style: italic;
            color: #ff0000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s15 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            font-style: italic;
            color: #000000;
            font-family: Arial;
            font-size: 7pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s32 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #c00000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            text-align: center;
            font-weight: bold;
            color: #ffffff;
            font-family: Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s47 {
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s33 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s9 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s31 {
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #c00000;
            font-family: 'Old English Text MT', Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s37 {
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s3 {
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #c00000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s13 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s13name {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s45 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s39 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s4 {
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s16 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 7pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s7 {
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s20 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 7pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s26 {
            border-bottom: 2px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s41 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: normal;
            overflow: hidden;
            word-wrap: break-word;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s17 {
            border-bottom: 1px DASHED #aeabab;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s19 {
            border-left: none;
            border-bottom: 1px DASHED #aeabab;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s22 {
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s2 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s6 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffc000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 12pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s11 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s35 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s21 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s46 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 11pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s5 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 8pt;
            vertical-align: middle;
            white-s pace: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s43 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s14 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 7pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s27 {
            border-bottom: 2px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s34 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s30 {
            border-bottom: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s48 {
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s44 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 11pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s36 {
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s38 {
            border-bottom: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s42 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: right;
            color: #000000;
            font-family: Arial;
            font-size: 11pt;
            vertical-align: bottom;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s28 {
            border-bottom: 2px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s18 {
            border-bottom: 1px DASHED #aeabab;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 9pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s12 {
            border-bottom: 1px DASHED #aeabab;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: left;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s40 {
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 2px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            font-weight: bold;
            color: #000000;
            font-family: Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle .s0 {
            border-left: 2px SOLID #7f7f7f;
            border-bottom: 1px SOLID #7f7f7f;
            border-right: 1px SOLID #7f7f7f;
            background-color: #ffffff;
            text-align: center;
            color: #000000;
            font-family: Calibri, Arial;
            font-size: 10pt;
            vertical-align: middle;
            white-space: nowrap;
            direction: ltr;
            padding: 0px 3px 0px 3px;
        }

        .ritz .waffle {
            border-collapse: collapse;
        }

        .ritz table.waffle {
            width: 100%;
            max-width: 720px;
            border-left: 2px solid #7f7f7f;
            border-top: 2px solid #7f7f7f;
        }

        .cutline {
            margin: 10px 0;
            border-top: 2px dashed #7f7f7f;
            position: relative;
        }

        .scissors {
            position: absolute;
            top: -15px;
            left: -10;
        }
    </style>
</head>

<body>
    @php
    $student = $req->student ?? null;
    $copies = $req->copies ?? 1;
    $gmCost = 70 * $copies;
    $safeLoan = $req->safe_loan_amount ?? 0;
    $total = $gmCost + $safeLoan;
    @endphp

    <div class="ritz grid-container" dir="ltr">
        <table class="waffle" cellspacing="0" cellpadding="0">
            <tbody>
                <tr style="height: 11px">
                    <td class="s0" rowspan="4" style="width:164px;">
                        <img src="{{ public_path('images/Usep_logo2.png') }}" alt="USeP Logo" style="width: 0.58in; height: 0.59in; display: block; margin: 0 auto;">
                    </td>
                    <td class="s1" colspan="6" style="width:464px;">Republic of the Philippines</td>
                    <td class="s2" colspan="2" rowspan="4" style="width:137px;">Reference No. {{ $req->reference_no ?? '__________________' }}</td>
                </tr>
                <tr style="height: 14px">
                    <td class="s3" colspan="6">University of Southeastern Philippines</td>
                </tr>
                <tr style="height: 12px">
                    <td class="s4" colspan="6">Office of Student Affairs and Services</td>
                </tr>
                <tr style="height: 14px">
                    <td class="s5" colspan="6">Iñigo St., Bo. Obrero Davao City</td>
                </tr>
                <tr style="height: 23px">
                    <td class="s6" colspan="9">REQUEST FOR CERTIFICATE OF GOOD MORAL CHARACTER /SAFE LOAN</td>
                </tr>
                <tr style="height: 3px">
                    <td class="s7" colspan="9"></td>
                </tr>
                <tr style="height: 3px">
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s8"></td>
                    <td class="s9"></td>
                </tr>
                <tr style="height: 22px">
                    <td class="s10">Date</td>
                    <td class="s11">:</td>
                    <td class="s12" colspan="7">{{ now()->format('F d, Y') }}</td>
                </tr>
                <tr style="height: 26px">
                    <td class="s10">Email:</td>
                    <td class="s11">:</td>
                    <td class="s13" colspan="7">{{ $student->email ?? ($req->email ?? '') }}</td>
                </tr>
                <tr style="height: 22px">
                    <td class="s10">Contact:</td>
                    <td class="s11">:</td>
                    <td class="s13" colspan="7">{{ $student->contact ?? ($req->contact ?? '') }}</td>
                </tr>
                <tr style="height: 26px">
                    <td class="s10">Student's Name</td>
                    <td class="s11">:</td>
                    <!-- <td class="s13" colspan="7">,  </td> -->
                    <td class="s13name" colspan="2" style="border-right: 1px solid transparent;">{{ $student->last_name ?? ($req->last_name ?? '') }},</td>
                    <td class="s13name" colspan="2" style="border-right: 1px solid transparent;">{{ $student->first_name ?? ($req->first_name ?? '') }}</td>
                    <td class="s13name" colspan="3">{{ $student->middle_name ?? ($req->middle_name ?? '') }}</td>
                </tr>
                <tr style="height: 12px">
                    <td class="s10"></td>
                    <td class="s14"></td>
                    <td class="s15" colspan="2" style=" border-right: 1px solid transparent;">(Last Name)</td>
                    <td class="s15" colspan="2" style=" border-right: 1px solid transparent;">(First Name)</td>
                    <td class="s15" colspan="3">(Middle Name)</td>
                </tr>
                <tr style="height: 16px">
                    <td class="s10">Gender</td>
                    <td class="s11">:</td>
                    <td class="s17">( {{ (($student->gender ?? $req->gender ?? '') === 'Female') ? '/' : ' ' }} ) Female </td>
                    <td class="s17"></td>
                    <td class="s17">( {{ (($student->gender ?? $req->gender ?? '') === 'Male') ? '/' : ' ' }} ) Male </td>
                    <td class="s17"></td>
                    <td class="s18" colspan="2">( {{ (($student->gender ?? $req->gender ?? '') === 'Prefer not to say') ? '/' : ' ' }} ) Prefer not to Say</td>
                    <td class="s20"></td>
                </tr>
                <tr style="height: 16px">
                    <td class="s10">Course and Year</td>
                    <td class="s11">:</td>
                    <td class="s13" colspan="7">@php($prog = $student->program ?? ($req->program ?? ''))@php($yr = $student->year ?? ($req->year ?? '')){{ $prog }}@if(!empty($yr)) {{ ' - ' . $yr }}@endif</td>
                </tr>
                <tr style="height: 17px">
                    <td class="s10" rowspan="2">Student's Status</td>
                    <td class="s21" rowspan="2">:</td>
                    <td class="s22" colspan="7">( {{ (($student->status ?? null) === 'Currently Enrolled' || ($req->student_status ?? null) === 'currently_enrolled') ? '/' : ' ' }} ) Currently Enrolled</td>
                </tr>
                <tr style="height: 14px">
                    <td class="s23" colspan="7">( {{ (($student->status ?? null) === 'Not Enrolled' || ($req->student_status ?? null) === 'not_enrolled') ? '/' : ' ' }} ) Not Enrolled (pls. specify last Sem. &amp; SY) <span style="text-decoration: underline;">{{ $req->last_semester ?? '____________________________' }}@if(($req->from_sy ?? null) || ($req->to_sy ?? null)) {{ ' & SY ' . ($req->from_sy ?? '') . ' - SY ' . ($req->to_sy ?? '') }}@endif</span></td>
                </tr>
                <tr style="height: 16px">
                    <td class="s10">Year Graduated <span style="font-size:8pt;font-family:Arial;font-weight:bold;font-style:italic;color:#000000;">(If Applicable)</span></td>
                    <td class="s24">:</td>
                    <td class="s25" colspan="7">{{ $student->year_graduated ?? ($req->year_graduated ?? '') }}</td>
                </tr>
                <tr style="height: 24px">
                    <td class="s26">Purpose</td>
                    <td class="s27">:</td>
                    <td class="s28" colspan="7">{{ $req->purpose ?? '' }}</td>
                </tr>
                <tr style="height: 21px">
                    <td class="s29" colspan="9">NOTE: Attach Official Receipt (OR) issued by the University Cashier's Office and present the OR to the OSAS Staff.</td>
                </tr>
                <tr style="height: 7px">
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                    <td class="s30"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="cutline"><span class="scissors">✂</span></div>

    <div class="ritz grid-container" dir="ltr">
        <table class="waffle" cellspacing="0" cellpadding="0">
            <tbody>
                <tr style="height: 11px">
                    <td class="s0" rowspan="4" style="width:164px;">
                        <img src="{{ public_path('images/Usep_logo2.png') }}" alt="USeP Logo" style="width: 0.58in; height: 0.59in; display: block; margin: 0 auto;">
                    </td>
                    <td class="s1" colspan="6" style="width:464px;">Republic of the Philippines</td>
                    <td class="s2" colspan="2" rowspan="4" style="width:137px;">Reference No. {{ $req->reference_no ?? '__________________' }}</td>
                </tr>
                <tr style="height: 14px">
                    <td class="s31" colspan="6">University of Southeastern Philippines</td>
                </tr>
                <tr style="height: 12px">
                    <td class="s4" colspan="6">Office of Student Affairs and Services</td>
                </tr>
                <tr style="height: 14px">
                    <td class="s5" colspan="6">Iñigo St., Bo. Obrero Davao City</td>
                </tr>
                <tr style="height: 25px">
                    <td class="s32" colspan="9">PAYMENT ORDER SLIP</td>
                </tr>
                <tr style="height: 4px">
                    <td class="s9" colspan="9"></td>
                </tr>
                <tr style="height: 22px">
                    <td class="s10">Date</td>
                    <td class="s11">:</td>
                    <td class="s13" colspan="7">{{ now()->format('F d, Y') }}</td>
                </tr>
                <tr style="height: 23px">
                    <td class="s10">Student's Name</td>
                    <td class="s11">:</td>
                    <!-- <td class="s13" colspan="7">{{ $student->last_name ?? ($req->last_name ?? '') }}, {{ $student->first_name ?? ($req->first_name ?? '') }} {{ $student->middle_name ?? ($req->middle_name ?? '') }}</td> -->
                    <td class="s13name" colspan="2" style="border-right: 1px solid transparent;">{{ $student->last_name ?? ($req->last_name ?? '') }},</td>
                    <td class="s13name" colspan="2" style="border-right: 1px solid transparent;">{{ $student->first_name ?? ($req->first_name ?? '') }}</td>
                    <td class="s13name" colspan="3">{{ $student->middle_name ?? ($req->middle_name ?? '') }}</td>
                    <!-- <td class="s13"></td> -->
                </tr>
                <tr style="height: 13px">
                    <td class="s10"></td>
                    <td class="s14"></td>
                    <td class="s15" colspan="2" style=" border-right: 1px solid transparent;">(Last Name)</td>
                    <td class="s15" colspan="2" style=" border-right: 1px solid transparent;">(First Name)</td>
                    <td class="s15" colspan="3">(Middle Name)</td>
                </tr>
                <tr style="height: 16px">
                    <td class="s33">Course &amp; Year</td>
                    <td class="s34">:</td>
                    <td class="s35" colspan="7">@php($prog2 = $student->program ?? ($req->program ?? ''))@php($yr2 = $student->year ?? ($req->year ?? '')){{ $prog2 }}@if(!empty($yr2)) {{ ' - ' . $yr2 }}@endif</td>
                </tr>
                <tr style="height: 16px">
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s37"></td>
                    <td class="s38"></td>
                    <td class="s39" colspan="2">Description</td>
                    <td class="s40" colspan="2">Cost</td>
                </tr>
                <tr style="height: 30px">
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s37"></td>
                    <td class="s41" colspan="3">Certificate of Good Moral Character <span style="font-size:8pt;font-family:Arial;font-style:italic;color:#000000;">(70.00 per copy)</span></td>
                    <td class="s42" colspan="2">Php {{ number_format($gmCost, 2) }}</td>
                </tr>
                <tr style="height: 20px">
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s36"></td>
                    <td class="s37"></td>
                    <td class="s43" colspan="3">Safe Loan</td>
                    <td class="s44" colspan="2">Php {{ number_format($safeLoan, 2) }}</td>
                </tr>
                <tr style="height: 23px">
                    <td class="s38"></td>
                    <td class="s38"></td>
                    <td class="s38"></td>
                    <td class="s45"></td>
                    <td class="s43" colspan="3">Total Amount</td>
                    <td class="s46" colspan="2">Php {{ number_format($total, 2) }}</td>
                </tr>
                <tr style="height: 30px">
                    <td class="s47" colspan="3">By: </td>
                    <td class="s38" colspan="2"></td>
                    <td class="s48" colspan="4"></td>
                </tr>
                <tr style="height: 16px">
                    <td class="s49" colspan="9">OSAS Staff</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>