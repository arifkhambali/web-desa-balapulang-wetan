@extends('layouts.app')

@section('title', 'Galeri Kegiatan - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-slate-50 dark:bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-3xl mx-auto">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm animate-fade-in-up">Dokumentasi</span>
                <h1 class="text-4xl md:text-6xl font-bold text-slate-800 dark:text-white mt-2 mb-6 animate-fade-in-up">
                    Galeri Desa
                </h1>
                <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
                    Dokumentasi visual kegiatan, pembangunan, dan keindahan alam di {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}.
                </p>
            </div>
        </div>
    </section>

    <!-- Gallery Grid Section -->
    <section class="py-16 bg-slate-50 dark:bg-slate-900 min-h-screen">
        <div class="container mx-auto px-4">

            {{-- Search & Filter Section --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm mb-8">
                <form id="filter-form" class="space-y-4" onsubmit="return handleFilterSubmit(event)">
                    {{-- Search Bar --}}
                    <div>
                        <x-search-bar name="search" :value="$search ?? ''"
                            placeholder="Cari foto berdasarkan judul atau deskripsi..." />
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
                                <option value="oldest" {{ ($sort ?? '') == 'oldest' ? 'selected' : '' }}>Terlama</option>
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
                        <button type="button" onclick="handleResetFilter()"
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
                    class="text-slate-800 dark:text-white">{{ $galleries->total() }}</strong> hasil pencarian
            </div>

            {{-- Grid Layout --}}
            <div id="gallery-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('partials.galeri-list')
            </div>

            {{-- Load More Button --}}
            @if($galleries->hasMorePages())
                <div class="text-center mt-16" id="load-more-container">
                    <button type="button" id="load-more-btn" onclick="handleLoadMore(this)"
                        data-next-page="{{ $galleries->nextPageUrl() }}"
                        class="px-8 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-full hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm hover:shadow-md flex items-center gap-2 mx-auto">
                        <span>Muat Lebih Banyak</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div id="loading-spinner" class="hidden mt-4">
                        <i class="fa-solid fa-spinner fa-spin text-blue-600 text-2xl"></i>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- Gallery Modal -->
    <div id="gallery-modal"
        class="fixed inset-0 z-[9999] bg-black/90 backdrop-blur-md hidden opacity-0 transition-opacity duration-300 flex items-center justify-center p-4">
        <button onclick="closeGalleryModal()"
            class="absolute top-6 right-6 text-white/70 hover:text-white transition-colors z-50">
            <i class="fa-solid fa-xmark text-4xl"></i>
        </button>

        <div class="relative w-full max-w-6xl h-[90vh] md:h-auto md:max-h-[90vh] flex flex-col md:flex-row bg-slate-900 rounded-3xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-300"
            id="gallery-modal-content">

            <!-- Image Container -->
            <div
                class="w-full md:w-2/3 h-[40vh] md:h-[80vh] bg-black flex items-center justify-center relative group shrink-0">
                <img id="modal-image" src="" alt="" class="max-w-full max-h-full object-contain">
            </div>

            <!-- Info Container -->
            <div
                class="w-full md:w-1/3 bg-white dark:bg-slate-800 p-8 flex flex-col flex-1 md:flex-none md:h-[80vh] overflow-y-auto">
                <div class="mb-6 shrink-0">
                    <span id="modal-category"
                        class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-primary text-xs font-bold rounded-full mb-3"></span>
                    <h2 id="modal-title"
                        class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-2 leading-tight"></h2>
                    <p id="modal-date" class="text-slate-500 dark:text-slate-400 text-sm flex items-center gap-2">
                        <i class="fa-regular fa-calendar"></i> <span></span>
                    </p>
                </div>

                <div
                    class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300 text-sm leading-relaxed flex-grow overflow-y-auto">
                    <p id="modal-description"></p>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 shrink-0">
                    <button onclick="closeGalleryModal()"
                        class="w-full py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                        Tutup Galeri
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Global state
            let isLoadingGalleries = false;

            // Modal functions
            window.openGalleryModal = function (imageSrc, title, category, date, description) {
                const modal = document.getElementById('gallery-modal');
                const modalContent = document.getElementById('gallery-modal-content');
                const modalImage = document.getElementById('modal-image');
                const modalTitle = document.getElementById('modal-title');
                const modalCategory = document.getElementById('modal-category');
                const modalDate = document.getElementById('modal-date')?.querySelector('span');
                const modalDescription = document.getElementById('modal-description');

                if (!modal || !modalImage || !modalTitle) return;

                modalImage.src = imageSrc;
                modalTitle.textContent = title;
                if (modalCategory) modalCategory.textContent = category;
                if (modalDate) modalDate.textContent = date;
                if (modalDescription) modalDescription.innerHTML = description || 'Tidak ada deskripsi.';

                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    if (modalContent) {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }
                }, 10);
            };

            window.closeGalleryModal = function () {
                const modal = document.getElementById('gallery-modal');
                const modalContent = document.getElementById('gallery-modal-content');
                const modalImage = document.getElementById('modal-image');

                if (!modal) return;

                modal.classList.add('opacity-0');
                if (modalContent) {
                    modalContent.classList.remove('scale-100');
                    modalContent.classList.add('scale-95');
                }

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    if (modalImage) modalImage.src = '';
                }, 300);
            };

            // Close modal on backdrop click
            document.addEventListener('click', function (e) {
                const modal = document.getElementById('gallery-modal');
                if (e.target === modal) {
                    closeGalleryModal();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function (e) {
                const modal = document.getElementById('gallery-modal');
                if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                    closeGalleryModal();
                }
            });

            // Load galleries function
            function loadGalleries(page = 1, append = false) {
                if (isLoadingGalleries) {
                    console.log('Already loading, please wait...');
                    return;
                }

                isLoadingGalleries = true;

                const filterForm = document.getElementById('filter-form');
                const galleryGrid = document.getElementById('gallery-grid');
                const loadingSpinner = document.getElementById('loading-spinner');
                const loadMoreBtn = document.getElementById('load-more-btn');
                const resultsCount = document.getElementById('results-count');

                const formData = new FormData(filterForm);
                const params = new URLSearchParams(formData);
                params.append('page', page);

                // Show loading state
                if (!append && galleryGrid) {
                    galleryGrid.innerHTML = '<div class="col-span-full text-center py-12"><i class="fa-solid fa-spinner fa-spin text-blue-600 text-3xl"></i></div>';
                }

                if (append && loadingSpinner) {
                    loadingSpinner.classList.remove('hidden');
                }

                if (loadMoreBtn) {
                    loadMoreBtn.disabled = true;
                }

                console.log('Fetching page:', page);

                fetch(`{{ route('galeri') }}?${params.toString()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newItems = doc.querySelectorAll('[data-gallery-item]');
                        const emptyState = doc.querySelector('.col-span-full');

                        if (append) {
                            // Append for load more
                            newItems.forEach(item => galleryGrid.appendChild(item));
                        } else {
                            // Replace for filter
                            galleryGrid.innerHTML = '';

                            if (newItems.length > 0) {
                                newItems.forEach(item => galleryGrid.appendChild(item));
                            } else if (emptyState) {
                                galleryGrid.appendChild(emptyState.cloneNode(true));
                            }
                        }

                        // Update metadata
                        const metadata = doc.querySelector('#gallery-metadata');
                        if (metadata && resultsCount) {
                            const total = metadata.getAttribute('data-total');
                            resultsCount.textContent = total;
                        }

                        // Update load more button
                        const loadMoreContainer = document.getElementById('load-more-container');
                        const nextPageUrl = metadata ? metadata.getAttribute('data-next-page') : null;

                        if (nextPageUrl && loadMoreContainer && loadMoreBtn) {
                            loadMoreBtn.setAttribute('data-next-page', nextPageUrl);
                            loadMoreContainer.classList.remove('hidden');
                            loadMoreBtn.disabled = false;
                            console.log('Next page available:', nextPageUrl);
                        } else if (loadMoreContainer) {
                            loadMoreContainer.classList.add('hidden');
                            console.log('No more pages');
                        }

                        // Update active filters
                        updateActiveFilters();

                        // Hide loading
                        if (loadingSpinner) loadingSpinner.classList.add('hidden');

                        // Re-init lazy loading
                        if (window.initLazyLoad) {
                            window.initLazyLoad();
                        }

                        isLoadingGalleries = false;
                        console.log('Loading complete');
                    })
                    .catch(error => {
                        console.error('Error loading galleries:', error);
                        galleryGrid.innerHTML = '<div class="col-span-full text-center py-12 text-red-600"><i class="fa-solid fa-exclamation-triangle mr-2"></i>Terjadi kesalahan. Silakan coba lagi.</div>';

                        if (loadingSpinner) loadingSpinner.classList.add('hidden');
                        if (loadMoreBtn) loadMoreBtn.disabled = false;

                        isLoadingGalleries = false;
                    });
            }

            // Update active filter badges
            function updateActiveFilters() {
                const filterForm = document.getElementById('filter-form');
                const activeFiltersDiv = document.getElementById('active-filters');
                const filterBadgesDiv = document.getElementById('filter-badges');
                const resultsCountWrapper = document.getElementById('results-count-wrapper');

                if (!filterForm || !filterBadgesDiv) return;

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
                                                    <button type="button" onclick="removeBadgeFilter('${key}')" class="hover:text-red-600 transition-colors">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                `;
                        filterBadgesDiv.appendChild(badge);
                    }
                }

                if (activeFiltersDiv) {
                    activeFiltersDiv.classList.toggle('hidden', !hasFilters);
                }

                if (resultsCountWrapper) {
                    resultsCountWrapper.classList.toggle('hidden', !hasFilters);
                }
            }

            // Remove badge filter
            window.removeBadgeFilter = function (key) {
                const input = document.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = '';
                    handleFilterSubmit(null);
                }
            };

            // Handle filter submit
            window.handleFilterSubmit = function (event) {
                if (event) event.preventDefault();
                loadGalleries(1, false);
                return false;
            };

            // Handle reset filter
            window.handleResetFilter = function () {
                const filterForm = document.getElementById('filter-form');
                if (filterForm) {
                    filterForm.reset();
                    loadGalleries(1, false);
                }
            };

            // Handle load more - INLINE ONCLICK
            window.handleLoadMore = function (button) {
                console.log('handleLoadMore called');

                const nextPageUrl = button.getAttribute('data-next-page');
                console.log('Next page URL:', nextPageUrl);

                if (!nextPageUrl || button.disabled || isLoadingGalleries) {
                    console.log('Aborted - URL:', nextPageUrl, 'Disabled:', button.disabled, 'Loading:', isLoadingGalleries);
                    return;
                }

                try {
                    const url = new URL(nextPageUrl);
                    const nextPage = url.searchParams.get('page');
                    console.log('Loading page:', nextPage);

                    loadGalleries(nextPage, true);
                } catch (error) {
                    console.error('Error parsing URL:', error);
                    button.disabled = false;
                }
            };

            // Initialize on page load
            (function () {
                console.log('Gallery page initialized');
                updateActiveFilters();

                // Search input handler
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const clearBtn = this.nextElementSibling;
                        if (clearBtn) {
                            clearBtn.classList.toggle('hidden', this.value.trim() === '');
                        }
                    });
                }
            })();
        </script>
    @endpush
@endsection