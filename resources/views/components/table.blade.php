@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => false,
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => false,
    'hasShadow' => false,
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
    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
    $exclude_columns = !empty($exclude_columns) ? explode(',', str_replace(' ','', $exclude_columns)) : [];
    $action_icons = (!empty($action_icons)) ? ((is_array($action_icons)) ?
        $action_icons : json_decode(str_replace('&quot;', '"', $action_icons), true)) : [];
    $column_aliases = (!empty($column_aliases)) ? ((is_array($column_aliases)) ?
        $column_aliases : json_decode(str_replace('&quot;', '"', $column_aliases), true)) : [];
    $icons_array = [];

    if (!empty($data)) {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;
        $total_records = count($data);
        $table_headings = ($total_records > 1) ? array_keys((array) $data[0]) : [];

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
            $temp = [];
            foreach($action_array as $array){
                $hmm = explode(':', $array);
                $temp[trim($hmm[0])] = trim($hmm[1]);
            }
            $icons_array[] = $temp;
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
<div class="z-20"> {{--max-w-screen overflow-x-hidden md:w-full--}}
    <div class="w-full">
        @if($searchable)
            <div class="bw-table-filter-bar bg-slate-100 p-2">
                <x-bladewind::input name="bw-search-{{$name}}" placeholder="{{$search_placeholder}}"
                                    onkeyup="filterTable(this.value, 'table.{{$name}}')"
                                    prefix_is_icon="true" add_clearing="false" class="!mb-0 focus:!border-slate-300"
                                    prefix="magnifying-glass"/>
            </div>
        @endif
        <table class="bw-table w-full {{$name}} @if($has_shadow) shadow-2xl shadow-gray-200 dark:shadow-xl dark:shadow-slate-900 @endif
            @if($divided) divided @if($divider=='thin') thin @endif @endif  @if($striped) striped @endif
            @if($hover_effect) with-hover-effect @endif @if($compact) compact @endif">
            @if(empty($data))
                <thead>
                <tr class="bg-gray-200 dark:bg-slate-800">{{ $header }}</tr>
                </thead>
                <tbody>{{ $slot }}</tbody>
            @else
                @if($total_records > 0)
                    <thead>
                    <tr class="bg-gray-200 dark:bg-slate-800">
                        @foreach($table_headings as $heading)
                            <th>{{ str_replace('_',' ', $column_aliases[$heading] ?? $heading ) }}</th>
                        @endforeach
                        @if( !empty($action_icons))
                            <th class="!text-right">{{$actions_title}}</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $row)
                        <tr>
                            @foreach($table_headings as $heading)
                                <td>{!! $row[$heading] !!}</td>
                            @endforeach
                            @if( !empty($icons_array) )
                                <td class="text-right space-x-2 actions">
                                    @foreach($icons_array as $icon)
                                        @if(isset($icon['icon']))
                                            <x-bladewind::button.circle
                                                    size="tiny"
                                                    icon="{{ $icon['icon'] }}"
                                                    color="{{ $icon['color'] ?? '' }}"
                                                    tooltip="{{$icon['tip']??''}}"
                                                    onclick="{!! build_click($icon['click'], $row) ?? 'void(0)' !!}"
                                                    type="{!! isset($icon['color']) ? 'primary' : 'secondary' !!}"/>
                                        @endif
                                    @endforeach
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <tr>
                        <td>nothing to display</td>
                    </tr>
                @endif
            @endif
        </table>
    </div>
</div>