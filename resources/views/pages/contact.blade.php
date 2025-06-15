@extends('layouts.user')

@section('title', 'Contact Us')

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    html, body {
        scroll-behavior: smooth;
        box-sizing: border-box;
        width: 100%;
        overflow-x: hidden;
    }
    *, *::before, *::after {
        box-sizing: inherit;
    }
    .reveal {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .reveal.active {
        opacity: 1;
        transform: translateY(0px);
    }
    .reveal-left {
        opacity: 0;
        transform: translateX(-50px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }
    .reveal-left.active {
        opacity: 1;
        transform: translateX(0px);
    }
    @keyframes spin-forever {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    #rotating-image img {
        animation: spin-forever 20s linear infinite;
    }
    .half-cover-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to top, #f2f2f2 80%, rgba(242, 242, 242, 0) 100%);
        border-bottom-left-radius: 1000px;
        border-bottom-right-radius: 1000px;
        z-index: 10;
        padding-bottom: 60px;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="pt-[55px] w-full">
    <!-- Hero Image -->
    <img src="{{ asset('images/hero_cars.jpg') }}" alt="Hero Cars" class="w-full object-cover max-h-[300px] md:max-h-[500px]">

    <div class="my-10 md:my-32 px-4 sm:px-6 md:px-12 mb-20">
        <!-- Judul Section -->
        <div class="text-center reveal max-w-screen-lg mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-black">Contact Us</h1>
            <p class="text-gray-600 mt-6 text-base md:text-lg max-w-2xl mx-auto">
                "Contact us and be part of this amazing journey together."
            </p>
        </div>

        <!-- Kontak Info -->
        <div class="my-10 md:my-32 text-center reveal max-w-screen-lg mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-black">Need Further Assistance?</h1>
            <p class="text-gray-600 mt-6 text-base md:text-lg max-w-2xl mx-auto">
                Our team is ready to support you. Feel free to reach out through the contact methods below.
            </p>

            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-y-8 gap-x-4 md:gap-x-10 text-left px-0 md:px-10">
                <div class="border-b md:border-b-0 md:border-r border-gray-300 pb-6 md:pb-0 md:pr-6 reveal-left">
                    <h2 class="text-xl font-semibold text-black mb-3">Phone + Email</h2>
                    <p class="text-gray-700 break-words">Phone: 0813-7853-5706</p>
                    <p class="text-gray-700 mt-1 break-words">Email: venuscars@gmail.com</p>
                </div>
                <div class="border-b md:border-b-0 md:border-r border-gray-300 md:px-6 reveal-left">
                    <h2 class="text-xl font-semibold text-black mb-3">Response Hours</h2>
                    <p class="text-gray-700">
                        <span class="font-semibold underline">Normal Hours:</span><br>
                        Monday – Friday: 8:00 a.m. – 8:00 p.m.<br>
                        Saturday: 9:00 a.m. – 7:00 p.m.
                    </p>
                </div>
                <div class="md:pl-6 reveal-left">
                    <h2 class="text-xl font-semibold text-black mb-3">Postal Mail</h2>
                    <p class="text-gray-700 break-words">
                        Venus Cars<br>
                        Jalan Ahmad Yani No. 88,<br>
                        Komp. Ruko Mitra Raya Blok B No.5,<br>
                        Batam City, Riau Islands 29444<br>
                        Indonesia
                    </p>
                </div>
            </div>
        </div>

        <!-- VC Engagement -->
        <div class="text-center reveal py-12 max-w-screen-md mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold text-black">VC Engagement Center</h1>
            <p class="text-lg font-semibold mt-6 text-gray-700">Call 0813-7853-5706</p>
            <div class="mt-4 text-gray-800">
                <p class="font-semibold underline">Normal Hours:</p>
                <p>Monday – Friday: 8:00 a.m. – 8:00 p.m.</p>
                <p>Saturday: 9:00 a.m. – 7:00 p.m.</p>
            </div>
            <a href="https://wa.me/6281378535706?text=Halo%20Venus%20Cars%2C%20saya%20ingin%20bertanya%20tentang%20mobil%20yang%20tersedia."
                class="mt-6 inline-block bg-[#4ab7bb] hover:bg-[#51a1a4] text-white font-semibold px-6 py-3 rounded transition">
                Contact Us
            </a>
        </div>

        <!-- Rotating Image -->
        <div class="w-full max-w-xl sm:max-w-2xl md:max-w-[1100px] mx-auto relative mt-16 overflow-hidden" id="rotating-image">
            <img src="{{ asset('images/image.png') }}" alt="Support Image" class="rounded-full w-full h-auto object-cover">

            <!-- Text Overlay -->
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 reveal">
                <h2 class="text-black mt-2 text-sm md:text-lg max-w-2xl">Explore Venus Cars' journey in Batam</h2>
                <p class="text-black mt-2 text-sm md:text-lg max-w-2xl">
                    Discover our journey of innovation and dedication.
                </p>
            </div>

            <!-- Bottom Cover -->
            <div class="half-cover-bottom flex flex-col items-center justify-center text-center py-8">
                <h2 class="text-2xl md:text-4xl font-bold text-gray-800 reveal">Realize the vision, explore innovation</h2>
                <a href="#"
                    class="mt-4 bg-[#ed1c24] hover:bg-[#c3141b] text-white font-bold text-lg md:text-2xl px-6 py-3 rounded-full shadow-lg transition reveal">
                    Find Your Cars!
                </a>
            </div>
        </div>
    </div>
</div>
@include('components.floating-menu')
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const revealElements = document.querySelectorAll(".reveal, .reveal-left");
    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        revealElements.forEach((el) => {
            const elementTop = el.getBoundingClientRect().top;
            if (elementTop < windowHeight - 100) {
                el.classList.add("active");
            }
        });
    };
    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
});
</script>
@endpush
