@extends('layouts.app')

@section('title', 'Statistik Desa - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')
<!-- Hero Section -->
<section class="relative pt-32 pb-20 bg-slate-900 overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/90 via-slate-900/80 to-slate-50 dark:to-dark"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up">
            Data Statistik Desa
        </h1>
        <p class="text-lg text-slate-300 max-w-2xl mx-auto animate-fade-in-up [animation-delay:200ms]">
            Transparansi data demografi penduduk {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} untuk perencanaan pembangunan yang lebih baik.
        </p>
    </div>
</section>

<section class="py-12 bg-slate-50 dark:bg-dark transition-colors duration-300">
    <div class="container mx-auto px-4">
        
        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Agama -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-hands-praying text-primary"></i> Agama
                </h3>
                <div class="h-80">
                    <canvas id="agamaChart"></canvas>
                </div>
            </div>

            <!-- Pendidikan -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-primary"></i> Pendidikan Terakhir
                </h3>
                <div class="h-80">
                    <canvas id="pendidikanChart"></canvas>
                </div>
            </div>

            <!-- Pekerjaan -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 lg:col-span-2">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-briefcase text-primary"></i> 10 Pekerjaan Terbanyak
                </h3>
                <div class="h-80">
                    <canvas id="pekerjaanChart"></canvas>
                </div>
            </div>

            <!-- Usia -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-users-line text-primary"></i> Kelompok Usia
                </h3>
                <div class="h-80">
                    <canvas id="usiaChart"></canvas>
                </div>
            </div>

            <!-- Status Perkawinan -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-ring text-primary"></i> Status Perkawinan
                </h3>
                <div class="h-80">
                    <canvas id="kawinChart"></canvas>
                </div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-venus-mars text-primary"></i> Jenis Kelamin
                </h3>
                <div class="h-80">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

            <!-- Golongan Darah -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-droplet text-primary"></i> Golongan Darah
                </h3>
                <div class="h-80">
                    <canvas id="darahChart"></canvas>
                </div>
            </div>

            <!-- Kewarganegaraan -->
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-passport text-primary"></i> Kewarganegaraan
                </h3>
                <div class="h-80">
                    <canvas id="wargaNegaraChart"></canvas>
                </div>
            </div>

        </div>

        <!-- Detailed Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
             <!-- Tabel Agama -->
             <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-bold text-slate-800 dark:text-white">Detail Data Agama</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3">Agama</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendudukByAgama as $data)
                            <tr class="border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">{{ $data->agama }}</td>
                                <td class="px-6 py-4 text-right text-slate-600 dark:text-slate-300">{{ number_format($data->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Pendidikan -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-bold text-slate-800 dark:text-white">Detail Data Pendidikan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3">Pendidikan</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendudukByPendidikan as $data)
                            <tr class="border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">{{ $data->pendidikan_terakhir }}</td>
                                <td class="px-6 py-4 text-right text-slate-600 dark:text-slate-300">{{ number_format($data->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Jenis Kelamin -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-bold text-slate-800 dark:text-white">Detail Data Jenis Kelamin</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3">Jenis Kelamin</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendudukByGender as $data)
                            <tr class="border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">{{ $data->jenis_kelamin }}</td>
                                <td class="px-6 py-4 text-right text-slate-600 dark:text-slate-300">{{ number_format($data->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Golongan Darah -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                    <h3 class="font-bold text-slate-800 dark:text-white">Detail Data Golongan Darah</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-700/50">
                            <tr>
                                <th class="px-6 py-3">Golongan Darah</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendudukByDarah as $data)
                            <tr class="border-b border-slate-100 dark:border-slate-700 last:border-0">
                                <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">{{ $data->golongan_darah ?? '-' }}</td>
                                <td class="px-6 py-4 text-right text-slate-600 dark:text-slate-300">{{ number_format($data->total) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" onload="initCharts()"></script>
<script>
    function initCharts(retryCount = 0) {
        try {
            // Check if Chart is loaded
            if (typeof Chart === 'undefined') {
                if (retryCount < 10) {
                    console.log('Chart.js not loaded yet, retrying...', retryCount);
                    setTimeout(() => initCharts(retryCount + 1), 200);
                    return;
                }
                console.error('Chart.js failed to load after retries');
                return;
            }

            // Helper to get colors safely
            const getColors = () => {
                const isDark = document.documentElement.classList.contains('dark');
                return {
                    text: isDark ? '#cbd5e1' : '#475569',
                    grid: isDark ? '#334155' : '#e2e8f0'
                };
            };

            // Common Chart Options
            const getCommonOptions = () => {
                const colors = getColors();
                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: colors.text,
                                font: { family: 'Inter' }
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: { color: colors.grid },
                            ticks: { color: colors.text }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: colors.text }
                        }
                    }
                };
            };

            const getPieOptions = () => {
                const common = getCommonOptions();
                return {
                    ...common,
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                };
            };

            // Helper to create or update chart
            const createChart = (id, type, data, options) => {
                const ctx = document.getElementById(id);
                if (!ctx) return;

                // Destroy existing chart if it exists
                const existingChart = Chart.getChart(ctx);
                if (existingChart) {
                    existingChart.destroy();
                }

                new Chart(ctx, {
                    type: type,
                    data: data,
                    options: options
                });
            };

            // Agama Chart
            createChart('agamaChart', 'doughnut', {
                labels: {!! json_encode($pendudukByAgama->pluck('agama')) !!},
                datasets: [{
                    data: {!! json_encode($pendudukByAgama->pluck('total')) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#6366f1'],
                    borderWidth: 0
                }]
            }, getPieOptions());

            // Pendidikan Chart
            createChart('pendidikanChart', 'bar', {
                labels: {!! json_encode($pendudukByPendidikan->pluck('pendidikan_terakhir')) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode($pendudukByPendidikan->pluck('total')) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            }, getCommonOptions());

            // Pekerjaan Chart
            createChart('pekerjaanChart', 'bar', {
                labels: {!! json_encode($pendudukByPekerjaan->pluck('pekerjaan')) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode($pendudukByPekerjaan->pluck('total')) !!},
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            }, {
                ...getCommonOptions(),
                indexAxis: 'y',
            });

            // Usia Chart
            createChart('usiaChart', 'bar', {
                labels: {!! json_encode($pendudukByUsia->keys()) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode($pendudukByUsia->values()) !!},
                    backgroundColor: '#f59e0b',
                    borderRadius: 6
                }]
            }, getCommonOptions());

            // Status Perkawinan Chart
            createChart('kawinChart', 'pie', {
                labels: {!! json_encode($pendudukByKawin->pluck('status_perkawinan')) !!},
                datasets: [{
                    data: {!! json_encode($pendudukByKawin->pluck('total')) !!},
                    backgroundColor: ['#ef4444', '#3b82f6', '#8b5cf6', '#64748b'],
                    borderWidth: 0
                }]
            }, getPieOptions());

            // Gender Chart
            createChart('genderChart', 'doughnut', {
                labels: {!! json_encode($pendudukByGender->pluck('jenis_kelamin')) !!},
                datasets: [{
                    data: {!! json_encode($pendudukByGender->pluck('total')) !!},
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0
                }]
            }, getPieOptions());

            // Golongan Darah Chart
            createChart('darahChart', 'bar', {
                labels: {!! json_encode($pendudukByDarah->pluck('golongan_darah')) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode($pendudukByDarah->pluck('total')) !!},
                    backgroundColor: '#ef4444',
                    borderRadius: 6
                }]
            }, getCommonOptions());

            // Kewarganegaraan Chart
            createChart('wargaNegaraChart', 'pie', {
                labels: {!! json_encode($pendudukByWargaNegara->pluck('kewarganegaraan')) !!},
                datasets: [{
                    data: {!! json_encode($pendudukByWargaNegara->pluck('total')) !!},
                    backgroundColor: ['#10b981', '#f59e0b'],
                    borderWidth: 0
                }]
            }, getPieOptions());

        } catch (error) {
            console.error('Error initializing charts:', error);
        }
    }

    // Initialize on both events to cover all scenarios
    document.addEventListener('livewire:navigated', initCharts);
    document.addEventListener('DOMContentLoaded', initCharts);
</script>
@endpush
@endsection
