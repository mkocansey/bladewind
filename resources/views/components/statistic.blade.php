@props([
    'number' => '',
    'label_position' => 'top',
    'labelPosition' => 'top',
    'icon_position' => 'left',
    'iconPosition' => 'left',
    'currency_position' => 'left',
    'currencyPosition' => 'left',
    'label' => '',
    'icon' => '',
    'currency' => '',
    'show_spinner' => false,
    'showSpinner' => false,
    'has_shadow' => true,
    'hasShadow' => true,
    'class' => '',
    'number_css' => '',
])
@php 
    // reset variables for Laravel 8 support
    $show_spinner = filter_var($show_spinner, FILTER_VALIDATE_BOOLEAN);
    $showSpinner = filter_var($showSpinner, FILTER_VALIDATE_BOOLEAN);
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    if ($labelPosition !== $label_position) $label_position = $labelPosition;
    if ($iconPosition !== $icon_position) $icon_position = $iconPosition;
    if ($currencyPosition !== $currency_position) $currency_position = $currencyPosition;
    if ($showSpinner) $show_spinner = $showSpinner;
    if (!$hasShadow) $has_shadow = $hasShadow;
@endphp

    <div class="bw-statistic bg-white dark:bg-slate-800/80 dark:border dark:border-slate-700/50 p-6 rounded-md relative @if($has_shadow)shadow-2xl shadow-gray-200/40 dark:shadow-xl dark:shadow-slate-900 @endif{{$class}}">
        <div class="flex space-x-4">
            @if($icon !== '' && $icon_position=='left')
            <div class="grow-0 icon">{!! $icon !!}</div>
            @endif
            <div class="grow number">
                @if($label_position=='top')
                <div class="uppercase tracking-wider text-xs text-gray-500/90 mb-1 label">{!! $label!!}</div>
                @endif
                <div class="text-3xl text-gray-500/90 font-light">
                    @if($show_spinner)<x-bladewind::spinner></x-bladewind::spinner>@endif
                    @if($currency!=='' && $currency_position == 'left') <span class="text-gray-300 dark:text-slate-600 mr-1 text-2xl">{!!$currency!!}</span>@endif<span class="figure tracking-wider dark:text-slate-400 font-semibold {{$number_css}}">{{ $number }}</span>@if($currency!=='' && $currency_position == 'right') <span class="text-gray-300 dark:text-slate-600 ml-1 text-2xl">{!!$currency!!}</span>@endif
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