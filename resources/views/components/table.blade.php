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
    'search_field' => null,
    'search_debounce' => 0,
    'search_min_length' => 0,
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
    'sortable' => config('bladewind.table.sortable', false),
    'sortable_columns' => [],
    'paginated' => config('bladewind.table.paginated', false),
    'pagination_style' => config('bladewind.table.pagination_style', 'arrows'),
    'page_size' => config('bladewind.table.page_size', 25),
    'show_row_numbers' => config('bladewind.table.show_row_numbers', false),
    'show_total' => config('bladewind.table.show_total', true),
    'show_page_number' => config('bladewind.table.show_page_number', true),
    'show_total_pages' => config('bladewind.table.show_total_pages', false),
    'default_page' => 1,
    'total_label' => config('bladewind.table.total_label', 'Showing :a to :b of :c records'),
    'limit' => null,
    'layout' => 'auto',
])
@php
    // reset variables for Laravel 8 support
    $has_shadow = parseBladewindVariable($has_shadow);
    $hasShadow = parseBladewindVariable($hasShadow);
    $hover_effect = parseBladewindVariable($hover_effect);
    $hoverEffect = parseBladewindVariable($hoverEffect);
    $striped = parseBladewindVariable($striped);
    $compact = parseBladewindVariable($compact);
    $divided = parseBladewindVariable($divided);
    $searchable = parseBladewindVariable($searchable);
    $search_field = parseBladewindVariable($search_field, 'string');
    $search_debounce = parseBladewindVariable($search_debounce, 'int');
    $search_min_length = parseBladewindVariable($search_min_length, 'int');
    $uppercasing = parseBladewindVariable($uppercasing);
    $celled = parseBladewindVariable($celled);
    $selectable = parseBladewindVariable($selectable);
    $checkable = parseBladewindVariable($checkable);
    $transparent = parseBladewindVariable($transparent);
    $paginated = parseBladewindVariable($paginated);
    $sortable = parseBladewindVariable($sortable);
    $page_size = parseBladewindVariable($page_size, 'int');
    $message_as_empty_state = parseBladewindVariable($message_as_empty_state);
    $show_row_numbers = parseBladewindVariable($show_row_numbers);
    $show_total = parseBladewindVariable($show_total);
    $default_page = parseBladewindVariable($default_page, 'int');

    if ($hasShadow) $has_shadow = $hasShadow;
    if (!$hoverEffect) $hover_effect = $hoverEffect;
    $name = preg_replace('/[\s-]/', '_', $name);

    $exclude_columns = !empty($exclude_columns) ? explode(',', str_replace(' ','', $exclude_columns)) : [];
    $action_icons = (!empty($action_icons)) ? ((is_array($action_icons)) ?
        $action_icons : json_decode(str_replace('&quot;', '"', $action_icons), true)) : [];
    $column_aliases = (!empty($column_aliases)) ? ((is_array($column_aliases)) ?
        $column_aliases : json_decode(str_replace('&quot;', '"', $column_aliases), true)) : [];
    $icons_array = $indices = [];
    $can_group = false;

    if (!is_null($data)) {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;

        $total_records = (!empty($limit)) ? $limit : count($data);
        $default_page = ($default_page > ceil($total_records/$page_size)) ? 1 : $default_page;
        $table_headings = $all_table_headings = ($total_records > 0) ? array_keys((array) $data[0]) : [];

        if( !empty($include_columns) ) {
            $exclude_columns = [];
            $table_headings = explode(',', str_replace(' ','', $include_columns));
        }

        if($sortable){
            $sortable_columns = empty($sortable_columns) ? $table_headings : explode(',', str_replace(' ','', $sortable_columns));
        }
//        dd($sortable_columns);

        // Ensure each row in $data has a unique ID
        if (!in_array('id', $all_table_headings)){
            foreach ($data as &$row){
                $row['id'] = uniqid();
            }
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

        if(!function_exists('pagination_row')){
            function pagination_row($row_number, $page_size=25, $default_page=1): string
            {
                $row_id =  uniqid();
                $row_page = ($row_number < $page_size) ? 1 : ceil($row_number/$page_size);
                return sprintf("data-id=%s data-page=%s class=%s", $row_id, $row_page,
                ($row_page != $default_page ? 'hidden' : ''));
            }
        }
    }
@endphp

<script>
    let tableData_{{str_replace('-','_', $name)}} = {!! json_encode($data) !!};
</script>
<div class="@if($has_border && !$celled) border border-gray-200/70 dark:border-dark-700/60 @endif border-collapse max-w-full">
    <div class="w-full">
        @if($searchable)
            <div class="bw-table-filter-bar @if($has_shadow) drop-shadow shadow shadow-gray-200/70 dark:shadow-md dark:shadow-dark-950/20 @endif">
                <x-bladewind::input
                        name="bw-search-{{$name}}"
                        placeholder="{{$search_placeholder}}"
                        onInput="filterTableDebounced(this.value, 'table.{{$name}}', '{{$search_field}}', {{$search_debounce}}, {{$search_min_length}}, tableData_{{str_replace('-','_', $name)}})();"
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
            @if($sortable) sortable @endif @if($paginated) paginated @endif
            @if($selectable) selectable @endif @if($checkable) checkable @endif @if($transparent) transparent @endif"
               @if($paginated) data-current-page="{{$default_page}}" @endif>
            @if(is_null($data) || $layout == 'custom')
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
                    @if($show_row_numbers)
                        <th>#</th>
                    @endif
                    @foreach($table_headings as $th)
                        @if(empty($exclude_columns) || !in_array($th, $exclude_columns))
                            @php
                                // get positions/indices of the fields to be displayed
                                // use these indices to directly target data to display from $data
                                $indices[] = $loop->index;
                            @endphp
                            <th @if($sortable && in_array($th, $sortable_columns))
                                    class="cursor-pointer"
                                data-sort-dir="no-sort"
                                data-can-sort="true"
                                data-column-index="{{ count($indices)-1}}"
                                onclick="sortTableByColumn(this, '{{$name}}')" @endif>
                                <span class="peer cursor-pointer">{{ str_replace('_', ' ', $column_aliases[$th] ?? $th ) }}</span>
                                @if($sortable && in_array($th, $sortable_columns))
                                    <x-bladewind::icon name="funnel"
                                                       class="!size-3 opacity-40 peer-hover:opacity-80 no-sort"/>
                                    <x-bladewind::icon name="arrow-long-up"
                                                       class="!size-3 opacity-60 peer-hover:opacity-90 sort-asc hidden"/>
                                    <x-bladewind::icon name="arrow-long-down"
                                                       class="!size-3 opacity-60 peer-hover:opacity-90 sort-desc hidden"/>
                                @endif
                            </th>
                        @endif
                    @endforeach
                    @if(!empty($action_icons))
                        <th class="!text-right">{{$actions_title}}</th>
                    @endif
                </tr>
                </thead>
                @if($total_records > 0 && $layout == 'auto')
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
                                @php $row_id =  $row['id']; @endphp
                                <tr data-id="{{ $row_id }}">
                                    @foreach($table_headings as $th)
                                        @if($th !== $groupby && in_array($loop->index, $indices))
                                            <td data-row-id="{{ $row_id }}"
                                                data-column="{{ $th }}">{!! $row[$th] !!}</td>
                                        @endif
                                    @endforeach
                                    <x-bladewind::table-icons :icons_array="$icons_array" :row="$row"/>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        @foreach($data as $row)
                            @php
                                $row_id =  $row['id'];
                                $row_page = (!$paginated || $loop->iteration < $page_size) ? 1 : ceil($loop->iteration/$page_size);
                            @endphp
                            @if(!empty($limit) && $loop->iteration > $limit)
                                @break
                            @endif
                            <tr data-id="{{ $row_id }}" data-page="{{ $row_page }}"
                                @if($paginated && $row_page != $default_page)class="hidden" @endif>
                                @if($show_row_numbers)
                                    <td>{{$loop->iteration}}</td>
                                @endif
                                @foreach($table_headings as $th)
                                    @if(in_array($loop->index, $indices))
                                        <td data-row-id="{{ $row_id }}"
                                            data-column="{{ $th }}">{!! $row[$th] !!}</td>
                                    @endif
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
        @if($paginated && !empty($total_records))
            <x-bladewind::pagination
                    :style="$pagination_style"
                    :total_records="$total_records"
                    :page_size="$page_size"
                    :show_total="$show_total"
                    :show_total_pages="$show_total_pages"
                    :show_page_number="$show_page_number"
                    :label="$total_label"
                    :table="$name"
                    :default_page="$default_page"/>
        @endif
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
        domEls('.bw-table.{{$name}}.selectable tr').forEach((el) => {
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
                domEls(`${table}.selectable tr`).forEach((el) => {
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
                domEls(`${table}.selectable tr`).forEach((el) => {
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
@if($sortable)
    @once
        <script>
            const originalTableOrder = new Map();

            // Save the initial order of all tables when the page loads
            window.onload = () => {
                document.querySelectorAll("table.sortable").forEach(table => {
                    const tbody = table.tBodies[0];
                    const rows = Array.from(tbody.rows);
                    originalTableOrder.set(table, rows); // Store original rows for this table
                });
            };

            const sortTableByColumn = (el, table) => {
                let sortColumnIndex = el.getAttribute('data-column-index');
                let sortDirection = el.getAttribute('data-sort-dir') || 'no-sort';
                let sortTable = domEl(`.${table}`);
                const tbody = sortTable.tBodies[0];
                let currentPage = String(sortTable.getAttribute('data-current-page') || 1);

                changeColumnSortIcon(sortColumnIndex, table, sortDirection);

                sortDirection = (sortDirection === "no-sort") ? "asc" : ((sortDirection === "asc") ? "desc" : "no-sort");
                let sortColumn = domEl(`.${table} th[data-column-index="${sortColumnIndex}"]`);
                sortColumn.setAttribute('data-sort-dir', sortDirection);

                if (sortDirection === "no-sort") {
                    resetToOriginalOrder(sortTable, tbody, currentPage);
                } else {
                    const rows = Array.from(tbody.rows).filter(row => (row.getAttribute('data-page') === currentPage));
                    document.body.appendChild(tbody);

                    rows.forEach(row => {
                        const cellValue = row.cells[sortColumnIndex].innerText.trim();
                        row.sortKey = isNumeric(cellValue) ? parseFloat(cellValue) : cellValue.toLowerCase();
                    });

                    rows.sort((a, b) => {
                        if (typeof a.sortKey === "number" && typeof b.sortKey === "number") {
                            return sortDirection === "asc" ? a.sortKey - b.sortKey : b.sortKey - a.sortKey;
                        } else {
                            return sortDirection === "asc" ? a.sortKey.localeCompare(b.sortKey) : b.sortKey.localeCompare(a.sortKey);
                        }
                    });

                    rows.forEach(row => tbody.appendChild(row));
                    sortTable.appendChild(tbody);
                }
            }

            const isNumeric = (value) => {
                return !isNaN(value) && !isNaN(parseFloat(value));
            }

            const changeColumnSortIcon = (column, table, direction) => {
                resetColumnSortIcons(table);
                if (direction === 'no-sort') {
                    hide(`.${table} th[data-column-index="${column}"] svg.no-sort`);
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-desc`);
                    unhide(`.${table} th[data-column-index="${column}"] svg.sort-asc`);
                }
                if (direction === 'asc') {
                    hide(`.${table} th[data-column-index="${column}"] svg.no-sort`);
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-asc`);
                    unhide(`.${table} th[data-column-index="${column}"] svg.sort-desc`);
                }
                if (direction === 'desc') {
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-asc`);
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-desc`);
                    unhide(`.${table} th[data-column-index="${column}"] svg.no-sort`);
                }
            }

            const resetColumnSortIcons = (table) => {
                domEls(`.${table} th[data-can-sort="true"]`).forEach((el) => {
                    let column = el.getAttribute('data-column-index');
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-desc`);
                    hide(`.${table} th[data-column-index="${column}"] svg.sort-asc`);
                    unhide(`.${table} th[data-column-index="${column}"] svg.no-sort`);
                    el.setAttribute('data-sort-dir', 'no-sort');
                });
            }

            function resetToOriginalOrder(table, tbody, currentPage) {
                const originalRows = originalTableOrder.get(table);
                const currentPageRows = originalRows.filter(row => (row.getAttribute('data-page') === currentPage));
                currentPageRows.forEach(row => tbody.appendChild(row));
            }
        </script>
    @endonce
@endif