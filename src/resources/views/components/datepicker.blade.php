@props([
    // determines what type of datepicker to show. Available options: single, range
    'type' => 'single',
    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => 'bw-datepicker',
    // default date to fill in to the datepicker. Defaults to today. Set to blank to display no default
    'default_date' => '',
    // text to display in the label that identifies the input field
    'label' => 'Date',
    // placeholder text to display if datepicker is empty
    'placeholder' => 'Select a date',
    // is the value of the date field required? used for form validation. default is false
    'required' => 'false',

    // used for range datepickers
    'default_date_from' => '',
    'default_date_to' => '',
    'date_from_label' => 'From',
    'date_to_label' => 'To',
    'has_label' => 'false',
    'css' => '',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $default_date = ($default_date != '') ? $default_date : '';
    $required_symbol = ($has_label == 'false' && $required == 'true') ? ' *' : '';
@endphp
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

@if($type == 'single')
    <div x-data="app('{{ $default_date }}')" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="relative w-full {{$css}}">
        <div class="flex absolute inset-y-0 right-3 items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <input 
            type="hidden" 
            name="{{ $name }}" 
            x-ref="date" 
            :value="datepickerValue" 
            value="{{ $default_date }}"   />
        <input 
            x-on:click="showDatepicker = !showDatepicker" 
            x-model="datepickerValue" 
            x-on:keydown.escape="showDatepicker = false"
            type="text" 
            id="dtp-{{ $name }}"
            maxDate="today"
            class="bw-datepicker bw-input block w-full peer {{ $name}} @if($required == 'true') required @endif {{$css}}" 
            placeholder="{{ $placeholder }}{{$required_symbol}}">
        @if($has_label == 'true')
            <label for="dtp-{{ $name }}" class="form-label">{{ $label }} @if($required == 'true')<span class="text-red-300">*</span>@endif</label>
        @endif

        <div class="bg-white mt-12 p-4 absolute top-0 left-0 z-50 shadow-md" style="width: 17rem" 
            x-show.transition="showDatepicker" @click.away="showDatepicker = false">
        <div class="flex justify-between items-center mb-2">
            <div>
            <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800 cursor-default"></span>
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
                <div x-text="day" class="text-gray-800 font-medium text-center text-xs uppercase cursor-default"></div>
            </div>
            </template>
        </div>

        <div class="flex flex-wrap -mx-1">
            <template x-for="blankday in blankdays">
                <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
            </template>
            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
            <div style="width: 14.28%" class=" mb-1">
                <div @click="getDateValue(date)" x-text="date" class="cursor-pointer text-center text-sm leading-8 rounded-full transition ease-in-out duration-100" :class="{
                    'bg-blue-200': isToday(date) == true, 
                    'text-gray-600 hover:bg-blue-200': isToday(date) == false && isSelectedDate(date) == false,
                    'bg-blue-500 text-white hover:bg-opacity-75': isSelectedDate(date) == true 
                }"></div>
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
                name="{{ $name }}-1" type="single" placeholder="{{$date_from_label}}" 
                default_date="{{ $default_date_from??'' }}" required="{{ $required }}" 
                label="{{$date_from_label}}"></x-bladewind::datepicker>
        </div>
        <div>
            <x-bladewind::datepicker 
                name="{{ $name }}-2" type="single" placeholder="{{$date_to_label}}" 
                default_date="{{ $default_date_to??'' }}" required="{{ $required }}" 
                label="{{$date_to_label}}}"></x-bladewind::datepicker>
        </div>
    </div>
@endif
<script>
    const january = '{{ __('datepicker.JAN') }}';
    const february = '{{ __('datepicker.FEB') }}';
    const march = '{{ __('datepicker.MAR') }}';
    const april = '{{ __('datepicker.APR') }}';
    const may = '{{ __('datepicker.MAY') }}';
    const june = '{{ __('datepicker.JUN') }}';
    const july = '{{ __('datepicker.JUL') }}';
    const august = '{{ __('datepicker.AUG') }}';
    const september = '{{ __('datepicker.SEP') }}';
    const october = '{{ __('datepicker.OCT') }}';
    const november = '{{ __('datepicker.NOV') }}';
    const december = '{{ __('datepicker.DEC') }}';

    const monday = '{{ __('datepicker.MON') }}';
    const tuesday = '{{ __('datepicker.TUE') }}';
    const wednesday = '{{ __('datepicker.WED') }}';
    const thursday = '{{ __('datepicker.THU') }}';
    const friday = '{{ __('datepicker.FRI') }}';
    const saturday = '{{ __('datepicker.SAT') }}';
    const sunday = '{{ __('datepicker.SUN') }}';

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
<script src="{{ asset('bladewind/js/datepicker.js') }}"></script>