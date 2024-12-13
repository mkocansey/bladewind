@props([
    'total_records' => null,
    'page_size' => 25,
    'style' => 'arrows',
    'show_total' => true,
    'show_page_number' => true,
    'show_total_pages' => false,
    'default_page' => 1,
    'table' => null,
    'label' => 'Showing :a to :b of :c records',
])

@php
    $show_total = parseBladewindVariable($show_total);
    $show_page_number = parseBladewindVariable($show_page_number);
    $show_total_pages = parseBladewindVariable($show_total_pages);
    $default_page = parseBladewindVariable($default_page, 'int');
    $style = (!in_array($style, ['arrows', 'dropdown', 'numbers'])) ? 'arrows' : $style;
    $total_pages = ceil($total_records/$page_size);
    $default_page = (is_numeric($default_page) && $default_page > 0 && $default_page <= $total_pages) ? $default_page : 1;
    $inactive_css = "opacity-30 hover:opacity-30 !hover:border-gray-500/50";
    $active_css = "!border-primary-500 dark:!border-gray-300";
    $default_button_css = "!border-gray-200 dark:!border-dark-600 hover:!border-gray-400 dark:hover:!border-dark-500";
    $next_button_status_css = ($default_page == $total_pages) ? $inactive_css : $default_button_css;
    $prev_button_status_css = ($default_page == 1) ? $inactive_css : $default_button_css;
    $to = $page_size*$default_page;
    $to = ($to > $total_records) ? $total_records : $to;
    $from = $to - ($page_size-1);
    $from = ($to == $total_records) ? 1 : $from;
    $prev_page = $default_page-1;
    $next_page = $default_page+1;
    $prev_page = ($prev_page <= 0) ? 0 : $default_page-1;
@endphp

@if(!empty($total_records) && !empty($table))
    <script>
        var previousPage_{{$table}} = {{$default_page}};
        var totalPages_{{$table}} = {{$total_pages}};
        var pageSize_{{$table}} = {{$page_size}};
        var totalRecords_{{$table}} = {{$total_records}};
        var paginationStyle_{{$table}} = '{{$style}}';
    </script>
    <div class="flex px-5 py-2 justify-between text-sm items-center opacity-80 bw-pagination-{{$table}}">
        <div>
            @if($show_total)
                {!! str_replace(':c', '<strong>'.$total_records.'</strong>',
                    str_replace(':b', '<span class="font-semibold to">'.$to.'</span>',
                    str_replace(':a', '<span class="font-semibold from">'.$from.'</span>', $label)))  !!}
            @endif
        </div>
        <div>
            @if($style == 'arrows')
                <x-bladewind::button
                        type="primary"
                        :outline="true"
                        color="gray"
                        size="tiny"
                        icon="arrow-left" class="!pr-0 prev-btn {{$prev_button_status_css}}"
                        onclick="goToPage('{{$prev_page}}', '{{$table}}', '{{$default_page}}')"/>
                <span class="page-number font-semibold p-1 @if(!$show_page_number)hidden @endif"><span
                            class="page">{{$default_page}}</span>@if($show_total_pages)
                        /{{$total_pages}}
                    @endif</span>
                <x-bladewind::button
                        type="primary"
                        :outline="true"
                        color="gray"
                        size="tiny"
                        icon="arrow-right" class="!pr-0 next-btn {{$next_button_status_css}}"
                        onclick="goToPage('{{$next_page}}', '{{$table}}')"/>
            @elseif($style == 'dropdown')
                <div class="!z-50">
                    <span class="table-name hidden" data-value="{{$table}}"></span>
                    <span class="current-page hidden" data-value="{{$default_page}}"></span>
                    <x-bladewind::select :selected_value="$default_page" :required="true" data="manual"
                                         meta="{table: '{{$table}}'}" size="small">
                        @for($p=1; $p <= $total_pages; $p++)
                            <x-bladewind::select-item :label="$p" :value="$p" onselect="routeToPage"/>
                        @endfor
                    </x-bladewind::select>
                </div>
            @else
                <span class="current-page hidden" data-value="{{$default_page}}"></span>
                <div class="flex">
                    <x-bladewind::button
                            type="primary"
                            color="gray"
                            :outline="true"
                            icon="arrow-left"
                            size="tiny"
                            class="!mr-0.5 !pl-5 !pr-1 prev-btn {{$default_button_css}}"
                            onclick="routeToPage('{{$prev_page}}', '', '', {table: '{{$table}}'}); shufflePageNumbers('{{$prev_page}}', '{{$table}}')"/>
                    <span class="mt-3 prev-dots"></span>
                    @for($p=1; $p <= $total_pages; $p++)
                        @php
                            $button_css = ($p==$default_page) ? $active_css : $default_button_css;
                        @endphp
                        <x-bladewind::button
                                type="primary"
                                color="gray"
                                :outline="true"
                                size="tiny"
                                data-page="{{$p}}"
                                class="btn {{ (strlen($p) == 1) ? '!px-3' : '!px-2' }} hidden !text-xs !mx-0.5 btn-{{$p}} {{$button_css}}"
                                onclick="routeToPage('{{$p}}', '', '', {table: '{{$table}}'}); shufflePageNumbers('{{$p}}', '{{$table}}')">{{$p}}</x-bladewind::button>
                        <span class="mt-3 dots-{{$p}}"></span>
                    @endfor
                    <span class="mt-3 next-dots"></span>
                    <x-bladewind::button
                            type="primary"
                            color="gray"
                            :outline="true"
                            icon="arrow-right"
                            size="tiny"
                            class="!ml-0.5 !pl-5 !pr-1 next-btn {{$default_button_css}}"
                            onclick="routeToPage('{{$next_page}}', '', '', {table: '{{$table}}'}); shufflePageNumbers('{{$next_page}}', '{{$table}}')"/>
                </div>
                <script>shufflePageNumbers('{{$default_page}}', '{{$table}}')</script>
            @endif
        </div>
    </div>
