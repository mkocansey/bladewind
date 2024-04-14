@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => false,
    'hasShadow' => false,
    // should the table have a border on all four sides
    'has_border' => false,
    // should the table have row dividers
    'divided' => true,
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => 'regular',
    // should rows light up on hover
    'hover_effect' => true,
    'hoverEffect' => true,
    // should the rows be tighter together
    'compact' => false,
    // provide a table name you can access via css
    'name' => 'tbl-'.uniqid(),
    'data' => null,
    'exclude_columns' => null,
    'include_columns' => null,
    'action_icons' => null,
    'actions_title' => 'actions',
    'column_aliases' => [],
    'searchable' => false,
    'search_placeholder' => 'Search table below...',
    'uppercasing' => true,
    'no_data_message' => 'No records to display',
    'message_as_empty_state' => false,
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'button_label' => '',
    'show_image' => true,
    'onclick' => '',
    //------------------ end empty state parameters -------------------
])
@php
    // reset variables for Laravel 8 support
    $has_shadow = filter_var($has_shadow, FILTER_VALIDATE_BOOLEAN);
    $hasShadow = filter_var($hasShadow, FILTER_VALIDATE_BOOLEAN);
    $hover_effect = filter_var($hover_effect, FILTER_VALIDATE_BOOLEAN);
    $hoverEffect = filter_var($hoverEffect, FILTER_VALIDATE_BOOLEAN);
    $striped = filter_var($striped, FILTER_VALIDATE_BOOLEAN);
    $compact = filter_var($compact, FILTER_VALIDATE_BOOLEAN);
    $divided = filter_var($divided, FILTER_VALIDATE_BOOLEAN);
    $searchable = filter_var($searchable, FILTER_VALIDATE_BOOLEAN);
    $uppercasing = filter_var($uppercasing, FILTER_VALIDATE_BOOLEAN);
    $message_as_empty_state = filter_var($message_as_empty_state, FILTER_VALIDATE_BOOLEAN);
    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
    $exclude_columns = !empty($exclude_columns) ? explode(',', str_replace(' ','', $exclude_columns)) : [];
    $action_icons = (!empty($action_icons)) ? ((is_array($action_icons)) ?
        $action_icons : json_decode(str_replace('&quot;', '"', $action_icons), true)) : [];
    $column_aliases = (!empty($column_aliases)) ? ((is_array($column_aliases)) ?
        $column_aliases : json_decode(str_replace('&quot;', '"', $column_aliases), true)) : [];
    $icons_array = [];

    if (!is_null($data)) {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;
        $total_records = count($data);
        $table_headings = ($total_records > 0) ? array_keys((array) $data[0]) : [];

        if(!empty($exclude_columns)) {
            $table_headings = array_filter($table_headings,
            function($column) use ( $exclude_columns) {
                if(!in_array($column, $exclude_columns)) return $column;
            });
        }

        if( !empty($include_columns) ) {
            $table_headings = explode(',', str_replace(' ','', $include_columns));
        }

        // build action icons
        foreach ($action_icons as $action) {
            $action_array = explode('|',$action);
            $temp_actions_arr = [];
            foreach($action_array as $this_action){
                $action_str_to_arr = explode(':', $this_action);
                $temp_actions_arr[trim($action_str_to_arr[0])] = trim($action_str_to_arr[1]);
            }
            $icons_array[] = $temp_actions_arr;
        }

        if(!function_exists('build_click')){
            function build_click($click, $row_data){
                return preg_replace_callback('/{\w+}/', function ($matches) use ($row_data) {
                    foreach($matches as $match) {
                        return $row_data[str_replace('}', '', str_replace('{', '', $match))];
                    }
                }, $click);
            }
        }
    }
@endphp
<div class="@if($has_border) border border-gray-200/70 dark:border-dark-700/60 @endif border-collapse max-w-full">
    <div class="w-full">
        @if($searchable)
            <div class="bw-table-filter-bar">
                <x-bladewind::input
                        name="bw-search-{{$name}}"
                        placeholder="{{$search_placeholder}}"
                        onkeyup="filterTable(this.value, 'table.{{$name}}')"
                        add_clearing="false"
                        class="!mb-0 focus:!border-slate-300 !pl-11"
                        clearable="true"
                        prefix_is_icon="true"
                        prefix="magnifying-glass"/>
            </div>
        @endif

        <table class="bw-table w-full {{$name}} @if($has_shadow) drop-shadow shadow shadow-gray-200/70 dark:shadow-lg dark:shadow-dark-950/20 @endif
            @if($divided) divided @if($divider=='thin') thin @endif @endif  @if($striped) striped @endif
            @if($hover_effect) with-hover-effect @endif @if($compact) compact @endif @if($uppercasing) uppercase-headers @endif">
            @if(is_null($data))
                <thead>
                <tr class="bg-gray-200 dark:bg-dark-800">{{ $header }}</tr>
                </thead>
                <tbody>{{ $slot }}</tbody>
            @else

                <thead>
                <tr class="bg-gray-200 dark:bg-dark-800">
                    @php
                        // if there are no records, build the headings with $column_headings if the array exists
                        $table_headings = ($total_records>0) ? $table_headings : (($column_aliases) ?? []);
                    @endphp
                    @foreach($table_headings as $th)
                        <th>{{ str_replace('_',' ', $column_aliases[$th] ?? $th ) }}</th>
                    @endforeach
                    @if( !empty($action_icons))
                        <th class="!text-right">{{$actions_title}}</th>
                    @endif
                </tr>
                </thead>
                @if($total_records > 0)
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            @foreach($table_headings as $th)
                                <td>{!! $row[$th] !!}</td>
                            @endforeach
                            @if( !empty($icons_array) )
                                <td class="text-right space-x-2 actions">
                                    @foreach($icons_array as $icon)
                                        @if(isset($icon['icon']))
                                            @if(!empty($icon['tip']))
                                                <a data-tooltip="{{ $icon['tip'] }}" data-inverted=""
                                                   data-position="top center"> @endif
                                                    <x-bladewind::button.circle
                                                            size="tiny"
                                                            icon="{{ $icon['icon'] }}"
                                                            color="{{ $icon['color'] ?? '' }}"
                                                            {{--title="{{$icon['tip']??''}}"--}}
                                                            onclick="{!! build_click($icon['click'], $row) ?? 'void(0)' !!}"
                                                            type="{!! isset($icon['color']) ? 'primary' : 'secondary' !!}"/>
                                                    @if(!empty($icon['tip']))
                                                </a>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="{{count($table_headings)}}" class="text-center">
                                @if($message_as_empty_state)
                                    <x-bladewind::empty-state
                                            :message="$no_data_message"
                                            :button_label="$button_label"
                                            :onclick="$onclick"
                                            :image="$image"
                                            :show_image="$show_image"
                                            :heading="$heading"/>
                                @else
                                    {{ $no_data_message }}
                                @endif
                                <script>
                                    changeCss('.{{$name}}', 'with-hover-effect', 'remove');
                                    changeCss('.{{$name}}', 'has-no-data');
                                </script>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                @endif
        </table>
    </div>
</div>