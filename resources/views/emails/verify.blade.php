<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body style="background-color: #f9fafb; font-family: Arial, sans-serif; padding: 2rem;">
    <div style="max-width: 600px; background-color: #ffffff; padding: 2rem; margin: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #1f2937;">Hi {{ $name }},</h2>
        <p style="color: #4b5563;">
            Welcome to <strong>Locker Management System</strong>! We're excited to have you on board.
        </p>
        <p style="color: #4b5563;">
            Please confirm your email address by clicking the button below. This step keeps your account secure and gives you access to all features.
        </p>

        <div style="text-align: center; margin: 2rem 0;">
            <a href="{{ $url }}" style="background-color: #2563eb; color: white; padding: 0.75rem 1.5rem; text-decoration: none; border-radius: 6px;">
                Verify Email Address
            </a>
        </div>

        <p style="color: #6b7280;">
            If you didn’t create an account, no action is needed. This message can be ignored.
        </p>

        <p style="margin-top: 2rem; color: #6b7280;">
            Cheers,<br>
            <strong>Locker Management System Team</strong>
        </p>
    </div>
</body>
</html>
