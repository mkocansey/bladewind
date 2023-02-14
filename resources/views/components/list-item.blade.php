@aware([ 'compact' => false, ])
@props([ 'class' => '', ])
<li class="flex @if(!$compact) py-4 @else py-2 @endif first:pt-0 last:pb-0 {{$class}}">{{$slot}}</li>