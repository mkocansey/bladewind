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
    'required' => 'false',
])
@php
    $name = preg_replace('/[\s-]/', '_', $name);
    $accepted_file_types = $acceptedFileTypes;
@endphp

<div class="relative px-2 py-3 border-2 border-dashed border-gray-300 text-center cursor-pointer mt-4 {{ $name }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 absolute z-20 left-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute z-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 h-5 w-5 text-gray-300 clear cursor-pointer hidden" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
    </svg>
    <span class="text-gray-400/80 px-6 pl-10 zoom-out inline-block selection">
        {{ $placeholder }}
        @if($required == 'true') <span class="text-red-300">*</span>@endif
    </span>
    <div class="w-0 h-0 overflow-hidden">
        <input 
            type="file" 
            name="{{ $name }}"
            class="bw-{{ $name }} @if($required == 'true') required @endif" 
            id="bw_{{ $name }}" 
            accept="{{ $accepted_file_types }}" />
            <textarea class="b64-{{ $name }}@if($required == 'true') required @endif" name="{{ $name }}"></textarea>
    </div>
</div>

<script>
    dom_el('.{{ $name }}').addEventListener('click', function (){
        dom_el('.bw-{{ $name }}').click();
    });
    dom_el('.bw-{{ $name }}').addEventListener('change', function (){
        let selection = this.value;
        if ( selection != '' ) {
            const [file] = this.files
            if (file) {
                dom_el('.{{ $name }} .selection').innerHTML = 
                ( file.type.indexOf('image') !== -1) ? '<img src="'+ URL.createObjectURL(file) + '" />' : file.name;
                convertToBase64(file, '.b64-{{ $name }}');
            }
            changeCss('.{{ $name }} .clear', 'hidden', 'remove');
        }
    });
    dom_el('.{{ $name }} .clear').addEventListener('click', function (e){
        dom_el('.{{ $name }} .selection').innerHTML = '{{ $placeholder }}';
        dom_el('.bw-{{ $name }}').value = dom_el('.b64-{{ $name }}').value = '';
        changeCss('.{{ $name }} .clear', 'hidden');
        e.stopImmediatePropagation();
    });
    
    convertToBase64 = function(file, el){
        const reader = new FileReader();
        reader.onloadend = () => {
            const base64String = reader.result;//.replace('data:', '').replace(/^.+,/, ''); 
            dom_el(el).value = base64String;
        };
        reader.readAsDataURL(file);
    }
</script>