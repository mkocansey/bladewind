@props([
    'status' => 'pending',
    'stacked' => false,
    'completed' => false,
    'date' => '',
    'label' => '',
    'last' => false,
    'color' => 'blue',
    'icon' => 'check',
    'coloring' => [
        'bg' => [
            'red' => 'bg-red-500',
            'yellow' => 'bg-yellow-500',
            'green' => 'bg-emerald-500',
            'blue' => 'bg-blue-500',
            'orange' => 'bg-orange-500',
            'purple' => 'bg-purple-500',
            'cyan' => 'bg-cyan-500',
            'pink' => 'bg-pink-500',
            'black' => 'bg-black',
        ],
        'border' => [
            'red' => 'border-red-500',
            'yellow' => 'border-yellow-500',
            'green' => 'border-emerald-500',
            'blue' => 'border-blue-500',
            'orange' => 'border-orange-500',
            'purple' => 'border-purple-500',
            'cyan' => 'border-cyan-500',
            'pink' => 'border-pink-500',
            'black' => 'border-black',
        ],
        'text' => [
            'red' => 'text-red-500',
            'yellow' => 'text-yellow-500',
            'green' => 'text-emerald-500',
            'blue' => 'text-blue-500',
            'orange' => 'text-orange-500',
            'purple' => 'text-purple-500',
            'cyan' => 'text-cyan-500',
            'pink' => 'text-pink-500',
            'black' => 'text-black',
        ],
    ],
])
@php
    $stacked = filter_var($stacked, FILTER_VALIDATE_BOOLEAN);
    $completed = filter_var($completed, FILTER_VALIDATE_BOOLEAN);
    $completed = ($status != 'pending') || $completed;
    $last = filter_var($last, FILTER_VALIDATE_BOOLEAN);
@endphp
<div class="flex text-slate-600 dark:text-slate-400">
    @if(!$stacked)
    <div class="pr-3 pt-2 w-[63px] text-right text-sm font-semibold whitespace-nowrap {{ $coloring['text'][$color] }}">{!!$date!!}</div>
    @endif
    <div class="z-20">
        @if($completed)
        <x-bladewind::icon name="{!! $icon !!}" class="{{$coloring['bg'][$color]}} p-2 text-white dark:!text-white rounded-full !h-9 !w-9" />
        @else
        <div class="h-9 w-9 bg-white dark:bg-slate-700 border-2 {{ $coloring['border'][$color] }} rounded-full"></div>
        @endif
    </div>
    <div class="@if(!$last) border-l-2 {{ $coloring['border'][$color] }}@endif pl-7 pb-8 pt-2 z-10 text-sm" style="margin-left: -18px; min-height: 70px">
        @if($stacked) <div class="font-semibold {{ $coloring['text'][$color] }}">{!!$date!!}</div> @endif
        {!!$label!!}
    </div>
</div>