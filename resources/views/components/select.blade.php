@props([
    // name to uniquely identity a select
    'name' => 'bw-select-'.uniqid(),

    // the default text to display when the select shows
    'placeholder' => config('bladewind.select.placeholder', 'Select One'),
    'search_placeholder' => config('bladewind.select.search_placeholder', 'Type here...'),
    'empty_placeholder' => config('bladewind.select.empty_placeholder', 'No options available'),
    'label' => config('bladewind.select.label', null),

    /**
     * Optional function to execute when a select item is selected.
     * By default, the value of a select item is written to an input field with the name dd_name.
     * Where name is the name you provided for the select. If you named your select <countries> for example,
     * whatever country is selected can be found in the <input type="hidden" clas="input-countries" name="dd_countries" />
     */
    'onselect' => '',

    /**
    * Data to pass to the select.
    * Your data must be a json string (not object) with the keys <value> and <label>
    * <value> is whatever value will be passed to your code when an item is selected
    * <label> is what will be displayed to the user
    * If you want to display icons for each item your json can contain the optional 'icon' key.
    * Where icons are required, they must be in the semantic UI icon format
    * [{"label":"Burkina Faso","icon":"bf flag","value":"+226"},{"label":"Ghana","icon":"gh flag","value":"+233"},{"label":"Ivory Coast","icon":"ivc flag","value":"+228"}]
 * */
    'data' => [],

    /**
     * What key in your data array should be used to populate 'value' of the select when an item is selected
     * By default, a key of 'value' is used. If your data is something like
     *  [ {"id": 1,"name": "Burkina Faso"} ], your value_key will be 'id'
    */
    'value_key' => 'value',
    'valueKey' => 'value',

    /**
     * What key in your data array should be used to display the labels the user will see as select items
     * The default key used for labels is 'label'. If your data is something like
     * [ {"id": 1,"name": "Burkina Faso"} ] your label_key will be 'name'
    */
    'label_key' => 'label',
    'labelKey' => 'label',

    /**
     * What key in your data array should be used to display flag icons next to the labels
     * [ {"id": 1, "name": "Burkina Faso", "flag": "/assets/images/bf-flag.png"} ] your flag_key will be 'flag'
     */
    'flag_key' => null,
    'flagKey' => null,

    /**
     * What key in your data array should be used to display images next to the labels
     * The default key used for images is '', meaning images will be ignored. If your data is something like
     * [ {"id":"1","name":"Burkina Faso", "image":"/assets/images/bf-flag.png"}] your image_key will be 'image'
    */
    'image_key' => null,
    'imageKey' => null,

    /**
     * There are instances when you want the name passed during form submission to be
     * different from the name you gave the component. Example. you may name the select as country but
     * want the data to be submitted as country_id.
    */
    'data_serialize_as' => '',
    'dataSerializeAs' => '',

    // enforces validation if set to true
    'required' => 'false',

    'disabled' => 'false',

    'readonly' => 'false',

    'multiple' => 'false',

    // adds margin after the input box
    'add_clearing' => config('bladewind.select.add_clearing', true),
    'addClearing' => config('bladewind.select.add_clearing', true),

    /**
     * Determines if a value passed in the data array should automatically be selected
     * Helpful when using the component in edit mode or as part of filter options
     * The value you specify should exist in your value_key. If your value_key is 'id', you
     * cannot set a selected_value of 'Burkina Faso'
    */
    'selected_value' => '',
    'selectedValue' => '',

    // setting this to true adds a search box above the select items
    // this can be used to filter the contents of the select items
    'searchable' => false,

    // specify the maximum number of items that can be selected
    'max_selectable' => -1,
    'maxSelectable' => -1,

    // error message to display when max_selectable is exceeded
    'max_error_message' => config('bladewind.select.max_error_message', 'Please select only %s items'),
    'maxErrorMessage' => config('bladewind.select.max_error_message', 'Please select only %s items'),

    'filter' => '',

    'filter_by' => '',

    // append type="module" to script tags
    'modular' => config('bladewind.select.modular', false),

    'size' => config('bladewind.select.size', 'medium'),

    'empty_state' => 'false',
    'empty_state_message' => config('bladewind.select.empty_placeholder', 'No options available'),
    'empty_state_button_label' => 'Add',
    'empty_state_onclick' => '',
    'empty_state_show_image' => 'true',
    'empty_state_image' => config('bladewind.empty_state.image', '/vendor/bladewind/images/empty-state.svg'),
    'meta' => null,

])
@php
    $add_clearing = parseBladewindVariable($add_clearing);
    $addClearing = parseBladewindVariable($addClearing);
    $searchable = parseBladewindVariable($searchable);
    $required = parseBladewindVariable($required);
    $readonly = parseBladewindVariable($readonly);
    $disabled = parseBladewindVariable($disabled);
    $empty_state = parseBladewindVariable($empty_state);
    $max_selectable = (int) $max_selectable;
    $maxSelectable = (int) $maxSelectable;

    if ($dataSerializeAs !== $data_serialize_as) $data_serialize_as = $dataSerializeAs;
    if ($selectedValue !== $selected_value) $selected_value = $selectedValue;
    if ($valueKey !== $value_key) $value_key = $valueKey;
    if ($labelKey !== $label_key) $label_key = $labelKey;
    if ($flagKey !== $flag_key) $flag_key = $flagKey;
    if ($imageKey !== $image_key) $image_key = $imageKey;
    if (!$add_clearing) $add_clearing = $addClearing;
    if ($maxSelectable !== $max_selectable) $max_selectable = $maxSelectable;
    $max_error_message = ($maxErrorMessage != $max_error_message) ? addslashes($maxErrorMessage) : addslashes($max_error_message);
    if($max_error_message == '') $max_error_message = 'Please select only %s items';

    $input_name = preg_replace('/[\s-]/', '_', $name);
    $filter = preg_replace('/[\s-]/', '_', $filter);
    $selected_value = ($selected_value != '') ? explode(',', str_replace(', ', ',', $selected_value)) : [];

    if ($data !== 'manual') {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;
        // if $data is empty there is no point to show the search bar even if user asked for it
        if($searchable && empty($data)) {
            $searchable = false;
        }
    }

    $size = (!in_array($size, ['small','medium', 'regular', 'big'])) ? 'medium' : $size;
    $sizes = [ 'small' => 'py-[6px]', 'medium' => 'py-[10px]', 'regular' => 'py-[6.5px]', 'big' => 'py-[18.5px]' ];
