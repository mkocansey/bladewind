@props([
    // name of the input field for use in forms
    'name' => 'input-'.uniqid(),
    // what type of input box are you displaying
    // available options are text, password, email, search, tel
    'type' => 'text', 
    // label to display on the input box
    'label' => '',
    // should the input accept numbers only. Default is false
    'numeric' => false,
    // is this a required field. Default is false
    'required' => false,
    // adds margin after the input box
    'add_clearing' => true,
    'addClearing' => true,
    // placeholder text
    'placeholder' => '',
    // value to set when in edit mode or if you want to load the input with default text
    'selected_value' => '', 
    'selectedValue' => '',
    // should the placeholder always be visible even if a label is set
    // by default the label overwrites the placeholder
    // useful if you dont want this overwriting
    'show_placeholder_always' => false,
    'showPlaceholderAlways' => false,
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
    // for numeric input only: should the numbers include dots
    'with_dots' => true,
    'withDots' => true,
    // determines if the input field has a label
    'has_label' => false,
    'hasLabel' => false,
    'is_datepicker' => false,
    'isDatepicker' => false,
    // set the prefix for the input field
    'prefix' => '',
    // set the suffix for the input field
    'suffix' => '',
    // define if prefix background is transparent
    'transparent_prefix' => true,
    'transparentPrefix' => true,
    // define if suffix background is transparent
    'transparent_suffix' => true,
    'transparentSuffix' => true,
    // force (or not) prefix to be an icon
    'prefix_is_icon' => false,
    'prefixIsIcon' => false,
    // force (or not) suffix to be an icon
    'suffix_is_icon' => false,
    'suffixIsIcon' => false,
    // define if icon prefix is outline or solid
    'prefix_icon_type' => 'outline',
    'prefixIconType' => 'outline',
    // force (or not) suffix to be an icon
    'suffix_icon_type' => 'outline',
    'suffixIconType' => 'outline',
    // should password be viewable
    'viewable' => false,
    // additional css for prefix
    'prefix_icon_css' => '',
    'prefixIconCss' => '',
    // additional css for suffix
    'suffix_icon_css' => '',
    'suffixIconCss' => '',
])
@php
    // reset variables for Laravel 8 support
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    $show_placeholder_always = filter_var($show_placeholder_always, FILTER_VALIDATE_BOOLEAN);
    $showPlaceholderAlways = filter_var($showPlaceholderAlways, FILTER_VALIDATE_BOOLEAN);
    $show_error_inline = filter_var($show_error_inline, FILTER_VALIDATE_BOOLEAN);
    $showErrorInline = filter_var($showErrorInline, FILTER_VALIDATE_BOOLEAN);
    $with_dots = filter_var($with_dots, FILTER_VALIDATE_BOOLEAN);
    $withDots = filter_var($withDots, FILTER_VALIDATE_BOOLEAN);
    $has_label = filter_var($has_label, FILTER_VALIDATE_BOOLEAN);
    $hasLabel = filter_var($hasLabel, FILTER_VALIDATE_BOOLEAN);
    $is_datepicker = filter_var($is_datepicker, FILTER_VALIDATE_BOOLEAN);
    $isDatepicker = filter_var($isDatepicker, FILTER_VALIDATE_BOOLEAN);
    $transparent_prefix = filter_var($transparent_prefix, FILTER_VALIDATE_BOOLEAN);
    $transparentPrefix = filter_var($transparentPrefix, FILTER_VALIDATE_BOOLEAN);
    $transparent_suffix = filter_var($transparent_suffix, FILTER_VALIDATE_BOOLEAN);
    $transparentSuffix = filter_var($transparentSuffix, FILTER_VALIDATE_BOOLEAN);
    $prefix_is_icon = filter_var($prefix_is_icon, FILTER_VALIDATE_BOOLEAN);
    $prefixIsIcon = filter_var($prefixIsIcon, FILTER_VALIDATE_BOOLEAN);
    $suffix_is_icon = filter_var($suffix_is_icon, FILTER_VALIDATE_BOOLEAN);
    $suffixIsIcon = filter_var($suffixIsIcon, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $numeric = filter_var($numeric, FILTER_VALIDATE_BOOLEAN);
    $viewable = filter_var($viewable, FILTER_VALIDATE_BOOLEAN);

    if (!$addClearing) $add_clearing = $addClearing;
    if ($showPlaceholderAlways) $show_placeholder_always = $showPlaceholderAlways;
    if ($showErrorInline) $show_error_inline = $showErrorInline;
    if (!$withDots) $with_dots = $withDots;
    if ($isDatepicker) $is_datepicker = $isDatepicker;
    if (!$transparentPrefix) $transparent_prefix = $transparentPrefix;
    if (!$transparentSuffix) $transparent_suffix = $transparentSuffix;
    if (!$prefixIsIcon) $prefix_is_icon = $prefixIsIcon;
    if (!$suffixIsIcon) $suffix_is_icon = $suffixIsIcon;

    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($errorMessage !== $error_message) $error_message = $errorMessage;
    if ($errorHeading !== $error_heading) $error_heading = $errorHeading;
    if ($prefixIconType !== $prefix_icon_type) $prefix_icon_type = $prefixIconType;
    if ($suffixIconType !== $suffix_icon_type) $suffix_icon_type = $suffixIconType;
    if ($prefixIconCss !== $prefix_icon_css) $prefix_icon_css = $prefixIconCss;
    if ($suffixIconCss !== $suffix_icon_css) $suffix_icon_css = $suffixIconCss;
    //--------------------------------------------------------------------

    $name = preg_replace('/[\s-]/', '_', $name);
    $required_symbol = ($label == '' && $required) ? ' *' : '';
    $is_required = ($required) ? 'required' : '';
    $placeholder_color = ($show_placeholder_always || $label == '') ? '' : 'placeholder-transparent dark:placeholder-transparent';
    $placeholder_label = ($show_placeholder_always) ? $placeholder : (($label !== '') ? $label : $placeholder);
    $with_dots = ($with_dots) ? 1 : 0;

    if($type == "password" && $viewable) {
        $suffix = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 cursor-pointer show-pwd" onclick="togglePassword(\''.$name.'\', \'show\')"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer hide-pwd hidden" onclick="togglePassword(\''.$name.'\', \'hide\')"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>';
        $suffix_is_icon = true;
    }
@endphp

<div class="relative w-full dv-{{$name}} @if($add_clearing) mb-3 @endif">
    <input
            {{ $attributes->merge(['class' => "bw-input peer $is_required $name $placeholder_color"]) }}
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $selected_value }}"
            autocomplete="off"
            placeholder="{{ $placeholder_label }}{{$required_symbol}}"
            @if($error_message != '')
                data-error-message="{{$error_message}}"
            data-error-inline="{{$show_error_inline}}"
            data-error-heading="{{$error_heading}}"
            @endif
    />
    @if(!empty($error_message))
        <div class="text-red-500 text-xs p-1 {{ $name }}-inline-error hidden">{{$error_message}}</div>
    @endif
    @if(!empty($label))
        <label for="{{ $name }}" class="form-label" onclick="dom_el('.{{$name}}').focus()">{!! $label !!}
            @if($required)
                <x-bladewind::icon name="star" class="!text-red-400 !w-2 !h-2 mt-[-2px]" type="solid"/>
            @endif
        </label>
    @endif
    @if (!empty($prefix))
        <div class="{{$name}}-prefix prefix text-sm select-none pl-3.5 pr-2 z-20 text-blue-900/50 dark:text-dark-400 absolute left-0 inset-y-0 inline-flex items-center @if(!$transparent_prefix) bg-slate-100 border-2 border-slate-200 dark:border-dark-700 dark:bg-dark-900/50 dark:border-r-0 border-r-0 rounded-tl-md rounded-bl-md @endif"
             data-transparency="{{$transparent_prefix}}">
            @if($prefix_is_icon)
                <x-bladewind::icon name='{!! $prefix !!}' type="{{ $prefix_icon_type }}" class="{{$prefix_icon_css}}"/>
            @else
                {!! $prefix !!}
            @endif</div>
        <script>positionPrefix('{{$name}}', 'blur', '{{$transparent_prefix}}');</script>
    @endif
    @if (!empty($suffix))
        <div class="{{$name}}-suffix suffix text-sm select-none pl-3.5 !pr-3 z-20 text-blue-900/50 dark:text-dark-400 absolute right-0 inset-y-0 inline-flex items-center @if(!$transparent_suffix) bg-slate-100 border-2 border-slate-200 border-l-0 dark:border-dark-700 dark:bg-dark-900/50 dark:border-l-0 rounded-tr-md rounded-br-md @endif"
             data-transparency="{{$transparent_prefix}}">
            @if($suffix_is_icon)
                <x-bladewind::icon name='{!! $suffix !!}' type="{{ $suffix_icon_type }}" class="{{$suffix_icon_css}}"/>
            @else
                {!! $suffix !!}
            @endif
        </div>
        <script>positionSuffix('{{$name}}');</script>
    @endif
</div>
<input type="hidden" class="bw-raw-select"/>
@if($numeric)
    <script>dom_el('input.{{$name}}').addEventListener('keydown', (event) => {
            isNumberKey(event, {{$with_dots}});
        });
    </script>
@endif