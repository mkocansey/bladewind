@php use Illuminate\Support\Str; @endphp
@props([
    // name of the input field for use in passing form submission data
    // this is prefixed with bw- when used as a class name
    'name' => defaultBladewindName('bw-file'),

    // the default text to display in the file picker
    'placeholder' => 'Drag and drop files here or <u class="cursor-pointer">Browse</u>',

    // by default all file media and pdf file types can be selected
    'acceptedFileTypes' => config('bladewind.filepicker.accepted_file_types', 'image/*,audio/*,video/*,application/pdf'),

    // ensure a file is selected by user
    'required' => false,

    // add files to the component by browsing for files
    'canBrowse' => config('bladewind.filepicker.can_browse', true),

    // add files using only drag and drop on the filepicker component
    'canDrop' => config('bladewind.filepicker.can_drop', true),

    // disable the filepicker
    'disabled' => false,

    // validate sizes of selected files
    'validateFileSize' => config('bladewind.filepicker.validate_file_size', true),

    // generate base64 output of selected files
    'base64' => config('bladewind.filepicker.base64', true),

    // show Filepond credits
    'showCredits' => config('bladewind.filepicker.show_credits', false),

    // show image previews when images are selected
    'showImagePreview' => config('bladewind.filepicker.show_image_preview', true),

    // display an image resizing control on selection of file
    'canResizeImage' => config('bladewind.filepicker.can_resize_image', true),

    // should files be automatically uploaded to a server once selected
    'autoUpload' => config('bladewind.filepicker.auto_upload', false),

    // how many files can the user select
    'maxFiles'   => config('bladewind.filepicker.max_files', 1),

    // maximum size for each file
    'maxFileSize'   => config('bladewind.filepicker.max_file_size', '5mb'),

    // maximum size allowed for all files selected
    'maxTotalFileSize'   => config('bladewind.filepicker.max_total_file_size', null),

    // display selected files when component loads
    'selectedValue' => '',

    // when files exist, add new files to this position. top|bottom
    'addNewFilesTo' => config('bladewind.filepicker.add_new_files_to', 'top'),

    // message to display when selected file's size exceeds allowed
    'maxFileSizeExceededLabel' => config('bladewind.filepicker.max_file_size_exceeded_label', 'File is too large'),
    'maxFileSizeLabel' => config('bladewind.filepicker.max_file_size_label', 'Maximum file size is {filesize}'),

    // message to display when total size of all selected files exceeds allowed
    'maxTotalFileSizeExceededLabel' => config('bladewind.filepicker.max_total_file_size_exceeded_label', 'Maximum total file size exceeded'),
    'maxTotalFileSizeLabel' => config('bladewind.filepicker.max_total_file_size_label', 'Maximum total file size is {filesize}'),

    // message to display when wrong file type is selected
    'invalidFileTypeLabel' => config('bladewind.filepicker.invalid_file_type_label', 'Wrong file type uploaded'),

    // message showing which file types are allowed
    'expectedFileTypesLabel' => config('bladewind.filepicker.expected_file_types_label', 'Only {allButLastType} and {lastType} files allowed'),

    // images should be cropped to this width
    'imageResizeWidth' => config('bladewind.filepicker.image_resize_width', null),

    // images should be cropped to this height
    'imageResizeHeight' => config('bladewind.filepicker.image_resize_height', null),

    // aspect ratio used for image cropping
    'cropAspectRatio' => config('bladewind.filepicker.crop_aspect_ratio', null),
])
@php
    $name = parseBladewindName($name);
    $required = parseBladewindVariable($required);
    $canBrowse = parseBladewindVariable($canBrowse);
    $canDrop = parseBladewindVariable($canDrop);
    $canResizeImage = parseBladewindVariable($canResizeImage);
    $validateFileSize = parseBladewindVariable($validateFileSize);
    $showImagePreview = parseBladewindVariable($showImagePreview);
    $maxFileSize = ((Str::contains($maxFileSize,'b')) ? $maxFileSize : $maxFileSize.'mb') ;
    $maxFiles = (! is_numeric($maxFiles)) ? 1 : (int) $maxFiles;
    $imageResizeWidth = (! is_numeric($imageResizeWidth)) ? null : $imageResizeWidth;
    $imageResizeHeight = (! is_numeric($imageResizeHeight)) ? null : $imageResizeHeight;
    $isImageFIle = Str::contains($acceptedFileTypes,['image','png','jpg','jpeg','gif']);
    if(!app()->environment('production') && !file_exists('vendor/bladewind/css/filepond.min.css')) {
        echo '<span class="text-red-400">filepicker assets missing. <a href="https://bladewindui.com/install#install">publish</a> public bladewind assets</span>';
    }
