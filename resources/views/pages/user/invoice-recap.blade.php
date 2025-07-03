<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Pembayaran</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        h2, h3 {
            margin-bottom: 4px;
            color: #222;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 2px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
        }
        .section {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>Rekap Pembayaran</h2>

    <div class="info">
        <p><strong>Nama:</strong> {{ $order->customer->user->name }}</p>
        <p><strong>No. Order:</strong> {{ $order->order_id }}</p>
        <p><strong>Mobil:</strong> {{ $order->car->brand }} {{ $order->car->model }}</p>
    </div>

    @if($dpPayment)
    <div class="section">
        <h3>Down Payment (DP)</h3>
        <table>
            <thead>
                <tr>
                    <th>Jumlah</th>
                    <th>Tanggal Bayar</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rp {{ number_format($dpPayment->amount, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($dpPayment->payment_date)->format('H:i') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if($installments->count() > 0)
    <div class="section">
        <h3>Pembayaran Cicilan</h3>
        <table>
            <thead>
                <tr>
                    <th>Cicilan ke</th>
                    <th>Jumlah</th>
                    <th>Tanggal Bayar</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($installments as $index => $ins)
                    @foreach($ins->payments as $pay)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>Rp {{ number_format($pay->amount, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pay->payment_date)->format('H:i') }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>
