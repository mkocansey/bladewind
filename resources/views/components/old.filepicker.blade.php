@props([
    // name of the input field for use in passing form submission data
    // this is prefixed with bw- when used as a class name
    'name' => 'bw-filepicker',
    // the default text to display in the file picker
    'placeholder' => 'Select a file',
    // by default all file audo, video, image and pdf file types can be selected
    // either restrict or allow more file types by modifying this value
    'accepted_file_types' => config('bladewind.filepicker.accepted_file_types', 'audio/*,video/*,image/*, .pdf'),
    'acceptedFileTypes' => config('bladewind.filepicker.accepted_file_types', 'audio/*,video/*,image/*, .pdf'),
    // should the user be forced to select a file. used in conjunction with validation scripts
    // default is false.
    'required' => false,
    // maximum allowed filezie in MB
    'max_file_size' => config('bladewind.filepicker.max_file_size', 5),
    'maxFileSize'   => config('bladewind.filepicker.max_file_size', 5),
    // adds margin after the input box
    'add_clearing' => config('bladewind.filepicker.max_file_size', true),
    'addClearing' => config('bladewind.filepicker.max_file_size', true),
    // display a selected value by default
    'selected_value' => '',
    'selectedValue' => '',
    // the css to apply to the selected value
    'selected_value_class' => config('bladewind.filepicker.selected_value_class', 'h-52'),
    'selectedValueClass' => config('bladewind.filepicker.selected_value_class', 'h-52'),
    // file to display in edit mode
    'url' => '',
    // allow base64 output
    'base64' => true,
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $required = parseBladewindVariable($required);
    $add_clearing = parseBladewindVariable($add_clearing);
    $addClearing = parseBladewindVariable($addClearing);
    $base64 = parseBladewindVariable($base64);
    if (!$addClearing) $add_clearing = $addClearing;
    if ($acceptedFileTypes !== $accepted_file_types) $accepted_file_types = $acceptedFileTypes;
    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($selectedValueClass !== $selected_value_class) $selected_value_class = $selectedValueClass;
    if ($maxFileSize !== $max_file_size) $max_file_size = $maxFileSize;
    if (! is_numeric($max_file_size)) $max_file_size = 5;
    $image_file_types = [ "png", "jpg", "jpeg", "gif", "svg" ];
@endphp
<div class="border-gray-500"></div>
<div class="relative px-2 py-3 border-2 border-dotted border-gray-300 hover:border-gray-400 dark:text-dark-300 dark:border-dark-600
    dark:bg-transparent hover:dark:border-dark-500 text-center cursor-pointer rounded-md bw-fp-{{ $name }} @if($add_clearing) mb-3 @endif">
    <x-bladewind::icon name="document-text"
                       class="h-6 w-6 absolute z-20 left-4 rtl:!right-4 rtl:!left-[unset] text-gray-300 dark:text-dark-500"/>
    <x-bladewind::icon name="x-circle"
                       class="absolute right-3 rtl:!left-3 rtl:!right-[unset] h-8 w-8 text-gray-600 hover:text-gray-700 clear cursor-pointer hidden"
                       type="solid"/>
    <span class="text-gray-400/80 px-6 pl-10 zoom-out inline-block selection">
        {{ $placeholder }}
        @if($required)
            <span class="text-red-300">*</span>
        @endif
    </span>
    <div class="w-0 h-0 overflow-hidden">
        <input
                type="file"
                name="{{ $name }}"
                class="bw-{{ $name }} @if($required) required @endif"
                id="bw_{{ $name }}"
                accept="{{ $accepted_file_types }}"/>
        <textarea class="b64-{{ $name }}@if($required) required @endif"
                  @if($base64)name="b64_{{ $name }}"@endif></textarea>
        @if(!empty($selected_value))
            <input type="hidden" class="selected_{{ $name }}" name="selected_{{ $name }}" value="{{$selected_value}}"/>
        @endif
    </div>
</div>

<script>
    domEl('.bw-fp-{{ $name }}').addEventListener('drop', function (evt) {
        changeCss('.bw-fp-{{ $name }}', 'border-gray-500', 'remove');
        changeCss('.bw-fp-{{ $name }}', 'border-gray-300');
        evt.preventDefault();
        domEl('.bw-{{ $name }}').click();
    });

    domEl('.bw-fp-{{ $name }}').addEventListener('click', function () {
        domEl('.bw-{{ $name }}').click();
    });

    domEl('.bw-{{ $name }}').addEventListener('change', function () {
        let selection = this.value;
        if (selection !== '') {
            const [file] = this.files

            if (file) {
                if (allowedFileSize(file.size, {{$max_file_size}})) {
                    domEl('.bw-fp-{{ $name }} .selection').innerHTML =
                        (file.type.indexOf('image') !== -1) ? '<img src="' + URL.createObjectURL(file) + '" class="rounded-md" />' : file.name;
                    convertToBase64(file, '.b64-{{ $name }}');
                } else {
                    domEl('.bw-fp-{{ $name }} .selection').innerHTML = '<span class="text-red-500">File must be {{$max_file_size}}mb or below</span>';
                }
            }
            changeCss('.bw-fp-{{ $name }} .clear', 'hidden', 'remove');
        }
    });

    domEl('.bw-fp-{{ $name }} .clear').addEventListener('click', function (e) {
        domEl('.bw-fp-{{ $name }} .selection').innerHTML = '{{ $placeholder }}';
        domEl('.bw-{{ $name }}').value = domEl('.b64-{{ $name }}').value = domEl('.selected_{{ $name }}').value = '';
        changeCss('.bw-fp-{{ $name }} .clear', 'hidden');
        e.stopImmediatePropagation();
    });

    @if(!empty($url))
            @if(in_array(pathinfo($url, PATHINFO_EXTENSION), $image_file_types))
        file = '<img src="{{ $url }}" alt="{{ $url }}" class="rounded-md {{$selected_value_class}}" />';
    @else
        file = '{{ ($selected_value != '') ? $selected_value : $url }}';
    @endif
    domEl('.bw-fp-{{ $name }} .selection').innerHTML = file;
    changeCss('.bw-fp-{{ $name }} .clear', 'hidden', 'remove');
    @endif

</script>