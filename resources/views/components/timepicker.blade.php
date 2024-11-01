@props([
    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => 'bw-timepicker-'.uniqid(),
    'hour_label' => config('bladewind.timepicker.hour_label','HH'),
    'minute_label' => config('bladewind.timepicker.minute_label','MM'),
    'format_label' => config('bladewind.timepicker.format_label','--'),
    'required' => false,
      // what should the time hours be displayed as. Available options are 12, 24
    'format' => config('bladewind.timepicker.format','12'),
    'selected_value' => '',
    'style' => config('bladewind.timepicker.style','popup'),
    'label' => '',
    'placeholder' => config('bladewind.timepicker.placeholder','HH:MM'),
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    if(!empty($selected_value)) {
        $selected_time_array = explode(':', str_replace(' ', '', $selected_value));
        $selected_hour = $selected_time_array[0];
        $selected_minute = substr($selected_time_array[1], 0, 2);
        $selected_format = (strlen($selected_time_array[1]) > 2) ? strtoupper(substr($selected_time_array[1], 2, 2)) : '';
    }
@endphp
@if($style == 'popup')
    <div style="width: 120px" class="inline-flex bw-time-icon-container-{{$name}}">
        <x-bladewind::input
                class="bw-time-{{$name}}"
                :name="$name"
                suffix="clock"
                :required="$required"
                suffix_is_icon="true"
                :selected_value="$selected_value"
                :placeholder="$placeholder"
                :label="$label"/>
    </div>
    <script>
        {{--domEl('.{{$name}}-suffix').addEventListener('click', () => {--}}
        domEl('.bw-time-icon-container-{{$name}}').addEventListener('click', () => {
            showModal('bw-timepicker-modal-{{$name}}');
            domEl('.bw-{{$name}}_hh').focus();
        });
    </script>

    <x-bladewind::modal
            title="{{ __('bladewind::timepicker.POPUP_TITLE') }}"
            name="bw-timepicker-modal-{{$name}}"
            cancel_button_label=""
            ok_button_label="{{ __('bladewind::timepicker.POPUP_OKAY') }}"
            show_cancel_button="false"
            align_buttons="center">
        <div class="flex justify-center pt-4 pb-3">
            <div>
                <x-bladewind::input numeric="true" max="{{($format=='12' ? 12 : 23)}}"
                                    :selected_value="$selected_hour??''"
                                    class="w-[105px] text-center border-2 border-gray-200/70 rounded-md !px-4 !py-5 text-5xl font-semibold opacity-80 bw-{{$name}}_hh"
                                    placeholder="{{$hour_label}}"
                                    :enforce_limits="true"
                                    oninput="setTime_{{$name}}(this.value); moveToMinutes('{{$name}}')"/>
            </div>
            <div class="px-3 text-center pt-2.5">
                <div class="block size-3 bg-gray-500 my-4 rounded-full"></div>
                <div class="block size-3 bg-gray-500 rounded-full"></div>
            </div>
            <div>
                <x-bladewind::input numeric="true" max="59"
                                    class="w-[105px] text-center border-2 border-gray-200/70 rounded-md !px-2 !py-5 text-5xl font-semibold opacity-80 bw-{{$name}}_mm"
                                    :selected_value="$selected_minute??''"
                                    placeholder="{{$minute_label}}"
                                    :enforce_limits="true"
                                    oninput="setTime_{{$name}}(this.value); "
                                    maxlength="2"/>
            </div>
            @if($format  == '12')
                <div class="pl-3 space-y-1">
                    <div class="rounded-t-lg font-semibold cursor-pointer text-2xl px-4 py-2 {{ (!empty($selected_format) && $selected_format == 'AM') ? 'bg-gray-500 text-white' : 'bg-gray-100 hover:bg-gray-300' }} bw-time-format-am"
                         onclick="toggleFormat('AM', '{{$name}}');setTime_{{$name}}('AM')">
                        {{ __('bladewind::timepicker.AM') }}
                    </div>
                    <div class="rounded-b-lg font-semibold cursor-pointer text-2xl px-4 py-2 {{ (!empty($selected_format) && $selected_format == 'PM') ? 'bg-gray-500 text-white' : 'bg-gray-100 hover:bg-gray-300' }} bw-time-format-pm"
                         onclick="toggleFormat('PM', '{{$name}}');setTime_{{$name}}('PM')">
                        {{ __('bladewind::timepicker.PM') }}
                    </div>
                    <input type="hidden" class="bw-{{$name}}_format bg-gray-500"/>
                </div>
            @endif
        </div>
    </x-bladewind::modal>
    @once
        <script>
            const toggleFormat = (format, field) => {
                let am = domEl('.bw-time-format-am');
                let pm = domEl('.bw-time-format-pm');
                if (format === 'AM') {
                    changeCss(am, 'bg-gray-500,text-white', 'add', true);
                    changeCss(am, 'bg-gray-100, hover:bg-gray-300', 'remove', true);
                    changeCss(pm, 'bg-gray-500,text-white', 'remove', true);
                    changeCss(pm, 'bg-gray-100, hover:bg-gray-300', 'add', true);
                }
                if (format === 'PM') {
                    changeCss(pm, 'bg-gray-500,text-white', 'add', true);
                    changeCss(pm, 'bg-gray-100, hover:bg-gray-300', 'remove', true);
                    changeCss(am, 'bg-gray-500,text-white', 'remove', true);
                    changeCss(am, 'bg-gray-100, hover:bg-gray-300', 'add', true);
                }
                domEl(`.bw-${field}_format`).value = format;
            }
            const moveToMinutes = (name) => {
                if (domEl(`.bw-${name}_hh`).value.length >= 2) {
                    domEl(`.bw-${name}_mm`).focus();
                }
            }
        </script>
    @endonce
@else
    <div class="flex">
        <div>
            <x-bladewind::select
                    data="manual"
                    onselect="setTime_{{$name}}"
                    :placeholder="$hour_label"
                    name="{{$name}}_hh"
                    :required="$required"
                    selected_value="{{$selected_hour??''}}">
                @for($hours=1; $hours < (($format=='12') ? 13:24); $hours++)
                    @php $hours = (($format=='12') ? $hours : str_pad($hours, 2, '0', STR_PAD_LEFT))  @endphp
                    <x-bladewind::select-item label="{{$hours}}" value="{{$hours}}"/>
                @endfor
                @if($format !== '12')
                    <x-bladewind::select-item label="00" value="00"/>
                @endif
            </x-bladewind::select>
        </div>
        <div class="!-ml-2">
            <x-bladewind::select
                    data="manual"
                    onselect="setTime_{{$name}}"
                    :placeholder="$minute_label"
                    name="{{$name}}_mm"
                    :required="$required"
                    selected_value="{{$selected_minute??''}}">
                <x-bladewind::select-item label="00" value="00"/>
                @for($minutes=1; $minutes < 60; $minutes++)
                    @php $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT) @endphp
                    <x-bladewind::select-item label="{{$minutes}}" value="{{$minutes}}"/>
                @endfor
            </x-bladewind::select>
        </div>
        @if($format == '12')
            <div class="!-ml-2">
                <x-bladewind::select
                        data="manual"
                        onselect="setTime_{{$name}}"
                        :placeholder="$format_label"
                        name="{{$name}}_format"
                        :required="$required"
                        selected_value="{{$selected_format??''}}">
                    <x-bladewind::select-item label="{{ __('bladewind::timepicker.AM') }}" value="AM"/>
                    <x-bladewind::select-item label="{{ __('bladewind::timepicker.PM') }}" value="PM"/>
                </x-bladewind::select>
            </div>
        @endif
    </div>
    <input type="hidden" class="bw-time-{{$name}}" name="{{$name}}" value="{{str_replace(' ', '', $selected_value)}}"/>
@endif

<script>
    const setTime_{{$name}} = (value) => {
        let field = domEl(`.bw-time-{{$name}}`);
        if (field) {
            let hour = domEl('.bw-{{$name}}_hh').value;
            let minute = ':' + domEl('.bw-{{$name}}_mm').value;
            let format = domEl('.bw-{{$name}}_format').value;
            field.value = `${hour}${minute}${format ?? ''}`;
        }
    }
</script>
