<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>StoreMe Reply</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif; background-color: #f6f9fc; padding: 0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.08);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #0f172a; padding: 20px; color: #fff;">
                            <img src="https://i.imgur.com/421Vq6C.png" alt="StoreMe Logo" style="max-width: 150px;">
                            <h2 style="margin: 10px 0 0;">Reply from StoreMe Admin</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px; color: #334155;">
                            <p>Dear {{ $userName }},</p>

                            <p>Thank you for reaching out to us. Here's our response to your concern:</p>

                            <div style="background-color: #f1f5f9; padding: 20px; border-radius: 8px; font-size: 15px;">
                                {{ $replyMessage }}
                            </div>

                            <p>If you need further assistance, feel free to reply to this email or visit your dashboard.</p>

                            <p style="margin-top: 40px;">Warm regards,<br><strong>StoreMe Support Team</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f1f5f9; padding: 20px; font-size: 12px; color: #64748b;">
                            &copy; {{ date('Y') }} StoreMe Locker Reservation. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
