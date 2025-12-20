<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Moral Certificate Completed</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            border-radius: 10px;
            padding: 40px;
            color: white;
        }

        .content {
            background: white;
            color: #333;
            padding: 30px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
        }

        .success-icon {
            font-size: 48px;
            text-align: center;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.9);
        }

        .reference-box {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .or-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">✓ OSAS</div>
            <h2 style="margin: 10px 0;">Good Moral Certificate Completed!</h2>
        </div>

        <div class="content">
            <div class="success-icon">✓</div>

            <p>Hello <strong>{{ $request->first_name }} {{ $request->last_name }}</strong>,</p>

            <p>Congratulations! Your Good Moral Certificate has been processed and is now ready for pickup.</p>

            <div class="reference-box">
                <strong>Reference Number:</strong> {{ $request->reference_no }}
            </div>

            <div class="or-box">
                <strong>Official Receipt (OR) Number:</strong><br>
                <span style="font-size: 20px; color: #856404; font-weight: bold;">{{ $request->or_number }}</span>
            </div>

            <h3 style="color: #218838;">What's Next?</h3>
            <p>You can now pick up your Good Moral Certificate from the Office of Student Affairs and Services (OSAS).</p>

            <p><strong>Requirements for pickup:</strong></p>
            <ul>
                <li>Valid ID</li>
                <li>Official Receipt (OR) Number: <strong>{{ $request->or_number }}</strong></li>
                <li>Reference Number: <strong>{{ $request->reference_no }}</strong></li>
            </ul>

            <p style="margin-top: 20px;"><strong>Office Hours:</strong><br>
                Monday - Friday: 8:00 AM - 5:00 PM</p>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                <strong>Note:</strong> Please claim your certificate within 30 days. For questions, contact the Office of Student Affairs and Services.
            </p>
        </div>

        <div class="footer">
            <p><strong>University of Southeastern Philippines</strong></p>
            <p>Office of Student Affairs and Services<br>
                Iñigo St., Bo. Obrero, Davao City</p>
            <p style="margin-top: 15px;">
                This is an automated message. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>

</html>