<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Complete Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }

        .header {
            background-color: #e60024;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
        }

        .header img {
            max-width: 100px;
        }

        .content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            vertical-align: top;
        }

        .greeting {
            font-size: 18px;
            color: #333;
        }

        .order-details {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            margin: 10px 0;
        }

        .gift-card-code {
            background-color: #e6ffe6;
            border: 2px solid #4caf50;
            text-align: center;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .content {
                padding: 10px;
            }

            .gift-card-code {
                font-size: 16px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <table class="container" cellpadding="0" cellspacing="0">
        <tr>
            <td class="header">
                <img src="{{ $data['logo'] }}" alt="{{ config('app.name') }}">
                <h2>Order Complete!</h2>
                <p>Your gift card is ready to use</p>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p class="greeting">Hi {{ $data['user'] }},</p>
                <p>Great news! Your order has been processed successfully.</p>
                <table class="order-details">
                    <tr>
                        <td><strong>Order Number:</strong></td>
                        <td>#{{ $data['order_no'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Product:</strong></td>
                        <td>{{ $data['product'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td>{{ $data['order_date'] }}</td>
                    </tr>
                </table>
                <table class="gift-card-code">
                    <tr>
                        <td>Your Gift Card Code</td>
                    </tr>
                    <tr>
                        <td>{{ $data['code'] }}</td>
                    </tr>
                </table>
                <p><strong>Redeem:</strong></p>
                <ol>
                    <li>Go to your application</li>
                    <li>Go to Account -> Redeem a Gift Card</li>
                </ol>
                <p>Questions? Contact us at <a
                        href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a></p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>

</html>
