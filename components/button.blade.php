@props([
    'type' => 'secondary', // primary, secondary
    'size' => 'big', // tiny, small, regular, big
    'name' => '', // for use with css and js if you want to manipulate the button
    'canSpin' => 'false', // will show a spinner
    'canSubmit' => 'false', // will make this <button type="submit">
    'onClick' => '', // a function to call onclick on the button
    'disabled' => 'false', // set to true to disable the button
    'css' => '',
    'class' => '', // this is just an alias for $css above
])
@php $buttonType = ($canSubmit == 'false') ? 'button' : 'submit'; @endphp
<button 
    @if ($onClick !== '') onclick="{!! $onClick !!}" @endif 
    @if ($disabled == 'true') disabled="true" @endif
    type="{{$buttonType}}"
    class="button {{$size}} {{$type}} {{$name}} {{$css ?? $class }} @if ($disabled == 'true')disabled @endif">
    <span>{{ $slot }}</span> @if ($canSpin === 'true') <x-spinner class="hidden"></x-spinner> @endif
</button>