@endif
@once
    <span class="dots hidden"><x-bladewind::icon name="ellipsis-horizontal"/></span>
    <script>
        var selectPage = (page, previousPage, table) => {
            let pageButton = domEl(`.bw-pagination-${table} button[data-page="${page}"]`);
            let prevPageButton = domEl(`.bw-pagination-${table} button[data-page="${previousPage}"]`);
            if (pageButton && prevPageButton) {
                let cssToRemove = "border-gray-500/50, focus:ring-gray-500, hover:border-gray-600, dark:hover:border-gray-500,{{str_replace(' ', ',', $default_button_css)}}";
                let cssToAdd = '{{str_replace(' ', ',', $active_css)}}';
                changeCss(pageButton, cssToRemove, 'remove', true);
                changeCss(pageButton, cssToAdd, 'add', true);
                changeCss(prevPageButton, cssToRemove, 'add', true);
                changeCss(prevPageButton, cssToAdd, 'remove', true);
            }
        }

        var goToPage = (page, table) => {
            let currentPage = parseInt(page);
            let previousPage = window[`previousPage_${table}`];
            let totalPages = window[`totalPages_${table}`];
            let totalRecords = window[`totalRecords_${table}`];
            let pageSize = window[`pageSize_${table}`];
            let paginationStyle = window[`paginationStyle_${table}`];

            if ((currentPage === previousPage)) return false;
            if (currentPage !== 0 && currentPage <= totalPages) {
                let nextPage = currentPage + 1;
                let prevPage = currentPage - 1;
                let nextButton = domEl(`.bw-pagination-${table} .next-btn`);
                let prevButton = domEl(`.bw-pagination-${table} .prev-btn`);
                let end = (currentPage * pageSize);
                let begin = end - (pageSize - 1);
                end = (end > totalRecords) ? totalRecords : end;

                // show rows on the current page
                domEls(`table.${table} tr[data-page="${currentPage}"]`).forEach((el) => {
                    unhide(el, true);
                });
                // hide rows on previous pages
                if (domEls(`table.${table} tr[data-page="${previousPage}"]`)) {
                    domEls(`table.${table} tr[data-page="${previousPage}"]`).forEach((el) => {
                        hide(el, true);
                    });
                }

                if (prevButton) {
                    if (currentPage === 1) {
                        prevButton.removeAttribute('onclick');
                        changeCss(prevButton, 'opacity-30,hover:opacity-30,hover:!border-gray-500/50', 'add', true);
                    } else {
                        if (paginationStyle === 'numbers') {
                            prevButton.setAttribute('onclick', `goToPage(${prevPage}, '${table}'); shufflePageNumbers('${prevPage}', '${table}')`);
                        } else {
                            prevButton.setAttribute('onclick', `goToPage(${prevPage}, '${table}')`);
                        }
                        changeCss(prevButton, 'opacity-30,hover:opacity-30,hover:!border-gray-500/50', 'remove', true);
                    }
                }
                if (nextButton) {
                    if (currentPage === totalPages) {
                        nextButton.removeAttribute('onclick');
                        changeCss(nextButton, 'opacity-30,hover:opacity-30,hover:!border-gray-500/50', 'add', true);
                    } else {
                        if (paginationStyle === 'numbers') {
                            nextButton.setAttribute('onclick', `goToPage(${nextPage}, '${table}'); shufflePageNumbers('${nextPage}', '${table}')`);
                        } else {
                            nextButton.setAttribute('onclick', `goToPage(${nextPage}, '${table}')`);
                        }
                        changeCss(nextButton, 'opacity-30,hover:opacity-30,hover:!border-gray-500/50', 'remove', true);
                    }
                }
                selectPage(currentPage, previousPage, table);
                domEl(`.bw-pagination-${table} .from`).innerText = begin;
                domEl(`.bw-pagination-${table} .to`).innerText = end;
                domEl(`.bw-pagination-${table} .page-number .page`).innerText = currentPage;
                domEl(`.${table}`).setAttribute('data-current-page', currentPage);
                window[`previousPage_${table}`] = currentPage;
            }
        }

        var routeToPage = (page, value, third, meta = {}) => {
            let table = meta.table;
            let currentPage = domEl(`.${table}`).getAttribute('data-current-page');

            if ((currentPage === page)) return false;
            if ((page !== currentPage) && domEls(`table.${table} tr[data-page="${currentPage}"]`)) {
                domEls(`table.${table} tr[data-page="${currentPage}"]`).forEach((el) => {
                    hide(el, true);
                });
            }
            goToPage(page, table);
        }

        const shufflePageNumbers = (page, table) => {
            let totalPages = window[`totalPages_${table}`];
            let dots = domEl('.dots').innerHTML;
            let equalDivider = domEl(`.bw-pagination-${table} .dots-3`);
            let firstDots = domEl(`.bw-pagination-${table} .dots-1`);
            let lastDots = domEl(`.bw-pagination-${table} .dots-${totalPages - 1}`);
            page = parseInt(page);

            const hideAllButtons = () => {
                domEls(`.bw-pagination-${table} .btn`).forEach((el) => {
                    hide(el, true);
                });
            }

            const defaultMode = () => {
                let defaultsArray = [1, 2, 3, totalPages - 2, totalPages - 1, totalPages];
                equalDivider.innerHTML = dots;
                firstDots.innerHTML = '';
                lastDots.innerHTML = '';
                hideAllButtons();
                for (x = 0; x <= defaultsArray.length; x++) {
                    unhide(`.bw-pagination-${table} .btn-${defaultsArray[x]}`);
                }
            }

            // if total pages are more than 7
            if (totalPages > 7) {
                // -- if the page is 3 or more
                if (page >= 3) {
                    if (page >= (totalPages - 1)) {
                        defaultMode();
                    } else {
                        equalDivider.innerHTML = '';
                        firstDots.innerHTML = dots;
                        lastDots.innerHTML = dots;

                        hideAllButtons();

                        for (x = (page - 2); x <= (page + 2); x++) {
                            unhide(`.bw-pagination-${table} .btn-${x}`);
                        }
                        unhide(`.bw-pagination-${table} .btn-1`);
                        unhide(`.bw-pagination-${table} .btn-${totalPages}`);
                    }
                } else {
                    defaultMode();
                }
            }

        }
    </script>
@endonce
