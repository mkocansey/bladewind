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
<div class="bw-contact-card bg-white dark:bg-dark-900 dark:border dark:border-dark-800/50 py-4 pl-6 pr-4 rounded-lg @if($has_shadow) shadow-2xl shadow-gray-200/40 dark:shadow-xl dark:shadow-dark-900 @endif {{ $css }}">
    <div class="flex items-start">
        <div>
            <x-bladewind::avatar image="{{ $image }}" />
        </div>
        <div class="grow pl-3">
            <strong>{{ $name }}</strong>
            <div class="text-sm mb-2">
                {!! $position !!}
                @if($department && $position)
                <x-bladewind::icon name="chevron-right" class="h-3 w-3 inline-block" />
                @endif
                {{ $department }}
            </div>
            @if($mobile)
                <div class="text-sm mb-1">
                    <x-bladewind::icon name="phone" class="h-4 w-4 inline-block mr-2 opacity-60" />
                    {{ $mobile }}
                </div>
            @endif
            @if($email)
                <div class="text-sm mb-1">
                    <x-bladewind::icon name="chat-bubble-left-ellipsis" class="h-4 w-4 inline-block mr-2 opacity-60" />
                    {!! $email !!}
                </div>
            @endif
            @if($birthday)
                <div class="text-sm mb-1">
                    <x-bladewind::icon name="calendar-days" class="h-4 w-4 inline-block mr-2 opacity-60" />
                    {{ $birthday }}
                </div>
            @endif
            {{ $slot }}
        </div>
    </div>
</div>
