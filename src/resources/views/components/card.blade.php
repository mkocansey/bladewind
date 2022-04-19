@props([
    'type' => 'stat',
    'figure' => '',
    'icon' => '',
    'label' => '',
    'spinner' => ''
])
@if ($type === 'stat')

    <div class="bg-white p-6 mb-6 rounded-sm relative animate__animated animate__fadeIn shadow-2xl shadow-gray-200/40">
        <div>
            <div class="uppercase tracking-wide text-xs zoom-out text-gray-400/90 mb-2">{{ $label}}</div>
            <div {{ $attributes->merge(['class' => "text-3xl zoom-out text-gray-500/90 font-light"]) }}>
                <span>{{ $spinner }}</span><span class="figure">{{ $figure }}</span>
            </div>
            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
        <div class="absolute right-5 top-5">{{ $icon }}</div>
    </div>

@else

    <div {{ $attributes->merge(['class' => "bg-white p-8 rounded-lg mb-8"])}} 
        style="box-shadow: rgba(149, 157, 165, 0.09) 0px 8px 10px;">
        @if($label !== '')<div class="section-heading">{{ $label}}</div>@endif
        <div @if($label !== '')class="mt-6"@endif>
            {{ $slot }}
        </div>
    </div>

@endif