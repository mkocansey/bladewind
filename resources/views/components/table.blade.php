{{-- format-ignore-start --}}
@props([
    // your table headers in <th></th> tags
    'header' => '',

    // setting to true will result in a striped table
    'striped' => config('bladewind.table.striped', false),

    // should the table with displayed with a drop-shadow effect
    'hasShadow' => config('bladewind.table.has_shadow', false),

    // should the table have a border on all four sides
    'hasBorder' => config('bladewind.table.has_border', false),

    // should the table have row dividers
    'divided' => config('bladewind.table.divided', true),

    // if table has row dividers, how wide should they be
    // available value are regular, thin
    'divider' => config('bladewind.table.divider', 'regular'),

    // should rows light up on hover
    'hasHover' => config('bladewind.table.has_hover', true),

    // should the rows be tighter together
    'compact' => config('bladewind.table.compact', false),

    // provide a table name you can access via css
    'name' => defaultBladewindName('tbl-'),

    'data' => null,
    'excludeColumns' => null,
    'includeColumns' => null,
    'actionIcons' => null,
    'groupBy' => null,
    'actionsTitle' => 'actions',
    'columnAliases' => [],
    'searchable' => config('bladewind.table.searchable', false),
    'searchPlaceholder' => config('bladewind.table.search_placeholder', __("bladewind::bladewind.table_search_placeholder")),
    'searchField' => null,
    'searchDebounce' => 0,
    'searchMinLength' => 0,
    'celled' => config('bladewind.table.celled', false),
    'uppercasing' => config('bladewind.table.uppercasing', true),
    'noDataMessage' => config('bladewind.table.no_data_message', __("bladewind::bladewind.table_no_data")),
    'messageAsEmptyState' => config('bladewind.table.message_as_empty_state', false),
    // parameters expected by the empty state component ---------------
    'image' => asset('vendor/bladewind/images/empty-state.svg'),
    'heading' => '',
    'buttonLabel' => '',
    'showImage' => config('bladewind.table.show_image', true),
    'onclick' => '',
    //------------------ end empty state parameters -------------------
    'selectable' => config('bladewind.table.selectable', false),
    'checkable' => config('bladewind.table.checkable', false),
    'transparent' => config('bladewind.table.transparent', false),
    'selectedValue' => null,
    'sortable' => config('bladewind.table.sortable', false),
    'sortableColumns' => [],
    'paginated' => config('bladewind.table.paginated', false),
    'paginationStyle' => config('bladewind.table.pagination_style', 'arrows'),
    'pageSize' => config('bladewind.table.page_size', 25),
    'showRowNumbers' => config('bladewind.table.show_row_numbers', false),
    'showTotal' => config('bladewind.table.show_total', true),
    'showPageNumber' => config('bladewind.table.show_page_number', true),
    'showTotalPages' => config('bladewind.table.show_total_pages', false),
    'defaultPage' => 1,
    'totalLabel' => config('bladewind.table.total_label', __("bladewind::bladewind.pagination_label")),
    'limit' => null,
    'layout' => 'auto',
    'groupHeadingCss' => '',
    'nonce' => config('bladewind.script.nonce', null),
])
@php
    // reset variables for Laravel 8 support
    $hasShadow = parseBladewindVariable($hasShadow);
    $hasHover = parseBladewindVariable($hasHover);
    $striped = parseBladewindVariable($striped);
    $compact = parseBladewindVariable($compact);
    $divided = parseBladewindVariable($divided);
    $searchable = parseBladewindVariable($searchable);
    $searchField = parseBladewindVariable($searchField, 'string');
    $searchDebounce = parseBladewindVariable($searchDebounce, 'int');
    $searchMinLength = parseBladewindVariable($searchMinLength, 'int');
    $uppercasing = parseBladewindVariable($uppercasing);
    $celled = parseBladewindVariable($celled);
    $selectable = parseBladewindVariable($selectable);
    $checkable = parseBladewindVariable($checkable);
    $transparent = parseBladewindVariable($transparent);
    $paginated = parseBladewindVariable($paginated);
    $sortable = parseBladewindVariable($sortable);
    $pageSize = parseBladewindVariable($pageSize, 'int');
    $messageAsEmptyState = parseBladewindVariable($messageAsEmptyState);
    $showRowNumbers = parseBladewindVariable($showRowNumbers);
    $showTotal = parseBladewindVariable($showTotal);
    $defaultPage = parseBladewindVariable($defaultPage, 'int');

    $name = preg_replace('/[\s-]/', '_', $name);

    $excludeColumns = !empty($excludeColumns) ? explode(',', str_replace(' ','', $excludeColumns)) : [];
    $actionIcons = (!empty($actionIcons)) ? ((is_array($actionIcons)) ?
        $actionIcons : json_decode(str_replace('&quot;', '"', $actionIcons), true)) : [];
    $columnAliases = (!empty($columnAliases)) ? ((is_array($columnAliases)) ?
        $columnAliases : json_decode(str_replace('&quot;', '"', $columnAliases), true)) : [];
    $icons_array = $indices = [];
    $can_group = false;

    if (!is_null($data)) {
        $data = (!is_array($data)) ? json_decode(str_replace('&quot;', '"', $data), true) : $data;

        $totalRecords = (!empty($limit)) ? $limit : count($data);
        $defaultPage = ($defaultPage > ceil($totalRecords/$pageSize)) ? 1 : $defaultPage;
        $table_headings = $all_table_headings = ($totalRecords > 0) ? array_keys((array) $data[0]) : [];

        if( !empty($includeColumns) ) {
            $excludeColumns = [];
            $table_headings = explode(',', str_replace(' ','', $includeColumns));
        }

        if($sortable){
            $sortableColumns = empty($sortableColumns) ? $table_headings : explode(',', str_replace(' ','', $sortableColumns));
        }
//        dd($sortableColumns);

        // Ensure each row in $data has a unique ID
        if (!in_array('id', $all_table_headings)){
            foreach ($data as &$row){
                $row['id'] = uniqid();
            }
        }

        if(!empty($groupBy) && in_array($groupBy, $table_headings)) {
            $can_group = true;
            $unique_group_headings = array_unique(array_column($data, $groupBy));
        }

        // build action icons
        foreach ($actionIcons as $action) {
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
            function pagination_row($row_number, $pageSize=25, $defaultPage=1): string
            {
                $row_id =  uniqid();
                $row_page = ($row_number < $pageSize) ? 1 : ceil($row_number/$pageSize);
                return sprintf("data-id=%s data-page=%s class=%s", $row_id, $row_page,
                ($row_page != $defaultPage ? 'hidden' : ''));
            }
        }
    }
