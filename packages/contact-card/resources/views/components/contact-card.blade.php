{{-- format-ignore-start --}}
@props([
    'hasHover' => config('bladewind.contact_card.has_hover', false),
    'hasShadow' => config('bladewind.contact_card.has_shadow', true),
    'hasBorder' => config('bladewind.contact_card.has_border', true),
    'noPadding' => config('bladewind.contact_card.no_padding', false),
    'compact' => config('bladewind.contact_card.compact', true),
    //should lazy load images?
    'lazy' => config('bladewind.contact_card.lazy', true),
    'image' => asset('vendor/bladewind/images/avatar.png'),
    'centered' => config('bladewind.contact_card.centered', false),
    'name' => null,
    'mobile' => null,
    'email' => null,
    'department' => null,
    'position' => null,
    'birthday' => null,
    'url' => null,
    'class' => '!p-5 ',
])
@php
    $hasShadow = parseBladewindVariable($hasShadow);
    $hasHover = parseBladewindVariable($hasHover);
    $hasBorder = parseBladewindVariable($hasBorder);
    $noPadding = parseBladewindVariable($noPadding);
    $compact = parseBladewindVariable($compact);
    $centered = parseBladewindVariable($centered);
    $lazy = parseBladewindVariable($lazy);
    $centered_class = $centered ? 'text-center' : '';
@endphp
{{-- format-ignore-end --}}

<x-bladewind::card
        class="{{$class}}"
        has_hover="{{$hasHover}}"
        has_shadow="{{$hasShadow}}"
        has_border="{{$hasBorder}}"
        no_padding="{{$noPadding}}"
        url="{{$url}}"
        is_contact_card="true"
        compact="{{$compact}}">
    <div class="flex items-start">
        @if(!$centered)
            <div class="-mt-1 pr-2">
                <x-bladewind::avatar size="big" image="{{ $image }}"/>
            </div>
        @endif
        <div class="grow pl-3 dark:text-dark-300">
            @if($centered)
                <div class="{{$centered_class}} pb-3.5">
                    <x-bladewind::avatar size="omg" image="{{ $image }}"/>
                </div>
            @endif
            <div class="font-semibold dark:text-dark-300 text-slate-600 {{$centered ? $centered_class.' text-xl' : ' text-lg'}}">{{ $name }}</div>
            <div class="text-sm pb-2 {{$centered_class}}">
                {{ $department }}
                @if($department && $position)
                    <x-bladewind::icon name="chevron-right" class="!h-3 !w-3 inline-block"/>
                @endif
                {!! $position !!}
            </div>
            <div class="space-y-1 {{$centered_class}}">
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
            </div>
        </div>
    </div>
    {{ $slot }}
</x-bladewind::card>
