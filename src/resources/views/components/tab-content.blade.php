@props([
    // available options are true or false as strings.
    // setting this to true will set this tab content as the active one
    'active' => 'false',
    // unique way to identify this tab content using css or javascript
    // this name is used for switching to this content when the tab header is clicked
    'name' => 'tab'
])
@php 
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
    $activeCss = ($active == 'false') ? 'hidden' : '';
@endphp
<div {{ $attributes->merge([ 'class' => "atab-content ag-tc-$name $activeCss" ]) }}>
    {{ $slot }}
</div>