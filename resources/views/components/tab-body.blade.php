@props([ 'class' => config('bladewind.tab.body.class', '')])
@aware([ 'name' => 'tab'])
@php $name = preg_replace('/[\s-]/', '_', $name); @endphp
<div class="{{ $name }}-tab-contents p-4 {{$class}}" data-name="{{ $name }}">
    {{ $slot }}
</div>