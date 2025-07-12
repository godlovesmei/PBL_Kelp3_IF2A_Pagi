@extends('layouts.user')
@section('title', 'Order Details')
@section('content')
<div class="min-h-screen pt-[55px] bg-[#f2f2f2]">
    <div class="bg-gray-200 text-center py-14 mb-0">
        <h2 class="text-4xl md:text-5xl font-bold text-black">Order Details</h2>
    </div>
    <x-stepper-order :current="$order->order_status" :type="$order->payment_method" />

    <div class="max-w-5xl mx-auto px-4 sm:px-12 py-12">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
            {{-- Jika ingin menambahkan info lainnya bisa di sini --}}
        </div>

        <div x-data="{ openSections: [2], modalOpen: false, modalTarget: '' }" class="space-y-6">
            <!-- TIDAK dalam accordion -->
            <div class="bg-white shadow-md p-6 md:p-8">
                <h3 class="text-xl text-center font-bold mb-4">Customer & Vehicle Details</h3>
                <div class="border-t border-gray-300 my-4"></div>
                <x-customer-car-info :customer="$customer" :order="$order" />
            </div>

            <!-- Dalam accordion -->
            <x-accordion-section number="2" title="Payment Details">
                <div class="border-t border-gray-300 my-3"></div>
                <x-payment-details
                    :order="$order"
                    :cash-payment="$cashPayment ?? null"
                    :dp-payment="$dpPayment ?? null"
                />
            </x-accordion-section>

            @if($order->payment_method === 'credit')
                <x-accordion-section number="3" title="Installment History">
                    <div class="border-t border-white my-3"></div>
                    @include('components.installment-history', [
                        'order' => $order,
                        'installments' => $installments,
                        'dpPayment' => $dpPayment ?? null
                    ])
                </x-accordion-section>
            @endif

            <x-upload-proof-modal>
                @include('components.upload-proof-forms', [
                    'order' => $order,
                    'installments' => $installments,
                ])
            </x-upload-proof-modal>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('user.orders.index') }}"
                class="inline-block bg-[#cfeeea] hover:bg-[#b0dad4] text-[#2f4442] font-bold py-3 px-6 rounded-md text-md shadow transition duration-300">
                &larr; Back to Order History
            </a>
        </div>
    </div>
</div>
@endsection
