@extends('layouts.dealer')

@section('content')
<div class="max-w-7xl mx-auto mt-12 px-4 md:px-6 lg:px-8 py-10 bg-gray-50 dark:bg-gray-900 rounded-md shadow-2xl">

  {{-- Title --}}
  <h2 class="text-2xl md:text-3xl font-bold text-blue-900 dark:text-blue-100 mb-8 flex items-center gap-3">
    <span class="w-12 h-12 flex items-center justify-center bg-indigo-100 dark:bg-blue-800/30 text-indigo-600 dark:text-blue-300 rounded-full shadow">
      <i class="fas fa-clipboard-list text-2xl"></i>
    </span>
    <span>ORDERS</span>
  </h2>

  {{-- Filter Form --}}
  <form action="{{ route('pages.dealer.order-index') }}" method="GET"
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 bg-gray-50 dark:bg-gray-800 p-6 rounded-xl shadow mb-10 border border-gray-200 dark:border-gray-700">

    {{-- Search --}}
    <div>
      <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">Search</label>
      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Customer, email, phone"
          class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
        <i class="fas fa-search absolute top-3 right-3 text-gray-400"></i>
      </div>
    </div>

    {{-- Status --}}
    <div>
      <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">Status</label>
      <select name="status"
        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
        <option value="">All</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="confirm" {{ request('status') === 'confirm' ? 'selected' : '' }}>Confirm</option>
        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
        <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
      </select>
    </div>

    {{-- Payment Method --}}
    <div>
      <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">Payment Method</label>
      <select name="payment_method"
        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
        <option value="">All</option>
        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="dp" {{ request('payment_method') === 'dp' ? 'selected' : '' }}>Down Payment (DP)</option>
        <option value="installment" {{ request('payment_method') === 'installment' ? 'selected' : '' }}>Installment</option>
      </select>
    </div>

    {{-- Date Range --}}
    <div>
      <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">Order Date</label>
      <div class="flex gap-2">
        <input type="date" name="date_from" value="{{ request('date_from') }}"
          class="w-1/2 rounded-xl border border-gray-300 dark:border-gray-700 px-2 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
        <input type="date" name="date_to" value="{{ request('date_to') }}"
          class="w-1/2 rounded-xl border border-gray-300 dark:border-gray-700 px-2 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
      </div>
    </div>

    {{-- Buttons --}}
    <div class="col-span-full flex flex-col sm:flex-row justify-between gap-4 mt-2 items-center">
      <div class="flex gap-2">
        <button type="submit"
          class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-xl font-semibold shadow-lg transition flex items-center gap-2">
          <i class="fas fa-filter"></i> Filter
        </button>
        <a href="{{ route('pages.dealer.order-index') }}"
          class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-700 px-6 py-2 rounded-xl font-semibold transition flex items-center gap-2">
          <i class="fas fa-redo"></i> Reset
        </a>
      </div>

      <select name="sort"
        class="w-full sm:w-48 rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-2 text-sm text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-900 focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
        <option value="created_at_desc" {{ request('sort') === 'created_at_desc' ? 'selected' : '' }}>Newest</option>
        <option value="created_at_asc" {{ request('sort') === 'created_at_asc' ? 'selected' : '' }}>Oldest</option>
        <option value="customer_asc" {{ request('sort') === 'customer_asc' ? 'selected' : '' }}>Customer A-Z</option>
        <option value="customer_desc" {{ request('sort') === 'customer_desc' ? 'selected' : '' }}>Customer Z-A</option>
      </select>
    </div>
  </form>

  {{-- Order Cards --}}
  @forelse ($orders as $order)
    <div class="border border-gray-200 dark:border-gray-800 rounded-2xl p-7 mb-8 shadow hover:shadow-lg transition bg-gradient-to-br from-white via-gray-50 to-gray-100 dark:from-gray-900 dark:via-gray-800/40 dark:to-gray-800/60">

      <!-- Info -->
      <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-4">
        <div>
          <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fas fa-user-circle text-blue-400"></i>
            {{ $order->customer->user->name ?? 'N/A' }}
          </h3>
          <p class="text-sm text-gray-700 dark:text-gray-300">Email: <span class="font-medium">{{ $order->customer->user->email ?? '-' }}</span></p>
          <p class="text-sm text-gray-700 dark:text-gray-300">Phone: <span class="font-medium">{{ $order->customer->user->phone ?? '-' }}</span></p>
        </div>
        <div class="text-right">
          <div class="flex items-center gap-2 justify-end">
            <span class="font-semibold text-gray-800 dark:text-gray-100 text-base">{{ $order->car->car_code ?? 'N/A' }}</span>
            <span class="px-2 py-1 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-medium">{{ $order->car->type ?? '' }}</span>
          </div>
          <span class="inline-block rounded-full px-3 py-1 mt-2 text-xs font-semibold shadow
            {{ $order->payment_method === 'credit' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200' : 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' }}">
            {{ ucfirst($order->payment_method ?? '-') }}
          </span>
        </div>
      </div>

      <!-- Price -->
      <div class="mb-4 text-gray-800 dark:text-gray-100 grid grid-cols-1 md:grid-cols-2 gap-x-8">
        <div>
          <span class="block font-semibold">Total Price:</span>
          <span class="inline-block font-bold text-lg">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
        @if($order->payment_method === 'credit' && $order->down_payment)
        <div>
          <span class="block text-sm"><span class="font-semibold">Down Payment (DP):</span> Rp{{ number_format($order->down_payment, 0, ',', '.') }} ({{ $order->down_payment_percent }}%)</span>
          <span class="block text-sm"><span class="font-semibold">Installment:</span> Rp{{ number_format($order->monthly_installment, 0, ',', '.') }} × {{ $order->tenor }} months</span>
        </div>
        @endif
      </div>

      <!-- Status -->
      <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
        @php
          $statusColors = [
            'pending' => 'bg-gray-400 dark:bg-gray-600',
            'confirm' => 'bg-blue-600 dark:bg-blue-500',
            'processing' => 'bg-yellow-400 dark:bg-yellow-600 text-black',
            'shipped' => 'bg-purple-500 dark:bg-purple-600',
            'completed' => 'bg-green-600 dark:bg-green-500',
          ];
          $colorClass = $statusColors[$order->order_status] ?? 'bg-gray-400 dark:bg-gray-600';
        @endphp
        <span class="px-5 py-1 rounded-full text-white text-sm font-semibold shadow {{ $colorClass }}">
          {{ ucfirst($order->order_status) }}
        </span>
        <span class="text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
          <i class="far fa-calendar-alt"></i> Order date: {{ $order->created_at->format('d M Y') }}
        </span>
      </div>

      <!-- Documents -->
      <div class="mb-4 space-y-1 text-sm text-gray-700 dark:text-gray-300 max-w-lg">
        @php $docs = $order->customer ?? null; @endphp
        @if($docs && ($docs->ktp_doc || $docs->npwp_doc || $docs->salary_doc))
          <div class="flex flex-wrap gap-3">
            @if($docs->ktp_doc)
              <a href="{{ asset('storage/'.$docs->ktp_doc) }}" target="_blank" class="hover:underline block truncate max-w-xs bg-gray-100 dark:bg-gray-800 rounded px-3 py-1">
                <i class="fas fa-id-card-alt"></i> ID Card
              </a>
            @endif
            @if($docs->npwp_doc)
              <a href="{{ asset('storage/'.$docs->npwp_doc) }}" target="_blank" class="hover:underline block truncate max-w-xs bg-gray-100 dark:bg-gray-800 rounded px-3 py-1">
                <i class="fas fa-file-invoice-dollar"></i> Tax Document
              </a>
            @endif
            @if($docs->salary_doc)
              <a href="{{ asset('storage/'.$docs->salary_doc) }}" target="_blank" class="hover:underline block truncate max-w-xs bg-gray-100 dark:bg-gray-800 rounded px-3 py-1">
                <i class="fas fa-money-check-alt"></i> Salary Slip
              </a>
            @endif
          </div>
        @else
          <p class="italic text-gray-400 dark:text-gray-600">No documents available</p>
        @endif
      </div>

      <!-- Update Status -->
      <form action="{{ route('pages.dealer.order-update', $order->order_id) }}" method="POST" x-data="{ selectedStatus: '' }"
            @submit.prevent="
              if(selectedStatus === '') {
                alert('Please select a status.');
                return;
              }
              if(confirm('Are you sure to update the status?')) {
                $el.submit();
              }
            ">
        @csrf
        <div class="flex flex-col md:flex-row gap-3 max-w-lg">
          <select name="status" x-model="selectedStatus"
            class="flex-grow rounded-xl border border-gray-300 dark:border-gray-700 px-4 py-2 text-base bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition" required>
            <option value="" disabled selected>Set status</option>
            @foreach(['confirm', 'processing', 'shipped', 'completed'] as $statusOption)
              <option value="{{ $statusOption }}" @if($order->order_status === $statusOption) disabled @endif>
                {{ ucfirst($statusOption) }}
              </option>
            @endforeach
          </select>
          <button type="submit"
            class="bg-teal-600 hover:bg-teal-700 text-white rounded-xl px-8 py-2 font-semibold transition disabled:opacity-50"
            :disabled="!selectedStatus">
            <i class="fas fa-save mr-1"></i> Save
          </button>
        </div>
      </form>
    </div>
  @empty
    <div class="flex flex-col items-center justify-center py-16">
      <i class="fas fa-box-open text-5xl text-gray-300 dark:text-gray-700 mb-4"></i>
      <p class="text-center text-gray-400 dark:text-gray-600 italic text-lg">No orders available.</p>
    </div>
  @endforelse

  <!-- Pagination -->
  <div class="mt-10 flex justify-center">
    {{ $orders->withQueryString()->links() }}
  </div>
</div>
@endsection
