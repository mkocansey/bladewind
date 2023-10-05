@props([
    // name to uniquely identity a select
    'name' => 'bw-select',

    // the default text to display when the select shows
    'placeholder' => 'Select One',

    // optional function to execute when a select item is selected
    // by default the value of a select item is written to an input field with the
    // name dd_name. Where name is the name you provided for the select
    // if you named your select countries for example, whatever country is selected can
    // be found in the <input type="hidden" clas="input-countries" name="dd_countries" />
    'onselect' => '',

    // data to pass to the select
    // your data must be a json string (not object) with the keys value and label
    // value is whatever value will be passed to your code when an item is selected
    // label is what will be displayed to the user
    // if you want to display icons for each item your json can contain the optional 'icon' key
    // where icons are required, they must be in the semantic UI icon format
    // [{"label":"Burkina Faso","icon":"bf flag","value":"+226"},{"label":"Ghana","icon":"gh flag","value":"+233"},{"label":"Ivory Coast","icon":"ivc flag","value":"+228"}]
    'data' => [],

    // what key in your data array should be used to populate 'value' of the select when an item is selected
    // by default a key of 'value' is used. If your data is something like [ {"id":"1","name":"Burkina Faso"}]
    // your value_key will be 'id'
    'value_key' => 'value',
    'valueKey' => 'value',

    // what key in your data array should be used to display the labels the user will see as select items
    // the default key used for labels is 'label'. If your data is something like [ {"id":"1","name":"Burkina Faso"}]
    // your label_key will be 'name'
    'label_key' => 'label',
    'labelKey' => 'label',

    // what key in your data array should be used to display flag icons next to the labels
    // [ {"id":"1","name":"Burkina Faso", "flag":"/assets/images/bf-flag.png"}]
    // your flag_key will be 'image'
    'flag_key' => null,
    'flagKey' => null,

    // what key in your data array should be used to display images next to the labels
    // the default key used for images is '', meaning images will be ignored. If your data is something like
    // [ {"id":"1","name":"Burkina Faso", "image":"/assets/images/bf-flag.png"}]
    // your image_key will be 'image'
    'image_key' => null,
    'imageKey' => null,

    // there are instances when you want the name passed by the select when you submit a form to be
    // different from the name you gave the select. Example. you may name the select as country but
    // want it to submit data as country_id.
    'data_serialize_as' => '',
    'dataSerializeAs' => '',

    // enforces validation if set to true
    'required' => 'false',

    'disabled' => 'false',

    'readonly' => 'false',

    'multiple' => 'false',

    // adds margin after the input box
    'add_clearing' => true,
    'addClearing' => true,

    // determines if a value passed in the data array should automatically be selected
    // useful when using the component in edit mode or as part of filter options
    // the value you specify should exist in your value_key. If your value_key is 'id', you
    // cannot set a selected_value of 'maize white'
    'selected_value' => '',
    'selectedValue' => '',

    // setting this to true adds a search box above the select items
    // this can be used to filter the contents of the select items
    'searchable' => false,
])
@php
    //$multiple = filter_var($multiple, FILTER_VALIDATE_BOOLEAN);
    $add_clearing = filter_var($add_clearing, FILTER_VALIDATE_BOOLEAN);
    $addClearing = filter_var($addClearing, FILTER_VALIDATE_BOOLEAN);
    $searchable = filter_var($searchable, FILTER_VALIDATE_BOOLEAN);
    $required = filter_var($required, FILTER_VALIDATE_BOOLEAN);
    $readonly = filter_var($readonly, FILTER_VALIDATE_BOOLEAN);
    $disabled = filter_var($disabled, FILTER_VALIDATE_BOOLEAN);

    if ($dataSerializeAs !== $data_serialize_as) $data_serialize_as = $dataSerializeAs;
    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($valueKey !== $value_key) $value_key = $valueKey;
    if ($labelKey !== $label_key) $label_key = $labelKey;
    if ($flagKey !== $flag_key) $flag_key = $flagKey;
    if ($imageKey !== $image_key) $image_key = $imageKey;
    if (!$add_clearing) $add_clearing = $addClearing;

    $input_name = preg_replace('/[\s-]/', '_', $name);
    $selected_value = ($selected_value != '') ? explode(',', str_replace(', ', ',', $selected_value)) : [];

    if ($data !== 'manual') {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;

        if(! isset($data[0][$label_key]) ) {
            die('<p style="color:red">
                &lt;x-bladewind.select /&gt;: ensure the value you set as label_key
                exists in your array data</p>');
        }

        if( !empty($flag_key) && !isset($data[0][$flag_key]) ) {
            die('<p style="color:red">
                &lt;x-bladewind.select /&gt;: ensure the value you set as flag_key exists in your array</p>');
        }
    }


@endphp
<style>
    .display-area::-webkit-scrollbar {
        display: none;
        width: 0 !important;
    }

    .display-area {
        scrollbar-width: none;
        -ms-overflow-style: none;
        scroll-behavior: smooth;
    }
</style>
<div class="relative bw-select bw-select-{{$input_name}} @if($add_clearing) mb-3 @endif"
     data-multiple="{{$multiple}}" data-type="{{ $data !== 'manual' ? 'dynamic' : 'manual'}}"
     @if($data == 'manual' && $selected_value != '') data-selected-value="{{implode(',',$selected_value)}}" @endif>
    <div class="flex justify-between text-sm items-center rounded-md bg-white text-slate-600 border-2 border-slate-300/50
        dark:text-slate-300 dark:border-slate-700 dark:bg-slate-800 py-3.5 pl-4 pr-2 clickable
        @if(!$disabled)focus:border-blue-400 cursor-pointer @else opacity-40 select-none cursor-not-allowed @endif"
         tabindex="0">
        <x-bladewind::icon name="chevron-left" class="!-ml-3 hidden scroll-left"/>
        <div class="text-left placeholder grow-0 text-blue-900/40 dark:text-slate-500">{{ $placeholder }}
            @if($required)
                <x-bladewind::icon name="star" class="!text-red-400 !w-2 !h-2 mt-[-2px]" type="solid"/>
            @endif
        </div>
        <div class="text-left grow display-area hidden whitespace-nowrap overflow-x-scroll p-0 m-0"></div>
        <div class="whitespace-nowrap inline-flex">
            <x-bladewind::icon name="chevron-right" class="scroll-right !-mr-1 hidden"/>
            <x-bladewind::icon name="x-circle" type="solid"
                               class="reset w-6 h-6 fill-slate-300 hover:fill-slate-500 text-white dark:!text-dark-200 hidden dark:!fill-dark-700 dark:hover:!fill-dark-900"/>
            <x-bladewind::icon name="chevron-up-down" class="opacity-40 !ml-2"/>
        </div>
    </div>
    <div class="w-full absolute z-30 rounded-br-lg rounded-bl-lg bg-white shadow-sm shadow-slate-400 border-2 
        border-blue-400 dark:text-slate-300 dark:border-slate-700 dark:bg-slate-800 border-t-0 -mt-1.5 
        hidden bw-select-items-container overflow-scroll max-h-64 animate__animated animate__fadeIn animate__faster">
        <div class="sticky top-0 min-w-full bg-slate-100 dark:bg-slate-700 py-1 pr-0 -pl-1 @if(!$searchable) hidden @endif">
            <x-bladewind::input
                    class="!border-0 !border-b !rounded-none focus:!border-slate-300 dark:focus:!border-slate-600 !w-full !text-sm bw_filter"
                    add_clearing="false"
                    placeholder="Type here..."
                    suffix="magnifying-glass"
                    suffix_is_icon="true"/>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-700 bw-select-items mt-0">
            @if($data !== 'manual')
                @foreach ($data as $item)
                    <x-bladewind::select-item
                            label="{{ $item[$label_key] }}"
                            value="{{ $item[$value_key] }}"
                            onselect="{{ $onselect }}"
                            flag="{{ $item[$flag_key] ?? '' }}"
                            image="{{ $item[$image_key] ?? '' }}"
                            selected="{{ (in_array($item[$value_key], $selected_value)) ? 'true' : 'false' }}"/>
                @endforeach
            @else
                {!! $slot !!}
            @endif
        </div>
    </div>
    <input type="hidden" name="{{ ($data_serialize_as !== '') ? $data_serialize_as : $input_name }}"
           class="bw-{{$input_name}} @if($required) required @endif"
           @if($required) data-parent="bw-select-{{$input_name}}" @endif />
</div>

<script>
    @php include_once('vendor/bladewind/js/select.js'); @endphp
    const bw_{{ $input_name }} = new BladewindSelect('{{ $input_name }}', '{{ $placeholder }}');
    @if(!$disabled && !$readonly) bw_{{ $input_name }}.activate(); @endif
</script>