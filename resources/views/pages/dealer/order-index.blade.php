@extends('layouts.dealer')

@section('content')
<div class="mt-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <h2 class="mb-6 text-2xl font-bold uppercase text-blue-900 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-2m0 0l7-7 7 7M13 5v6h6" />
        </svg>
        ORDERS
    </h2>
    <div class="border-t-4 border-blue-700 mb-6"></div>

<form action="{{ route('pages.dealer.order-index') }}" method="GET" class="mb-6">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">

    {{-- Search --}}
    <div>
      <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Order ID / Customer</label>
      <input type="text" name="search" value="{{ request('search') }}"
             class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700 placeholder-slate-500 italic"
             placeholder="Order ID, customer name, email...">
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Status</label>
      <select name="status"
              class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
        <option value="">All</option>
        @foreach(['pending', 'confirm', 'processing', 'shipped', 'completed'] as $status)
          <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
            {{ ucfirst($status) }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Payment Method --}}
    <div>
      <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Payment Type</label>
      <select name="payment_method"
              class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
        <option value="">All</option>
        @foreach(['cash', 'dp', 'installment'] as $method)
          <option value="{{ $method }}" {{ request('payment_method') === $method ? 'selected' : '' }}>
            {{ ucfirst($method) }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Quick Date Range --}}
    <div>
      <label class="block text-gray-700 dark:text-gray-300 text-sm mb-1">Date Range</label>
      <select name="quick_date"
              class="w-full border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
        <option value="">All Time</option>
        <option value="today" {{ request('quick_date') === 'today' ? 'selected' : '' }}>Today</option>
        <option value="7days" {{ request('quick_date') === '7days' ? 'selected' : '' }}>Last 7 Days</option>
        <option value="30days" {{ request('quick_date') === '30days' ? 'selected' : '' }}>Last 30 Days</option>
      </select>
    </div>

 {{-- Buttons + Sort --}}
<div class="md:col-span-4 flex flex-wrap sm:justify-end items-center gap-3 mt-4">
    <div>
        <select name="sort"
                class="border rounded px-3 py-2 text-sm dark:bg-gray-900 dark:text-white dark:border-gray-700">
            <option value="created_at_desc" {{ request('sort') === 'created_at_desc' ? 'selected' : '' }}>Newest</option>
            <option value="created_at_asc" {{ request('sort') === 'created_at_asc' ? 'selected' : '' }}>Oldest</option>
        </select>
    </div>

    <div class="flex gap-2">
        <button type="submit"
                class="px-4 py-2 bg-teal-600 text-white text-sm rounded hover:bg-teal-700">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
        <a href="{{ route('pages.dealer.order-index') }}"
           class="text-sm text-gray-500 hover:underline flex items-center gap-1">
            <i class="fas fa-redo"></i> Reset
        </a>
    </div>
    </div>
  </div>
