@props([
    // available options are true or false as strings.
    // setting this to true will set this tab content as the active one
    'active' => false,
    // unique way to identify this tab content using css or javascript
    // this name is used for switching to this content when the tab header is clicked
    'name' => 'tab'
])
@php 
    $name = preg_replace('/[\s]/', '-', $name);
    $active = filter_var($active, FILTER_VALIDATE_BOOLEAN);
    $active_css = (!$active) ? 'hidden' : '';
@endphp
<div class="atab-content bw-tc-{{$name}} {{$active_css}} p-4">
    {{ $slot }}
</div>