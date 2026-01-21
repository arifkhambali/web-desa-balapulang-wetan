<footer class="bg-slate-900 text-slate-300 pt-20 pb-10">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-16">
            <!-- About -->
            <div>
                <div class="flex items-center gap-3 mb-6">
                    @if($identitasDesa && $identitasDesa->logo)
                    <img src="{{ asset('storage/' . $identitasDesa->logo) }}" alt="Logo Desa" class="w-10 h-10 object-contain">
                    @else
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white">
                        <i class="fa-solid fa-landmark"></i>
                    </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-sm font-bold leading-none tracking-wide uppercase text-white">{{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}</span>
                        <span class="text-[10px] text-slate-400 font-medium">Kec. Watukumpul, Kab. Pemalang</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed mb-6 text-slate-400">
                    Website resmi Pemerintah {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }} sebagai media komunikasi dan transparansi publik untuk
                    mewujudkan desa yang maju, mandiri, dan sejahtera.
                </p>
                <div class="flex gap-4">
                    @if($identitasDesa && $identitasDesa->facebook)
                    <a href="{{ $identitasDesa->facebook }}" target="_blank"
                        class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($identitasDesa && $identitasDesa->instagram)
                    <a href="{{ $identitasDesa->instagram }}" target="_blank"
                        class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    @endif
                    @if($identitasDesa && $identitasDesa->youtube)
                    <a href="{{ $identitasDesa->youtube }}" target="_blank"
                        class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    @endif
                    @if($identitasDesa && $identitasDesa->twitter)
                    <a href="{{ $identitasDesa->twitter }}" target="_blank"
                        class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center hover:bg-primary hover:text-white transition-colors">
                        <i class="fa-brands fa-twitter"></i>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Kontak -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6">Kontak Kami</h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot mt-1 text-primary"></i>
                        <span>{{ $identitasDesa->alamat ?? 'Desa Tundagan, Kec. Watukumpul, Kab. Pemalang, Jawa Tengah' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-primary"></i>
                        <span>{{ $identitasDesa->telepon ?? '(022) 1234-5678' }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-primary"></i>
                        <span>{{ $identitasDesa->email ?? 'admin@desatundagan.go.id' }}</span>
                    </li>
                </ul>
            </div>

            <!-- Lokasi Kami -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6">Lokasi Kami</h3>
                @if($identitasDesa && $identitasDesa->latitude && $identitasDesa->longitude)
                    <div id="footer-map" wire:ignore class="bg-slate-800 rounded-xl overflow-hidden h-48 mb-4 relative z-0"></div>
                    <a href="https://www.google.com/maps?q={{ $identitasDesa->latitude }},{{ $identitasDesa->longitude }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 text-sm text-primary hover:text-blue-400 transition-colors">
                        <i class="fa-solid fa-map-marked-alt"></i>
                        Buka di Google Maps
                    </a>
                @else
                    <div class="bg-slate-800 rounded-xl h-48 flex items-center justify-center text-slate-500">
                        <div class="text-center">
                            <i class="fa-solid fa-map-location-dot text-4xl mb-2"></i>
                            <p class="text-xs">Koordinat belum diatur</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Jam Layanan -->
            <div>
                <h3 class="text-white font-bold text-lg mb-6">Jam Pelayanan</h3>
                <div class="space-y-3 text-sm text-slate-300">
                    @if($identitasDesa && $identitasDesa->jam_pelayanan)
                        {!! $identitasDesa->jam_pelayanan !!}
                    @else
                        <div class="bg-slate-800 rounded-lg p-4 text-center text-slate-400">
                            <i class="fa-solid fa-clock text-2xl mb-2"></i>
                            <p class="text-xs">Jam pelayanan belum diatur</p>
                            <p class="text-xs mt-1">Silakan atur di Admin Panel</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 pt-8 text-center text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} Pemerintah {{ $identitasDesa->nama_desa ?? 'Desa Tundagan' }}. All rights reserved.</p>
        </div>
    </div>
</footer>
