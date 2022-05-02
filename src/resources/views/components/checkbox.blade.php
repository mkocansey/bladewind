@props([ 
    'name' => 'checkbox',
    'value' => '',
    'label' => '',
    'checked' => 'false',
    'disabled' => 'false',
    'type' => 'checkbox',
    'css' => '',
])
@php $name = preg_replace('/[\s-]/', '_', $name); @endphp

<label 
    class="inline-flex items-center cursor-pointer text-sm @if($disabled=='true') opacity-60 @endif {{$css}}">
    <input 
        value="{{$value}}" 
        name="{{$name}}"
        @if($disabled=='true') disabled="disabled" @endif
        class="text-blue-500 
            w-5 h-5 mr-2 disabled:opacity-60
            focus:ring-blue-400 focus:ring-opacity-25 
            border border-gray-300 bw-checkbox 
            rounded" 
        type="{{$type}}" @if($checked == 'true') checked="checked" @endif />{!! $label !!}
</label>  &nbsp; &nbsp;