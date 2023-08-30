@props([
    // name of the input field for use in passing form submission data
    // this is prefixed with bw- when used as a class name
    'name' => 'bw-filepicker',
    // the default text to display in the file picker
    'placeholder' => 'Select a file',
    // by default all file audo, video, image and pdf file types can be selected
    // either restrict or allow more file types by modifying this value
    'accepted_file_types' => 'audio/*,video/*,image/*, .pdf',
    'acceptedFileTypes' => 'audio/*,video/*,image/*, .pdf',
    // should the user be forced to select a file. used in conjunction with validation scripts
    // default is false.
    'required' => false,
    // maximum allowed filezie in MB
    'max_file_size' => 5,
    'maxFileSize'   => 5,
    // adds margin after the input box
    'add_clearing' => true,
    'addClearing' => true,
    // display a selected value by default
    'selected_value' => '',
    'selectedValue' => '',
    // the css to apply to the selected value
    'selected_value_class' => 'h-52',
    'selectedValueClass' => 'h-52',
    // file to display in edit mode
    'url' => '',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    if (!$addClearing) $add_clearing = $addClearing;
    if ($acceptedFileTypes !== $accepted_file_types) $accepted_file_types = $acceptedFileTypes;
    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($selectedValueClass !== $selected_value_class) $selected_value_class = $selectedValueClass;
    if ($maxFileSize !== $max_file_size) $max_file_size = $maxFileSize;
    if (! is_numeric($max_file_size)) $max_file_size = 5;
    $image_file_types = [ "png", "jpg", "jpeg", "gif", "svg" ];
@endphp
<div class="border-gray-500"></div>
<div class="relative px-2 py-3 border-2 border-dashed border-gray-300 dark:text-dark-300 dark:border-dark-700
    dark:bg-dark-800 hover:dark:border-dark-600 text-center cursor-pointer rounded-md bw-fp-{{ $name }} @if($add_clearing) mb-3 @endif">
    <x-bladewind::icon name="document-text" class="h-6 w-6 absolute z-20 left-4 text-gray-300" />
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute z-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
    </svg>
    <x-bladewind::icon name="x-circle" class="absolute right-3 h-8 w-8 text-gray-600 hover:text-gray-800 clear cursor-pointer hidden" type="solid" />
    <span class="text-gray-400/80 px-6 pl-10 zoom-out inline-block selection">
        {{ $placeholder }}
        @if($required) <span class="text-red-300">*</span>@endif
    </span>
    <div class="w-0 h-0 overflow-hidden">
        <input 
            type="file" 
            name="{{ $name }}"
            class="bw-{{ $name }} @if($required) required @endif"
            id="bw_{{ $name }}" 
            accept="{{ $accepted_file_types }}" />
            <textarea class="b64-{{ $name }}@if($required) required @endif" name="b64_{{ $name }}"></textarea>
            @if(!empty($selected_value))<input type="hidden" class="selected_{{ $name }}" name="selected_{{ $name }}" value="{{$selected_value}}" />@endif
    </div>
</div>

<script>

    dom_el('.bw-fp-{{ $name }}').addEventListener('drop', function (evt){
        changeCss('.bw-fp-{{ $name }}','border-gray-500', 'remove');
        changeCss('.bw-fp-{{ $name }}','border-gray-300');
        evt.preventDefault();
        dom_el('.bw-{{ $name }}').click();
    });

    ['dragleave', 'drop', 'mouseout'].forEach(evt =>
        dom_el('.bw-fp-{{ $name }}').addEventListener(evt, () => {
            changeCss('.bw-fp-{{ $name }}','border-gray-500', 'remove');
            changeCss('.bw-fp-{{ $name }}','border-gray-300');
        }, false)
    );

    ['dragenter', 'dragover', 'mouseover'].forEach(evt =>
        dom_el('.bw-fp-{{ $name }}').addEventListener(evt, () => {
            changeCss('.bw-fp-{{ $name }}','border-gray-500');
        }, false)
    );

    dom_el('.bw-fp-{{ $name }}').addEventListener('click', function (){
        dom_el('.bw-{{ $name }}').click();
    });

    dom_el('.bw-{{ $name }}').addEventListener('change', function (){
        let selection = this.value;
        if ( selection !== '' ) {
            const [file] = this.files

            if (file) {
                if(allowedFileSize(file.size, {{$max_file_size}})) {
                    dom_el('.bw-fp-{{ $name }} .selection').innerHTML = 
                    ( file.type.indexOf('image') !== -1) ? '<img src="'+ URL.createObjectURL(file) + '" class="rounded-md" />' : file.name;
                    convertToBase64(file, '.b64-{{ $name }}');
                } else {
                    dom_el('.bw-fp-{{ $name }} .selection').innerHTML = '<span class="text-red-500">File must be {{$max_file_size}}mb or below</span>';
                }
            }
            changeCss('.bw-fp-{{ $name }} .clear', 'hidden', 'remove');
        }
    });

    dom_el('.bw-fp-{{ $name }} .clear').addEventListener('click', function (e){
        dom_el('.bw-fp-{{ $name }} .selection').innerHTML = '{{ $placeholder }}';
        dom_el('.bw-{{ $name }}').value = dom_el('.b64-{{ $name }}').value = '';
        changeCss('.bw-fp-{{ $name }} .clear', 'hidden');
        e.stopImmediatePropagation();
    });
    
    convertToBase64 = (file, el) => {
        const reader = new FileReader();
        reader.onloadend = () => {
            const base64String = reader.result;//.replace('data:', '').replace(/^.+,/, ''); 
            dom_el(el).value = base64String;
        };
        reader.readAsDataURL(file);
    }

    allowedFileSize = (file_size, max_size) => {
        return ( file_size <= ((max_size)*1)*1000000 );
    }

    @if(!empty($url))
    @if(in_array(pathinfo($url, PATHINFO_EXTENSION), $image_file_types))
        file = '<img src="{{ $url }}" alt="{{ $url }}" class="rounded-md {{$selected_value_class}}" />';
    @else
        file = '{{ ($selected_value != '') ? $selected_value : $url }}';
    @endif
    dom_el('.bw-fp-{{ $name }} .selection').innerHTML = file;
    changeCss('.bw-fp-{{ $name }} .clear', 'hidden', 'remove');
    @endif

</script>