<div x-data="searchComponent()" x-init="init()" class="relative w-full">
    <form action="{{ route('pages.shop') }}" method="GET"
        @submit="$event.target.search.value.trim() === '' ? $event.preventDefault() : null"
        class="w-full h-9 flex items-center bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-full px-2 shadow-sm backdrop-blur
        transition duration-200 group
        hover:border-blue-400 hover:shadow-md dark:hover:border-blue-400 focus-within:border-blue-500 focus-within:shadow-md"
        style="min-height: 36px">
        <svg class="w-4 h-4 text-blue-600 dark:text-blue-300 mr-1.5 transition-transform duration-300 group-hover:scale-110"
            viewBox="0 0 24 24" fill="currentColor">
            <path
                d="m20.267 19.207-4.818-4.818A6.97 6.97 0 0 0 17 10a7 7 0 1 0-7 7 6.97 6.97 0 0 0 4.389-1.55l4.818 4.817a.75.75 0 0 0 1.06 0 .75.75 0 0 0 0-1.06M4.5 10c0-3.033 2.467-5.5 5.5-5.5s5.5 2.467 5.5 5.5-2.467 5.5-5.5 5.5-5.5-2.467-5.5-5.5" />
        </svg>
        <input x-ref="input" type="text" name="search" x-model="search" autocomplete="off" placeholder="Search ..."
            class="flex-1 bg-transparent focus:ring-0 border-0 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition-all py-1 italic"
            @focus="isFocused = true" @blur="isFocused = false" />
        <!-- Loading spinner -->
        <svg x-show="loading" class="w-4 h-4 animate-spin text-blue-400 mx-1" viewBox="0 0 24 24" fill="none">
            <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <!-- Clear Button -->
        <button type="button" x-show="search" @click="search = ''; $refs.input.focus()"
            class="ml-1 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-200 transition"
            tabindex="-1" aria-label="Clear" x-cloak>
            <svg class="w-3.5 h-3.5" viewBox="0 0 16 16" fill="currentColor">
                <path
                    d="M12.243 11.182a.75.75 0 1 1-1.06 1.06L8 9.062l-3.182 3.182a.75.75 0 0 1-1.06 0 .75.75 0 0 1 0-1.06L6.938 8 3.757 4.818a.75.75 0 1 1 1.06-1.06L8 6.938l3.182-3.182a.75.75 0 1 1 1.06 1.06L9.062 8z" />
            </svg>
        </button>
    </form>
    <!-- Autocomplete Dropdown -->
    <div x-show="search.length > 0 && (suggestions.length > 0 || loading || !loading)"
        @mousedown.away="search = ''; suggestions = []"
        class="absolute left-0 right-0 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-2xl z-50 mt-3 text-base max-h-96 overflow-y-auto
        transition-all duration-300 ease-in-out
        animate-fade-in-up"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        style="box-shadow: 0 18px 40px 0 rgba(50,65,120,0.13);">
        <template x-if="search && loading">
            <div class="px-6 py-4 flex items-center space-x-3 text-gray-400 dark:text-gray-500">
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-80" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>Searching...</span>
            </div>
        </template>
        <template x-if="!loading && suggestions.length > 0">
            <ul>
                <template x-for="(item, idx) in suggestions" :key="item.id">
                    <li>
                        <a :href="`/cars/${item.id}`"
                            class="flex items-center gap-4 px-5 py-3 hover:bg-blue-50 dark:hover:bg-gray-800 transition duration-100 rounded-lg group"
                            :class="{ 'bg-blue-100/60 dark:bg-gray-700/60': idx === highlightedIndex }"
                            @mouseover="highlightedIndex = idx" @mouseleave="highlightedIndex = -1"
                            @keydown.enter.prevent="goTo(item.id)">
                            <div
                                class="w-20 h-12 flex items-center justify-center bg-gray-50 dark:bg-gray-700 rounded-md flex-shrink-0 overflow-hidden shadow">
                                <img :src="`/images/${item.photo}`" alt="Car image"
                                    class="max-w-full max-h-full object-contain transition-transform duration-200 scale-95 group-hover:scale-110" />
                            </div>
                            <div class="flex flex-col flex-1 min-w-0">
                                <span class="text-gray-900 dark:text-gray-100 font-semibold text-base truncate"
                                    x-text="item.brand + ' ' + item.model"></span>
                                <span class="text-gray-500 dark:text-gray-400 text-xs mt-0.5 truncate"
                                    x-text="'Year: ' + item.year + ' • ' + item.category"></span>
                                <span class="text-blue-800 dark:text-blue-200 font-bold text-xs mt-0.5"
                                    x-text="item.price ? 'Rp ' + (Number(item.price)).toLocaleString('id-ID') : ''"></span>
                            </div>
                            <svg class="w-4 h-4 ml-auto text-blue-400 group-hover:text-blue-700 transition"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </li>
                </template>
            </ul>
        </template>
        <template x-if="!loading && suggestions.length === 0 && search">
            <div class="px-6 py-4 text-gray-400 dark:text-gray-500 text-base text-center">
                <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 13h6m-3-3v6m-7 4a9 9 0 1118 0 9 9 0 01-18 0z" />
                </svg>
                No results found.
            </div>
        </template>
    </div>
</div>
<script>
    function searchComponent() {
        return {
            search: '',
            suggestions: [],
            loading: false,
            timeout: null,
            highlightedIndex: -1,
            isFocused: false,

            async fetchSuggestions() {
                if (this.search.trim() === '') {
                    this.suggestions = [];
                    this.loading = false;
                    return;
                }

                this.loading = true;
                clearTimeout(this.timeout);
                this.timeout = setTimeout(async () => {
                    try {
                        const res = await fetch(
                            `/search-autocomplete?query=${encodeURIComponent(this.search)}`);
                        if (!res.ok) throw new Error('Request failed');
                        this.suggestions = await res.json();
                    } catch (e) {
                        console.error('Fetch error', e);
                        this.suggestions = [];
                    } finally {
                        this.loading = false;
                    }
                }, 250); // debounce 250ms
            },

            goTo(id) {
                window.location.href = `/cars/${id}`;
            },

            init() {
                this.$watch('search', () => this.fetchSuggestions());

                // Keyboard navigation for accessibility
                window.addEventListener('keydown', (e) => {
                    if (!this.suggestions.length || document.activeElement !== this.$refs.input) return;

                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        this.highlightedIndex = (this.highlightedIndex + 1) % this.suggestions.length;
                    }
                    if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        this.highlightedIndex = (this.highlightedIndex - 1 + this.suggestions.length) % this
                            .suggestions.length;
                    }
                    if (e.key === 'Enter' && this.highlightedIndex !== -1) {
                        this.goTo(this.suggestions[this.highlightedIndex].id);
                    }
                });
            }
        }
    }
</script>
<style>
    @keyframes fade-in-up {
        0% {
            opacity: 0;
            transform: translateY(10px) scale(0.96);
        }

        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up .25s cubic-bezier(.4, 0, .2, 1);
    }
</style>
