@props([
    // determines what type of datepicker to show. Available options: single, range
    'type' => 'single',

    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => 'bw-datepicker',

    // default date to fill in to the datepicker. Defaults to today. Set to blank to display no default
    'default_date' => '',
    'defaultDate' => '',

    // date format.. default is yyyy-mm-dd
    // accepted formats are yyyy-mm-dd, mm-dd-yyyy, dd-mm-yyyy, D d M, Y
    'format' => config('bladewind.datepicker.format', 'yyyy-mm-dd'),

    // text to display in the label that identifies the input field
    'label' => '',

    // placeholder text to display if datepicker is empty
    'placeholder' => 'Select a date',

    // is the value of the date field required? used for form validation. default is false
    'required' => false,

    // should the datepicker include a timepicker. The timepicker is hidden by default
    'with_time' => config('bladewind.datepicker.with_time', false),
    'withTime' => config('bladewind.datepicker.with_time', false),

    // when timepicker is included, what should the time hours be displayed as. Default is 12-hour format
    // available options are 12, 24
    'hours_as' => config('bladewind.datepicker.hours_as', 12),
    'hoursAs' => config('bladewind.datepicker.hours_as', 12),

    // what format should the time be displayed in
    'time_format' => 'hh:mm',
    'timeFormat' => 'hh:mm',

    // when the timepicker is included, should the time be displayed with seconds. Default is false
    'show_seconds' => false,
    'showSeconds' => false,

    //----------- used for range datepickers ----------------------------------
    // what should be the default date for the from date
    'default_date_from' => '',
    'defaultDateFrom' => '',

    // what should be the default date for the to date
    'default_date_to' => '',
    'defaultDateTo' => '',

    // what label should be displayed for the from date. Default is 'From'
    'date_from_label' => 'From',
    'dateFromLabel' => 'From',

    // what label should be displayed for the to date. Default is 'To'
    'date_to_label' => 'To',
    'dateToLabel' => 'To',

    // what names should be used for the from date. Default is 'start_date'
    'date_from_name' => 'start_date',
    'dateFromName' => 'start_date',

    // what name should be displayed for the to date. Default is 'end_date'
    'date_to_name' => 'end_date',
    'dateToName' => 'end_date',

    // should validation be turned on for the range picker
    'validate' => false,

    // should the error message be displayed inline instead of in the notification component
    // ensure you have the <-bladewind::notification /> component in your page if you do not
    // want to display the error inline
    'show_error_inline' => false,

    // validation message to display if there is an error with the range picker selection
    'validation_message' => 'Your end date cannot be less than your start date',

    // custom function to call when the datepicker loses focus
    'onblur' => '',

    'tabindex' => -1,

    // first day of the week
    'week_starts' => 'sunday',

    // any extra classes for the datepicker
    'class' => '',

    // should the datepicker use a placeholder instead of the labels when type="range"
    'use_placeholder' => false,

    // show the range pickers be stacked vertically
    'stacked' => false,

    // size of the input field
    'size' => 'medium'
])
@php
    // reset variables for Laravel 8 support
    $default_date = $defaultDate;
    $with_time = filter_var($with_time, FILTER_VALIDATE_BOOLEAN);
    $withTime = filter_var($withTime, FILTER_VALIDATE_BOOLEAN);
    if($withTime) $with_time = $withTime;
    $hours_as = $hoursAs;
    $time_format = $timeFormat;
    $show_seconds = filter_var($show_seconds, FILTER_VALIDATE_BOOLEAN);
    $showSeconds = filter_var($showSeconds, FILTER_VALIDATE_BOOLEAN);
    if($showSeconds) $show_seconds = $showSeconds;
    $default_date_from = $defaultDateFrom;
    $default_date_to = $defaultDateTo;
    $date_from_label = $dateFromLabel;
    $date_to_label = $dateToLabel;
    $date_from_name = $dateFromName;
    $date_to_name = $dateToName;
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $validate = filter_var($validate, FILTER_VALIDATE_BOOLEAN);
    $show_error_inline = filter_var($show_error_inline, FILTER_VALIDATE_BOOLEAN);
    $use_placeholder = filter_var($use_placeholder, FILTER_VALIDATE_BOOLEAN);
    $stacked = filter_var($stacked, FILTER_VALIDATE_BOOLEAN);
    //--------------------------------------------------------
    $name = preg_replace('/[\s-]/', '_', $name);
    $default_date = ($default_date != '') ? $default_date : '';
    $js_function = ($validate) ? "compareDates('$date_from_name', '$date_to_name', '$validation_message', '$show_error_inline')" : $onblur;
    $week_starts = str_replace('day', '', ((in_array($week_starts, ['sun','sunday','mon','monday'])) ? $week_starts : 'sunday'));
