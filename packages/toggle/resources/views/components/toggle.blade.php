{{-- format-ignore-start --}}
@props([
    // unique name for identifying the toggle element
    // useful for checking the value of the toggle when form is submitted
    'name' => defaultBladewindName('bw-toggle-'),
    // label to display next to the toggle element
    'label' => '',
    // the position of the label above. left or right
    'labelPosition' => config('bladewind.toggle.label_position', 'left'),
    // sets or unsets disabled on the toggle element
    'disabled' => false,
    // sets or unsets checked on the toggle element
    'checked' => false,
    // background color to display when toggle is active
    'color' => 'primary',
    // should the label and toggle element be justified in their parent element?
    'justified' => config('bladewind.toggle.justified', false),
    // how big should the toggle bar be. Options available are thin, thick, thicker
    'bar' => config('bladewind.toggle.bar', 'thick'),
    // javascript function to run when toggle is clicked
    'onclick' => 'javascript:void(0)',
    // css for label
    'class' => '',
])
@php
    $name = parseBladewindName($name);
    $disabled = parseBladewindVariable($disabled);
    $checked = parseBladewindVariable($checked);
    $justified = parseBladewindVariable($justified);
    $bar = (!in_array($bar, ['thin', 'thick', 'thicker'])) ? 'thick' : $bar;
    $colour = defaultBladewindColour($color);
    $bar_colour = "peer-checked:bg-$colour-600 after:border-$colour-100 dark:after:border-red-700";

    // build size of the bar and circle
    $bar_circle_size = [
        'thin' => 'w-12 h-3 after:w-5 after:h-5',
        'thick' => 'w-12 h-7 after:w-5 after:h-5',
        'thicker' => 'w-[4.5rem] h-10 after:w-8 after:h-8',
    ];
@endphp
{{-- format-ignore-end --}}

<label class="relative @if(!$justified)inline-flex @else flex justify-between @endif items-center group bw-tgl-{{$name}}">
    @if($labelPosition == 'left' && !empty($label))
        <span class="pr-4 rtl:pl-4">{!!$label!!}</span>
    @endif
    <input type="checkbox" @if($checked) checked @endif @if($disabled) disabled @endif onclick="{!!$onclick!!}"
           name="{{$name}}"
           class="peer sr-only appearance-none {{$name}}"/>
    <span class="flex items-center flex-shrink-0 p-1 bg-gray-900/10 dark:bg-dark-800 rounded-full cursor-pointer
    peer-disabled:opacity-40 rtl:peer-checked:after:-translate-x-full peer-checked:after:translate-x-full transition
    duration-200 ease-in-out after:transition after:duration-200 after:ease-in-out after:bg-white dark:after:bg-dark-400 after:shadow-sm after:ring-1 after:ring-slate-700/10
    after:rounded-full bw-tgl-sp-{{$name}} {{$bar_circle_size[$bar]}} {{$bar_colour}} {{$class}}"></span>
    @if($labelPosition=='right' && $label !== '')
        <span class="pl-4 rtl:pr-4 {{$class}}">{!!$label!!}</span>
    @endif
</label>