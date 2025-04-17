<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Received</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 0;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.08);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #0f172a; color: white; padding: 20px;">
                            <img src="https://i.imgur.com/421Vq6C.png" alt="StoreMe Logo" style="max-width: 150px; margin-bottom: 10px;">
                            <h2 style="margin: 0; font-size: 20px;">New Feedback Received</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px; color: #334155;">
                            <p><strong>From:</strong> {{ $user->name }} ({{ $user->email }})</p>
                            <p><strong>Rating:</strong> {{ $rating }}/5</p>
                            <p><strong>Message:</strong></p>
                            <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; font-size: 15px;">
                                {{ $messageContent }}
                            </div>

                            <!-- Reply Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="mailto:{{ $user->email }}" 
                                   style="background-color: #3b82f6; color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; display: inline-block;">
                                    Reply Now
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f1f5f9; padding: 20px; font-size: 12px; color: #64748b;">
                            &copy; {{ date('Y') }} StoreMe Locker Reservation. All rights reserved.<br>
                            Follow us on 
                            <a href="https://facebook.com/YourPage" style="color: #3b82f6; text-decoration: none;">Facebook</a> |
                            <a href="https://instagram.com/YourProfile" style="color: #3b82f6; text-decoration: none;">Instagram</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
