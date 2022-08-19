@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => 'false',
    // should the table with displayed with a dropshadow effect
    'has_shadow' => 'false',
    'hasShadow' => 'false',
    // should the table have row dividers
    'divided' => 'true',
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => 'true',
    'hoverEffect' => 'true',
    // should the rows be tighter together
    'compact' => 'false',
])
@php 
    // reset variables for Laravel 8 support
    $has_shadow = $hasShadow;
    $hover_effect = $hoverEffect;
@endphp
<div class=" z-20"> {{--max-w-screen overflow-x-hidden md:w-full--}}
    <div class="w-full">
        <table class="bw-table w-full @if($has_shadow == 'true') shadow-2xl shadow-gray-200 @endif  @if($divided == 'true') divided @if($divider=='thin') thin @endif @endif  @if($striped == 'true') striped @endif @if($hover_effect=='true') with-hover-effect @endif @if($compact=='true') compact @endif">
            <thead>
                <tr class="text-gray-500 bg-gray-200">{{ $header }}</tr>
            </thead>
            <tbody>{{ $slot }}</tbody>
        </table>
    </div>
</div>