@props([
    'css' => null,
    'has_shadow' => true,
    'hasShadow' => true,
    'image' => asset('vendor/bladewind/images/avatar.png'),
    'name' => null,
    'mobile' => null,
    'email' => null,
    'department' => null,
    'position' => null,
    'birthday' => null,
])
@php
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    if(!$hasShadow) $has_shadow = $hasShadow;
@endphp
<div class="bw-contact-card bg-white dark:bg-slate-900 dark:border dark:border-slate-800/50 py-4 pl-6 pr-4 rounded-lg @if($has_shadow) shadow-2xl shadow-gray-200/40 dark:shadow-xl dark:shadow-slate-900 @endif {{ $css }}">
    <div class="flex items-start">
        <div>
            <x-bladewind::avatar image="{{ $image }}" />
        </div>
        <div class="grow pl-3">
            <strong>{{ $name }}</strong>
            <div class="text-sm mb-2">
                {!! $position !!}
                @if($department && $position)
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
                @endif
                {{ $department }}
            </div>
            @if($mobile)
                <div class="text-sm mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    {{ $mobile }}
                </div>
            @endif
            @if($email)
                <div class="text-sm mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    {!! $email !!}
                </div>
            @endif
            @if($birthday)
                <div class="text-sm mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $birthday }}
                </div>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
