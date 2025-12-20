<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎓 OSAS GMS</div>
            <h2 style="margin: 10px 0;">Account Approved!</h2>
        </div>

        <div class="content">
            <p>Hello <strong>{{ $user->name }}</strong>,</p>

            <p>Great news! Your student account has been approved by the Office of Student Affairs and Services (OSAS).</p>

            <p>You can now log in to the Grievance Management System and access all available services:</p>

            <ul>
                <li>View grievances</li>
                <li>Track your grievance status</li>
                <li>Request Good Moral certificates and Safe Loan documents</li>
                <li>Receive notifications on your requests</li>
            </ul>

            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="button">Log In Now</a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                <strong>Note:</strong> If you have not yet verified your email address, please check your inbox for the verification email.
            </p>
        </div>

        <div class="footer">
            <p>This is an automated message from OSAS Grievance Management System.<br>
                © {{ date('Y') }} University of Southeastern Philippines. All rights reserved.</p>
        </div>
    </div>
</body>

</html>