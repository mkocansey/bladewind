{{-- format-ignore-start --}}
@props([
    // this component is used internally by the library.
    // devs can also use it to display inline script tags
    'src' => null,
    'nonce' => config('bladewind.script.nonce', null),
    'defer' => config('bladewind.script.defer', false),
    'async' => config('bladewind.script.async', false),
    'modular' => config('bladewind.script.modular', false),
])
@php
    $defer = parseBladewindVariable($defer);
    $async = parseBladewindVariable($async);
    $modular = parseBladewindVariable($modular);
@endphp
{{-- format-ignore-end --}}
<script @if($nonce) nonce="{{$nonce}}" @endif @if($defer) defer @endif @if($async) async
        @endif @if($modular) type="module" @endif @if($src) src="{{$src}}" @endif>
    {!! $slot !!}
</script>