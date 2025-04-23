@props([ 'class' => config('bladewind.tab.body.class', '')])
@aware([ 'name' => defaultBladewindName('bw-tab-body-')])
@php $name = parseBladewindName($name); @endphp
<div class="{{ $name }}-tab-contents p-4 {{$class}}" data-name="{{ $name }}">
    {{ $slot }}
</div>