@props([
    'status' => 'pending',
    'date' => '',
    'date_css' => '',
    'label' => '',
    'content' => '',
    'last' => false,
    'avatar' => '',
    'avatar_css' => '',
    'align_left' => false,
])
@aware([
    'stacked' => config('bladewind.timeline.stacked', false),
    'completed' => false,
    'color' => 'gray',
    'anchor' => 'small',
    'anchor_css' => '',
    'icon' => '',
    'icon_css' => '',
    'date_css' => '',
    'position' => 'center',
])
@php
    $stacked = filter_var($stacked, FILTER_VALIDATE_BOOLEAN);
    $completed = filter_var($completed, FILTER_VALIDATE_BOOLEAN);
    $completed = ($status !== 'pending') || $completed;
    $last = filter_var($last, FILTER_VALIDATE_BOOLEAN);
    $align_left = filter_var($align_left, FILTER_VALIDATE_BOOLEAN);
    $content = (!empty($label)) ? $label : $content;
    $anchor_size_css = ($anchor == 'big') ? "h-8 w-8" : "h-3 w-3";
    $anchor_css = sprintf('%s ' .(($completed) ? "bg-$color-500 " : "border-2 border-$color-500/50 "), $anchor_size_css);
    $content_css = ($stacked) ? 'pt-0 pb-6' : (($anchor=='big') ? 'pt-2 pb-10' : 'pb-6');
    $date_css = (($stacked) ? 'pt-0 ' : (($anchor=='big') ? 'pt-2.5 ' : '')) . $date_css;
    $icon = ($completed && $anchor == 'big' && empty($icon)) ? 'check' : $icon;
    $icon_css = (($completed && $anchor == 'big') ? 'text-white ' : "!text-$color-500 opacity-70 ") . $icon_css;
    if(!empty($avatar)) $anchor = "big";
@endphp
<div class="flex">
    <div class="@if($position!=='left') grow w-1/2 @else @if(!$stacked) min-w-28 @else !pr-0 @endif @endif text-right pr-5 text-sm">
        @if(!$stacked || ($stacked && $align_left))
            <div class="font-semibold text-slate-600 dark:text-dark-500 min-w-28 {{$date_css}}">{!! $date !!}</div>
            @if($align_left)
                <div class="leading-6 {{$content_css}}">
                    {!! $content !!}
                </div>
            @endif
        @endif
    </div>

    <div class="flex flex-col @if(!$last) justify-center @endif items-center">
        <div class="rounded-full mt-1 inline-flex items-center justify-center {{$anchor_css}}">
            @if(!empty($avatar))
                <x-bladewind::avatar :image="$avatar" size="small" class="{{$avatar_css}}"/>
            @elseif(!empty($icon))
                <x-bladewind::icon :name="$icon" class="!w-5 !h-5 {{$icon_css}}"/>
            @endif
        </div>
        @if(!$last)
            <div class="bg-{{$color}}-500 @if(!$completed) opacity-30 @endif grow w-[2px] my-1.5"></div>
        @endif
    </div>

    <div class="grow w-1/2 pl-5 space-y-1 text-sm">
        @if(!$align_left)
            @if($stacked)
                <div class="font-bold text-slate-600 dark:text-dark-500 {{$date_css}}">{!! $date !!}</div>
            @endif
            <div class="leading-6 {{$content_css}}">
                {!! $content !!}
            </div>
        @endif
    </div>
</div>