@endphp
@once
    <link href="{{ asset('vendor/bladewind/css/filepond.css') }}" rel="stylesheet"/>
    @if($isImageFIle)
    <link href="{{ asset('vendor/bladewind/css/filepond-plugin-image-preview.css') }}" rel="stylesheet"/>
    <link href="{{ asset('vendor/bladewind/css/filepond-plugin-image-edit.css') }}" rel="stylesheet"/>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-exif-orientation.js') }}"></script>
    @if($validateFileSize)
        <script src="{{ asset('vendor/bladewind/js/filepond-plugin-file-validate-size.js') }}"></script>
        <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-validate-size.js') }}"></script>
    @endif
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-crop.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-resize.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-transform.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-image-edit.js') }}"></script>
    @endif
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/filepond.min.js') }}"></script>
    <div class="label-idle-{{$name}} space-y-2 flex hidden align-middle py-3">
        <div>
            <x-bladewind::icon name="arrow-up-tray"
                               class="!size-14 rounded-full p-3 bg-white stroke-2 text-slate-400"/>
        </div>
        <div class="text-left pl-2.5 pt-1.5">
            <div>Browse or drag and drop files</div>
            <div class="!text-xs tracking-wider opacity-70">
                {{strtoupper(preg_replace(['/\/\*/', '/application\//', '/,/', '/\s*,\s*/'], ['', '', ', ', ', '], $acceptedFileTypes))}}
                up to {{strtoupper($maxFileSize)}}</div>
        </div>
    </div>
@endonce
<input {{
    $attributes->merge([
        'type' => 'file',
        'name' => $name,
        'accept' => $acceptedFileTypes,
    ])
    ->when($required, fn($attributes) => $attributes->merge(['required' => 'true']))
}}/>

<script>
    FilePond.registerPlugin(
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType,
        FilePondPluginImageValidateSize,
        FilePondPluginImagePreview,
        FilePondPluginImageCrop,
        FilePondPluginImageResize,
        FilePondPluginImageTransform,
        FilePondPluginImageEdit,
    );
    const pond_{{$name}} = FilePond.create(domEl('input[name="{{$name}}"]'), {
        name: '{{$name}}',
        className: '{{$name}}',
        maxFiles: {{$maxFiles}},
        maxFileSize: '{{$maxFileSize}}',
        allowFileSizeValidation: {{$validateFileSize ? 'true' : 'false'}},
        maxTotalFileSize: {{!empty($maxTotalFileSize) ? "'$maxTotalFileSize'" : 'null'}},
        allowMultiple: {{$maxFiles > 1 ? 'true' : 'false'}},
        allowBrowse: {{$canBrowse ? 'true' : 'false'}},
        allowDrop: {{$canDrop ? 'true' : 'false'}},
        @if($isImageFIle)
        allowImagePreview: {{$showImagePreview ? 'true' : 'false'}},
        allowImageResize: {{$canResizeImage ? 'true' : 'false'}},
        imageResizeTargetWidth: {{empty($imageResizeWidth) ? 'null' : $imageResizeWidth}},
        imageResizeTargetHeight: {{empty($imageResizeHeight) ? 'null' : $imageResizeHeight}},
        imageCropAspectRatio: {{empty($cropAspectRatio) ? 'null' : $cropAspectRatio}},
        @endif
        disabled: {{$disabled ? 'true' : 'false'}},
        itemInsertLocation: '{{$addNewFilesTo == 'top' ? 'before' : 'after'}}',
        credits: {{$showCredits ? 'true' : 'false'}},
        labelIdle: domEl('.label-idle-{{$name}}').innerHTML,
        acceptedFileTypes: {!! json_encode(explode(',', $acceptedFileTypes)) !!},
        labelMaxFileSizeExceeded: '{{$maxFileSizeExceededLabel}}',
        labelMaxTotalFileSizeExceeded: '{{$maxTotalFileSizeExceededLabel}}',
        labelMaxFileSize: '{{$maxFileSizeLabel}}',
        labelMaxTotalFileSize: '{{$maxTotalFileSizeLabel}}',
        labelFileTypeNotAllowed: '{{$invalidFileTypeLabel}}',
        fileValidateTypeLabelExpectedTypes: '{{$expectedFileTypesLabel}}',
        fileValidateTypeLabelExpectedTypesMap: {
            'image/*': 'images',
            'audio/*': 'audios',
            'video/*': 'videos',
            'application/pdf': 'pdfs'
        },
        iconRemove: `<x-bladewind::icon name="trash" class="p-1 opacity-80 hover:text-red-500" type="solid" />`,
    });
</script>