@props([
    // name of the datepicker. This name is used when posting the form with the datepicker
    'name' => 'bw-timepicker-'.uniqid(),
    'hour_label' => 'HH',
    'minute_label' => 'MM',
    'format_label' => '--',
    'required' => 'false',
      // what should the time hours be displayed as. Available options are 12, 24
    'format' => '12',
    'selected' => '',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    if(!empty($selected)) {
        $selected = explode(':', str_replace(' ', '', $selected));
        $selected_hour = $selected[0];
        $selected_minute = substr($selected[1], 0, 2);
        $selected_format = (strlen($selected[1]) > 2) ? strtoupper(substr($selected[1], 2, 2)) : '';
    }
@endphp
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
                <x-bladewind::select-item label="AM" value="AM"/>
                <x-bladewind::select-item label="PM" value="PM"/>
            </x-bladewind::select>
        </div>
    @endif
</div>
<input type="hidden" class="bw-time-{{$name}}" name="{{$name}}"/>

<script>
    setTime_{{$name}} = (value) => {
        let field = domEl(`.bw-time-{{$name}}`);
        if (field) {
            let hour = domEl('.bw-{{$name}}_hh').value;
            let minute = ':' + domEl('.bw-{{$name}}_mm').value;
            let format = domEl('.bw-{{$name}}_format').value;
            field.value = `${hour}${minute}${format ?? ''}`;
        }
    }
</script>