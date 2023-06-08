@props([
    // name of the input field for use in forms
    'name' => 'textarea-'.uniqid(),
    'rows' => 3,
    'label' => '',
    'required' => false,
    'add_clearing' => true,
    'addClearing' => true,
    'placeholder' => '', // placeholder text
    'selected_value' => '', // selected value
    'selectedValue' => '',
     // message to display when validation fails for this field
    // this is just attached to the input field as a data attribute
    'error_message' => '',
    'errorMessage' => '',
    // this is an easy way to pass a translatable heading to the notification component
    // since it is triggered from Javascript, it is hard to translate any text from within js
    'error_heading' => 'Error',
    'errorHeading' => 'Error',
    // how should error messages be displayed for this input
    // by default error messages are displayed in the Bladewind notification component
    // the component should exist on the page
    'show_error_inline' => false,
    'showErrorInline' => false,
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
    @if($error_message !== '')<div class="text-red-500 text-xs pt-2 px-1 {{ $name }}-inline-error hidden">{{$error_message}}</div>@endif
    @if($label !== '')
        <label for="{{ $name }}" class="form-label dark:peer-focus:pt-1" onclick="dom_el('.{{$name}}').focus()">{{ $label }} 
            @if($required == 'true') <span class="text-red-400/80"><svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2 inline-block -mt-1" viewBox="0 0 20 20" fill="currentColor">
  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
</svg></span>@endif
        </label>
    @endif
</div>