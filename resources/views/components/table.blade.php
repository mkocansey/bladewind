@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a dropshadow effect
    'has_shadow' => false,
    'hasShadow' => false,
    // should the table have row dividers
    'divided' => true,
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => true,
    'hoverEffect' => true,
    // should the rows be tighter together
    'compact' => false,
    // provide a table name you can access via css
    'name' => '',
])
@php 
    // reset variables for Laravel 8 support
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    $hover_effect = filter_var($hover_effect, FILTER_VALIDATE_BOOLEAN);
    $hoverEffect = filter_var($hoverEffect, FILTER_VALIDATE_BOOLEAN);
    $striped = filter_var($striped, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
    $divided = filter_var($divided, FILTER_VALIDATE_BOOLEAN);
    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
@endphp
<div class="z-20"> {{--max-w-screen overflow-x-hidden md:w-full--}}
    <div class="w-full">
        <table class="bw-table w-full {{$name}} @if($has_shadow) shadow-2xl shadow-gray-200 dark:shadow-xl dark:shadow-slate-900 @endif  @if($divided) divided @if($divider=='thin') thin @endif @endif  @if($striped) striped @endif @if($hover_effect) with-hover-effect @endif @if($compact) compact @endif">
            <thead>
                <tr class="bg-gray-200 dark:bg-slate-800">{{ $header }}</tr>
            </thead>
            <tbody>{{ $slot }}</tbody>
        </table>
    </div>
</div>