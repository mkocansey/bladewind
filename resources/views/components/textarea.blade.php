@props([
    // name of the input field for use in forms
    'name' => 'textarea-'.uniqid(),
    'rows' => config('bladewind.textarea.rows', 3),
    'label' => '',
    'required' => false,
    'add_clearing' => config('bladewind.textarea.add_clearing', true),
    'addClearing' => config('bladewind.textarea.add_clearing', true),
    'placeholder' => '', // placeholder text
    'selected_value' => '', // selected value
    'selectedValue' => '',
     // message to display when validation fails for this field
    // this is just attached to the input field as a data attribute
    'error_message' => '',
    'errorMessage' => '',
    // this is an easy way to pass a translatable heading to the notification component
    // since it is triggered from Javascript, it is hard to translate any text from within js
    'error_heading' => config('bladewind.textarea.error_heading', 'Error'),
    'errorHeading' => config('bladewind.textarea.error_heading', 'Error'),
    // how should error messages be displayed for this input
    // by default error messages are displayed in the Bladewind notification component
    // the component should exist on the page
    'show_error_inline' => config('bladewind.textarea.show_error_inline', false),
    'showErrorInline' => config('bladewind.textarea.show_error_inline', false),

    'toolbar' => config('bladewind.textarea.toolbar', false),
    'except' => '',
])
@php
    // reset variables for Laravel 8 support
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    $show_error_inline = filter_var($show_error_inline, FILTER_VALIDATE_BOOLEAN);
    $showErrorInline = filter_var($showErrorInline, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);

    if (!$addClearing) $add_clearing = $addClearing;
    if($showErrorInline) $show_error_inline = $showErrorInline;
    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($errorMessage !== $error_message) $error_message = $errorMessage;
    if ($errorHeading !== $error_heading) $error_heading = $errorHeading;
    //----------------------------------------------------
    
    $name = preg_replace('/[\s-]/', '_', $name);
    $required_symbol = ($label == '' && $required) ? ' *' : '';
    $is_required = ($required) ? 'required' : '';
    $placeholder_color = ($label !== '') ? 'placeholder-transparent dark:placeholder-transparent' : '';
@endphp
<div class="relative w-full @if($add_clearing) mb-3 @endif">
    @if($toolbar)
        <div id="{{$name}}"></div>
        <textarea hidden name="{{ $name }}" id="{{ $name }}-hidden" class="size-0"></textarea>
    @else
        <textarea {{ $attributes->merge(['class' => "bw-input peer $is_required $name $placeholder_color"]) }}
                  id="{{ $name }}"
                  name="{{ $name }}"
                  rows="{{ $rows }}"
                  @if($error_message !== '')
                      data-error-message="{{$error_message}}"
                  data-error-inline="{{$show_error_inline}}"
                  data-error-heading="{{$error_heading}}"
                  @endif
                  placeholder="{{ ($label !== '') ? $label : $placeholder }}{{$required_symbol}}">{{$selected_value}}</textarea>
    @endif
    @if($error_message !== '')
        <div class="text-red-500 text-xs pt-2 px-1 {{ $name }}-inline-error hidden">{{$error_message}}</div>
    @endif
    @if($label !== '')
        <label for="{{ $name }}" class="form-label dark:peer-focus:pt-1"
               onclick="dom_el('.{{$name}}').focus()">{{ $label }}
            @if($required == 'true')
                <x-bladewind::icon name="star" class="!text-red-400 !w-2 !h-2 mt-[-2px]" type="solid"/>
            @endif
        </label>
    @endif
</div>
@if($toolbar)
    @once
        {{--        <span class="hidden ql-toolbar ql-snow ql-stroke ql-thin ql-container ql-editor ql-blank"></span>--}}
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet"/>
        <script>
            const toolbarOptions = ['bold', 'italic', 'underline',
                {'align': []},
                {'indent': '-1'}, {'indent': '+1'}, 'link',
                {'color': []}, {'background': []},
                {'list': 'ordered'}, {'list': 'bullet'},
                {'list': 'check'}, 'image', 'blockquote', 'code-block', 'clean'
            ];

            const modifyToolbarOptions = (toolbarOptions, except) => {
                except = except.replaceAll(' ', '');
                const exceptArray = except.split(',').map(item => item.trim());
                return toolbarOptions.filter(option => {
                    if (typeof option === 'string') {
                        return !exceptArray.includes(option);
                    } else if (typeof option === 'object') {
                        const key = Object.keys(option)[0];
                        return !exceptArray.includes(key);
                    }
                    return true;
                });
            }

            const quillOptions = {
                theme: 'snow',
                placeholder: '{{ ($label !== '') ? $label : $placeholder }}',
                modules: {
                    toolbar: '',
                },
            };
        </script>
    @endonce
    <script>
        if (typeof Quill === 'undefined') {
            console.log('Unable to load assets from https://quilljs.com');
        } else {
            quillOptions.modules.toolbar = modifyToolbarOptions(toolbarOptions, '{{$except}}');
            var quill_{{$name}} = new Quill('#{{$name}}', quillOptions);
            // Update the hidden input field whenever the textarea content changes
            quill_{{ $name }}.on('text-change', function(delta, oldDelta, source) {
                var value = quill_{{ $name }}.root.innerHTML;
                document.getElementById('{{ $name }}-hidden').value = value;
            });

            // set the initial content for quill
            quill_{{ $name }}.root.innerHTML = @js($selected_value);
        }
    </script>
@endif