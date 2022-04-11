@props([
    'size' => '10'
])
<span class="h-10 h-9 h-8 h-7 h-6 h-5 h-4 h-3 h-2 h-1"></span>
<a href="javascript:showModal('change-language')" data-tooltip="{{ __('copy.CHANGE_LANGUAGE') }}" data-inverted="" data-position="left center">
    @if(App::getLocale() == 'en') <i class="uk flag"></i> @else <i class="fr flag"></i> @endif 
</a>
<a href="/features" data-tooltip="{{ __('copy.CHOOSE_APPS') }}" data-inverted="" data-position="left center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
    </svg>
</a>
<a href="javascript:showModal('lock-page')" data-tooltip="{{ __('copy.LOCK_PAGE') }}" data-inverted="" data-position="left center">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    </svg>
</a>
<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
</svg>
<img src="https://lh3.googleusercontent.com/ogw/ADea4I7GzGYvBDTkA8tADfgaKuOGH-VnSyiec73j3v5BLQ=s83-c-mo" 
    class="h-{{$size}} rounded-full ring-1 ring-offset-2 cursor-pointer" onclick="animateCSS('.profile-box','slideInRight');" />