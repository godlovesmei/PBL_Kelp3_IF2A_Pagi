<footer class="relative bg-gray-50 dark:bg-gray-900 border-t border-[#d2e3ea] dark:border-gray-700 mt-20">
    <div class="max-w-screen-xl mx-auto px-6 py-12 sm:py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 gap-y-8">
            <!-- Brand Info -->
            <div>
                <h3 class="text-2xl font-bold font-serif text-gray-900 dark:text-white mb-4">Venus Cars</h3>
                <p class="text-base sm:text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Delivering the best car selections for every journey in life.
                    Because every wheel has its own story.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h4>
                <ul class="space-y-2 text-base sm:text-sm text-gray-600 dark:text-gray-400">
                    <li><a href="{{ route('pages.about') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">About Us</a>
                    </li>
                    <li><a href="{{ route('pages.shop') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Showroom</a>
                    </li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Contact</a>
                    </li>
                    <li><a href="{{ route('pages.brochure.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Brochure</a>
                    </li>
                </ul>
            </div>

            <!-- Contact & Socials -->
            <div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Us</h4>
                <p class="text-base sm:text-sm text-gray-600 dark:text-gray-400">Need help? Reach out to our support
                    team:</p>
                <a href="https://wa.me/6281378535706" target="_blank"
                    class="mt-2 font-medium text-gray-800 dark:text-gray-200 block">
                    +62 813-7853-5706
                </a>
                <div class="flex space-x-4 mt-5 text-gray-500 dark:text-gray-400 text-xl">
                    <a href="https://www.instagram.com/hondaisme" target="_blank" aria-label="Instagram"
                        class="hover:text-pink-500 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://x.com/hondaisme" target="_blank" aria-label="Twitter"
                        class="hover:text-sky-400 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/hondaisme" target="_blank" aria-label="Facebook"
                        class="hover:text-blue-600 transition">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.youtube.com/hondaisme" target="_blank" aria-label="YouTube"
                        class="hover:text-red-500 transition">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTopBtn"
        class="fixed bottom-4 left-4 sm:bottom-6 sm:left-6 z-50 flex items-center justify-center
           w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#16274c] hover:bg-blue-700
           text-white font-semibold shadow-lg transition duration-300 hidden"
        aria-label="Back to top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>
    <!-- Bottom -->
    <div class="bg-gray-50 dark:bg-gray-800 py-4 border-t border-gray-200 dark:border-gray-700">
        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            © 2025 <span class="font-semibold text-gray-700 dark:text-white">Venus Cars</span>. Drive Your Destiny.
        </p>
    </div>

    <!-- Back to Top Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopBtn = document.getElementById('backToTopBtn');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('hidden');
                } else {
                    backToTopBtn.classList.add('hidden');
                }
            });
        });
    </script>
</footer>


