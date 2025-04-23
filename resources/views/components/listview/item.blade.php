@aware([ 'compact' => false, ])
@props([ 'class' => '', ])
<li class="flex @if(!$compact) p-4 @else py-2 px-4 @endif {{$class}}">{{$slot}}</li>