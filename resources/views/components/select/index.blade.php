{{-- format-ignore-start --}}
@props([
    // name to uniquely identity a select
    'name' => defaultBladewindName('bw-select-'),

    // the default text to display when the select shows
    'placeholder' => config('bladewind.select.placeholder', __("bladewind::bladewind.select_placeholder")),
    'searchPlaceholder' => config('bladewind.select.search_placeholder', __("bladewind::bladewind.select_search_placeholder")),
    'emptyPlaceholder' => config('bladewind.select.empty_placeholder', __("bladewind::bladewind.select_empty_placeholder")),
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
     *  [ {"id": 1,"name": "Burkina Faso"} ], your valueKey will be 'id'
    */
    'valueKey' => 'value',

    /**
     * What key in your data array should be used to display the labels the user will see as select items
     * The default key used for labels is 'label'. If your data is something like
     * [ {"id": 1,"name": "Burkina Faso"} ] your labelKey will be 'name'
    */
    'labelKey' => 'label',

    /**
     * What key in your data array should be used to display flag icons next to the labels
     * [ {"id": 1, "name": "Burkina Faso", "flag": "/assets/images/bf-flag.png"} ] your flagKey will be 'flag'
     */
    'flagKey' => null,

    /**
     * What key in your data array should be used to display images next to the labels
     * The default key used for images is '', meaning images will be ignored. If your data is something like
     * [ {"id":"1","name":"Burkina Faso", "image":"/assets/images/bf-flag.png"}] your imageKey will be 'image'
    */
    'imageKey' => null,

    /**
     * There are instances when you want the name passed during form submission to be
     * different from the name you gave the component. Example. you may name the select as country but
     * want the data to be submitted as country_id.
    */
    'dataSerializeAs' => '',

    // enforces validation if set to true
    'required' => 'false',

    'disabled' => 'false',

    'readonly' => 'false',

    'multiple' => 'false',

    // adds margin after the input box
    'addClearing' => config('bladewind.select.add_clearing', true),

    /**
     * Determines if a value passed in the data array should automatically be selected
     * Helpful when using the component in edit mode or as part of filter options
     * The value you specify should exist in your valueKey. If your valueKey is 'id', you
     * cannot set a selectedValue of 'Burkina Faso'
    */
    'selectedValue' => '',

    // setting this to true adds a search box above the select items
    // this can be used to filter the contents of the select items
    'searchable' => false,

    // specify the maximum number of items that can be selected
    'maxSelectable' => -1,

    // error message to display when maxSelectable is exceeded
    'maxErrorMessage' => config('bladewind.select.max_error_message', __("bladewind::bladewind.select_max_selection")),

    'filter' => '',

    'filterBy' => '',

    // append type="module" to script tags
    'modular' => config('bladewind.select.modular', false),

    'size' => config('bladewind.select.size', 'regular'),

    'emptyState' => 'false',
    'emptyStateMessage' => config('bladewind.select.empty_placeholder', __("bladewind::bladewind.select_empty_placeholder")),
    'emptyStateButtonLabel' => __("bladewind::bladewind.select_empty_state_button_label"),
    'emptyStateOnclick' => '',
    'emptyStateShowImage' => 'true',
    'emptyStateImage' => config('bladewind.empty_state.image', '/vendor/bladewind/images/empty-state.svg'),
    'meta' => null,
    'nonce' => config('bladewind.script.nonce', null),

])
@php
    $name = parseBladewindName($name);
    $addClearing = parseBladewindVariable($addClearing);
    $searchable = parseBladewindVariable($searchable);
    $required = parseBladewindVariable($required);
    $readonly = parseBladewindVariable($readonly);
    $disabled = parseBladewindVariable($disabled);
    $emptyState = parseBladewindVariable($emptyState);
    $maxSelectable = (int) $maxSelectable;

    $maxErrorMessage = addslashes($maxErrorMessage);
    if($maxErrorMessage == '') $maxErrorMessage = __("bladewind::bladewind.select_max_selection");

    $input_name = $name;
    $filter = parseBladewindName($filter);
    $selectedValue = ($selectedValue != '') ? explode(',', str_replace(', ', ',', $selectedValue)) : [];

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
{{-- format-ignore-end --}}

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
<div class="relative bw-select bw-select-{{$input_name}} @if($addClearing) mb-3 @endif"
     role="combobox"
     data-multiple="{{$multiple}}" data-required="{{$required?'true':'false'}}"
     data-type="{{ $data !== 'manual' ? 'dynamic' : 'manual'}}"
     @if(!empty($filter)) data-filter="{{ $filter}}" @endif
     @if(!empty($meta)) data-meta-data="{{ $meta}}" @endif
     @if($data == 'manual' && $selectedValue != '') data-selected-value="{{implode(',',$selectedValue)}}" @endif>
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
        border-primary-600 dark:text-slate-300 dark:border-dark-600 dark:bg-dark-700 border-t-0 -mt-1.5
        hidden bw-select-items-container overflow-scroll max-h-64 animate__animated animate__fadeIn animate__faster">
        <div class="sticky top-0 min-w-full bg-slate-100 dark:bg-transparent py-1 pr-0 -pl-1 bw-search-wrapper @if(!$searchable) hidden @endif">
            <x-bladewind::input
                    class="!border-0 !border-b !rounded-none focus:!border-slate-300 dark:focus:!border-slate-600 !w-full !text-sm bw_search"
                    add_clearing="false"
                    :placeholder="$searchPlaceholder"
                    onFocus="changeCss('.bw-select-{{$input_name}} div.clickable.enabled', 'border-primary-600'); changeCss('.bw-select-{{$input_name}} div.clickable.enabled', 'hover:border-slate-300', 'remove')"
                    onBlur="changeCss('.bw-select-{{$input_name}} div.clickable.enabled', 'border-primary-600', 'remove');  changeCss('.bw-select-{{$input_name}} div.clickable.enabled', 'hover:border-slate-300')"
                    suffix="magnifying-glass"
                    suffixIsIcon="true"/>
        </div>
        <div class="divide-y divide-slate-100 dark:divide-slate-600/70 bw-select-items mt-0">
            @if($data !== 'manual')
                @forelse ($data as $item)
                    <x-bladewind::select.item
                            label="{{ $item[$labelKey] }}"
                            value="{{ $item[$valueKey] }}"
                            filter_by="{{ ($filterBy != '') ? $item[$filterBy] : '' }}"
                            onselect="{{ $onselect }}"
                            flag="{{ $item[$flagKey] ?? '' }}"
                            image="{{ $item[$imageKey] ?? '' }}"
                            selected="{{ (in_array($item[$valueKey], $selectedValue)) ? 'true' : 'false' }}"/>
                @empty
                    @if($emptyState)
                        <x-bladewind::select.item
                                :selectable="false"
                                :empty_state="true"
                                :empty_state_message="$emptyStateMessage"
                                :empty_state_show_image="$emptyStateShowImage"
                                :empty_state_button_label="$emptyStateButtonLabel"
                                empty_state_onclick="{!! $emptyStateOnclick !!}"
                                :empty_state_image="$emptyStateImage" />
                    @else
                        <x-bladewind::select.item
                                :selectable="false"
                                :label="$emptyPlaceholder"
                        />
                    @endif
                @endforelse
                @if($emptyState)
                    <x-bladewind::select.item
                            :selectable="false"
                            :empty_state="true"
                            :empty_state_message="$emptyStateMessage"
                            :empty_state_show_image="$emptyStateShowImage"
                            :empty_state_button_label="$emptyStateButtonLabel"
                            empty_state_onclick="{!! $emptyStateOnclick !!}"
                            :empty_state_image="$emptyStateImage"
                            :visible="false"
                            data-empty-state="true" />
                @else
                    <x-bladewind::select.item
                        :selectable="false"
                        :label="$emptyPlaceholder"
                        :visible="false" 
                        data-empty-state="true" />
                @endif
            @else
                {!! $slot !!}
            @endif
        </div>
    </div>
    <input type="hidden" name="{{ ($dataSerializeAs !== '') ? $dataSerializeAs : $input_name }}"
           class="bw-{{$input_name}} @if($required) required @endif"
           @if($required) data-parent="bw-select-{{$input_name}}" @endif
           @if($multiple) autocomplete="off" @endif />
</div>

<x-bladewind::script :nonce="$nonce">
    @php include_once(public_path('vendor/bladewind/js/select.js')); @endphp
</x-bladewind::script>
<x-bladewind::script :nonce="$nonce" :modular="$modular">
    const bw_{{ $input_name }} = new BladewindSelect('{{ $input_name }}', '{{ $placeholder }}');
    bw_{{ $input_name }}.activate({disabled: '{{$disabled}}', readonly: '{{$readonly}}'});
    @if(!$disabled && !$readonly)
        bw_{{ $input_name }}.maxSelectable({{$maxSelectable}}, '{{ sprintf($maxErrorMessage, $maxSelectable) }}');
    @endif
    @if(!empty($filter))
        bw_{{ $input_name }}.filter('{{ $filter }}');
    @endif
    @if(!$required && $multiple == 'false')
        bw_{{ $input_name }}.clearable();
    @endif
</x-bladewind::script>