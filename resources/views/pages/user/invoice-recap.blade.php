<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Recap of Payment</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            margin: 40px;
            color: #1f2937;
            background: #fff;
        }

        .logo {
            width: 110px;
            margin-bottom: 6px;
        }

        .header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 14px;
            margin-bottom: 34px;
        }

        .header-title {
            text-align: right;
        }

        .header-title h2 {
            font-size: 20px;
            color: #111827;
            margin: 0;
            letter-spacing: 2px;
        }
        .header-title p {
            color: #888;
            margin: 0;
            margin-bottom: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .info {
            margin-bottom: 22px;
            line-height: 1.7;
        }

        .info p {
            margin: 3px 0;
        }

        h3 {
            color: #2563eb;
            margin-top: 26px;
            font-size: 16px;
            border-left: 5px solid #3b82f6;
            padding-left: 10px;
            font-weight: 600;
            background: #f6faff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 13px;
        }

        th {
            background: #f3f4f6;
            font-weight: 600;
            color: #1f2937;
            text-align: left;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 9px 10px;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .summary-box {
            margin-top: 28px;
            padding: 13px 16px;
            background: #f0fdf4;
            border-left: 5px solid #22c55e;
            border: 1px solid #bbf7d0;
            color: #166534;
            font-weight: 600;
            font-size: 14px;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            border-top: 1px dashed #d1d5db;
            padding-top: 12px;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <img src="{{ public_path('images/companylogo.png') }}" class="logo" alt="Company Logo">
        <div class="header-title">
            <p>INSTALLMENT PLAN</p>
            <h2>PAYMENT SUMMARY</h2>
        </div>
    </div>

    {{-- Buyer Info --}}
    <div class="info">
        <p><strong>Customer Name:</strong> {{ $order->customer->user->name }}</p>
        <p><strong>Order Number:</strong> {{ $order->order_id }}</p>
        <p><strong>Car:</strong> {{ $order->car->brand }} {{ $order->car->model }}</p>
    </div>

    {{-- Total Initialization --}}
    @php $totalPaid = 0; @endphp

    {{-- Down Payment --}}
    @if($dpPayment)
        <h3>Down Payment (DP)</h3>
        <table>
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($dpPayment->created_at)->translatedFormat('d F Y') }}</td>
                    <td>
                        @php
                            $time = \Carbon\Carbon::parse($dpPayment->created_at)->format('H:i');
                        @endphp
                        {{ $time !== '00:00' ? $time . ' WIB' : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
        @php $totalPaid += $dpPayment->amount; @endphp
    @endif

    {{-- Installments --}}
    @if($installments->count() > 0)
        <h3>Installment Payments</h3>
        <table>
            <thead>
                <tr>
                    <th>Installment No.</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @php $installmentNo = 1; $installmentCount = 0; @endphp
                @foreach($installments as $ins)
                    @foreach($ins->payments as $pay)
                        <tr>
                            <td>{{ $installmentNo++ }}</td>
                            <td>Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pay->created_at)->translatedFormat('d F Y') }}</td>
                            <td>
                                @php
                                    $hour = \Carbon\Carbon::parse($pay->created_at)->format('H:i');
                                @endphp
                                {{ $hour !== '00:00' ? $hour . ' WIB' : '-' }}
                            </td>
                        </tr>
                        @php
                            $totalPaid += $pay->amount;
                            $installmentCount++;
                        @endphp
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Total Recap --}}
    <div class="summary-box">
        Total Paid: Rp {{ number_format($totalPaid, 0, ',', '.') }}<br>
        Total Installments: {{ $installmentCount ?? 0 }}x
    </div>

    {{-- Footer --}}
    <div class="footer">
        Thank you for your payment.<br>
        Please keep this document as an official proof of your transaction.
    </div>

</body>
</html>
