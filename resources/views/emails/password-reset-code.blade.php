<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .code-box {
            background: #f4f4f4;
            border: 2px dashed #800000;
            padding: 20px;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #800000;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Password Reset Code</h2>
        <p>You requested to reset your password. Use the verification code below:</p>

        <div class="code-box">
            {{ $code }}
        </div>

        <p>This code will expire in <strong>10 minutes</strong>.</p>
        <p>If you didn't request this, please ignore this email.</p>

        <p>
            Best regards,<br>
            Office of Student Affairs and Services
        </p>
    </div>
</body>

</html>