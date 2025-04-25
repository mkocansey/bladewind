{{-- format-ignore-start --}}
@aware([ 'compact' => false, ])
@props([ 'class' => '', ])
{{-- format-ignore-end --}}
<li class="flex @if(!$compact) p-4 @else py-2 px-4 @endif {{$class}}">{{$slot}}</li>