<!DOCTYPE html>
<html>

<head>
    <title>Preregistration Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px;">
        <tr>
            <td style="padding: 20px; text-align: center;">
                <h2 style="color: #333;">Preregistration Confirmation</h2>
                <p style="color: #555;">Thank you for preregistering with <strong>iDentify</strong>. Use
                    the code below to view the next instructions.</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td align="center"
                            style="background-color: #1F555F; color: #ffffff; font-size: 24px; font-weight: bold; border-radius: 5px;">
                            {{ $data['code'] }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                <p style="color: #777;">If you didn’t request this code, you can ignore this email.</p>
                <p style="color: #777;">Click <a href="{{ route('pre-reg.tracking.search') }}">here</a> to know the following instructions</p>
            </td>
        </tr>
    </table>
</body>

</html>