@props([
    'name' => 'checkbox',
    'value' => null,
    'label' => null,
    'checked' => false,
    'disabled' => false,
    'type' => 'checkbox',
    'css' => null,
])
@php($name = preg_replace('/[\s-]/', '_', $name))

<label class="inline-flex items-center cursor-pointer text-sm @if($disabled) opacity-60 @endif {{ $css }}">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        class="text-blue-500 w-5 h-5 mr-2 disabled:opacity-60 focus:ring-blue-400 focus:ring-opacity-25 border border-gray-300 bw-checkbox rounded"
        @if($disabled) disabled @endif
        @if($checked) checked @endif
        value="{{ $value }}"
    />
    {!! $label !!}
</label>
