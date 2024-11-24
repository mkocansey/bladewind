@props([
   'color' => '',
   'grouped' => true,
   'can_open_multiple' => false,
   'class' => '',
])
@php
    $name = defaultBladewindName();
    $grouped = parseBladewindVariable($grouped);
    $can_open_multiple = parseBladewindVariable($can_open_multiple);
@endphp

<div class="w-full bw-accordions {{$name}} {{ $class }}"
     data-name="{{$name}}"
     data-open-multiple="{{$can_open_multiple ? '1':'0'}}">
    @if($grouped)
        <x-bladewind::card>
            <div class="divide-y divide-gray-200/70 dark:divide-dark-600 space-y-4">
                {!! $slot !!}
            </div>
        </x-bladewind::card>
    @else
        <div class="space-y-4">{!! $slot !!}</div>
    @endif
</div>

@once
    <script>
        const toggleVisibility = (element) => {
            const accordion = domEl(`.${element}`);
            if (!accordion) return;

            const parentAccordion = accordion.closest('.bw-accordions');
            const canOpenMultiple = parentAccordion?.getAttribute('data-open-multiple') === '1';
            const accordions = domEls('.bw-accordion', `.${parentAccordion?.getAttribute('data-name') || ''}`);

            const toggleState = (targetAccordion, isOpen) => {
                const accordionName = targetAccordion.getAttribute('data-name');
                const content = domEl(`.${accordionName} .accordion-content`);
                const arrow = domEl(`.${accordionName} .accordion-arrow`);
                const title = domEl(`.${accordionName} .accordion-title`);

                targetAccordion.setAttribute('data-open', isOpen ? '1' : '0');
                if (content) content.style.maxHeight = isOpen ? `${content.scrollHeight}px` : null;
                changeCss(arrow, 'rotate-180', isOpen ? 'add' : 'remove', true);
                changeCss(title, 'text-gray-700 dark:text-slate-100', isOpen ? 'add' : 'remove', true);
            };

            if (!canOpenMultiple) {
                accordions.forEach((el) => {
                    if (el !== accordion) toggleState(el, false);
                });
            }

            const isOpen = accordion.getAttribute('data-open') === '1';
            toggleState(accordion, !isOpen);
        };
    </script>
@endonce