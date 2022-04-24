@props([
    'type' => 'stat',
    'figure' => '',
    'icon' => '',
    'title' => '',
    'show_spinner' => 'false',
    'css' => '',
    'has_shadow' => 'true',
])
@if ($type === 'stat')

    <div class="bw-card bg-white p-6 mb-6 rounded-sm relative animate__animated animate__fadeIn @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif">
        <div>
            <div class="uppercase tracking-wide text-xs zoom-out text-gray-400/90 mb-2">{{ $title}}</div>
            <div class="text-3xl zoom-out text-gray-500/90 font-light {{ $css }}">
                @if($show_spinner=='true')<x-bladewind::spinner></x-bladewind::spinner><span class="figure">{{ $figure }}</span>
            </div>
            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
        <div class="absolute right-5 top-5">{{ $icon }}</div>
    </div>

@else

    <div class="bg-white p-8 rounded-lg mb-8 @if($has_shadow=='true')shadow-2xl shadow-gray-200/40 @endif {{$css}}" 
        style="box-shadow: rgba(149, 157, 165, 0.09) 0px 8px 10px;">
        @if($title !== '')<div class="section-heading">{{ $title}}</div>@endif
        <div @if($title !== '')class="mt-6"@endif>
            {{ $slot }}
        </div>
    </div>

@endif