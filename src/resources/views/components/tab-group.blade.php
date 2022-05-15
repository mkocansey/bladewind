@props([ 
    'name' => '' ,
    'headings' => '',
    'color' => 'blue',
])
@php 
    $name = preg_replace('/[\s]/', '-', $name);
@endphp
<div class="border-b border-gray-200 dark:border-gray-700 bw-tab bw-tab-{{ $name }}">
    <ul class="flex flex-wrap -mb-px tab">
        @php if ($name == '') dd('you need to specify the name property of the tab'); @endphp
        {{ $headings }}
    </ul>
</div>
 <x-bladewind::tab-body for="{{$name}}">
    {{$slot}}
</x-bladewind::tab-body>

<script>
</script>