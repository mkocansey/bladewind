{{-- format-ignore-start --}}
@aware([ 'compact' => false, ])
@props([ 'class' => '', ])
{{-- format-ignore-end --}}
<li class="flex first:rounded-t-lg last:rounded-b-lg space-x-5 @if(!$compact) p-4 @else py-2 px-4 @endif {{$class}}">{{$slot}}</li>