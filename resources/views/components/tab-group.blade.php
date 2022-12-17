@props([ 
    'name' => '' ,
    'headings' => '',
    'color' => 'blue'
])
@php 
    $name = preg_replace('/[\s]/', '-', $name);
    if ($name == '') die('you need to specify the name property of the tab');
@endphp
<div class="border-b border-gray-200 dark:border-gray-700 bw-tab bw-tab-{{ $name }}">
    <ul class="flex flex-wrap -mb-px tab {{$name}}-headings" data-name="{{$name}}">
        {{ $headings }}
    </ul>
</div>
{{$slot}}