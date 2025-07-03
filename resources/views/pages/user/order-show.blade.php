@extends('layouts.user')
@section('title', 'Order Details')
@section('content')
<div class="min-h-screen pt-[55px] bg-[#f2f2f2]">
    <div class="bg-gray-200 text-center py-14 mb-0">
        <h2 class="text-4xl md:text-5xl font-bold text-black">Order Details</h2>
    </div>

@php
    $statusToStepperKey = [
        'pending' => 'pending',
        'confirm' => 'confirmed',
        'processing' => 'processing',
        'shipped' => 'shipped',
        'completed' => 'completed',
        'financing' => 'financing',
        'contract' => 'contract',
    ];
    $currentStepperKey = $statusToStepperKey[$order->order_status ?? 'pending'] ?? 'pending';
@endphp

<x-stepper-order :current="$order->order_status" :type="$order->payment_type" />



<div class="max-w-5xl mx-auto px-4 sm:px-12 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">

    </div>

    <div x-data="{ openSections: [], modalOpen: false, modalTarget: '' }" class="space-y-6">
<!-- TIDAK dalam accordion -->
<div class="bg-white rounded-xl shadow-md p-6 md:p-8">
    <h3 class="text-xl font-bold mb-4">Customer & Vehicle Details</h3>
    <x-customer-car-info :customer="$customer" :order="$order" />
</div>

<!-- Dalam accordion -->
<x-accordion-section number="2" title="Payment Details">
    @include('components.payment-details', [
        'order' => $order,
        'cashPayment' => $cashPayment ?? null,
        'dpPayment' => $dpPayment ?? null
    ])
</x-accordion-section>

@if($order->payment_method === 'credit')
    <x-accordion-section number="3" title="Installment History">
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

        <div class="mt-14 text-center">
            <a href="{{ route('user.orders.index') }}"
                class="inline-block bg-[#cfeeea] hover:bg-[#b0dad4] text-[#2f4442] font-bold py-3 px-8 rounded-xl text-lg shadow transition duration-300">
                &larr; Back to Order History
            </a>
        </div>
    </div>
</div>
@endsection
