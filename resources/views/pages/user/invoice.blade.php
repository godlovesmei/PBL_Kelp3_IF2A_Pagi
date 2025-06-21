<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            padding: 40px;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header p {
            color: #888;
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            font-size: 28px;
            margin: 0;
            color: #0f1530;
        }

        .header h3 {
            font-size: 18px;
            font-weight: 400;
            color: #666;
        }

        .success-box {
            background-color: #e0f7ec;
            color: #2e7d32;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 500;
        }

        .success-box span {
            font-weight: bold;
        }

        .section {
            margin-bottom: 32px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
        }

        /* Ensure label and value always align in two columns */
        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 2px;
            margin-bottom: 0;
        }
        .info-table td {
            font-size: 15px;
            padding: 4px 0;
            vertical-align: top;
        }
        .info-label {
            width: 180px;
            color: #666;
            font-weight: 500;
            text-align: left;
            padding-right: 16px;
            padding-left: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kiri */
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .info-value {
            color: #111827;
            font-weight: 500;
            word-break: break-word;
            padding-left: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kiri */
            padding-right: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kanan */
            letter-spacing: 0.5px;
        }

        .success {
            color: #16a34a;
            font-weight: bold;
            padding-left: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kiri */
            padding-right: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kanan */
            padding: 2px 8px;
            background: #e5fbe5;
            border-radius: 4px;
        }

        .paid {
            color: #16a34a;
            font-weight: bold;
            padding: 2px 8px;
            padding-left: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kiri */
            padding-right: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kanan */
            background: #e5fbe5;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            padding-left: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kiri */
            padding-right: 16px; /* Tambahkan ini untuk memberi ruang dari sisi kanan */
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #f3f4f6;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
            margin-top: 30px;
            color: #1f2937;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-top: 40px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 12px;
            }
            .info-label {
                width: 110px;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <p>Invoice {{ strtoupper($type) }}</p>
            <h2>Thank You!</h2>
            <h3>Your transaction has been completed</h3>
        </div>

        <div class="success-box">
            Your order <span>{{ $order->order_id }}</span> has been successfully processed.
        </div>

        <div class="section">
            <div class="section-title">Order Details</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Product</td>
                    <td class="info-value">{{ $order->car->brand }} - {{ $order->car->model }}</td>
                </tr>
                <tr>
                    <td class="info-label">Invoice Number</td>
                    <td class="info-value">{{ $order->order_id }}</td>
                </tr>
                <tr>
                    <td class="info-label">Transaction Status</td>
                    <td><span class="success">SUCCESS</span></td>
                </tr>
                <tr>
                    <td class="info-label">Payment Status</td>
                    <td><span class="paid">PAID</span></td>
                </tr>
                <tr>
                    <td class="info-label">Date</td>
                    <td class="info-value">{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y/m/d H:i:s') }} WIB</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Account Information</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Name</td>
                    <td class="info-value">{{ $order->customer->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Address</td>
                    <td class="info-value">{{ $order->customer->user->address ?? '-' }}</td>
                </tr>
            </table>
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
                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i:s') }} WIB</td>
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

        <div class="total">
            Total Payment: Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
        </div>

        <div class="footer">
            Thank you for your payment.<br>
            Please keep this invoice as a valid proof of payment.
        </div>

    </div>
</body>
</html>
