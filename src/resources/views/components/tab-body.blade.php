@aware([ 'name' => 'tab'])
@php $name = preg_replace('/[\s-]/', '_', $name); @endphp
<div class="{{ $name }}-tab-contents" data-name="{{ $name }}">
    {{ $slot }}
</div>