@endphp
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
@if($type == 'single')
    <div x-data="app('{{ $default_date }}', '{{ strtoupper($format) }}', '{{$week_starts}}')"
         x-init="[initDate(), getNoOfDays()]" x-cloak>
        <div class="relative w-full">
            <input
                    type="hidden"
                    x-ref="date"
                    :value="datepickerValue"
                    value="{{ $default_date }}"/>

            <x-bladewind::input
                    {{-- class="bw-datepicker bw-input block w-full peer {{$name}}" --}}
                    class="bw-datepicker {{$class}}"
                    x-on:click="showDatepicker = !showDatepicker;"
                    x-on:keydown.escape="showDatepicker = false"
                    x-model="datepickerValue"
                    type="text"
                    id="dtp-{{ $name }}"
                    max_date="today"
                    name="{{$name}}"
                    x-ref="{{$name}}"
                    label="{{ ($use_placeholder) ? '' : $label }}"
                    placeholder="{{ $placeholder }}"
                    onblur="{!! $onblur !!}"
                    tabindex="{!! $tabindex !!}"
                    size="{{$size}}"
                    suffix="calendar-days"
                    suffix_is_icon="true"
                    suffix_icon_div_css="rtl:!right-[unset] rtl:!left-0"
                    suffix_icon_css="text-slate-300"
                    required="{{$required}}"/>

            <div class="bg-white dark:bg-dark-700 mt-12 p-4 absolute top-0 left-0 z-50 drop-shadow-md dark:border dark:border-dark-600/70 rounded-lg"
                 style="width: 17rem"
                 x-show.transition="showDatepicker" @click.away="showDatepicker = false">
                <div class="flex justify-between items-center bg-primary-500 dark:bg-dark-800/50 p-4 !-mx-4 !-mt-4 mb-4 rounded-tl-lg rounded-tr-lg">
                    <div>
                        <button type="button"
                                class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer py-1 pr-1 !-ml-1"
                                @click="if (month == 0) {
                    year--;
                    month = 12;
                } month--; getNoOfDays()">
                            <x-bladewind::icon name="arrow-left"
                                               class="size-5 text-white/50 hover:text-white inline-flex rtl:!rotate-180"/>
                        </button>
                    </div>
                    <div class="text-lg text-white/90 dark:text-gray-100 cursor-default">
                        <span x-text="MONTH_NAMES[month]"></span>
                        <span x-text="year" class="ml-1"></span>
                    </div>
                    <div>
                        <button type="button"
                                class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer py-1 pl-1 !-mr-1 rounded-full"
                                @click="if (month == 11) {
                    month = 0;
                    year++;
                } else {
                    month++;
                } getNoOfDays()">
                            <x-bladewind::icon name="arrow-right"
                                               class="size-5 text-white/50 hover:text-white inline-flex rtl:!rotate-180"/>
                        </button>
                    </div>
                </div>

                <div class="flex flex-wrap mb-3 -mx-1">
                    <template x-for="(day, index) in DAYS" :key="index">
                        <div style="width: 14.26%" class="px-0.5">
                            <div x-text="day"
                                 class="text-gray-500 tracking-wide dark:text-gray-400 font-medium text-center text-xs uppercase cursor-default"></div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap -mx-1">
                    <template x-for="blankday in blankdays">
                        <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                        <div style="width: 14.28%" class=" mb-1">
                            <div @click="getDateValue(date, '{{$format}}')" x-text="date"
                                 class="cursor-pointer text-center text-sm leading-8 rounded-md transition ease-in-out duration-100"
                                 :class="{
                            'bg-primary-100 dark:bg-dark-800': isToday(date) == true,
                            'text-gray-600 dark:text-gray-100 hover:bg-primary-200 hover:dark:bg-dark-500': isToday(date) == false && isSelectedDate(date) == false,
                            'bg-primary-600 dark:bg-dark-900 text-white hover:bg-opacity-75': isSelectedDate(date) == true }">
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="@if(!$stacked) grid  grid-cols-2 gap-2 @endif">
        <div>
            <x-bladewind::datepicker
                    name="{{ $date_from_name }}"
                    type="single"
                    placeholder="{{$date_from_label}}"
                    default_date="{{ $default_date_from??'' }}"
                    :required="$required"
                    :stacked="$stacked"
                    :use_placeholder="$use_placeholder"
                    label="{{$date_from_label}}"
                    week_starts="{{$week_starts}}"
                    onblur="{{ $js_function }}"
                    class="{{$class}}"
                    size="{{$size}}"
                    format="{{$format}}"/>
        </div>
        <div>
            <x-bladewind::datepicker
                    name="{{ $date_to_name }}"
                    type="single"
                    placeholder="{{$date_to_label}}"
                    default_date="{{ $default_date_to??'' }}"
                    :required="$required"
                    :stacked="$stacked"
                    :use_placeholder="$use_placeholder"
                    label="{{$date_to_label}}"
                    week_starts="{{$week_starts}}"
                    onblur="{{ $js_function }}"
                    class="{{$class}}"
                    size="{{$size}}"
                    format="{{$format}}"/>
        </div>
        <div class="text-red-500 text-sm -mt-2 mb-3 col-span-2 error-{{ $date_from_name.$date_to_name }}"></div>
    </div>
