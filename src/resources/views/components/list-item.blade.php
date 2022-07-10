@aware([ 'compact' => 'false' ])
<li class="flex @if($compact=='false') py-4 @else py-2 @endif first:pt-0 last:pb-0">{{$slot}}</li>