@props([ 
    'name' => 'checkbox',
    'css' => '',
    'value' => '',
    'label' => '',
    'checked' => 'false',
    'disabled' => 'false',
    'type' => 'checkbox',
])
@php $name = str_replace(' ','_', str_replace('-', '_',$name)); @endphp

<label 
    class="inline-flex items-center cursor-pointer text-sm @if($disabled=='true') opacity-60 @endif">
    <input 
        value="{{$value}}" 
        name="{{$name}}"
        @if($disabled=='true') disabled="disabled" @endif
        class="text-blue-500 
            w-5 h-5 mr-2 disabled:opacity-60
            focus:ring-blue-400 focus:ring-opacity-25 
            border border-gray-300 
            rounded {{$css}}" 
        type="{{$type}}" @if($checked == 'true') checked="checked" @endif />{{ $label }}
</label>