@endphp
{{-- format-ignore-end --}}

<x-bladewind::script :nonce="$nonce">
    let tableData_{{str_replace('-','_', $name)}} = {!! json_encode($data) !!};
</x-bladewind::script>
<div class="@if($hasBorder && !$celled) border border-gray-200/70 dark:border-dark-700/60 @endif border-collapse max-w-full">
    <div class="w-full">
        @if($searchable)
            <div class="bw-table-filter-bar @if($hasShadow) drop-shadow shadow shadow-gray-200/70 dark:shadow-md dark:shadow-dark-950/20 @endif">
                <x-bladewind::input
                        name="bw-search-{{$name}}"
                        placeholder="{{$searchPlaceholder}}"
                        onInput="filterTableDebounced(this.value, 'table.{{$name}}', '{{$searchField}}', {{$searchDebounce}}, {{$searchMinLength}}, tableData_{{str_replace('-','_', $name)}})();"
                        add_clearing="false"
                        class="!mb-0 focus:!border-slate-300 !pl-9 !py-3"
                        clearable="true"
                        prefix_is_icon="true"
                        prefix="magnifying-glass"/>
            </div>
        @endif
        <table class="bw-table w-full {{$name}} @if($hasShadow) drop-shadow shadow shadow-gray-200/70 dark:shadow-md dark:shadow-dark-950/20 @endif
            @if($divided) divided @if($divider=='thin') thin @endif @endif  @if($striped) striped @endif  @if($celled) celled @endif
            @if($hasHover) with-hover-effect @endif @if($compact) compact @endif @if($uppercasing) uppercase-headers @endif
            @if($sortable) sortable @endif @if($paginated) paginated @endif
            @if($selectable) selectable @endif @if($checkable) checkable @endif @if($transparent) transparent @endif"
               @if($paginated) data-current-page="{{$defaultPage}}" @endif>
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
                        $table_headings = ($totalRecords>0) ? $table_headings : (($columnAliases) ?? []);
                        // when grouping rows, remove the heading for the column being grouped by
                        if($can_group) {
                            unset($table_headings[array_search($groupBy, $table_headings)]);
                        }
                    @endphp
                    @if($showRowNumbers)
                        <th>#</th>
                    @endif
                    @foreach($table_headings as $th)
                        @if(empty($excludeColumns) || !in_array($th, $excludeColumns))
                            @php
                                // get positions/indices of the fields to be displayed
                                // use these indices to directly target data to display from $data
                                $indices[] = $loop->index;
                            @endphp
                            <th @if($sortable && in_array($th, $sortableColumns))
                                    class="cursor-pointer"
                                data-sort-dir="no-sort"
                                data-can-sort="true"
                                data-column-index="{{ $checkable ? count($indices) : count($indices)-1}}"
                                onclick="sortTableByColumn(this, '{{$name}}')" @endif>
                                <span class="peer cursor-pointer">{{ str_replace('_', ' ', $columnAliases[$th] ?? $th ) }}</span>
                                @if($sortable && in_array($th, $sortableColumns))
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
                    @if(!empty($actionIcons))
                        <th class="!text-right">{{$actionsTitle}}</th>
                    @endif
                </tr>
                </thead>
                @if($totalRecords > 0 && $layout == 'auto')
                    <tbody>
                    @if($can_group)
                        @foreach($unique_group_headings as $group_heading)
                            <tr>
                                <td @class([
        "group-heading" => empty($groupHeadingCss),
        "$groupHeadingCss" => !empty($groupHeadingCss)
]) colspan="{{count($table_headings)}}">{{ $group_heading }}</td>
                            </tr>
                            @php
                                $grouped_data = array_filter($data, function ($item) use ($group_heading, $groupBy) {
                                    return $item[$groupBy] === $group_heading;
                                });
                            @endphp
                            @foreach($grouped_data as $row)
                                @php $row_id =  $row['id']; @endphp
                                <tr data-id="{{ $row_id }}">
                                    @foreach($table_headings as $th)
                                        @if($th !== $groupBy && in_array($loop->index, $indices))
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
                                $row_page = (!$paginated || $loop->iteration < $pageSize) ? 1 : ceil($loop->iteration/$pageSize);
                            @endphp
                            @if(!empty($limit) && $loop->iteration > $limit)
                                @break
                            @endif
                            <tr data-id="{{ $row_id }}" data-page="{{ $row_page }}"
                                @if($paginated && $row_page != $defaultPage)class="hidden" @endif>
                                @if($showRowNumbers)
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
                                @if($messageAsEmptyState)
                                    <x-bladewind::empty-state
                                            :message="$noDataMessage"
                                            :buttonLabel="$buttonLabel"
                                            :onclick="$onclick"
                                            :image="$image"
                                            :showImage="$showImage"
                                            :heading="$heading"/>
                                @else
                                    {{ $noDataMessage }}
                                @endif
                                <x-bladewind::script :nonce="$nonce">
                                    changeCss('.{{$name}}', 'with-hover-effect', 'remove');
                                    changeCss('.{{$name}}', 'has-no-data');
                                </x-bladewind::script>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                @endif
        </table>
        @if($paginated && !empty($totalRecords))
            <x-bladewind::pagination
                    :style="$paginationStyle"
                    :totalRecords="$totalRecords"
                    :pageSize="$pageSize"
                    :showTotal="$showTotal"
                    :showTotalPages="$showTotalPages"
                    :showPageNumber="$showPageNumber"
                    :label="$totalLabel"
                    :table="$name"
                    :defaultPage="$defaultPage"/>
        @endif
    </div>
