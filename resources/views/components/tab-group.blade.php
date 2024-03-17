@props([ 
    'name' => '' ,
    'headings' => '',
    'color' => 'blue',
    'style' => 'simple'
])
@php
    $name = preg_replace('/[\s]/', '-', $name);
    if ($name == '') die('you need to specify the name property of the tab');
@endphp
<div class="bw-tab bw-tab-{{ $name }} {{$style}} {{$color}}">
    <ul class="flex flex-wrap -mb-px {{$name}}-headings" data-name="{{$name}}">
        {{ $headings }}
    </ul>
</div>
{{$slot}}