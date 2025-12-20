<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Good Moral Certificate Ready</title>
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
            background: linear-gradient(135deg, #DC5656 0%, #800000 100%);
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

        .button {
            display: inline-block;
            background: #800000;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.8);
        }

        .reference-box {
            background: #f8f9fa;
            border-left: 4px solid #800000;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 OSAS</div>
            <h2 style="margin: 10px 0;">Good Moral Certificate Ready</h2>
        </div>

        <div class="content">
            <p>Hello <strong>{{ $request->first_name }} {{ $request->last_name }}</strong>,</p>

            <p>Good news! Your Good Moral Certificate request is now ready for processing.</p>

            <div class="reference-box">
                <strong>Reference Number:</strong> {{ $request->reference_no }}
            </div>

            <h3 style="color: #800000;">Next Steps:</h3>
            <ol>
                <li><strong>Visit the OSAS Office</strong> - Please proceed to the Office of Student Affairs and Services. Bring your reference number and valid ID.</li>
                <li><strong>Payment Slip</strong> - OSAS staff will provide you with the payment slip. Please wait at the office while they process and print your slip.</li>
                <li><strong>Complete Payment</strong> - After receiving your payment slip, complete the payment and submit any other required documents. You will receive an Official Receipt (OR) number.</li>
                <li><strong>Certificate Processing</strong> - Once the OR number is entered into the system, you will receive another notification when your Good Moral Certificate is ready for pickup.</li>
            </ol>

            <p style="margin-top: 20px;"><strong>Important:</strong> Please bring a valid ID when visiting the OSAS office.</p>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                For questions or concerns, please contact the Office of Student Affairs and Services.
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