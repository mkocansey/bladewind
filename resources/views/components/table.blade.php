@props([
    // your table headers in <th></th> tags
    'header' => '',
    // setting to true will result in a striped table
    'striped' => config('bladewind.table.striped', false),
    // should the table with displayed with a drop-shadow effect
    'has_shadow' => config('bladewind.table.has_shadow', false),
    'hasShadow' => config('bladewind.table.has_shadow', false),
    // should the table have a border on all four sides
    'has_border' => config('bladewind.table.has_border', false),
    // should the table have row dividers
    'divided' => config('bladewind.table.divided', true),
    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => config('bladewind.table.divider', 'regular'),
    // should rows light up on hover
    'hover_effect' => config('bladewind.table.hover_effect', true),
    'hoverEffect' => config('bladewind.table.hover_effect', true),
    // should the rows be tighter together
    'compact' => config('bladewind.table.compact', false),
    // provide a table name you can access via css
    'name' => 'tbl-'.uniqid(),
    'data' => null,
    'exclude_columns' => null,
    'include_columns' => null,
    'action_icons' => null,
    'groupby' => null,
    'actions_title' => 'actions',
    'column_aliases' => [],
    'searchable' => config('bladewind.table.searchable', false),
    'search_placeholder' => config('bladewind.table.search_placeholder', 'Search table below...'),
    'celled' => config('bladewind.table.celled', false),
    'uppercasing' => config('bladewind.table.uppercasing', true),
    'no_data_message' => config('bladewind.table.no_data_message', 'No records to display'),
    'message_as_empty_state' => config('bladewind.table.message_as_empty_state', false),
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'button_label' => '',
    'show_image' => config('bladewind.table.show_image', true),
    'onclick' => '',
    //------------------ end empty state parameters -------------------
    'selectable' => config('bladewind.table.selectable', false),
    'checkable' => config('bladewind.table.checkable', false),
    'transparent' => config('bladewind.table.transparent', false),
    'selected_value' => null,
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
    $celled = filter_var($celled, FILTER_VALIDATE_BOOLEAN);
    $selectable = filter_var($selectable, FILTER_VALIDATE_BOOLEAN);
    $checkable = filter_var($checkable, FILTER_VALIDATE_BOOLEAN);
    $transparent = filter_var($transparent, FILTER_VALIDATE_BOOLEAN);
    $message_as_empty_state = filter_var($message_as_empty_state, FILTER_VALIDATE_BOOLEAN);
    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
    $exclude_columns = !empty($exclude_columns) ? explode(',', str_replace(' ','', $exclude_columns)) : [];
    $action_icons = (!empty($action_icons)) ? ((is_array($action_icons)) ?
        $action_icons : json_decode(str_replace('&quot;', '"', $action_icons), true)) : [];
    $column_aliases = (!empty($column_aliases)) ? ((is_array($column_aliases)) ?
        $column_aliases : json_decode(str_replace('&quot;', '"', $column_aliases), true)) : [];
    $icons_array = [];
    $can_group = false;

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

        if(!empty($groupby) && in_array($groupby, $table_headings)) {
            $can_group = true;
            $unique_group_headings = array_unique(array_column($data, $groupby));
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
<div class="@if($has_border && !$celled) border border-gray-200/70 dark:border-dark-700/60 @endif border-collapse max-w-full">
    <div class="w-full">
        @if($searchable)
            <div class="bw-table-filter-bar">
                <x-bladewind::input
                        name="bw-search-{{$name}}"
                        placeholder="{{$search_placeholder}}"
                        onkeyup="filterTable(this.value, 'table.{{$name}}')"
                        add_clearing="false"
                        class="!mb-0 focus:!border-slate-300 !pl-9 !py-3"
                        clearable="true"
                        prefix_is_icon="true"
                        prefix="magnifying-glass"/>
            </div>
        @endif

        <table class="bw-table w-full {{$name}} @if($has_shadow) drop-shadow shadow shadow-gray-200/70 dark:shadow-md dark:shadow-dark-950/20 @endif
            @if($divided) divided @if($divider=='thin') thin @endif @endif  @if($striped) striped @endif  @if($celled) celled @endif
            @if($hover_effect) with-hover-effect @endif @if($compact) compact @endif @if($uppercasing) uppercase-headers @endif
            @if($selectable) selectable @endif @if($checkable) checkable @endif @if($transparent) transparent @endif">
            @if(is_null($data))
                @if(!empty($header))
                    <thead>
                    <tr>{{ $header }}</tr>
                    </thead>
                @endif
                <tbody>{{ $slot }}</tbody>
            @else
                <thead>
                <tr>
                    @php
                        // if there are no records, build the headings with $column_headings if the array exists
                        $table_headings = ($total_records>0) ? $table_headings : (($column_aliases) ?? []);
                        // when grouping rows, remove the heading for the column being grouped by
                        if($can_group) {
                            unset($table_headings[array_search($groupby, $table_headings)]);
                        }
                    @endphp
                    @foreach($table_headings as $th)
                        <th>{{ str_replace('_', ' ', $column_aliases[$th] ?? $th ) }}</th>
                    @endforeach
                    @if( !empty($action_icons))
                        <th class="!text-right">{{$actions_title}}</th>
                    @endif
                </tr>
                </thead>
                @if($total_records > 0)
                    <tbody>
                    @if($can_group)
                        @foreach($unique_group_headings as $group_heading)
                            <tr>
                                <td class="group-heading" colspan="{{count($table_headings)}}">{{ $group_heading }}</td>
                            </tr>
                            @php
                                $grouped_data = array_filter($data, function ($item) use ($group_heading, $groupby) {
                                    return $item[$groupby] === $group_heading;
                                });
                            @endphp
                            @foreach($grouped_data as $row)
                                <tr data-id="{{ $row['id'] ?? uniqid() }}">
                                    @foreach($table_headings as $th)
                                        @if($th !== $groupby)
                                            <td>{!! $row[$th] !!}</td>
                                        @endif
                                    @endforeach
                                    <x-bladewind::table-icons :icons_array="$icons_array" :row="$row"/>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        @foreach($data as $row)
                            <tr data-id="{{ $row['id'] ?? uniqid() }}">
                                @foreach($table_headings as $th)
                                    <td>{!! $row[$th] !!}</td>
                                @endforeach
                                <x-bladewind::table-icons :icons_array="$icons_array" :row="$row"/>
                            </tr>
                        @endforeach
                    @endif
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
@if($selectable)
    @once
        <script>
            const addRemoveRowValue = (value, name) => {
                const input = domEl(`input[type="hidden"][name="${name}"]`);
                const table = domEl(`.bw-table.${name}.selectable`);
                const checkAllBox = table.querySelector('th:first-child input[type="checkbox"]');
                const partiallyCheckedBox = table.querySelector('th:first-child .check-icon');
                const totalRows = table.getAttribute('data-total-rows') * 1;
                let totalChecked = table.getAttribute('data-total-checked') * 1;
                if (value) {
                    if (input.value.includes(value)) { // remove
                        const keyword = `(,?)${value}`;
                        input.value = input.value.replace(input.value.match(keyword)[0], '');
                        totalChecked--;
                    } else { // add
                        input.value += `,${value}`;
                        totalChecked++;
                    }
                    table.setAttribute('data-total-checked', `${totalChecked}`);
                    if (totalChecked > 0 && totalChecked < totalRows) {
                        hide(checkAllBox, true);
                        unhide(partiallyCheckedBox, true);
                        if (!partiallyCheckedBox.getAttribute('onclick')) {
                            partiallyCheckedBox.setAttribute('onclick', `checkAllFromPartiallyChecked('${name}')`);
                        }
                    } else {
                        unhide(checkAllBox, true);
                        hide(partiallyCheckedBox, true);
                        checkAllBox.checked = (totalChecked === totalRows);
                    }
                    stripComma(input);
                }
            }

            const checkAllFromPartiallyChecked = (name) => {
                const table = domEl(`.bw-table.${name}.selectable`);
                const checkAllBox = table.querySelector('th:first-child input[type="checkbox"]')
                checkAllBox.checked = true;
                toggleAll(checkAllBox, `.bw-table.${name}`);
            }
        </script>
    @endonce
    <script>
        dom_els('.bw-table.{{$name}}.selectable tr').forEach((el) => {
            el.addEventListener('click', (e) => {
                el.classList.toggle('selected');
                let id = el.getAttribute('data-id');
                let checkbox = el.querySelector('td:first-child input[type="checkbox"]');
                if (checkbox) checkbox.checked = el.classList.contains('selected');
                addRemoveRowValue(id, '{{$name}}');
            });
        });
    </script>
    <input type="hidden" name="{{$name}}" class="{{$name}}"/>
@endif

@if($checkable)
    @once
        <div class="hidden size-0 checkbox-template">
            <x-bladewind::checkbox class="!size-5 !mr-0 rounded-md" label_css="mr-0" add_clearing="false"/>
        </div>
        <div class="hidden size-0 partial-check-template">
            <x-bladewind::icon name="minus" type="solid"
                               class="hidden stroke-2 rounded-md bg-primary-500 text-white check-icon !size-5 !mb-1 !mt-[4px] !-ml-1"/>
        </div>
        <script>
            const addCheckboxesToTable = (el) => {
                let table = domEl(el);
                let checkboxHtml = domEl('.checkbox-template').innerHTML;
                let partialCheckHtml = domEl('.partial-check-template').innerHTML;

                for (let row of table.rows) {
                    let cellTag = (row.parentElement.tagName.toLowerCase() === 'thead') ? 'th' : 'td';
                    let checkboxCell = document.createElement(cellTag);
                    checkboxCell.innerHTML = (cellTag === 'th') ?
                        checkboxHtml.replace('type="checkbox"', `type="checkbox" onclick="toggleAll(this,'${el}')"`) + partialCheckHtml :
                        checkboxHtml;
                    checkboxCell.setAttribute('class', '!size-0 !pr-0');
                    row.insertBefore(checkboxCell, row.firstChild);
                }
                table.setAttribute('data-total-rows', (table.rows.length - 1)); // minus heading
                table.setAttribute('data-total-checked', 0);
            }

            const toggleAll = (srcEl, table) => {
                dom_els(`${table}.selectable tr`).forEach((el) => {
                    const checkbox = el.querySelector('td:first-child input[type="checkbox"]');
                    if (checkbox) {
                        // to properly take advantage of the logic for adding and removing IDs
                        // already defined in addRemoveRowValue(), simply simulate a click of the checkbox
                        if (srcEl.checked && !checkbox.checked || (!srcEl.checked && checkbox.checked)) el.click();
                    }
                });
            }

            const checkSelected = (table, selectedValue) => {
                let selectedValues = selectedValue.split(',');
                dom_els(`${table}.selectable tr`).forEach((el) => {
                    const thisValue = el.getAttribute('data-id');
                    if (selectedValues.includes(thisValue)) {
                        el.click();
                    }
                });
            }

        </script>
    @endonce
    <script>
        addCheckboxesToTable('.bw-table.{{$name}}');
        // select rows in selected_value
        @if(!empty($selected_value)) checkSelected('.bw-table.{{$name}}', '{{$selected_value}}') @endif
    </script>
@endif