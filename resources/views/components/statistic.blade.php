@props([
    'number' => '',
    'label_position' => config('bladewind.statistic.label_position', 'top'),
    'labelPosition' => config('bladewind.statistic.label_position', 'top'),
    'icon_position' => config('bladewind.statistic.icon_position', 'left'),
    'iconPosition' => config('bladewind.statistic.icon_position', 'left'),
    'currency_position' => config('bladewind.statistic.currency_position', 'left'),
    'currencyPosition' => config('bladewind.statistic.currency_position', 'left'),
    'label' => '',
    'icon' => '',
    'currency' => config('bladewind.statistic.currency', ''),
    'show_spinner' => false,
    'showSpinner' => false,
    'has_shadow' => config('bladewind.statistic.has_shadow', true),
    'hasShadow' => config('bladewind.statistic.has_shadow', true),
    'hasBorder' => config('bladewind.statistic.has_border', true),
    'class' => '',
    'number_css' => '',
])
@php
    // reset variables for Laravel 8 support
    $show_spinner = parseBladewindVariable($show_spinner);
    $showSpinner = parseBladewindVariable($showSpinner);
    $has_shadow = parseBladewindVariable($has_shadow);
    $hasShadow = parseBladewindVariable($hasShadow);
    $has_border = parseBladewindVariable($hasBorder);
    if ($labelPosition !== $label_position) $label_position = $labelPosition;
    if ($iconPosition !== $icon_position) $icon_position = $iconPosition;
    if ($currencyPosition !== $currency_position) $currency_position = $currencyPosition;
    if ($showSpinner) $show_spinner = $showSpinner;
    if (!$hasShadow) $has_shadow = $hasShadow;
    $shadow_css = ($has_shadow) ? 'drop-shadow-sm shadow-sm shadow-slate-200 dark:shadow-dark-800/70' : '';
    $border_css = ($has_border) ? 'border border-gray-100/80 dark:border-dark-600/60' : '';
@endphp

<div {{ $attributes(['class' => "bw-statistic bg-white dark:bg-dark-800/30 focus:outline-none p-6 rounded-md relative $shadow_css $border_css $class"]) }}>
    <div class="flex space-x-4">
        @if($icon !== '' && $icon_position=='left')
            <div class="grow-0 icon">{!! $icon !!}</div>
        @endif
        <div class="grow number">
            @if($label_position=='top')
                <div class="uppercase tracking-wider text-xs text-gray-500/90 mb-1 label">{!! $label!!}</div>
            @endif
            <div class="text-3xl text-gray-500/90 font-light">
                @if($show_spinner)
                    <x-bladewind::spinner></x-bladewind::spinner>
                @endif
                @if($currency!=='' && $currency_position == 'left')
                    <span class="text-gray-300 dark:text-slate-600 mr-1 text-2xl">{!!$currency!!}</span>
                @endif<span
                        class="figure tracking-wider dark:text-slate-400 font-semibold {{$number_css}}">{{ $number }}</span>@if($currency!=='' && $currency_position == 'right')
                    <span class="text-gray-300 dark:text-slate-600 ml-1 text-2xl">{!!$currency!!}</span>
                @endif
            </div>
            @if($label_position=='bottom')
                <div class="uppercase tracking-wider text-xs text-gray-500/90 mt-1 label">{!! $label!!}</div>
            @endif
            {{ $slot }}
        </div>
        @if($icon !== '' && $icon_position=='right')
            <div class="grow-0 icon">{!! $icon !!}</div>
        @endif
    </div>
</div>