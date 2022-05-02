@props([
    // unique way to identify this tab content container using css or javascript
    // this name is used for grouping tab content for  their corresponding tabs
    // the name should be the same as the name given to the tabs container x-tabs
    'for' => 'tab'
])
@php 
    $name = preg_replace('/[\s-]/', '_', $for);
@endphp
<div class="{{ $name }}-tab-contents" data-name="{{ $name }}">
    {{ $slot }}
</div>
<script>
    if( dom_el('.ag-tab-{{ $name }}') == null ){
        alert('you need to define an x-tabs div with the same name as the <{{ $name }}> tab contents container');
    }
</script>