@endif
@once
    <script>
        const january = '{{ __('bladewind::datepicker.JAN') }}';
        const february = '{{ __('bladewind::datepicker.FEB') }}';
        const march = '{{ __('bladewind::datepicker.MAR') }}';
        const april = '{{ __('bladewind::datepicker.APR') }}';
        const may = '{{ __('bladewind::datepicker.MAY') }}';
        const june = '{{ __('bladewind::datepicker.JUN') }}';
        const july = '{{ __('bladewind::datepicker.JUL') }}';
        const august = '{{ __('bladewind::datepicker.AUG') }}';
        const september = '{{ __('bladewind::datepicker.SEP') }}';
        const october = '{{ __('bladewind::datepicker.OCT') }}';
        const november = '{{ __('bladewind::datepicker.NOV') }}';
        const december = '{{ __('bladewind::datepicker.DEC') }}';

        const monday = '{{ __('bladewind::datepicker.MON') }}';
        const tuesday = '{{ __('bladewind::datepicker.TUE') }}';
        const wednesday = '{{ __('bladewind::datepicker.WED') }}';
        const thursday = '{{ __('bladewind::datepicker.THU') }}';
        const friday = '{{ __('bladewind::datepicker.FRI') }}';
        const saturday = '{{ __('bladewind::datepicker.SAT') }}';
        const sunday = '{{ __('bladewind::datepicker.SUN') }}';

        const MONTH_NAMES = [
            january, february, march, april, may, june, july, august,
            september, october, november, december,
        ];
        const MONTH_SHORT_NAMES = [
            january.substring(0, 3), february.substring(0, 3), march.substring(0, 3),
            april.substring(0, 3), may.substring(0, 3), june.substring(0, 3), july.substring(0, 3),
            august.substring(0, 3), september.substring(0, 3), october.substring(0, 3),
            november.substring(0, 3), december.substring(0, 3)
        ];
        const DAYS = [@if($week_starts == 'sun') sunday.substring(0, 3), @endif
        monday.substring(0, 3), tuesday.substring(0, 3), wednesday.substring(0, 3),
            thursday.substring(0, 3), friday.substring(0, 3), saturday.substring(0, 3) @if($week_starts == 'mon') , sunday.substring(0, 3) @endif
        ];
    </script>
    <script src="{{ asset('vendor/bladewind/js/datepicker.js') }}"></script>
@endonce
