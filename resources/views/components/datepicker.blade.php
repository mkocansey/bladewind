@props([
    // allow date range selection
    'range' => false,

    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => defaultBladewindName(),

    // default date to fill in to the datepicker.
    'selectedValue' => '',

    // date format.. default is yyyy-mm-dd
    // accepted formats are yyyy-mm-dd, mm-dd-yyyy, dd-mm-yyyy, D d M, Y
    'format' => config('bladewind.datepicker.format', 'yyyy-mm-dd'),

    // text to display in the label that identifies the input field
    'label' => config('bladewind.datepicker.label', 'Select a date'),

    // placeholder text to display if datepicker is empty
    'placeholder' => config('bladewind.datepicker.placeholder', 'Select a date'),

    // is the value of the date field required? used for form validation
    'required' => false,

    'tabindex' => -1,

    // first day of the week
    'weekStarts' => 'sunday',

    // any extra classes for the datepicker
    'class' => '',

    // size of the input field
    'size' => 'medium',

    // calendar dates start from
    'minDate' => '',

    // calendar dates end at
    'maxDate' => '',
])
@php
    $required = parseBladewindVariable($required);
    $weekStarts = in_array($weekStarts, ['sunday','monday']) ? $weekStarts : 'sunday';
@endphp

<div class="relative w-full">
    <x-bladewind::input
            class="{{$name}} {{$class}}"
            type="text"
            id="{{ $name }}"
            name="{{$name}}"
            label="{{$label}}"
            placeholder="{{ $placeholder }}"
            size="{{$size}}"
            suffix="calendar-days"
            suffix_is_icon="true"
            selected_value="{{$selectedValue}}"
            suffix_icon_div_css="rtl:!right-[unset] rtl:!left-0"
            suffix_icon_css="text-slate-300"
            required="{{$required}}"/>
</div>
@once
    <span class="bw-datepicker-right-arrow hidden"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5" stroke="currentColor"
                                                        class="size-6 cursor-pointer opacity-80 hover:opacity-100"><path
                    stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg></span>
    <span class="bw-datepicker-left-arrow hidden"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                       viewBox="0 0 24 24"
                                                       stroke-width="1.5" stroke="currentColor"
                                                       class="size-6 cursor-pointer opacity-80 hover:opacity-100">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
</svg></span>
    <script>
        const MONTH_NAMES = {
            jan: '{{ __('bladewind::datepicker.JAN') }}',
            feb: '{{ __('bladewind::datepicker.FEB') }}',
            mar: '{{ __('bladewind::datepicker.MAR') }}',
            apr: '{{ __('bladewind::datepicker.APR') }}',
            may: '{{ __('bladewind::datepicker.MAY') }}',
            jun: '{{ __('bladewind::datepicker.JUN') }}',
            jul: '{{ __('bladewind::datepicker.JUL') }}',
            aug: '{{ __('bladewind::datepicker.AUG') }}',
            sep: '{{ __('bladewind::datepicker.SEP') }}',
            oct: '{{ __('bladewind::datepicker.OCT') }}',
            nov: '{{ __('bladewind::datepicker.NOV') }}',
            dec: '{{ __('bladewind::datepicker.DEC') }}',
        };
        const DAY_NAMES = {
            sun: '{{ __('bladewind::datepicker.SUN') }}'.substring(0, 3),
            mon: '{{ __('bladewind::datepicker.MON') }}'.substring(0, 3),
            tue: '{{ __('bladewind::datepicker.TUE') }}'.substring(0, 3),
            wed: '{{ __('bladewind::datepicker.WED') }}'.substring(0, 3),
            thu: '{{ __('bladewind::datepicker.THU') }}'.substring(0, 3),
            fri: '{{ __('bladewind::datepicker.FRI') }}'.substring(0, 3),
            sat: '{{ __('bladewind::datepicker.SAT') }}'.substring(0, 3)
        };
    </script>
    <script src="{{ asset('vendor/bladewind/js/datepicker.js') }}"></script>
@endonce
<script>
    initCalendar({
        inputId: "{{$name}}",
        weekStarts: "{{$weekStarts}}",
        @if(!empty($minDate))minDate: "{{$minDate}}",
        @endif @if(!empty($maxDate))maxDate: "{{$maxDate}}",
        @endif dateFormat: "{{$format}}",
        useRange: {{$range ? 1 : 0}}
    });
</script>
