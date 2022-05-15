@props([
    'number' => '',
    'label_position' => 'top',
    'icon_position' => 'left',
    'currency_position' => 'left',
    'label' => '',
    'icon' => '',
    'currency' => '',
    'show_spinner' => 'false',
    'has_shadow' => 'true',
    'css' => '',
])

    <div class="bw-statistic bg-white p-6 rounded-sm relative @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif{{$css}}">
        <div class="flex space-x-4">
            @if($icon !== '' && $icon_position=='left')
            <div class="grow-0 icon">{!! $icon !!}</div>
            @endif
            <div class="grow number">
                @if($label_position=='top')
                <div class="uppercase tracking-widest text-xs zoom-out text-gray-400/90 mb-1 label">{{ $label}}</div>
                @endif
                <div class="text-3xl zoom-out text-gray-500/90 font-light">
                    @if($show_spinner=='true')<x-bladewind::spinner></x-bladewind::spinner>@endif 
                    @if($currency!=='' && $currency_position == 'left') <span class="text-gray-300 text-2xl">{{$currency}}</span>@endif<span class="figure tracking-wider">{{ $number }}</span>@if($currency!=='' && $currency_position == 'right') <span class="text-gray-300 text-2xl">{{$currency}}</span>@endif
                </div>
                @if($label_position=='bottom')
                <div class="uppercase tracking-wide text-xs zoom-out text-gray-400/90 mt-1 label">{{ $label}}</div>
                @endif
            </div>
            @if($icon !== '' && $icon_position=='right')
            <div class="grow-0 icon">{!! $icon !!}</div>
            @endif
        </div>
    </div>