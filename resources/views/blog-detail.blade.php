@extends('layouts.app')

@section('title', $post->title . ' - ' . ($identitasDesa->nama_desa ?? 'Desa Tundagan'))

@section('content')

    <section class="pt-24 pb-6 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800">
        <div class="container mx-auto px-4">

        </div>
    </section>
    {{-- Main Content --}}
    <section class="py-12 bg-white dark:bg-dark transition-colors duration-300">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Article Content --}}
                <article class="flex-1">
                    {{-- Category Badge --}}
                    @if($post->categories->count() > 0)
                        <div class="mb-4">
                            <a href="{{ route('blog', ['category' => $post->categories->first()->slug]) }}"
                                class="inline-block bg-purple-600 text-white text-sm font-bold px-4 py-2 rounded-full hover:bg-purple-700 transition-colors">
                                {{ $post->categories->first()->name }}
                            </a>
                        </div>
                    @endif

                    {{-- Title --}}
                    <h1
                        class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-800 dark:text-white mb-6 leading-tight">
                        {{ $post->title }}
                    </h1>

                    {{-- Meta Information --}}
                    <div
                        class="flex flex-wrap items-center gap-4 md:gap-6 text-slate-600 dark:text-slate-400 mb-8 pb-6 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-user"></i>
                            <span class="font-medium">{{ $post->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-calendar"></i>
                            <span>{{ $post->published_at->format('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-clock"></i>
                            <span>{{ $post->published_at->format('H:i') }} WIB</span>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    @if($post->cover_photo_path)
                        <div class="mb-8 rounded-2xl overflow-hidden shadow-lg">
                            <img data-src="{{ Str::startsWith($post->cover_photo_path, 'http') ? $post->cover_photo_path : asset('storage/' . $post->cover_photo_path) }}"
                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                alt="{{ $post->title }}" class="lazy-image w-full h-auto">
                        </div>
                    @endif

                    {{-- Content --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                        {!! $post->body !!}
                    </div>

                    {{-- Share Buttons --}}
                    <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl p-6 mb-8">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Bagikan Artikel</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fa-brands fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-sky-500 text-white px-4 py-2 rounded-lg hover:bg-sky-600 transition-colors">
                                <i class="fa-brands fa-twitter"></i>
                                <span>Twitter</span>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}"
                                target="_blank"
                                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                <i class="fa-brands fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <button onclick="copyToClipboard('{{ request()->url() }}')"
                                class="flex items-center gap-2 bg-slate-600 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition-colors">
                                <i class="fa-solid fa-link"></i>
                                <span>Salin Link</span>
                            </button>
                        </div>
                    </div>

                    {{-- Navigation --}}
                    <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                        <a href="{{ route('blog') }}"
                            class="inline-flex items-center gap-2 text-purple-600 font-semibold hover:underline">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Kembali ke Blog</span>
                        </a>
                    </div>
                </article>

                {{-- Sidebar --}}
                <aside class="lg:w-80 space-y-6">
                    {{-- Related Posts --}}
                    @if($relatedPosts->count() > 0)
                        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-newspaper text-purple-500"></i> Artikel Terkait
                            </h3>
                            <div class="space-y-4">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('blog.detail', $related->slug) }}" wire:navigate class="flex gap-3 group">
                                        <div class="relative w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden">
                                            @if($related->cover_photo_path)
                                                <img data-src="{{ Str::startsWith($related->cover_photo_path, 'http') ? $related->cover_photo_path : asset('storage/' . $related->cover_photo_path) }}"
                                                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'%3E%3C/svg%3E"
                                                    alt="{{ $related->title }}"
                                                    class="lazy-image w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full h-full bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                                                    <i class="fa-solid fa-blog text-white text-xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-semibold text-slate-800 dark:text-white text-sm line-clamp-2 group-hover:text-purple-600 transition-colors mb-1">
                                                {{ $related->title }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                                <span><i
                                                        class="fa-regular fa-calendar mr-1"></i>{{ $related->published_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
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
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Link berhasil disalin!');
                });
            }
        </script>
    @endpush
@endsection