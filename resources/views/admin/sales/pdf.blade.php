<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            font-size: 20px;
            margin: 15px 0;
            font-weight: bold;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 13px;
        }

        th,
        td {
            border: 0.5px solid #ddd;
            padding: 8px 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f8f8;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
            border: 0.5px solid #ccc;
        }

        .col-sno {
            width: 6%;
            text-align: center;
        }

        .col-date {
            width: 10%;
        }

        .col-invoice {
            width: 12%;
        }

        .col-customer {
            width: 18%;
        }

        .col-items {
            width: 20%;
            font-size: 11px;
        }

        .col-amount {
            width: 12%;
            text-align: right;
        }

        .col-status {
            width: 10%;
            text-align: center;
        }

        .col-payment {
            width: 12%;
            text-align: center;
        }

        .items-list {
            font-size: 11px;
            line-height: 1.3;
        }

        .item-badge {
            display: inline-block;
            background-color: #f1f1f1;
            padding: 2px 6px;
            margin: 1px;
            border-radius: 3px;
            font-size: 10px;
            border: 0.5px solid #ddd;
        }

        .summary {
            margin-top: 25px;
            font-size: 14px;
            font-weight: bold;
        }

        .summary table {
            width: 50%;
            margin-left: auto;
            border: 1px solid #ddd;
        }

        .summary th,
        .summary td {
            padding: 10px;
            font-size: 13px;
            border: 0.5px solid #ddd;
        }

        .summary th {
            background-color: #f8f8f8;
            text-align: left;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 11px;
            text-align: center;
            border-top: 0.5px solid #ddd;
            padding-top: 6px;
            background-color: white;
        }

        .app-name {
            font-weight: bold;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Sales Report</h1>
        <p><strong>Generated on:</strong> {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-sno">S.No</th>
                <th class="col-date">Date</th>
                <th class="col-invoice">Order Reference#</th>
                <th class="col-customer">Customer</th>
                <th class="col-items">Items</th>
                <th class="col-amount">Amount</th>
                <th class="col-status">Status</th>
                <th class="col-payment">Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $index => $sale)
                <tr>
                    <td class="col-sno">{{ $index + 1 }}</td>
                    <td class="col-date">{{ $sale['date'] }}</td>
                    <td class="col-invoice">{{ $sale['invoice_number'] }}</td>
                    <td class="col-customer">{{ $sale['customer_name'] }}</td>
                    <td class="col-items">
                        <div class="items-list">
                            @if (isset($sale['items']) && count($sale['items']) > 0)
                                @foreach ($sale['items'] as $item)
                                    <span class="item-badge">{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                                @endforeach
                            @else
                                <span class="item-badge">No items</span>
                            @endif
                        </div>
                    </td>
                    <td class="col-amount amount">{{ config('app.currency') }} {{ number_format($sale['amount'], 2) }}
                    </td>
                    <td class="col-status">{{ $sale['status'] }}</td>
                    <td class="col-payment">{{ $sale['payment_method'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <th>Total Records:</th>
                <td class="amount">{{ count($sales) }}</td>
            </tr>
            <tr>
                <th>Total Amount:</th>
                <td class="amount">{{ number_format($sales->sum('amount'), 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="app-name">{{ config('app.name', 'My Business') }}</div>
        <div>Sales Management System</div>
    </div>
</body>

</html>
