<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete Email</title>
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
                <h2 style="margin: 0; font-size: 24px; font-weight: 400;">Order Complete!</h2>
                <p style="margin: 5px 0 0; font-size: 14px; opacity: 0.9;">Your gift card is ready to use</p>
            </td>
        </tr>
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 20px; color: #333; font-weight: 400; margin-bottom: 10px;">Hi {{ $data['user'] }},
                </p>
                <p style="color: #555; font-size: 16px; margin-bottom: 20px;">Great news! Your order has been processed
                    successfully.</p>
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 6px; margin: 15px 0;">
                    <tr>
                        <td style="padding: 10px 15px; font-weight: 500; width: 40%; color: #333; font-size: 14px;">
                            <strong>Order Number:</strong>
                        </td>
                        <td style="padding: 10px 15px; color: #333; font-size: 14px;">#{{ $data['order_no'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 15px; font-weight: 500; width: 40%; color: #333; font-size: 14px;">
                            <strong>Product:</strong>
                        </td>
                        <td style="padding: 10px 15px; color: #333; font-size: 14px;">{{ $data['product'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 15px; font-weight: 500; width: 40%; color: #333; font-size: 14px;">
                            <strong>Order Date:</strong>
                        </td>
                        <td style="padding: 10px 15px; color: #333; font-size: 14px;">{{ $data['order_date'] }}</td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="background-color: #e6ffe6; border: 2px solid #4caf50; border-radius: 6px; text-align: center; padding: 20px; margin: 20px 0; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td style="padding-bottom: 10px; font-size: 16px; color: #555; font-weight: 400;">Your Gift Card
                            Code</td>
                    </tr>
                    <tr>
                        <td style="font-size: 22px; font-weight: 500; color: #333;">{{ $data['code'] }}</td>
                    </tr>
                </table>
                <p style="font-weight: 500; color: #333; margin: 20px 0 10px;">Redeem:</p>
                <ol style="margin: 0; padding-left: 20px; color: #555; font-size: 14px;">
                    <li>Go to your application</li>
                    <li>Go to Account -> Redeem a Gift Card</li>
                </ol>
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
                        style="color: #e60024; text-decoration: none;">{{ config('app.url') }}</a>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
