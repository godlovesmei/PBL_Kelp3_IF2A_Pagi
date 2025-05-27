@extends('layouts.user')

@section('title', 'History Transactions')

@section('content')
<div class="max-w-6xl mx-auto mt-8 pt-[63px]">
    <h1 class="text-2xl font-bold mb-6 text-center">History Transactions</h1>

    @auth
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-black text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Car</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Date</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $trx)
                        <tr>
                            <td class="border px-4 py-2">{{ $trx->id }}</td>
                            <td class="border px-4 py-2">{{ $trx->car->brand ?? 'N/A' }} {{ $trx->car->model ?? '' }}</td>
                            <td class="border px-4 py-2">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="border px-4 py-2">{{ $trx->created_at->format('d M Y') }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $trx->payment_status }}</td>
                            <td class="border px-4 py-2">
                                <a href="#" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="border px-4 py-2 text-center" colspan="6">No transactions yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-white border border-gray-300 shadow-md rounded-md px-6 py-8 text-center">
            <div class="flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                </svg>
                <p class="text-gray-700">
                    To view your transaction history, 
                    <a href="{{ route('login') }}" class="text-blue-600 underline">login</a> 
                    or 
                    <a href="{{ route('register') }}" class="text-blue-600 underline">create an account</a> first.
                </p>
            </div>
        </div>
    @endauth
</div>
@endsection