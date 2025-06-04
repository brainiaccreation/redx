<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f4f4f4; line-height: 1.6;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #e0e0e0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border-radius: 8px;">
        <tr>
            <td
                style="background: linear-gradient(135deg, #e60024 0%, #c60020 100%); color: #ffffff; text-align: center; padding: 20px 0; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <img src="{{ $data['logo'] }}" alt="{{ config('app.name') }}"
                    style="max-width: 120px; margin-bottom: 10px;">
                <h2 style="margin: 0; font-size: 24px; font-weight: 400;">Password Changed</h2>
                <p style="margin: 5px 0 0; font-size: 14px; opacity: 0.9;">Your account password has been updated</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 20px; color: #333; font-weight: 400; margin-bottom: 10px;">Hi {{ $data['user'] }},
                </p>
                <p style="color: #555; font-size: 16px; margin-bottom: 20px;">Your password has been successfully
                    changed by an administrator.</p>
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; margin: 15px 0;">
                    <tr>
                        <td style="padding: 10px 15px; font-weight: 500; width: 40%; color: #333; font-size: 14px;">
                            <strong>New Password:</strong>
                        </td>
                        <td style="padding: 10px 15px; color: #333; font-size: 14px;">{{ $data['new_password'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 15px; font-weight: 500; width: 40%; color: #333; font-size: 14px;">
                            <strong>Changed On:</strong>
                        </td>
                        <td style="padding: 10px 15px; color: #333; font-size: 14px;">{{ $data['changed_date'] }}</td>
                    </tr>
                </table>
                <p style="color: #555; font-size: 14px; margin-top: 20px;">We recommend logging in and changing your
                    password to something memorable. Go to your account settings to update it.</p>
                <p style="color: #555; font-size: 14px; margin-top: 20px;">Questions? Contact us at <a
                        href="mailto:{{ config('mail.from.address') }}"
                        style="color: #e60024; text-decoration: none; font-weight: 500;">{{ config('mail.from.address') }}</a>
                </p>
            </td>
        </tr>
        <tr>
            <td
                style="text-align: center; padding: 15px; font-size: 12px; color: #777; background-color: #f9f9f9; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved. | <a
                        href="{{ config('app.url') }}"
                        style="color: #e60024; text-decoration: none;">{{ config('app.url') }}</a></p>
            </td>
        </tr>
    </table>
</body>

</html>
```
