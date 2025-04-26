@extends('layouts.customer')

@section('title', 'Shop')

@section('content')
<main class="bg-white py-10 px-6">
  <div class="min-h-screen flex flex-col pt-[80px]">
    <h1 class="text-2xl font-bold mb-8 text-center">Katalog Mobil</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
      @foreach ($cars as $car)
      <div class="border rounded-2xl p-4 shadow-md text-center hover:shadow-lg transition">
        <img src="{{ asset('images/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="mx-auto mb-4 h-36 object-contain">
        <h2 class="text-lg font-semibold mb-1">{{ $car->brand }} {{ $car->model }}</h2>
        <p class="text-sm text-gray-600 mb-1">{{ $car->category }} - {{ $car->year }}</p>
        <p class="font-semibold">Rp{{ number_format($car->price, 0, ',', '.') }}</p>

        {{-- Warna Mobil --}}
        @if($car->colors->count())
        <div class="mt-2">
          <span class="text-sm font-medium">Warna:</span>
          <ul class="flex flex-wrap justify-center gap-1 mt-1">
            @foreach ($car->colors as $color)
              <li class="px-2 py-1 text-xs rounded bg-gray-200">{{ $color->color_name }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        {{-- Wishlist & Detail Button --}}
        <div class="mt-4 flex justify-center gap-2">
          <a href="{{ route('customer.cars.show', $car->id) }}"
             class="border-2 border-black rounded-full px-4 py-2 text-sm hover:bg-black hover:text-white transition">
              Detail
          </a>
          <button class="addToWishlistBtn border-2 border-black rounded-full px-4 py-2 text-sm hover:bg-black hover:text-white transition"
                  data-car-id="{{ $car->id }}">
              Add To Wishlist
          </button>
      </div>
      </div>
      @endforeach
    </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
      // Ketika tombol Add To Wishlist diklik
      $('.addToWishlistBtn').click(function() {
          var carId = $(this).data('car-id'); // Ambil car_id dari atribut data

          $.ajax({
              url: '{{ route("customer.wishlist.store") }}', // URL untuk store wishlist
              type: 'POST',
              data: {
                  _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                  car_id: carId // Kirim car_id
              },
              success: function(response) {
                  // Jika berhasil, tampilkan pesan sukses
                  alert('Mobil berhasil ditambahkan ke wishlist!');
                  // Bisa tambahkan logika untuk mengganti tampilan tombol, misalnya mengganti teks tombol jadi 'Added'
                  var button = $('.addToWishlistBtn[data-car-id="'+carId+'"]');
                  button.text('Added').attr('disabled', true); // Mengubah teks tombol dan menonaktifkan tombol
              },
              error: function(xhr, status, error) {
                  // Jika gagal, tampilkan pesan error
                  if (xhr.status === 401) {
                      alert('Silakan login terlebih dahulu!');
                  } else {
                      alert('Terjadi kesalahan: ' + error);
                  }
              }
          });
      });
  });
</script>

@endsection
