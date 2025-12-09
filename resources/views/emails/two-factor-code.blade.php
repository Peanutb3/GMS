<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #DC5656 0%, #800000 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .code-box {
            background: #f8f9fa;
            border: 2px dashed #DC5656;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
        }

        .code {
            font-size: 48px;
            font-weight: bold;
            color: #800000;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }

        .info {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin: 20px 0;
        }

        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            font-size: 13px;
            color: #856404;
        }

        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Two-Factor Authentication</h1>
        </div>

        <div class="content">
            <p class="info">Hello <strong>{{ $user->name ?? 'User' }}</strong>,</p>

            <p class="info">You requested to login to your OSAS Grievance Management System account. Use the verification code below to complete your login:</p>

            <div class="code-box">
                <div class="code">{{ $code }}</div>
            </div>

            <p class="info">This code will expire in <strong>10 minutes</strong>.</p>

            <div class="warning">
                <strong>⚠️ Security Notice:</strong><br>
                If you didn't request this code, please ignore this email or contact the Office of Student Affairs and Services immediately.
            </div>
        </div>

        <div class="footer">
            <p>Office of Student Affairs and Services<br>
                University of Southeastern Philippines<br>
                © {{ date('Y') }} OSAS GMS. All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>