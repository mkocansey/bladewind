@props([ 
    // unique name for identifying the toggle element
    // useful for checking the value of the toggle when form is submitted
    'name' => 'bw-toggle',
    // label to display next to the toggle element
    'label' => '',
    // the position of the label above. left or right
    'label_position' => 'left',
    'labelPosition' => 'left',
    // sets or unsets disabled on the toggle element
    'disabled' => false,
    // sets or unsets checked on the toggle element
    'checked' => false,
    // background color to display when toggle is active
    'color' => 'primary',
    // should the label and toggle element be justified in their parent element?
    'justified' => false,
    // how big should the toggle bar be. Options available are thin, thick, thicker
    'bar' => 'thick',
    // javascript function to run when toggle is clicked
    'onclick' => 'javascript:void(0)',
    // css for label
    'class' => '',
    // build size of the bar and circle
    'bar_circle_size' => [
        'thin' => 'w-12 h-3 after:w-5 after:h-5',
        'thick' => 'w-12 h-7 after:w-5 after:h-5',
        'thicker' => 'w-[4.5rem] h-10 after:w-8 after:h-8',
    ],
    'bar_colours' => [
        'primary' => 'peer-checked:bg-primary-500/80 after:border-primary-100',
        'red' => 'peer-checked:bg-red-500/80 after:border-red-100',
        'yellow' => 'peer-checked:bg-yellow-500/80 after:border-yellow-100',
        'green' => 'peer-checked:bg-green-500/80 after:border-green-100',
        'pink' => 'peer-checked:bg-pink-500/80 after:border-pink-100',
        'cyan' => 'peer-checked:bg-cyan-500/80 after:border-cyan-100',
        'gray' => 'peer-checked:bg-slate-500 after:border-slate-100',
        'purple' => 'peer-checked:bg-purple-500/80 after:border-purple-100',
        'orange' => 'peer-checked:bg-orange-500/80 after:border-orange-100',
        'blue' => 'peer-checked:bg-blue-500/80 after:border-blue-100',
    ],
])
@php
    // reset variables for Laravel 8 support
    if ($labelPosition !== $label_position) $label_position = $labelPosition;
    $name = preg_replace('/[\s-]/', '_', $name);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);
    $checked = filter_var($checked, FILTER_VALIDATE_BOOLEAN);
    $justified = filter_var($justified, FILTER_VALIDATE_BOOLEAN);
    $bar = (!in_array($bar, ['thin', 'thick', 'thicker'])) ? 'thick' : $bar;
    $color = (!in_array($color, ['red', 'yellow', 'green', 'blue', 'pink', 'cyan', 'gray', 'purple', 'orange'])) ? 'primary' : $color;
@endphp

<label class="relative @if(!$justified)inline-flex @else flex justify-between @endif items-center group bw-tgl-{{$name}}">
    @if($label_position == 'left' && !empty($label))
        <span class="pr-4 rtl:pl-4">{!!$label!!}</span>
    @endif
    <input type="checkbox" @if($checked) checked @endif @if($disabled) disabled @endif onclick="{!!$onclick!!}"
           name="{{$name}}"
           class="peer sr-only appearance-none {{$name}}"/>
    <span class="flex items-center flex-shrink-0 p-1 bg-gray-900/10 dark:bg-slate-700 rounded-full cursor-pointer
    peer-disabled:opacity-40 rtl:peer-checked:after:-translate-x-full peer-checked:after:translate-x-full transition
    duration-200 ease-in-out after:transition after:duration-200 after:ease-in-out after:bg-white after:shadow-sm after:ring-1 after:ring-slate-700/10
    after:rounded-full bw-tgl-sp-{{$name}} {{$bar_circle_size[$bar]}} {{$bar_colours[$color]}} {{$class}}"></span>
    @if($label_position=='right' && $label !== '')
        <span class="pl-4 rtl:pr-4 {{$class}}">{!!$label!!}</span>
    @endif
</label>