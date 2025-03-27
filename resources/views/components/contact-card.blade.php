@props([
    'hasHover' => config('bladewind.contact_card.has_hover', false),
    'hasShadow' => config('bladewind.contact_card.has_shadow', true),
    'image' => asset('vendor/bladewind/images/avatar.png'),
    'name' => null,
    'mobile' => null,
    'email' => null,
    'department' => null,
    'position' => null,
    'birthday' => null,
    'class' => '',
    'hasBorder' => true,
])
@php
    $hasShadow = parseBladewindVariable($hasShadow);
    $hasHover = parseBladewindVariable($hasHover);
    $hasBorder = parseBladewindVariable($hasBorder);
@endphp
<x-bladewind::card
        class="!p-5 {{$class}}"
        :has_hover="$hasHover"
        :has_shadow="$hasShadow"
        :has_border="$hasBorder"
        :is_contact_card="true"
        :compact="true">
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
            </div>
        </div>
    </div>
    {{ $slot }}
</x-bladewind::card>
