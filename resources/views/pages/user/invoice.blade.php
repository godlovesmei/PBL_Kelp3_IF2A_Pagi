<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #1f2937;
            background-color: #fff;
        }

        .logo {
            width: 120px;
            margin-bottom: 0;
            float: left;
        }

        .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 15px;
            margin-bottom: 35px;
        }

        .header-title {
            text-align: right;
            flex: 1;
        }

        .header-title h2 {
            font-size: 26px;
            color: #111827;
            margin: 5px 0;
            margin-top: 0;
            margin-bottom: 0;
        }
        .header-title p {
            color: #888;
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0;
        }

        .info {
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .info p {
            margin: 5px 0;
        }

        h3 {
            color: #2563eb;
            margin-top: 30px;
            font-size: 17px;
            border-left: 5px solid #3b82f6;
            padding-left: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 13px;
        }

        th {
            background-color: #f3f4f6;
            font-weight: 600;
            color: #1f2937;
            text-align: left;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 10px;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .summary-box {
            margin-top: 30px;
            padding: 14px 18px;
            background-color: #f0fdf4;
            border-left: 5px solid #22c55e;
            border: 1px solid #bbf7d0;
            color: #166534;
            font-weight: 600;
        }

        .footer {
            margin-top: 45px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
            border-top: 1px dashed #d1d5db;
            padding-top: 10px;
        }

        /* Clear floats after the header */
        .header::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>

    {{-- Header --}}
   <div class="header">
    <img src="{{ public_path('images/companylogo.png') }}" class="logo" alt="Company Logo">
    <div class="header-title">
        <p>
            @if($type === 'dp')
                DOWN PAYMENT
            @elseif($type === 'installment')
                INSTALLMENT
            @elseif($type === 'cash')
                CASH
            @else
                INVOICE
            @endif
        </p>
        <h2>INVOICE</h2>
    </div>
</div>

    {{-- Info Pembeli --}}
    <div class="info">
        <p><strong>Nama Pelanggan:</strong> {{ $order->customer->user->name ?? '-' }}</p>
        <p><strong>No. Order:</strong> {{ $order->order_id }}</p>
        <p><strong>Mobil:</strong> {{ $order->car->brand }} {{ $order->car->model }}</p>
    </div>

    {{-- Detail Order --}}
    <h3>Order Details</h3>
    <table>
        <tbody>
            <tr>
                <th>Invoice Number</th>
                <td>{{ $order->order_id }}</td>
            </tr>
            <tr>
                <th>Transaction Status</th>
                <td><span style="color:#16a34a;font-weight:bold;background:#e5fbe5;padding:2px 8px;border-radius:4px;">SUCCESS</span></td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td><span style="color:#16a34a;font-weight:bold;background:#e5fbe5;padding:2px 8px;border-radius:4px;">PAID</span></td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ \Carbon\Carbon::parse($order->created_at)->format('Y/m/d H:i:s') }} WIB</td>
            </tr>
        </tbody>
    </table>

    {{-- Detail Akun --}}
    <h3>Account Information</h3>
    <table>
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $order->customer->user->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $order->customer->user->address ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    @if($type === 'dp' && $payment)
        <h3>Down Payment Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y H:i:s') }} WIB</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($type === 'cash' && $payment)
        <h3>Cash Payment Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @elseif($type === 'installment' && $payment && $installment)
        <h3>Installment Payment #{{ $installment->installment_number }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($installment->due_date)->format('d M Y') }}</td>
                    <td>Rp {{ number_format($installment->amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <div class="summary-box">
        Total Payment: Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}
    </div>

    <div class="footer">
        Thank you for your payment.<br>
        Please keep this invoice as a valid proof of payment.
    </div>

</body>
</html>
