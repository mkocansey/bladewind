@props([
    'type' => 'secondary', // primary, secondary
    'size' => 'big', // tiny, small, regular, big
    'name' => '', // for use with css and js if you want to manipulate the button
    'has_spinner' => 'false', // will show a spinner
    'can_submit' => 'false', // will make this <button type="submit">
    'onclick' => '', // a function to call onclick on the button
    'disabled' => 'false', // set to true to disable the button
    'class' => '',
])
@php $button_type = ($can_submit == 'false') ? 'button' : 'submit'; @endphp
<button 
    @if ($onclick !== '') onclick="{!! $onclick !!}" @endif 
    @if ($disabled == 'true') disabled="true" @endif
    type="{{$button_type}}"
    class="button {{$size}} {{$type}} {{$name}} {{$class}} @if ($disabled == 'true')disabled @endif">
    <span>{{ $slot }}</span> @if ($has_spinner == 'true') <x-bladewind::spinner class="hidden"></x-bladewind::spinner> @endif
</button>