</form>

 <div class="border-t-2 border-blue-400 mb-6"></div><br>

  {{-- Order List --}}
  @forelse($orders as $order)
    <div class="pb-6 mb-6 border-b border-gray-300 dark:border-gray-700 group">
      <div class="flex justify-between items-start mb-2">
        <div>
          <h3 class="text-lg font-bold text-gray-800 dark:text-white">
            {{ $order->customer->user->name ?? '-' }}
          </h3>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ $order->customer->user->email }}</p>
        </div>
        <div class="text-right">
          <span class="text-sm px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-700">
            {{ $order->car->car_code ?? '-' }}
          </span>
          <span class="ml-2 text-xs px-2 py-1 rounded-full
            {{ $order->payment_method === 'credit' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' }}">
            {{ ucfirst($order->payment_method ?? '-') }}
          </span>
        </div>
      </div>

      <div class="grid sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
        <div>
          <div class="font-semibold">Total Price:</div>
          <div class="text-base text-gray-800 dark:text-white font-bold">
            Rp{{ number_format($order->total_price, 0, ',', '.') }}
          </div>
        </div>
        @if($order->payment_method === 'credit')
          <div>
            <div>DP: Rp{{ number_format($order->down_payment, 0, ',', '.') }} ({{ $order->down_payment_percent }}%)</div>
            <div>Cicilan: Rp{{ number_format($order->monthly_installment, 0, ',', '.') }} × {{ $order->tenor }} bln</div>
          </div>
        @endif
      </div>

      <div class="mt-4 flex justify-between items-center text-sm">
        <span class="px-4 py-1 rounded-full text-white font-semibold
          {{ match($order->order_status) {
            'pending' => 'bg-gray-500',
            'confirm' => 'bg-blue-500',
            'processing' => 'bg-yellow-400 text-black',
            'shipped' => 'bg-purple-600',
            'completed' => 'bg-green-600',
            default => 'bg-gray-400'
          } }}">
          {{ ucfirst($order->order_status) }}
        </span>
        <span class="text-gray-500 dark:text-gray-400">
          <i class="far fa-calendar-alt mr-1"></i>{{ $order->created_at->format('d M Y') }}
        </span>
      </div>

    {{-- Documents --}}
@php $docs = $order->customer ?? null; @endphp
@if($docs && ($docs->ktp_doc || $docs->npwp_doc || $docs->salary_doc))
  <div class="mt-4 flex flex-wrap gap-3 text-sm text-gray-700 dark:text-gray-300">
    @if($docs->ktp_doc)
      <a href="{{ asset('storage/'.$docs->ktp_doc) }}" target="_blank"
         class="hover:underline bg-gray-100 dark:bg-gray-800 rounded px-3 py-1 truncate max-w-xs">
        <i class="fas fa-id-card-alt mr-1"></i> ID Card
      </a>
    @endif
    @if($docs->npwp_doc)
      <a href="{{ asset('storage/'.$docs->npwp_doc) }}" target="_blank"
         class="hover:underline bg-gray-100 dark:bg-gray-800 rounded px-3 py-1 truncate max-w-xs">
        <i class="fas fa-file-invoice-dollar mr-1"></i> Tax ID
      </a>
    @endif
    @if($docs->salary_doc)
      <a href="{{ asset('storage/'.$docs->salary_doc) }}" target="_blank"
         class="hover:underline bg-gray-100 dark:bg-gray-800 rounded px-3 py-1 truncate max-w-xs">
        <i class="fas fa-money-check-alt mr-1"></i> Salary Slip
      </a>
    @endif
  </div>
@else
  <p class="mt-4 italic text-gray-400 dark:text-gray-500 text-sm">No documents available</p>
@endif


      {{-- Set Status --}}
      <form action="{{ route('pages.dealer.order-update', $order->order_id) }}" method="POST"
            class="mt-4 flex flex-col sm:flex-row gap-3 max-w-md"
            x-data="{ selectedStatus: '' }"
            @submit.prevent="
              if (selectedStatus === '') {
                alert('Please select a status.');
                return;
              }
              if (confirm('Are you sure to update the status?')) {
                $el.submit();
              }
            ">
        @csrf
        <select name="status" x-model="selectedStatus"
          class="w-full sm:w-64 rounded-lg border-gray-300 dark:border-gray-700 px-4 py-2 text-sm dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition">
          <option value="" disabled selected>Set status</option>
          @foreach(['confirm', 'processing', 'shipped', 'completed'] as $statusOption)
            <option value="{{ $statusOption }}" @if($order->order_status === $statusOption) disabled @endif>
              {{ ucfirst($statusOption) }}
            </option>
          @endforeach
        </select>
        <button type="submit"
          class="bg-teal-600 hover:bg-teal-700 text-white rounded-lg px-6 py-2 font-medium text-sm disabled:opacity-50"
          :disabled="!selectedStatus">
          <i class="fas fa-save mr-1"></i> Save
        </button>
      </form>
    </div>
  @empty
    <div class="text-center py-16 text-gray-500 dark:text-gray-400">
      <i class="fas fa-box-open text-5xl mb-4"></i>
      <p class="italic">No orders found.</p>
    </div>
  @endforelse

  {{-- Pagination --}}
  <div class="mt-10 flex justify-center">
    {{ $orders->withQueryString()->links() }}
  </div>

</div>
@endsection
