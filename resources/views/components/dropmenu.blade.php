@props([ 'trigger' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>', ])
@once
<style>
    .bw-dropmenu:focus-within .bw-dropmenu-items {
        opacity:1;
        transform: translate(0) scale(1);
        visibility: visible;
        display: block;
        tabindex: 0;
    }
</style>
@endonce
<div class="relative inline-block text-left bw-dropmenu !z-40" tabindex="0">
    <button class="text-sm transition duration-150 ease-in-out z-10">
        {!!$trigger!!}
    </button>
    <div class="opacity-0 hidden bw-dropmenu-items bg-white dark:bg-dark-800 transition-all duration-300 transform origin-top-right -translate-y-2 scale-95 !z-50">
        <div class="absolute right-0  mt-1 origin-top-right bg-white dark:bg-dark-800 border border-gray-200 dark:border-dark-900 divide-y divide-gray-100 dark:divide-dark-700 rounded-md shadow-lg outline-none">
            {{$slot}}
        </div>
    </div>
</div>