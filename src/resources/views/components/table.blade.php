@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => 'false',
    'has_shadow' => 'false',
    'divided' => 'true',
    'divider' => 'regular',
    'hover_effect' => 'true',
])

<div class="max-w-screen overflow-x-hidden md:w-full">
    <div class="w-full overflow-x-scroll">
        <table class="bw-table w-full @if($has_shadow == 'true') shadow-2xl shadow-gray-200 @endif  @if($divided == 'true') divided @if($divider=='thin') thin @endif @endif  @if($striped == 'true') striped @endif @if($hover_effect=='true') with-hover-effect @endif">
            <thead>
                <tr class="text-gray-500 bg-gray-200">{{ $header }}</tr>
            </thead>
            <tbody>{{ $slot }}</tbody>
        </table>
    </div>
</div>