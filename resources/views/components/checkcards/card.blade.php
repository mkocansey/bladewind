@props([
    'class' => null,
    'title' => '',
    'value' => '',
])
@aware([
    'compact' => config('bladewind.checkcards.compact', false),
    'color' => config('bladewind.checkcards.color', 'primary'),
    'radius' => config('bladewind.checkcards.rounded', false),
    'name' => null,
    'align_items' => 'top',
    'radius' => 'medium',
    'border_color' => 'gray',
    'border_width' => 2,
    'selected_value' => '',
    'checkbox_position' => 'left',
    'icon' => null,
    'avatar' => null,
    'avatar_size' => 'medium',
])
@php
    $name = parseBladewindName($name);
    $compact = parseBladewindVariable($compact);
    $colour = defaultBladewindColour($color);
    $border_colour = defaultBladewindColour($border_color, 'gray');
    $border_width = !in_array($border_width, ['', 2,4,8]) ? '' : '-'.$border_width;
    $radius = !in_array($radius, ['none', 'small', 'medium', 'full']) ? 'small' : $radius;
    $radii = [
        'none' => 'rounded-none',
        'small' => 'rounded-md',
        'medium' => 'rounded-lg',
        'full' => 'rounded-full'
    ];
@endphp
<div @class([
        'bg-white dark:bg-dark-800/30 bw-selectable-card cursor-pointer focus:outline-none flex',
        'items-center' => ($align_items == 'center'),
        'items-start' => ($align_items != 'center'),
        "border$border_width border-$border_colour-400/50 hover:border-$border_colour-500/80 dark:border-dark-500 dark:hover:border-dark-500",
        $class => (!empty($class)),
        $radii[$radius],
        $name,
        'py-3 px-4' => ($compact),
        'p-5' => (!$compact)
]) {{ $attributes->merge([ 'class' => ""]) }} onclick="selectCheckcard('{{$name}}', '{{$value}}', '{{$border_colour}}')"
     data-value="{{$value}}">
    <div class="flex">
        @if(!empty($icon))
            <x:bladewind::icon name="{{$icon}}"
                               class="rounded-full p-2 size-11 bg-{{$colour}}-100/70 text-{{$colour}}-600 mr-3"/>
        @elseif(!empty($avatar))
            <x-bladewind::avatar image="{{$avatar}}" bg_color="{{$colour}}" :size="$avatar_size"
                                 class="mr-3.5 {{($align_items!='center') ? 'mt-2':''}}"/>
        @endif
    </div>
    <div class="grow">
        @if(!empty($title))
            <div class="text-base tracking-wide font-medium text-slate-900">{{$title}}</div>
        @endif
        <div class="text-slate-500">
            {{$slot}}
        </div>
    </div>
    <div class="relative">
        <div class="">
            <x-bladewind::icon name="check-circle" type="solid"
                               class="text-{{$border_colour}}-600 stroke-white !size-9 absolute checkmark hidden
                               {{ ($compact) ? '-top-6 -right-8' : '-top-8 -right-9' }}"/>
        </div>
    </div>
</div>

@once
    <script>
        var selectCheckcard = (name, value, borderColour) => {
            let input = domEl(`input.${name}`);
            let arrInputValue = (input.value !== '') ? input.value.split(',') : [];
            let elString = `div.${name}[data-value="${value}"]`;
            let el = domEl(elString);
            let checkmark = domEl(`${elString} .checkmark`);
            const border_default = `border-${borderColour}-400/50,hover:border-${borderColour}-500/80`;
            const border_active = `border-${borderColour}-500`;
            const maxSelection = parseInt(input.getAttribute('data-max-selection'));
            const errorHeading = input.getAttribute('data-error-heading') ?? '';
            const errorMessage = input.getAttribute('data-error-message');
            const showError = parseInt(input.getAttribute('data-show-error')) === 1;
            const autoSelect = parseInt(input.getAttribute('data-auto-select')) === 1;

            if (arrInputValue.length > 0 && arrInputValue.includes(value)) {
                arrInputValue = arrInputValue.filter(item => item !== value);
                input.value = arrInputValue.join(',');
                hide(checkmark, true);
                changeCss(el, border_default, 'add', true);
                changeCss(el, border_active, 'remove', true);
            } else {
                if (arrInputValue.length >= maxSelection) {
                    if (autoSelect) { //removed last item selected
                        selectCheckcard(name, arrInputValue[arrInputValue.length - 1], borderColour);
                        arrInputValue.pop();
                    } else {
                        if (showError) showNotification(errorHeading, errorMessage, 'error');
                        return false;
                    }
                }
                arrInputValue.push(value);
                input.value = arrInputValue.join(',');
                unhide(checkmark, true);
                changeCss(el, border_default, 'remove', true);
                changeCss(el, border_active, 'add', true);
            }
        }
    </script>
@endonce

@if($selected_value !== '')
    @if(in_array($value, explode(',', $selected_value)))
        <script>selectCheckcard('{{$name}}', '{{$value}}', '{{$border_colour}}'); </script>
    @endif
@endif