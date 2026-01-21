@props(['label', 'value'])

<span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-medium border border-blue-200 dark:border-blue-800">
    <span>{{ $label }}: <strong>{{ $value }}</strong></span>
    <button type="button" onclick="this.closest('span').remove(); this.closest('form').submit();" class="hover:text-red-600 transition-colors">
        <i class="fa-solid fa-xmark"></i>
    </button>
</span>
