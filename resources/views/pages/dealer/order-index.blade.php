@extends('layouts.dealer')

@section('content')
<div class="max-w-5xl mx-auto mt-14 bg-white p-8 rounded-xl shadow-lg">
  <!-- Judul Halaman -->
  <h2 class="text-3xl font-extrabold text-blue-900 mb-8">Orders</h2>

  <!-- Advanced Filter & Search -->
  <form action="{{ route('pages.dealer.order-index') }}" method="GET" class="mb-8 flex flex-wrap gap-4 items-end bg-gray-50 p-4 rounded-lg">
    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Search</label>
      <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Customer, email, phone, car model"
        autocomplete="off"
        class="rounded-md border border-gray-300 px-4 py-2 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 w-56"
      />
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
      <select name="status" class="rounded-md border-gray-300 px-4 py-2 w-40">
        <option value="">All</option>
        @foreach(['pending', 'confirm', 'processing', 'shipped', 'completed'] as $filterStatus)
          <option value="{{ $filterStatus }}" {{ request('status') === $filterStatus ? 'selected' : '' }}>{{ ucfirst($filterStatus) }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Payment Method</label>
      <select name="payment_method" class="rounded-md border-gray-300 px-4 py-2 w-40">
        <option value="">All</option>
        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Cash</option>
        <option value="dp" {{ request('payment_method') === 'dp' ? 'selected' : '' }}>Down Payment (DP)</option>
        <option value="installment" {{ request('payment_method') === 'installment' ? 'selected' : '' }}>Installment</option>
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Car Type</label>
      <select name="car_type" class="rounded-md border-gray-300 px-4 py-2 w-40">
        <option value="">All</option>
        @foreach ($allCarTypes as $carType)
          @if($carType)
            <option value="{{ $carType }}" {{ request('car_type') == $carType ? 'selected' : '' }}>{{ ucfirst($carType) }}</option>
          @endif
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Customer</label>
      <select name="customer_id" class="rounded-md border-gray-300 px-4 py-2 w-40">
        <option value="">All</option>
        @foreach ($allCustomers as $cid => $cname)
          <option value="{{ $cid }}" {{ request('customer_id') == $cid ? 'selected' : '' }}>{{ $cname }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Order Date From</label>
      <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded border-gray-300 px-2 py-2 w-36"/>
    </div>
    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Order Date To</label>
      <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded border-gray-300 px-2 py-2 w-36"/>
    </div>

    <div>
      <label class="block text-xs font-semibold text-gray-600 mb-1">Sort</label>
      <select name="sort" class="rounded-md border-gray-300 px-4 py-2 w-40">
        <option value="created_at_desc" {{ request('sort') === 'created_at_desc' ? 'selected' : '' }}>Newest</option>
        <option value="created_at_asc" {{ request('sort') === 'created_at_asc' ? 'selected' : '' }}>Oldest</option>
        <option value="customer_asc" {{ request('sort') === 'customer_asc' ? 'selected' : '' }}>Customer A-Z</option>
        <option value="customer_desc" {{ request('sort') === 'customer_desc' ? 'selected' : '' }}>Customer Z-A</option>
      </select>
    </div>

    <div class="flex items-end">
      <button
        type="submit"
        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-md shadow-md font-semibold transition-colors duration-300 mt-1"
      >
        <i class="fas fa-filter mr-2"></i>Filter
      </button>
      <a href="{{ route('pages.dealer.order-index') }}"
         class="ml-2 px-5 py-2 rounded-md bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition mt-1">
        Reset
      </a>
    </div>
  </form>

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
          <p class="font-semibold text-gray-800 text-base">{{ $order->car->car_code ?? 'N/A' }} <span class="text-xs font-normal text-gray-400 ml-1">{{ $order->car->type ?? '' }}</span></p>
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
            'pending' => 'bg-gray-400',
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