@endphp
<style xmlns:x-bladewind="http://www.w3.org/1999/html">
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
     role="combobox"
     data-multiple="{{$multiple}}" data-required="{{$required?'true':'false'}}"
     data-type="{{ $data !== 'manual' ? 'dynamic' : 'manual'}}"
     @if(!empty($filter)) data-filter="{{ $filter}}" @endif
     @if(!empty($meta)) data-meta-data="{{ $meta}}" @endif
     @if($data == 'manual' && $selected_value != '') data-selected-value="{{implode(',',$selected_value)}}" @endif>
    <div tabindex="0"
         class="flex justify-between text-sm items-center rounded-md bg-white text-slate-600 border-2 border-slate-300/50 hover:border-slate-300
         dark:text-dark-300 dark:border-dark-600 dark:hover:border-dark-500/50 dark:bg-transparent {{$sizes[$size]}} pl-4 pr-2 clickable
         @if($disabled) disabled @elseif($readonly) readonly @else enabled @endif">
        <x-bladewind::icon name="chevron-left" class="!-ml-3 hidden scroll-left"/>
        <div class="text-left placeholder grow-0 text-blue-900/40 dark:text-slate-500">
            @if(!empty($label))
                <span class="form-label !top-4">{{$label}}
                    @if($required)
                        <x-bladewind::icon name="star" class="!text-red-400 !w-2 !h-2 mt-[-2px]" type="solid"/>
                    @endif</span>
            @else
                {{ $placeholder }}
                @if($required)
                    <x-bladewind::icon name="star" class="!text-red-400 !w-2 !h-2 mt-[-2px]" type="solid"/>
                @endif
            @endif
        </div>
        <div class="text-left grow display-area hidden whitespace-nowrap overflow-x-scroll p-0 m-0"></div>
        <div class="whitespace-nowrap inline-flex">
            <x-bladewind::icon name="chevron-right" class="scroll-right !-mr-2 !mt-0.5 !w-5 !h-5 hidden"/>
            <x-bladewind::icon
                    name="x-circle" type="solid"
                    class="hidden reset size-6 text-white fill-gray-400/70 hover:fill-gray-400 dark:fill-white/40 dark:hover:fill-white/60"/>
            <x-bladewind::icon name="chevron-up-down" class="opacity-40 opener !ml-2"/>
        </div>
    </div>
    <div class="w-full absolute z-30 rounded-br-lg rounded-bl-lg bg-white shadow-sm shadow-slate-400 dark:shadow-none border-2
        border-blue-400 dark:text-slate-300 dark:border-dark-600 dark:bg-dark-700 border-t-0 -mt-1.5
        hidden bw-select-items-container overflow-scroll max-h-64 animate__animated animate__fadeIn animate__faster">
        <div class="sticky top-0 min-w-full bg-slate-100 dark:bg-transparent py-1 pr-0 -pl-1 @if(!$searchable) hidden @endif">
            <x-bladewind::input
                    class="!border-0 !border-b !rounded-none focus:!border-slate-300 dark:focus:!border-slate-600 !w-full !text-sm bw_search"
                    add_clearing="false"
                    :placeholder="$search_placeholder"
                    suffix="magnifying-glass"
                    suffixIsIcon="true"/>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-600/70 bw-select-items mt-0">
            @if($data !== 'manual')
                @forelse ($data as $item)
                    <x-bladewind::select-item
                            label="{{ $item[$label_key] }}"
                            value="{{ $item[$value_key] }}"
                            filter_by="{{ ($filter_by != '') ? $item[$filter_by] : '' }}"
                            onselect="{{ $onselect }}"
                            flag="{{ $item[$flag_key] ?? '' }}"
                            image="{{ $item[$image_key] ?? '' }}"
                            selected="{{ (in_array($item[$value_key], $selected_value)) ? 'true' : 'false' }}"/>
                @empty
                    @if($empty_state)
                        <x-bladewind::select-item
                                :selectable="false"
                                :empty_state="true"
                                :empty_state_message="$empty_state_message"
                                :empty_state_show_image="$empty_state_show_image"
                                :empty_state_button_label="$empty_state_button_label"
                                empty_state_onclick="{!! $empty_state_onclick !!}"
                                :empty_state_image="$empty_state_image"/>
                    @else
                        <x-bladewind::select-item
                                :selectable="false"
                                :label="$empty_placeholder"
                        />
                    @endif
                @endforelse
            @else
                {!! $slot !!}
            @endif
        </div>
    </div>
    <input type="hidden" name="{{ ($data_serialize_as !== '') ? $data_serialize_as : $input_name }}"
           class="bw-{{$input_name}} @if($required) required @endif"
           @if($required) data-parent="bw-select-{{$input_name}}" @endif
           @if($multiple) autocomplete="off" @endif />
</div>

<script>
    @php include_once(public_path('vendor/bladewind/js/select.js')); @endphp
</script>
<script @if($modular) type="module" @endif>
    const bw_{{ $input_name }} = new BladewindSelect('{{ $input_name }}', '{{ $placeholder }}');
    bw_{{ $input_name }}.activate({disabled: '{{$disabled}}', readonly: '{{$readonly}}'});
    @if(!$disabled && !$readonly)
    bw_{{ $input_name }}.maxSelectable({{$max_selectable}}, '{{ sprintf($max_error_message, $max_selectable) }}');
    @endif
    @if(!empty($filter))
    bw_{{ $input_name }}.filter('{{ $filter }}');
    @endif
    @if(!$required && $multiple == 'false') bw_{{ $input_name }}.clearable();
    @endif
</script>