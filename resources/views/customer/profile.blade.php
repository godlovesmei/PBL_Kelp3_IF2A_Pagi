@extends('layouts.customer')

@section('title', 'My Profile')

@section('content')
<div class="flex pt-20">

  <!-- SIDEBAR -->
  <aside class="w-[220px] bg-[#bcbcbc] rounded-xl m-6 flex-shrink-0 flex flex-col justify-between py-10 px-6">
    <div class="text-center">
      <i class="fas fa-user-circle text-6xl text-black mb-6"></i>
      <nav class="space-y-4 text-sm text-black font-semibold">
        <a href="#" class="block hover:underline">DASHBOARD</a>
        <a href="#" class="block hover:underline">TRANSAKSI</a>
        <a href="#" class="block hover:underline">EDIT PROFIL</a>
      </nav>
    </div>
    <div class="border-t border-gray-500 mt-10 pt-6 text-center">
        <form id="logout-form" action="{{ route('customer.logout') }}" method="POST">
          @csrf
          <button type="submit" class="text-red-600 font-bold text-sm flex items-center justify-center gap-2">
            <i class="fas fa-sign-out-alt"></i> LOGOUT
          </button>
        </form>
      </div>
  </aside>

  <!-- MAIN PROFILE CONTENT -->
  <main class="flex-1 m-6">
    <div class="bg-[#bcbcbc] rounded-xl shadow-md px-10 py-8 max-w-3xl mx-auto">
      <h1 class="text-3xl font-bold mb-8 text-center">My Profile</h1>
      <form class="space-y-6">
        <div>
          <label class="block font-medium mb-1">Upload Photo:</label>
          <input type="file" class="block w-full bg-gray-300 px-4 py-2 rounded" />
        </div>
        <div>
          <label class="block font-medium mb-1">Name:</label>
          <input type="text" class="block w-full bg-gray-300 px-4 py-2 rounded" />
        </div>
        <div>
          <label class="block font-medium mb-1">Phone Number:</label>
          <input type="text" class="block w-full bg-gray-300 px-4 py-2 rounded" />
        </div>
        <div>
          <label class="block font-medium mb-1">Address:</label>
          <input type="text" class="block w-full bg-gray-300 px-4 py-2 rounded" />
        </div>
        <button type="submit" class="bg-gray-700 text-white px-6 py-2 rounded hover:bg-gray-800">Save</button>
      </form>
    </div>
  </main>
</div>
@endsection