<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
    <style>
        .email-content {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }
        .email-content h1 {
            color: #444444;
        }
        .email-content p {
            color: #666666;
            line-height: 1.5;
        }
        .code {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="email-content">
    <h1>Welcome to Our App!</h1>
    <p>Hello,</p>
    <p>We're excited that you've decided to join our community! To verify your email address, please use the following code:</p>
    <p class="code">{{ $code }}</p>
    <p>If you didn’t request this email, there's nothing to worry about - you can safely ignore it.</p>
    <p>Thank you for choosing us!</p>
    <p>Best Regards,</p>
    <p>SafetyApp Team</p>
</div>
</body>
</html>
