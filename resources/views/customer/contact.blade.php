@extends('layouts.customer')

@section('title', 'Profil Perusahaan')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    html, body {
      scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<!-- Main Contains -->
<div class="pt-20 w-full">
    <!-- Hero Image -->
    <img src="{{ asset('images/hero_cars.jpg') }}" alt="Hero Cars" class="w-full object-cover">

    <!-- Contact Us Section -->
    <div class="my-24"></div>
    <div class="bg-[#f2f2f2] py-12 text-center">
        <h1 class="text-4xl font-bold text-black">Contact Us</h1>
        <p class="text-gray-600 mt-6 text-lg px-4 md:px-0 max-w-2xl mx-auto">
            "Contact us and be part of this awesome journey together."
        </p>
    </div>

    <!-- Spacer sebelum section baru -->
    <div class="my-24"></div>

    <!-- Further Assistance -->
    <div class="bg-[#f2f2f2] py-12 text-center">
        <h1 class="text-4xl font-bold text-black">Need Further Assistance?</h1>
        <p class="text-gray-600 mt-6 text-lg px-4 md:px-0 max-w-2xl mx-auto">
            Our team is ready to support you. Feel free to get in touch through the contact methods below.
        </p>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-12 px-4 md:px-24 text-left">
            <!-- Phone + Email -->
            <div class="border-r border-gray-300 pr-6 md:pr-10">
                <h2 class="text-xl font-semibold text-black mb-3">Phone + Email</h2>
                <p class="text-gray-700 text-base">Phone: 0813-7853-5706</p>
                <p class="text-gray-700 text-base mt">Email: @venuscars@gmail.com</p>
            </div>

            <!-- Response Hours -->
            <div class="border-r border-gray-300 px-6 md:px-10">
                <h2 class="text-xl font-semibold text-black mb-3">Response Hours</h2>
                <p class="text-gray-700 text-base">
                    <span class="font-semibold underline">Normal Hours:</span><br>
                    Monday – Friday: 8:00 a.m. – 8:00 p.m.<br>
                    Saturday: 9:00 a.m. – 7:00 p.m.
                </p>
            </div>

            <!-- Postal Mail -->
            <div class="pl-6 md:pl-10">
                <h2 class="text-xl font-semibold text-black mb-3">Postal Mail</h2>
                <p class="text-gray-700 text-base">
                    Venus Cars<br>
                    Jalan Ahmad Yani No. 88,<br>
                    Komp. Ruko Mitra Raya Blok B No.5,<br>
                    Batam Kota, Kepulauan Riau 29444<br>
                    Indonesia
                </p>
            </div>
        </div>
    </div>

    <!-- Spacer sebelum section baru -->
    <div class="my-24"></div>

    <!-- Support Center Section -->
    <div class="bg-[#f2f2f2] py-12 text-center">
        <h1 class="text-4xl font-bold text-black">VC Brand Engagement Center</h1>

        <p class="text-[#fffff] text-xl font-semibold mt-6">
            Call 0813-7853-5706
        </p>

        <div class="mt-6 text-lg text-gray-800">
            <p class="font-semibold underline">Normal Hours:</p>
            <p>Monday – Friday: 8:00 a.m. – 8:00 p.m.</p>
            <p>Saturday: 9:00 a.m. – 7:00 p.m.</p>
        </div>

        <a href="#" class="mt-10 bg-[#bfae91] hover:bg-[#a99b7b] text-white font-semibold text-base px-6 py-3 rounded inline-block text-center">
            Contact Us
        </a>

    </div>
</section>
@endsection