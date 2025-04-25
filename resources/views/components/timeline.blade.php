{{-- format-ignore-start --}}
@props([
    'status' => 'pending',
    'date' => '',
    'dateCss' => '',
    'label' => '',
    'content' => '',
    'last' => false,
    'avatar' => '',
    'avatarCss' => '',
    'alignLeft' => false,
])
@aware([
    'stacked' => config('bladewind.timeline.stacked', false),
    'completed' => false,
    'color' => 'gray',
    'anchor' => 'small',
    'anchorCss' => '',
    'icon' => '',
    'iconCss' => '',
    'dateCss' => '',
    'position' => 'center',
])
@php
    $stacked = parseBladewindVariable($stacked);
    $completed = parseBladewindVariable($completed);
    $completed = ($status !== 'pending') || $completed;
    $last = parseBladewindVariable($last);
    $alignLeft = parseBladewindVariable($alignLeft);
    $content = (!empty($label)) ? $label : $content;
    $anchor_size_css = ($anchor == 'big') ? "h-8 w-8" : "h-3 w-3";
    $anchorCss = sprintf('%s ' .(($completed) ? "bg-$color-500 " : "border-2 border-$color-500/50 "), $anchor_size_css);
    $content_css = ($stacked) ? 'pt-0 pb-6' : (($anchor=='big') ? 'pt-2 pb-10' : 'pb-6');
    $dateCss = (($stacked) ? 'pt-0 ' : (($anchor=='big') ? 'pt-2.5 ' : '')) . $dateCss;
    $icon = ($completed && $anchor == 'big' && empty($icon)) ? 'check' : $icon;
    $iconCss = (($completed && $anchor == 'big') ? 'text-white ' : "!text-$color-500 opacity-70 ") . $iconCss;
    if(!empty($avatar)) $anchor = "big";
@endphp
{{-- format-ignore-end --}}

<div class="flex">
    <div class="@if($position!=='left') grow w-1/2 @else @if(!$stacked) min-w-28 @else !pr-0 @endif @endif text-right pr-5 text-sm">
        @if(!$stacked || ($stacked && $alignLeft))
            <div class="font-semibold text-slate-600 dark:text-dark-500 min-w-28 {{$dateCss}}">{!! $date !!}</div>
            @if($alignLeft)
                <div class="leading-6 {{$content_css}}">
                    {!! $content !!}
                </div>
            @endif
        @endif
    </div>

    <div class="flex flex-col @if(!$last) justify-center @endif items-center">
        <div class="rounded-full mt-1 inline-flex items-center justify-center {{$anchorCss}}">
            @if(!empty($avatar))
                <x-bladewind::avatar :image="$avatar" size="small" class="{{$avatarCss}}"/>
            @elseif(!empty($icon))
                <x-bladewind::icon :name="$icon" class="!w-5 !h-5 {{$iconCss}}"/>
            @endif
        </div>
        @if(!$last)
            <div class="bg-{{$color}}-500 @if(!$completed) opacity-30 @endif grow w-[2px] my-1.5"></div>
        @endif
    </div>

    <div class="grow w-1/2 pl-5 space-y-1 text-sm">
        @if(!$alignLeft)
            @if($stacked)
                <div class="font-bold text-slate-600 dark:text-dark-500 {{$dateCss}}">{!! $date !!}</div>
            @endif
            <div class="leading-6 {{$content_css}}">
                {!! $content !!}
            </div>
        @endif
    </div>
</div>