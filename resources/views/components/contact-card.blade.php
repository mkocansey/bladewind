@props([
    'hover_effect' => false,
    'has_shadow' => true,
    'hasShadow' => true,
    'image' => asset('vendor/bladewind/images/avatar.png'),
    'name' => null,
    'mobile' => null,
    'email' => null,
    'department' => null,
    'position' => null,
    'birthday' => null,
    'class' => '',
])
@php
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hover_effect = filter_var($hover_effect, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    if(!$hasShadow) $has_shadow = $hasShadow;
@endphp
<div class="bw-contact-card bg-white border dark:bg-dark-900/50 dark:border-dark-700/50 border-gray-100 py-4 pl-6 pr-4 rounded-lg @if($has_shadow) shadow-lg dark:shadow-dark-900/80 shadow-gray-300/40 @if($hover_effect) hover:shadow-xl cursor-pointer dark:hover:!border-dark-600/50 hover:!border-gray-300/80 @endif  @endif {{ $class }}">
    <div class="flex items-start">
        <div>
            <x-bladewind::avatar image="{{ $image }}"/>
        </div>
        <div class="grow pl-3">
            <strong class="tracking-wide">{{ $name }}</strong>
            <div class="text-xs mb-2 opacity-75">
                {{ $department }}
                @if($department && $position)
                    <x-bladewind::icon name="chevron-right" class="!h-3 !w-3 inline-block"/>
                @endif
                {!! $position !!}
            </div>
            <div class="space-y-1">
                @if($mobile)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon name="phone" class="!h-4 !w-4 inline-block mr-1.5 opacity-60"/>
                        {{ $mobile }}
                    </div>
                @endif
                @if($email)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon name="chat-bubble-left-ellipsis"
                                           class="!h-4 !w-4 inline-block mr-2 opacity-60"/>
                        {!! $email !!}
                    </div>
                @endif
                @if($birthday)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon name="calendar-days" class="!h-4 !w-4 inline-block mr-2 opacity-60"/>
                        {{ $birthday }}
                    </div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
