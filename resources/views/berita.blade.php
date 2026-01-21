@extends('layouts.app')

@section('title', 'Berita & Informasi - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
    {{-- Hero Section --}}
    <section class="relative pt-24 pb-20 bg-gradient-to-br from-blue-600 to-cyan-600 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <div
                    class="inline-block mb-4 mt-6 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-sm font-semibold">
                    <i class="fa-solid fa-newspaper mr-2"></i>Kabar Terkini
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita & Informasi</h1>
                <p class="text-lg text-blue-100">
                    Ikuti perkembangan dan informasi terbaru dari {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="py-16 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Main Content --}}
                <div class="flex-1">
                    {{-- Search & Filter Section --}}
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm mb-6">
                        <form id="filter-form" class="space-y-4">
                            {{-- Search Bar --}}
                            <div>
                                <x-search-bar name="search" :value="$search ?? ''"
                                    placeholder="Cari berita berdasarkan judul, konten, atau penulis..." />
                            </div>

                            {{-- Filters Row --}}
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
                                {{-- Kategori Filter --}}
                                <div>
                                    <label
                                        class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                        <i class="fa-solid fa-folder mr-1"></i> Kategori
                                    </label>
                                    <select name="kategori"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ ($kategori ?? '') == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Start Date Filter --}}
                                <div>
                                    <label
                                        class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                        <i class="fa-solid fa-calendar-days mr-1"></i> Dari Tanggal
                                    </label>
                                    <input type="date" name="start_date" value="{{ $startDate ?? '' }}"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>

                                {{-- End Date Filter --}}
                                <div>
                                    <label
                                        class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                        <i class="fa-solid fa-calendar-check mr-1"></i> Sampai Tanggal
                                    </label>
                                    <input type="date" name="end_date" value="{{ $endDate ?? '' }}"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                </div>

                                {{-- Sort Filter --}}
                                <div>
                                    <label
                                        class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                        <i class="fa-solid fa-arrow-down-wide-short mr-1"></i> Urutkan
                                    </label>
                                    <select name="sort"
                                        class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                        <option value="newest" {{ ($sort ?? 'newest') == 'newest' ? 'selected' : '' }}>Terbaru
                                        </option>
                                        <option value="oldest" {{ ($sort ?? '') == 'oldest' ? 'selected' : '' }}>Terlama
                                        </option>
                                        <option value="most_viewed" {{ ($sort ?? '') == 'most_viewed' ? 'selected' : '' }}>
                                            Paling Banyak Dilihat</option>
                                        <option value="least_viewed" {{ ($sort ?? '') == 'least_viewed' ? 'selected' : '' }}>
                                            Paling Sedikit Dilihat</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-2 md:gap-3">
                                <button type="submit"
                                    class="px-4 md:px-6 py-2 md:py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm md:text-base font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-filter text-xs md:text-sm"></i>
                                    <span class="hidden sm:inline">Terapkan Filter</span>
                                    <span class="sm:hidden">Filter</span>
                                </button>
                                <button type="button" id="reset-filter"
                                    class="px-4 md:px-6 py-2 md:py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 text-sm md:text-base font-semibold rounded-lg transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-rotate-right text-xs md:text-sm"></i>
                                    <span>Reset</span>
                                </button>
                            </div>

                            {{-- Active Filters --}}
                            <div id="active-filters" class="hidden pt-4 border-t border-slate-200 dark:border-slate-700">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Filter
                                        Aktif:</span>
                                    <div id="filter-badges"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- Results Count --}}
                    <div id="results-count-wrapper" class="mb-4 text-sm text-slate-600 dark:text-slate-400 hidden">
                        Menampilkan <strong id="results-count"
                            class="text-slate-800 dark:text-white">{{ $beritas->total() }}</strong> hasil pencarian
                    </div>

                    {{-- Berita Grid --}}
                    <div id="berita-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @include('partials.berita-list')
                    </div>

                    {{-- Load More Button --}}
                    @if($beritas->hasMorePages())
                        <div id="load-more-container" class="mt-8 text-center">
                            <button id="load-more-btn" data-next-page="{{ $beritas->nextPageUrl() }}"
                                class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2 mx-auto">
                                <span>Muat Lebih Banyak</span>
                                <i class="fa-solid fa-arrow-down"></i>
                            </button>
                            <div id="loading-spinner" class="hidden mt-4">
                                <i class="fa-solid fa-spinner fa-spin text-blue-600 text-2xl"></i>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="lg:w-80 space-y-6">
                    {{-- Berita Terpopuler --}}
                    @if($beritaTerpopuler->count() > 0)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-fire text-orange-500"></i> Terpopuler
                            </h3>
                            <div class="space-y-4">
                                @foreach($beritaTerpopuler as $popular)
                                    <a href="{{ route('berita.detail', $popular->slug) }}" wire:navigate class="flex gap-3 group">
                                        <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            @if($popular->gambar)
                                                <img data-src="{{ asset('storage/' . $popular->gambar) }}"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                                    alt="{{ $popular->judul }}"
                                                    class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <i class="fa-solid fa-newspaper text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-semibold text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-primary transition-colors mb-1">
                                                {{ $popular->judul }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                                <span><i
                                                        class="fa-regular fa-calendar mr-1"></i>{{ $popular->published_at->format('d M Y') }}</span>
                                                <span><i
                                                        class="fa-regular fa-eye mr-1"></i>{{ number_format($popular->views) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Kategori --}}
                    @if($kategoriList->count() > 0)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-folder text-blue-500"></i> Kategori
                            </h3>
                            <div class="space-y-2">
                                @foreach($kategoriList as $kategori)
                                    <a href="{{ route('berita', ['kategori' => $kategori->id]) }}" wire:navigate
                                        class="flex items-center justify-between p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors group">
                                        <span class="text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">
                                            {{ $kategori->nama_kategori }}
                                        </span>
                                        <span class="bg-primary/10 text-primary px-2 py-1 rounded-full text-xs font-semibold">
                                            {{ $kategori->beritas_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Initialize function that can be called on both DOMContentLoaded and immediate execution
            function initBeritaPage() {
                const filterForm = document.getElementById('filter-form');
                const beritaGrid = document.getElementById('berita-grid');
                const loadMoreBtn = document.getElementById('load-more-btn');
                const loadMoreContainer = document.getElementById('load-more-container');
                const loadingSpinner = document.getElementById('loading-spinner');
                const resetBtn = document.getElementById('reset-filter');
                const resultsCount = document.getElementById('results-count');
                const activeFiltersDiv = document.getElementById('active-filters');
                const filterBadgesDiv = document.getElementById('filter-badges');

                // Check if elements exist before initializing
                if (!filterForm || !beritaGrid) return;

                // Prevent multiple initializations
                if (filterForm.dataset.initialized === 'true') return;
                filterForm.dataset.initialized = 'true';

                let currentPage = 1;
                let currentFilters = {};

                // Function to load berita with AJAX
                function loadBerita(page = 1, append = false) {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    params.append('page', page);

                    // Store current filters
                    currentFilters = Object.fromEntries(params.entries());

                    // Show loading state
                    if (!append && beritaGrid) {
                        beritaGrid.innerHTML = '<div class="col-span-full text-center py-12"><i class="fa-solid fa-spinner fa-spin text-blue-600 text-3xl"></i></div>';
                    }

                    fetch(`{{ route('berita') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newItems = doc.querySelectorAll('[data-berita-card]');
                            const emptyState = doc.querySelector('.col-span-full');

                            if (append) {
                                // Append for load more
                                newItems.forEach(item => beritaGrid.appendChild(item));
                            } else {
                                // Replace for filter
                                beritaGrid.innerHTML = '';

                                if (newItems.length > 0) {
                                    newItems.forEach(item => beritaGrid.appendChild(item));
                                } else if (emptyState) {
                                    // Show empty state if no results
                                    beritaGrid.appendChild(emptyState.cloneNode(true));
                                }
                            }

                            // Update total count display
                            const metadata = doc.querySelector('#pagination-metadata');
                            if (metadata && resultsCount) {
                                const total = metadata.getAttribute('data-total');
                                resultsCount.textContent = total;
                            }

                            // Check for next page in metadata
                            const hasMore = metadata ? metadata.getAttribute('data-has-more') === 'true' : false;
                            const nextPageUrl = metadata ? metadata.getAttribute('data-next-page') : null;

                            if (hasMore && nextPageUrl && loadMoreContainer && loadMoreBtn) {
                                loadMoreBtn.setAttribute('data-next-page', nextPageUrl);
                                loadMoreContainer.classList.remove('hidden');
                                loadMoreBtn.style.display = 'flex';
                            } else if (loadMoreContainer) {
                                loadMoreContainer.classList.add('hidden');
                            }

                            // Update active filters and results count
                            updateActiveFilters();

                            //Hide results count if no results
                            const resultsCountWrapper = document.getElementById('results-count-wrapper');
                            if (resultsCountWrapper) {
                                if (newItems.length === 0) {
                                    resultsCountWrapper.classList.add('hidden');
                                }
                            }

                            if (loadingSpinner) loadingSpinner.classList.add('hidden');
                            if (loadMoreBtn) loadMoreBtn.disabled = false;

                            // Re-initialize lazy loading for new images
                            if (window.initLazyLoad) {
                                window.initLazyLoad();
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            beritaGrid.innerHTML = '<div class="col-span-full text-center py-12 text-red-600"><i class="fa-solid fa-exclamation-triangle mr-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>';
                            if (loadingSpinner) loadingSpinner.classList.add('hidden');
                            if (loadMoreBtn) loadMoreBtn.disabled = false;
                        });
                }

                // Function to update active filter badges
                function updateActiveFilters() {
                    const formData = new FormData(filterForm);
                    filterBadgesDiv.innerHTML = '';
                    let hasFilters = false;

                    for (let [key, value] of formData.entries()) {
                        if (value && value !== '' && value !== 'newest') {
                            hasFilters = true;
                            const badge = document.createElement('span');
                            badge.className = 'inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium border border-blue-200 dark:border-blue-800';

                            let label = key.replace('_', ' ');
                            label = label.charAt(0).toUpperCase() + label.slice(1);

                            let displayValue = value;
                            if (key === 'start_date' || key === 'end_date') {
                                const date = new Date(value);
                                displayValue = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                            }

                            badge.innerHTML = `
                                    <span>${label}: <strong>${displayValue}</strong></span>
                                    <button type="button"
                                        onclick="this.closest('span').remove(); document.querySelector('[name=\u0022${key}\u0022]').value = ''; document.getElementById('filter-form').dispatchEvent(new Event('submit'));"
                                        class="hover:text-red-600 transition-colors">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                `;
                            filterBadgesDiv.appendChild(badge);
                        }
                    }

                    // Show/hide active filters section
                    if (hasFilters) {
                        activeFiltersDiv.classList.remove('hidden');
                    } else {
                        activeFiltersDiv.classList.add('hidden');
                    }

                    // Show/hide results count - only show when there are filters
                    const resultsCountWrapper = document.getElementById('results-count-wrapper');
                    if (resultsCountWrapper) {
                        if (hasFilters) {
                            resultsCountWrapper.classList.remove('hidden');
                        } else {
                            resultsCountWrapper.classList.add('hidden');
                        }
                    }
                }

                // Filter form submit
                filterForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    currentPage = 1;
                    loadBerita(1, false);
                });

                // Reset filter
                resetBtn.addEventListener('click', function () {
                    filterForm.reset();
                    currentPage = 1;
                    loadBerita(1, false);
                });

                // Load more button
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', function () {
                        const nextPageUrl = this.getAttribute('data-next-page');
                        if (!nextPageUrl) return;

                        const url = new URL(nextPageUrl);
                        const nextPage = url.searchParams.get('page');

                        loadMoreBtn.disabled = true;
                        loadingSpinner.classList.remove('hidden');

                        loadBerita(nextPage, true);
                    });
                }

                // Initialize active filters on page load
                updateActiveFilters();

                // Search input - show/hide clear button and handle clear action
                const searchInput = filterForm.querySelector('input[name="search"]');
                const clearSearchBtn = filterForm.querySelector('.clear-search-btn');

                if (searchInput) {
                    // Show/hide clear button based on input value
                    searchInput.addEventListener('input', function () {
                        const clearBtn = this.nextElementSibling;
                        if (this.value.trim() !== '') {
                            if (clearBtn) clearBtn.classList.remove('hidden');
                        } else {
                            if (clearBtn) clearBtn.classList.add('hidden');
                        }
                    });

                    // Handle clear button click - trigger filter
                    if (clearSearchBtn) {
                        clearSearchBtn.addEventListener('click', function () {
                            searchInput.value = '';
                            this.classList.add('hidden');
                            filterForm.dispatchEvent(new Event('submit'));
                        });
                    }
                }
            };

            // Initialize on DOMContentLoaded or immediately if DOM is already loaded
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initBeritaPage);
            } else {
                initBeritaPage();
            }
        </script>
    @endpush
@endsection