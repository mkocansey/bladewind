{{-- format-ignore-start --}}
@props([
    'number' => '',
    'labelPosition' => config('bladewind.statistic.label_position', 'top'),
    'iconPosition' => config('bladewind.statistic.icon_position', 'left'),
    'currencyPosition' => config('bladewind.statistic.currency_position', 'left'),
    'label' => '',
    'icon' => '',
    'currency' => config('bladewind.statistic.currency', ''),
    'showSpinner' => false,
    'hasShadow' => config('bladewind.statistic.has_shadow', true),
    'hasBorder' => config('bladewind.statistic.has_border', true),
    'class' => '',
    'numberCss' => '',
])
@php
    $showSpinner = parseBladewindVariable($showSpinner);
    $hasShadow = parseBladewindVariable($hasShadow);
    $hasBorder = parseBladewindVariable($hasBorder);

    $shadow_css = ($hasShadow) ? 'drop-shadow-sm shadow-sm shadow-slate-200 dark:shadow-dark-800/70' : '';
    $border_css = ($hasBorder) ? 'border border-gray-100/80 dark:border-dark-600/60' : '';
@endphp
{{-- format-ignore-end --}}

<div {{ $attributes(['class' => "bw-statistic bg-white dark:bg-dark-800/30 focus:outline-none p-6 rounded-md relative $shadow_css $border_css $class"]) }}>
    <div class="flex space-x-4">
        @if($icon !== '' && $iconPosition=='left')
            <div class="grow-0 icon">{!! $icon !!}</div>
        @endif
        <div class="grow number">
            @if($labelPosition=='top')
                <div class="uppercase tracking-wider text-xs text-gray-500/90 mb-1 label">{!! $label!!}</div>
            @endif
            <div class="text-3xl text-gray-500/90 font-light">
                @if($showSpinner)
                    <x-bladewind::spinner></x-bladewind::spinner>
                @endif
                @if($currency!=='' && $currencyPosition == 'left')
                    <span class="text-gray-300 dark:text-slate-600 mr-1 text-2xl">{!!$currency!!}</span>
                @endif<span
                        class="figure tracking-wider dark:text-slate-400 font-semibold {{$numberCss}}">{{ $number }}</span>@if($currency!=='' && $currencyPosition == 'right')
                    <span class="text-gray-300 dark:text-slate-600 ml-1 text-2xl">{!!$currency!!}</span>
                @endif
            </div>
            @if($labelPosition=='bottom')
                <div class="uppercase tracking-wider text-xs text-gray-500/90 mt-1 label">{!! $label!!}</div>
            @endif
            {{ $slot }}
        </div>
        @if($icon !== '' && $iconPosition=='right')
            <div class="grow-0 icon">{!! $icon !!}</div>
        @endif
    </div>
</div>