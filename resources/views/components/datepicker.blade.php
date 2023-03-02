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
    'format' => 'yyyy-mm-dd',
    // text to display in the label that identifies the input field
    'label' => '',
    // placeholder text to display if datepicker is empty
    'placeholder' => 'Select a date',
    // is the value of the date field required? used for form validation. default is false
    'required' => false,
    // should the datepicker include a timepicker. The timepicker is hidden by default
    'with_time' => false,
    'withTime' => false,
    // when timepicker is included, what should the time hours be displayed as. Default is 12 hour format
    // available options are 12, 24
    'hours_as' => '12',
    'hoursAs' => '12',
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
    // should labels be displayed for the datepicker
    // By default only placeholders are displayed in the textbox(es)
    /*** deprecating this as of 1.4.1
        'has_label' => 'false',
        'hasLabel' => 'false',
    ***/
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
    //--------------------------------------------------------
    $name = preg_replace('/[\s-]/', '_', $name);
    $default_date = ($default_date != '') ? $default_date : '';
@endphp

@if($type == 'single')
    <div x-data="app('{{ $default_date }}', '{{ strtoupper($format) }}')" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="relative w-full">
        <div class="flex absolute inset-y-0 right-3 z-30 items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
        </div>{{--name="{{ $name }}" --}}
        <input
            type="hidden"
            x-ref="date"
            :value="datepickerValue"
            value="{{ $default_date }}"   />
        <x-bladewind::input
            {{-- class="bw-datepicker bw-input block w-full peer {{$name}}" --}}
            class="bw-datepicker"
            x-on:click="showDatepicker = !showDatepicker"
            x-model="datepickerValue"
            x-on:keydown.escape="showDatepicker = false"
            type="text"
            id="dtp-{{ $name }}"
            max_date="today"
            name="{{$name}}"
            label="{{ $label }}"
            placeholder="{{ $placeholder }}"
            required="{{$required}}" />

        <div class="bg-white dark:bg-slate-600 mt-12 p-4 absolute top-0 left-0 z-50 shadow-md" style="width: 17rem"
            x-show.transition="showDatepicker" @click.away="showDatepicker = false">
        <div class="flex justify-between items-center mb-2">
            <div>
            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800 dark:text-gray-400 cursor-default"></span>
            <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal cursor-default"></span>
            </div>
            <div>
            <button type="button" class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full"
                @click="if (month == 0) {
                    year--;
                    month = 12;
                } month--; getNoOfDays()">
                <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button type="button" class="focus:outline-none focus:shadow-outline transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-100 p-1 rounded-full" @click="if (month == 11) {
                    month = 0;
                    year++;
                } else {
                    month++;
                } getNoOfDays()">
                <svg class="h-6 w-6 text-gray-400 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            </div>
        </div>

            <div class="flex flex-wrap mb-3 -mx-1">
                <template x-for="(day, index) in DAYS" :key="index">
                    <div style="width: 14.26%" class="px-0.5">
                        <div x-text="day" class="text-gray-800 dark:text-gray-400 font-medium text-center text-xs uppercase cursor-default"></div>
                    </div>
                </template>
            </div>

            <div class="flex flex-wrap -mx-1">
                <template x-for="blankday in blankdays">
                    <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
                </template>
                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                    <div style="width: 14.28%" class=" mb-1">
                        <div @click="getDateValue(date, '{{$format}}')" x-text="date" class="cursor-pointer text-center text-sm leading-8 rounded-full transition ease-in-out duration-100" :class="{
                            'bg-blue-200 dark:bg-slate-700': isToday(date) == true,
                            'text-gray-600 dark:text-gray-100 hover:bg-blue-200 hover:dark:bg-slate-500': isToday(date) == false && isSelectedDate(date) == false,
                            'bg-blue-500 dark:bg-slate-700 text-white hover:bg-opacity-75': isSelectedDate(date) == true }">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
  </div>
@else
    <div class="grid grid-cols-2 gap-2">
        <div>
            <x-bladewind::datepicker
                name="{{ $date_from_name }}"
                type="single"
                placeholder="{{$date_from_label}}"
                default_date="{{ $default_date_from??'' }}"
                required="{{ $required }}"
                label="{{$date_from_label}}"
                format="{{$format}}" />
        </div>
        <div>
            <x-bladewind::datepicker
                name="{{ $date_to_name }}"
                type="single"
                placeholder="{{$date_to_label}}"
                default_date="{{ $default_date_to??'' }}"
                required="{{ $required }}"
                label="{{$date_to_label}}"
                format="{{$format}}" />
        </div>
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
        january.substr(0,3), february.substr(0,3), march.substr(0,3),
        april.substr(0,3), may.substr(0,3), june.substr(0,3), july.substr(0,3),
        august.substr(0,3), september.substr(0,3), october.substr(0,3),
        november.substr(0,3), december.substr(0,3)
    ];
    const DAYS = [
        sunday.substr(0,3), monday.substr(0,3), tuesday.substr(0,3), wednesday.substr(0,3),
        thursday.substr(0,3), friday.substr(0,3), saturday.substr(0,3)
    ];
</script>
<script src="{{ asset('vendor/bladewind/js/datepicker.js') }}"></script>
@endonce