</div>
@if($selectable)
    @once
        <x-bladewind::script :nonce="$nonce">
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
        </x-bladewind::script>
    @endonce
    <x-bladewind::script :nonce="$nonce">
        domEls('.bw-table.{{$name}}.selectable tr').forEach((el) => {
        el.addEventListener('click', (e) => {
        el.classList.toggle('selected');
        let id = el.getAttribute('data-id');
        let checkbox = el.querySelector('td:first-child input[type="checkbox"]');
        if (checkbox) checkbox.checked = el.classList.contains('selected');
        addRemoveRowValue(id, '{{$name}}');
        });
        });
    </x-bladewind::script>
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
        <x-bladewind::script :nonce="$nonce">
            const addCheckboxesToTable = (el) => {
            let table = domEl(el);
            let checkboxHtml = domEl('.checkbox-template').innerHTML;
            let partialCheckHtml = domEl('.partial-check-template').innerHTML;

            for (let row of table.rows) {
            let cellTag = (row.parentElement.tagName.toLowerCase() === 'thead') ? 'th' : 'td';
            let checkboxCell = document.createElement(cellTag);
            checkboxCell.innerHTML = (cellTag === 'th') ?
            checkboxHtml.replace('type="checkbox"', `type="checkbox" onclick="toggleAll(this,'${el}')"`) +
            partialCheckHtml :
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
        </x-bladewind::script>
    @endonce
    <x-bladewind::script :nonce="$nonce">
        addCheckboxesToTable('.bw-table.{{$name}}');
        // select rows in selectedValue
        @if(!empty($selectedValue))
            checkSelected('.bw-table.{{$name}}', '{{$selectedValue}}')
        @endif
    </x-bladewind::script>
@endif
@if($sortable)
    @once
        <x-bladewind::script :nonce="$nonce">
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
        </x-bladewind::script>
    @endonce
@endif