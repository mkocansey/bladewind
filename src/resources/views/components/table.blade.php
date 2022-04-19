@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => 'false',
    'hasShadow' => 'false',
    'divided' => 'true',
])

<table class="w-full @if($hasShadow == 'true') shadow-2xl shadow-gray-200 @endif  @if($divided == 'true') divided @endif  @if($striped == 'true') striped @endif">
    <thead>
        <tr class="text-gray-500 bg-gray-200">{{ $header }}</tr>
    </thead>
    <tbody>{{ $slot }}</tbody>
</table>