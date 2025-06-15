<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #fff;
            color: #222;
            padding: 28px 0;
            max-width: 700px;
            margin: auto;
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .header h2 {
            margin: 0 0 4px 0;
            color: #111;
            letter-spacing: 2px;
        }
        .header p {
            margin: 0 0 2px 0;
            color: #444;
            font-size: 15px;
        }
        .header h3 {
            margin: 10px 0 0 0;
            color: #111;
            font-weight: 600;
            font-size: 19px;
            letter-spacing: 1px;
        }
        .success-box {
            background: #f5f5f5;
            padding: 18px 0;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        .success-box p {
            margin: 0;
            color: #181818;
            font-size: 16px;
        }
        .success-box p span {
            font-weight: 600;
            background: #eaeaea;
            color: #000;
            padding: 4px 12px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            font-size: 15px;
        }
        .section {
            margin-bottom: 24px;
        }
        .section-title {
            font-weight: 600;
            margin-bottom: 9px;
            border-bottom: 1px solid #bbb;
            padding-bottom: 4px;
            color: #171717;
            letter-spacing: 1px;
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 15px;
            margin-top: 8px;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
        }
        td, th {
            padding: 9px 12px;
            border-bottom: 1px solid #dcdcdc;
            text-align: left;
        }
        th {
            background: #f7f7f7;
            color: #222;
            font-weight: 700;
            border-top: 1px solid #dcdcdc;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .total {
            text-align: right;
            font-weight: bold;
            background: #fff;
            padding: 18px 0 0 0;
            color: #151515;
            font-size: 16px;
            border-top: 1px solid #bbb;
            margin-top: 10px;
        }
        .footer {
            margin-top: 36px;
            text-align: center;
            font-size: 13px;
            color: #888;
            letter-spacing: 0.5px;
        }
        .paid {
            color: #13a042;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 1px;
            background: #e7fbe7;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .success {
            color: #13a042;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 1px;
            background: #e7fbe7;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .info-value {
            color: #222;
            font-weight: 500;
        }
        @media (max-width: 600px) {
            body {
                padding: 8px 0;
                font-size: 14px;
            }
            .header h2 { font-size: 20px; }
            .section-title, th, td { font-size: 13px; }
            .total { font-size: 14px; }
            .success-box p { font-size: 13px; }
        }
    </style>
</head>
<body>

    <div class="header">
        <p>Invoice {{ strtoupper($type) }}</p>
        <h2>Thank You!</h2>
        <h3>Your transaction has been completed</h3>
    </div>

    <div class="success-box">
        <p>Your order <span>{{ $order->order_id }}</span> has been successfully processed.</p>
    </div>

    <div class="section">
        <div class="section-title">Order Details</div>
        <p>Product: <span class="info-value">{{ $order->car->brand }} - {{ $order->car->model }}</span></p>
        <p><strong>Invoice Number:</strong> <span class="info-value">{{ $order->order_id }}</span></p>
        <p><strong>Transaction Status:</strong> <span class="success">SUCCESS</span></p>
        <p><strong>Payment Status:</strong> <span class="paid">PAID</span></p>
        <p><strong>Date:</strong> <span class="info-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y/m/d H:i:s') }} WIB</span></p>
    </div>

    <div class="section">
        <div class="section-title">Account Information</div>
        <p><strong>Name:</strong> <span class="info-value">{{ $order->customer->user->name ?? '-' }}</span></p>
        <p><strong>Address:</strong> <span class="info-value">{{ $order->customer->user->address ?? '-' }}</span></p>
    </div>

    @if($type === 'dp' && $payment)
        <div class="section">
            <div class="section-title">Down Payment Details</div>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @elseif($type === 'cash' && $payment)
        <div class="section">
            <div class="section-title">Cash Payment Details</div>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @elseif($type === 'installment' && $payment && $installment)
        <div class="section">
            <div class="section-title">Installment Payment #{{ $installment->installment_number }}</div>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($installment->amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @endif

    <div class="section total">
        Total Payment: Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
    </div>

    <div class="footer">
        Thank you for your payment.<br>
        Please keep this invoice as a valid proof of payment.
    </div>

</body>
</html>
