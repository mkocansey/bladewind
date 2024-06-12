@props([
    // title of the card
    'title' => null,
    // should the card be displayed with a shadow
    'has_shadow' => config('bladewind.card.has_shadow', true),
    // for backward compatibility with Laravel 8
    'hasShadow' => config('bladewind.card.has_shadow', true),
    // display a border around the card. useful on white backgrounds
    'has_border' => config('bladewind.card.has_border', true),
    // display a thicker shadow on hover
    'hover_effect' => config('bladewind.card.hover_effect', false),
    // reduce padding within the card
    'compact' => config('bladewind.card.compact', false),
    // TODO: deprecate this
    'reduce_padding' => config('bladewind.card.reduce_padding', false),
    // for backward compatibility with Laravel 8
    'reducePadding' => config('bladewind.card.reduce_padding', false),
    // content to display as card header
    'header' => null,
    // content to display as card footer
    'footer' => null,
    // additional css
    'class' => null,
    // the contact card uses this card component but needs to have a different class name
    'is_contact_card' => false,
])
@php
    // reset variables for Laravel 8 support
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    $reduce_padding = filter_var($reduce_padding, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
    $reducePadding = filter_var($reducePadding, FILTER_VALIDATE_BOOLEAN);
    $has_border = filter_var($has_border, FILTER_VALIDATE_BOOLEAN);
    $is_contact_card = filter_var($is_contact_card, FILTER_VALIDATE_BOOLEAN);
    if ( !$hasShadow ) $has_shadow = $hasShadow;
    if ( $reducePadding ) {
        $reduce_padding = $reducePadding;
        $compact = $reduce_padding;
    }
@endphp
<div class="@if($is_contact_card) bw-contact-card @else bw-card @endif bg-white dark:bg-dark-800/50 rounded-md {{ $class }}
@if($has_border) border border-slate-200 border-opacity-95 dark:border-dark-600/30 focus:outline-none @endif
@if(!$header && ! $compact) p-8 @elseif($compact) py-3 px-5 @endif
@if($has_shadow) shadow-sm shadow-slate-200/50 dark:shadow-dark-800
    @if($hover_effect) hover:shadow-mdÍ hover:dark:shadow-dark-800 cursor-pointer @endif
@endif">
    @if($header)
        <div class="border-b border-gray-100/30 dark:border-dark-800/50">
            {{ $header }}
        </div>
    @endif
    @if($title && ! $header)
        <div class="uppercase tracking-wide text-xs text-gray-500/90 mb-2">{{ $title }}</div>
    @endif
    <div @if($title && ! $header) class="mt-6" @endif>
        {{ $slot }}
    </div>
    @if($footer)
        <div class="border-t border-gray-100/30 dark:border-dark-800/50">
            {{$footer}}
        </div>
    @endif
</div>
