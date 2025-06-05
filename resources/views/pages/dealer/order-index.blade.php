@extends('layouts.dealer')

@section('content')
<div class="max-w-4xl mx-auto mt-14 bg-white p-8 rounded-xl shadow-lg">
  <!-- Judul Halaman -->
  <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Orders</h2>

  <!-- Form Pencarian -->
  <form action="{{ route('pages.dealer.order-index') }}" method="GET" class="mb-8 flex gap-4">
    <input
      type="text"
      name="search"
      value="{{ request('search') }}"
      placeholder="Search by customer name or email"
      autocomplete="off"
      class="flex-grow rounded-md border border-gray-300 px-4 py-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500"
    />
    <button
      type="submit"
      class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded-md shadow-md font-semibold transition-colors duration-300"
    >
      Search
    </button>
  </form>

  <!-- Filter Status Order -->
  <div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('pages.dealer.order-index') }}"
       class="px-5 py-2 rounded-lg font-semibold transition
              {{ request()->query('status') == null ? 'bg-blue-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
      All
    </a>
    @foreach(['confirm', 'processing', 'shipped', 'completed'] as $filterStatus)
      <a href="{{ route('pages.dealer.order-index', ['status' => $filterStatus]) }}"
         class="px-5 py-2 rounded-lg font-semibold transition
                {{ request()->query('status') == $filterStatus ? 'bg-blue-700 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
        {{ ucfirst($filterStatus) }}
      </a>
    @endforeach
  </div>

  <!-- Notifikasi Success -->
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm text-base">
      {{ session('success') }}
    </div>
  @endif

  <!-- Daftar Order -->
  @forelse ($orders as $order)
    <div class="border border-gray-300 rounded-lg p-5 mb-6 shadow-sm hover:shadow-md transition">
      <!-- Info Customer & Mobil -->
      <div class="flex justify-between items-start mb-3">
        <div>
          <h3 class="text-lg font-semibold text-gray-900">{{ $order->customer->user->name ?? 'N/A' }}</h3>
          <p class="text-sm text-gray-600 truncate max-w-lg">{{ $order->customer->user->email ?? '-' }}</p>
          <p class="text-sm text-gray-600 truncate max-w-lg">{{ $order->customer->user->phone ?? '-' }}</p>
        </div>
        <div class="text-right">
          <p class="font-semibold text-gray-800 text-base">{{ $order->car->car_code ?? 'N/A' }}</p>
          <p>
            <span
              class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                     {{ $order->payment_method === 'credit' ? 'bg-yellow-300 text-yellow-900' : 'bg-green-300 text-green-900' }}">
              {{ ucfirst($order->payment_method ?? '-') }}
            </span>
          </p>
        </div>
      </div>

      <!-- Detail Harga dan Cicilan -->
      <div class="mb-4 text-gray-700 text-base">
        <p>Total Price: <span class="font-semibold">Rp{{ number_format($order->total_price, 0, ',', '.') }}</span></p>

        @if($order->payment_method === 'credit' && $order->down_payment)
          <p class="text-sm text-gray-500">
            Down Payment (DP): Rp{{ number_format($order->down_payment, 0, ',', '.') }} ({{ $order->down_payment_percent }}%)
          </p>
          <p class="text-sm text-gray-500">
            Monthly Installment: Rp{{ number_format($order->monthly_installment, 0, ',', '.') }} × {{ $order->tenor }} months
          </p>
        @endif
      </div>

      <!-- Status dan Tanggal -->
      <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
        @php
          $statusColors = [
            'confirm' => 'bg-blue-600',
            'processing' => 'bg-yellow-400 text-black',
            'shipped' => 'bg-purple-600',
            'completed' => 'bg-green-600',
          ];
          $colorClass = $statusColors[$order->order_status] ?? 'bg-gray-400';
        @endphp
        <span class="px-4 py-1 rounded-full text-white text-sm font-semibold {{ $colorClass }}">
          {{ ucfirst($order->order_status) }}
        </span>

        <span class="text-sm text-gray-600">Order date: {{ $order->created_at->format('d M Y') }}</span>
      </div>

      <!-- Dokumen -->
      <div class="mb-5 space-y-1 text-sm text-blue-700 max-w-lg">
        @php $docs = $order->customer ?? null; @endphp
        @if($docs && ($docs->ktp_doc || $docs->npwp_doc || $docs->salary_doc))
          @if($docs->ktp_doc)
            <a href="{{ asset('storage/'.$docs->ktp_doc) }}" target="_blank" class="hover:underline block truncate max-w-lg">ID Card</a>
          @endif
          @if($docs->npwp_doc)
            <a href="{{ asset('storage/'.$docs->npwp_doc) }}" target="_blank" class="hover:underline block truncate max-w-lg">Tax Document</a>
          @endif
          @if($docs->salary_doc)
            <a href="{{ asset('storage/'.$docs->salary_doc) }}" target="_blank" class="hover:underline block truncate max-w-lg">Salary Slip</a>
          @endif
        @else
          <p class="italic text-gray-400">No documents available</p>
        @endif
      </div>

      <!-- Form Update Status Order -->
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
        <div class="flex flex-col sm:flex-row gap-4 max-w-lg">
          <select
            name="status"
            x-model="selectedStatus"
            class="flex-grow rounded-md border border-gray-300 px-4 py-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          >
            <option value="" disabled selected>Set status</option>
            @foreach(['confirm', 'processing', 'shipped', 'completed'] as $statusOption)
              <option value="{{ $statusOption }}" @if($order->order_status === $statusOption) disabled @endif>
                {{ ucfirst($statusOption) }}
              </option>
            @endforeach
          </select>
          <button
            type="submit"
            class="bg-blue-700 hover:bg-blue-800 text-white rounded-md px-6 py-2 font-semibold transition disabled:opacity-50"
            :disabled="!selectedStatus"
          >
            Save
          </button>
        </div>
      </form>
    </div>
  @empty
    <p class="text-center text-gray-500 italic text-base">No orders available.</p>
  @endforelse

  <!-- Pagination -->
  <div class="mt-8">
    {{ $orders->withQueryString()->links() }}
  </div>
</div>
@endsection

