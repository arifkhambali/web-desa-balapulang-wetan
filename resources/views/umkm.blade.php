@extends('layouts.app')

@section('title', 'UMKM Desa - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0">
            <img data-src="{{ $identitasDesa->hero_image_umkm ? asset('storage/' . $identitasDesa->hero_image_umkm) : 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80' }}"
                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                alt="UMKM Banner" class="lazy-image w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-white dark:to-dark"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-fade-in-up">
                Produk UMKM Desa
            </h1>
            <p class="text-lg md:text-xl text-slate-300 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
                Temukan berbagai produk unggulan karya warga {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}. Dukung
                ekonomi lokal dengan membeli produk asli desa.
            </p>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-20 bg-white dark:bg-dark transition-colors duration-300 min-h-screen">
        <div class="container mx-auto px-4">
            {{-- Search & Filter Section --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm mb-8">
                <form id="filter-form" class="space-y-4">
                    {{-- Search Bar --}}
                    <div>
                        <x-search-bar name="search" :value="$search ?? ''"
                            placeholder="Cari produk berdasarkan nama, deskripsi, atau penjual..." />
                    </div>

                    {{-- Filters Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
                        {{-- Kategori Filter --}}
                        <div>
                            <label
                                class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                <i class="fa-solid fa-tag mr-1"></i> Kategori
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

                        {{-- Min Price Filter --}}
                        <div>
                            <label
                                class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                <i class="fa-solid fa-money-bill-wave mr-1"></i> Harga Minimum
                            </label>
                            <input type="number" name="min_price" value="{{ $minPrice ?? '' }}" placeholder="0" min="0"
                                step="1000"
                                class="w-full px-3 md:px-4 py-2 md:py-2.5 text-sm md:text-base rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>

                        {{-- Max Price Filter --}}
                        <div>
                            <label
                                class="block text-xs md:text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5 md:mb-2">
                                <i class="fa-solid fa-money-bill-wave mr-1"></i> Harga Maksimum
                            </label>
                            <input type="number" name="max_price" value="{{ $maxPrice ?? '' }}" placeholder="Tidak terbatas"
                                min="0" step="1000"
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
                                <option value="oldest" {{ ($sort ?? '') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price_low" {{ ($sort ?? '') == 'price_low' ? 'selected' : '' }}>Harga Terendah
                                </option>
                                <option value="price_high" {{ ($sort ?? '') == 'price_high' ? 'selected' : '' }}>Harga
                                    Tertinggi</option>
                                <option value="most_viewed" {{ ($sort ?? '') == 'most_viewed' ? 'selected' : '' }}>Paling
                                    Banyak Dilihat</option>
                                <option value="name_asc" {{ ($sort ?? '') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="name_desc" {{ ($sort ?? '') == 'name_desc' ? 'selected' : '' }}>Nama Z-A
                                </option>
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
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Filter Aktif:</span>
                            <div id="filter-badges"></div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Results Count --}}
            <div id="results-count-wrapper" class="mb-6 text-sm text-slate-600 dark:text-slate-400 hidden">
                Menampilkan <strong id="results-count"
                    class="text-slate-800 dark:text-white">{{ $products->total() }}</strong> hasil pencarian
            </div>

            <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @include('partials.umkm-list')
            </div>

            {{-- Load More Button --}}
            @if($products->hasMorePages())
                <div id="load-more-container" class="mt-8 text-center">
                    <button type="button" id="load-more-btn" data-next-page="{{ $products->nextPageUrl() }}"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-all flex items-center gap-2 mx-auto cursor-pointer">
                        <span>Muat Lebih Banyak</span>
                        <i class="fa-solid fa-arrow-down"></i>
                    </button>
                    <div id="loading-spinner" class="hidden mt-4">
                        <i class="fa-solid fa-spinner fa-spin text-blue-600 text-2xl"></i>
                    </div>
                </div>
            @endif

        </div>
    </section>

    @push('scripts')
        <script>
            // Initialize function that can be called on both DOMContentLoaded and immediate execution
            function initUmkmPage() {
                const filterForm = document.getElementById('filter-form');
                const productsGrid = document.getElementById('products-grid');
                const loadMoreBtn = document.getElementById('load-more-btn');
                const loadMoreContainer = document.getElementById('load-more-container');
                const loadingSpinner = document.getElementById('loading-spinner');
                const resetBtn = document.getElementById('reset-filter');
                const resultsCount = document.getElementById('results-count');
                const activeFiltersDiv = document.getElementById('active-filters');
                const filterBadgesDiv = document.getElementById('filter-badges');

                // Check if elements exist before initializing
                if (!filterForm || !productsGrid) return;

                // Prevent multiple initializations
                if (filterForm.dataset.initialized === 'true') return;
                filterForm.dataset.initialized = 'true';

                let currentPage = 1;
                let currentFilters = {};

                // Function to load products with AJAX
                function loadProducts(page = 1, append = false) {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    params.append('page', page);

                    // Store current filters
                    currentFilters = Object.fromEntries(params.entries());

                    // Show loading state
                    if (!append && productsGrid) {
                        productsGrid.innerHTML = '<div class="col-span-full text-center py-12"><i class="fa-solid fa-spinner fa-spin text-blue-600 text-3xl"></i></div>';
                    }

                    fetch(`{{ route('umkm') }}?${params.toString()}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newItems = doc.querySelectorAll('[data-product-card]');
                            const emptyState = doc.querySelector('.col-span-full');
                            const totalCountEl = doc.querySelector('#products-total-count');

                            if (append) {
                                // Append for load more
                                newItems.forEach(item => productsGrid.appendChild(item));
                            } else {
                                // Replace for filter
                                productsGrid.innerHTML = '';

                                if (newItems.length > 0) {
                                    newItems.forEach(item => productsGrid.appendChild(item));
                                } else if (emptyState) {
                                    // Show empty state if no results
                                    productsGrid.appendChild(emptyState.cloneNode(true));
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

                            // Hide results count if no results
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
                            productsGrid.innerHTML = '<div class="col-span-full text-center py-12 text-red-600"><i class="fa-solid fa-exclamation-triangle mr-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>';
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
                            if (key === 'min_price' || key === 'max_price') {
                                displayValue = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }

                            badge.innerHTML = `
                                                    <span>${label}: <strong>${displayValue}</strong></span>
                                                    <button type="button" onclick="this.closest('span').remove(); document.querySelector('[name=\u0022${key}\u0022]').value = ''; document.getElementById('filter-form').dispatchEvent(new Event('submit'));" class="hover:text-red-600 transition-colors">
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
                    loadProducts(1, false);
                });

                // Reset filter
                resetBtn.addEventListener('click', function () {
                    filterForm.reset();
                    currentPage = 1;
                    loadProducts(1, false);
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

                        loadProducts(nextPage, true);
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
                document.addEventListener('DOMContentLoaded', initUmkmPage);
            } else {
                initUmkmPage();
            }
        </script>
    @endpush
@endsection