@props([
    // available options are true or false as strings.
    // setting this to true will set this tab content as the active one
    'active' => false,
    // unique way to identify this tab content using css or javascript
    // this name is used for switching to this content when the tab header is clicked
    'name' => 'tab',
    // additional css to add to the tab content
    // prodbably you'd want to reduce the paddings
    'class' => config('bladewind.tab.content.class', ''),
])
@php 
    $name = preg_replace('/[\s]/', '-', $name);
    $active = parseBladewindVariable($active);
    $active_css = sprintf(((!$active) ? 'hidden %s' : '%s'), $class);
@endphp
<div class="atab-content bw-tc-{{$name}} {{$active_css}}">
    {{ $slot }}
</div>