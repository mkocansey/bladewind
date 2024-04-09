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
    'has_border' => true,
])
@php
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hover_effect = filter_var($hover_effect, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    $has_border = filter_var($has_border, FILTER_VALIDATE_BOOLEAN);
    if(!$hasShadow) $has_shadow = $hasShadow;
@endphp
<div class="bw-contact-card bg-white dark:bg-dark-900/50 @if($has_border) ring-1 ring-slate-800 ring-opacity-5 dark:ring-dark-700/50 @endif pt-4 pb-6 pl-6 pr-4 rounded-md focus:outline-none @if($has_shadow) shadow dark:shadow-dark-900/80 @if($hover_effect) hover:shadow-md cursor-pointer hover:!ring-opacity-15 hover:dark:ring-dark-300 @endif  @endif {{ $class }}">
    <div class="flex items-start">
        <div class="-mt-1 pr-2">
            <x-bladewind::avatar size="big" image="{{ $image }}"/>
        </div>
        <div class="grow pl-3 dark:text-dark-300">
            <div class="text-lg font-semibold dark:text-dark-300 text-slate-600">{{ $name }}</div>
            <div class="text-sm pb-2">
                {{ $department }}
                @if($department && $position)
                    <x-bladewind::icon name="chevron-right" class="!h-3 !w-3 inline-block"/>
                @endif
                {!! $position !!}
            </div>
            <div class="space-y-1">
                @if($mobile)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon
                                name="device-tablet"
                                class="inline-block mr-1 !size-5 opacity-45"/>
                        {{ $mobile }}
                    </div>
                @endif
                @if($email)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon
                                name="at-symbol"
                                class="inline-block mr-1 !size-5 opacity-45"/>
                        {!! $email !!}
                    </div>
                @endif
                @if($birthday)
                    <div class="text-sm mb-1">
                        <x-bladewind::icon
                                name="calendar-days"
                                class="inline-block mr-1 !size-5 opacity-45"/>
                        {{ $birthday }}
                    </div>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
