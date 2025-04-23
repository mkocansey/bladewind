@props([
    // title of the card
    'title' => null,

    // should the card be displayed with a shadow
    'hasShadow' => config('bladewind.card.has_shadow', true),

    // display a border around the card. useful on white backgrounds
    'hasBorder' => config('bladewind.card.has_border', true),

    // display a thicker shadow on hover
    'hasHover' => config('bladewind.card.has_hover', false),

    // reduce padding within the card
    'compact' => config('bladewind.card.compact', false),

    // content to display as card header
    'header' => null,

    // content to display as card footer
    'footer' => null,

    // additional css
    'class' => null,

    // the contact card uses this card component but needs to have a different class name
    'isContactCard' => false,
])
@php
    $compact = parseBladewindVariable($compact);
    $hasShadow = parseBladewindVariable($hasShadow);
    $hasHover = parseBladewindVariable($hasHover);
    $hasBorder = parseBladewindVariable($hasBorder);
    $isContactCard = parseBladewindVariable($isContactCard);

    $class = "bg-white dark:bg-dark-800/30 rounded-lg $class";
    $contact_card_css =   ($isContactCard) ? 'bw-contact-card' : 'bw-card';
    $has_border_css =   ($hasBorder) ? 'border border-slate-200 dark:border-dark-600/60 focus:outline-none' : '';
    $header_compact_css =   (!$header && ! $compact) ? 'p-6' : (($compact) ? 'p-4' : '');
    $shadow_css =   ($hasShadow) ? 'shadow-sm shadow-slate-200/50 dark:shadow-dark-800/70' : '';
    $hover_css =  ($hasHover) ? 'hover:shadow-slate-400 hover:dark:shadow-dark-900 cursor-pointer' : '';
@endphp
<div {{ $attributes->merge([ 'class' => "$class $contact_card_css $has_border_css $header_compact_css $shadow_css $hover_css"]) }}>
    @if($header)
        <div class="border-b border-gray-100/30 dark:border-dark-600/60">
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
        <div class="border-t border-gray-100/30 dark:border-dark-600/60">
            {{$footer}}
        </div>
    @endif
</div>
