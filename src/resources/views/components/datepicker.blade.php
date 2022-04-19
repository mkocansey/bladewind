@props([
    // determines what type of datepicker to show. Available options: inline, popup, range
    'type' => 'popup',
    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => 'datepicker',
    // default date to fill in to the datepicker. Defaults to today. Set to blank to display no default
    'defaultDate' => '',
    // text to display in the label that identifies the input field
    'label' => 'Date',
    // placeholder text to display if datepicker is empty
    'placeholder' => 'Select a date',
    // is the value of the date field required? used for form validation. default is false
    'required' => 'false',
    // used for range datepickers
    'dateFrom' => '',
    'dateTo' => '',
])
@php
    $name = str_replace(' ', '_', $name);
    $name = str_replace('-', '_', $name);
    $defaultDate = ($defaultDate != '') ? $defaultDate : '';
@endphp
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

@if($type == 'popup')
    <div x-data="app('{{ $defaultDate }}')" x-init="[initDate(), getNoOfDays()]" x-cloak>
    <div class="relative w-full">
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
            value="{{ $defaultDate }}"   />
        <input 
            x-on:click="showDatepicker = !showDatepicker" 
            x-model="datepickerValue" 
            x-on:keydown.escape="showDatepicker = false"
            type="text" 
            id="dtp-{{ $name }}"
            maxDate="today"
            class="block w-full peer {{ $name}} @if($required == 'true') required @endif" 
            placeholder="{{ $placeholder }}">
        <label for="dtp-{{ $name }}" class="form-label">{{ $label }} @if($required == 'true')<span class="text-red-300">*</span>@endif</label>

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
            <x-datepicker 
                name="from" type="popup" placeholder="{{ __('copy.FROM') }}" 
                defaultDate="{{ $dateFrom??'' }}" required="{{ $required }}" 
                label="{{ __('copy.FROM') }}"></x-datepicker>
        </div>
        <div>
            <x-datepicker 
                name="to" type="popup" placeholder="{{ __('copy.TO') }}" 
                defaultDate="{{ $dateTo??'' }}" required="{{ $required }}" 
                label="{{ __('copy.TO') }}"></x-datepicker>
        </div>
    </div>
@endif
<script>
    const january = '{{ __('calendar.JAN') }}';
    const february = '{{ __('calendar.FEB') }}';
    const march = '{{ __('calendar.MAR') }}';
    const april = '{{ __('calendar.APR') }}';
    const may = '{{ __('calendar.MAY') }}';
    const june = '{{ __('calendar.JUN') }}';
    const july = '{{ __('calendar.JUL') }}';
    const august = '{{ __('calendar.AUG') }}';
    const september = '{{ __('calendar.SEP') }}';
    const october = '{{ __('calendar.OCT') }}';
    const november = '{{ __('calendar.NOV') }}';
    const december = '{{ __('calendar.DEC') }}';

    const monday = '{{ __('calendar.MON') }}';
    const tuesday = '{{ __('calendar.TUE') }}';
    const wednesday = '{{ __('calendar.WED') }}';
    const thursday = '{{ __('calendar.THU') }}';
    const friday = '{{ __('calendar.FRI') }}';
    const saturday = '{{ __('calendar.SAT') }}';
    const sunday = '{{ __('calendar.SUN') }}';

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