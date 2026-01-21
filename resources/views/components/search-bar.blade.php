@props(['placeholder' => 'Cari...', 'value' => '', 'name' => 'search'])

<div class="relative group">
    <div class="absolute inset-y-0 left-0 pl-3 md:pl-4 flex items-center pointer-events-none">
        <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-blue-500 transition-colors text-sm"></i>
    </div>
    <input 
        type="text" 
        name="{{ $name }}" 
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        class="w-full pl-9 md:pl-11 pr-10 py-2.5 md:py-3 text-sm md:text-base rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all shadow-sm hover:border-blue-300"
        {{ $attributes }}
    >
    @if($value)
    <button type="button" onclick="this.previousElementSibling.value = ''; this.previousElementSibling.dispatchEvent(new Event('input')); this.classList.add('hidden');" class="absolute inset-y-0 right-0 pr-3 md:pr-4 flex items-center text-slate-400 hover:text-red-500 transition-colors">
        <i class="fa-solid fa-circle-xmark text-sm"></i>
    </button>
    @else
    <button type="button" onclick="this.previousElementSibling.value = ''; this.previousElementSibling.dispatchEvent(new Event('input')); this.classList.add('hidden');" class="hidden absolute inset-y-0 right-0 pr-3 md:pr-4 flex items-center text-slate-400 hover:text-red-500 transition-colors clear-search-btn">
        <i class="fa-solid fa-circle-xmark text-sm"></i>
    </button>
    @endif
</div>
