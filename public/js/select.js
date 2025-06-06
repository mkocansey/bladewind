class BladewindSelect {
    clickArea;
    rootElement;
    itemsContainer;
    searchInput;
    selectItems;
    isMultiple;
    required;
    displayArea;
    formInput;
    maxSelection;
    toFilter;
    selectedValue;
    canClear;
    enabled;
    metaData;


    constructor(name, placeholder) {
        this.name = name;
        this.placeholder = placeholder || 'Select One';
        this.rootElement = `.bw-select-${name}`;
        this.clickArea = `${this.rootElement} .clickable`;
        this.displayArea = `${this.rootElement} .display-area`;
        this.itemsContainer = `${this.rootElement} .bw-select-items-container`;
        this.searchInput = `${this.itemsContainer} .bw_search`;
        this.selectItems = `${this.itemsContainer} .bw-select-items .bw-select-item`;
        this.isMultiple = (domEl(this.rootElement).getAttribute('data-multiple') === 'true');
        this.required = (domEl(this.rootElement).getAttribute('data-required') === 'true');
        this.formInput = `input.bw-${this.name}`;
        domEl(this.displayArea).style.maxWidth = `${(domEl(this.rootElement).offsetWidth - 40)}px`;
        this.maxSelection = -1;
        this.canClear = (!this.required && !this.isMultiple);
        this.enabled = true;
        this.selectedItem = null;
        this.metaData = domEl(this.rootElement).getAttribute('data-meta-data') || null;
    }

    activate = (options = {}) => {
        if (options.disabled !== '1' && options.readonly !== '1') {
            domEl(this.clickArea).addEventListener('click', (e) => {
                unhide(this.itemsContainer);
            });
            this.hide();
            this.search();
            this.manualModePreSelection();
            this.selectItem();
            this.enableKeyboardNavigation();
        } else {
            this.selectItem();
            this.enabled = false;
        }
    }

    enableKeyboardNavigation = () => {
        domEl(this.rootElement).addEventListener('keydown', (e) => {
            if (e.key === "Enter") {
                if (!this.selectedItem) {
                    e.preventDefault();
                    unhide(this.itemsContainer);
                    domEl(this.searchInput).focus();
                } else {
                    hide(this.itemsContainer);
                }
            }
            if (e.key === "Tab" || e.key === "Escape") {
                hide(this.itemsContainer);
            }

            if (e.key === "ArrowDown" || e.key === "ArrowUp") {
                e.preventDefault();
                let els = [...domEls(this.selectItems)].filter((el) => {
                    if (el.classList.contains('hidden')) {
                        return false;
                    }

                    return el.getAttribute('data-unselectable') === null;
                });

                if (!this.selectedItem) {
                    this.selectedItem = e.key === 'ArrowDown' ? els[0] : els[els.length - 1];
                } else {
                    let idx = els.indexOf(this.selectedItem);

                    this.selectedItem = e.key === 'ArrowDown' ? els[idx + 1] : els[idx - 1];
                }
                changeCssForDomArray(`${this.rootElement} .bw-select-item`, 'bg-slate-100/90', 'remove');
                changeCss(this.selectedItem, 'bg-slate-100/90', 'add', true);
                this.setValue(this.selectedItem);
                this.callUserFunction(this.selectedItem);
            }
        });
    }


    clearable = () => {
        this.canClear = true;
    }

    hide = () => {
        document.addEventListener('mouseup', (e) => {
            let searchArea = domEl(this.searchInput);
            let container = domEl((this.isMultiple) ? this.itemsContainer : this.clickArea);
            if (searchArea && container && !searchArea.contains(e.target) && !container.contains(e.target)) hide(this.itemsContainer);
        });
    }

    search = () => {
        const inputEl = domEl(this.searchInput);
        const emptyEl = domEl(`${this.selectItems}[data-empty-state="true"]`);
        const allItems = [...domEls(this.selectItems)];
        const items = emptyEl ? allItems.filter(el => el !== emptyEl) : allItems;

        if (emptyEl) hide(emptyEl, true);

        inputEl.addEventListener('keyup', () => {
            const searchValue = inputEl.value.toLowerCase();

            for (const el of items) {
                const match = el.innerText.toLowerCase().includes(searchValue);
                match ? unhide(el, true) : hide(el, true);
            }
        });
    };



    /**
     * When using non-dynamic selects, ensure select_value=<value>
     * works the same way as for dynamic selects. This saves the user from
     * manually checking if each select-item should be selected or not.
     */
    manualModePreSelection = () => {
        let selectMode = domEl(`${this.rootElement}`).getAttribute('data-type');
        let selectedValue = domEl(`${this.rootElement}`).getAttribute('data-selected-value');
        if (selectMode === 'manual' && selectedValue !== null) {
            domEls(this.selectItems).forEach((el) => {
                let item_value = el.getAttribute('data-value');
                if (item_value === selectedValue) el.setAttribute('data-selected', true);
            });
        }
    }

    selectItem = () => {
        domEls(this.selectItems).forEach((el) => {
            let selected = (el.getAttribute('data-selected') !== null);
            if (selected) this.setValue(el);
            let isSelectable = (el.getAttribute('data-unselectable') === null);
            if (isSelectable) {
                el.addEventListener('click', () => {
                    this.setValue(el);
                    this.callUserFunction(el);
                });
            }
        });
    }

    moveLabel = (direction = 'up') => {
        let placeholderElement = domEl(`${this.rootElement} .placeholder`);
        let labelElement = domEl(`${this.rootElement} .placeholder .form-label`);
        if (labelElement) {
            if (direction === 'up') {
                changeCss(labelElement, '!top-4', 'remove', true);
            } else {
                changeCss(labelElement, '!top-4', 'add', true);
            }
            unhide(placeholderElement, true);
        }
    }

    setValue = (item) => {
        this.selectedValue = item ? item.getAttribute('data-value') : null;
        let selectedLabel = item ? item.getAttribute('data-label') : null;
        let svg = domEl(`${this.rootElement} div[data-value="${this.selectedValue}"] svg`);
        let input = domEl(this.formInput);

        hide(`${this.rootElement} .placeholder`);
        unhide(this.displayArea);

        if (this.toFilter) {
            (new BladewindSelect(this.toFilter, '')).reset();  //FIXME: dont new up an instance
            this.filter(this.toFilter, this.selectedValue);
        }

        if (this.enabled) {
            if (!this.isMultiple) {
                changeCssForDomArray(`${this.selectItems} svg`, 'hidden');
                domEl(this.displayArea).innerText = selectedLabel;
                input.value = this.selectedValue;
                unhide(svg, true);
                this.moveLabel();
                if (this.canClear) {
                    unhide(`${this.clickArea} .reset`);
                    domEl(`${this.clickArea} .reset`).addEventListener('click', (e) => {
                        this.unsetValue(item);
                        e.stopImmediatePropagation();
                    });
                }
            } else {
                if (input.value.includes(this.selectedValue)) {
                    this.unsetValue(item);
                } else {
                    if (!this.maxSelectableExceeded()) {
                        unhide(svg, true);
                        input.value += `,${this.selectedValue}`;
                        domEl(this.displayArea).innerHTML += this.labelTemplate(selectedLabel, this.selectedValue);
                        this.removeLabel(this.selectedValue);
                    } else {
                        showNotification('', this.maxSelectionError, 'error');
                    }
                    this.moveLabel();
                }
                this.scrollbars();
            }
            stripComma(input);
            changeCss(`${this.clickArea}`, '!border-red-400', 'remove');
        }
    }

    unsetValue = (item) => {
        this.selectedValue = item ? item.getAttribute('data-value') : null;
        // let selectedValue = item.getAttribute('data-value');
        let svg = domEl(`${this.rootElement} div[data-value="${this.selectedValue}"] svg`);
        let input = domEl(this.formInput);

        // only unset values if the Select component is not disabled
        if (this.enabled) { //!domEl(this.clickArea).classList.contains('disabled')
            if (!this.isMultiple) {
                unhide(`${this.rootElement} .placeholder`);
                changeCssForDomArray(`${this.selectItems} svg`, 'hidden');
                domEl(this.displayArea).innerText = '';
                input.value = '';
                hide(this.displayArea);
                hide(`${this.clickArea} .reset`);
                this.moveLabel('down');
            } else {
                if (domEl(`${this.displayArea} span.bw-sp-${this.selectedValue}`)) {
                    let keyword = `(,?)${this.selectedValue}`;
                    input.value = input.value.replace(input.value.match(keyword)[0], '');
                    hide(svg, true);
                    domEl(`${this.displayArea} span.bw-sp-${this.selectedValue}`).remove();
                    if (domEl(this.displayArea).innerText === '') {
                        unhide(`${this.rootElement} .placeholder`);
                        hide(this.displayArea);
                        this.moveLabel('down');
                    }
                }
            }
            stripComma(input);
            this.callUserFunction(item);
            if (this.toFilter) {
                (new BladewindSelect(this.toFilter, '')).reset(); //FIXME: dont new up an instance
                this.clearFilter(this.toFilter);
            }
        }
    }

    scrollbars = () => {
        if (domEl(this.displayArea).scrollWidth > domEl(this.rootElement).clientWidth) {
            unhide(`${this.clickArea} .scroll-left`);
            unhide(`${this.clickArea} .scroll-right`);
            domEl(`${this.clickArea} .scroll-right`).addEventListener('click', (e) => {
                this.scroll(150);
                e.stopImmediatePropagation();
            });
            domEl(`${this.clickArea} .scroll-left`).addEventListener('click', (e) => {
                this.scroll(-150);
                e.stopImmediatePropagation();
            });
        } else {
            hide(`${this.clickArea} .scroll-left`);
            hide(`${this.clickArea} .scroll-right`);
        }
    }

    scroll = (amount) => {
        domEl(this.displayArea).scrollBy(amount, 0);
        ((domEl(this.displayArea).clientWidth + domEl(this.displayArea).scrollLeft) >= domEl(this.displayArea).scrollWidth) ?
            hide(`${this.clickArea} .scroll-right`) :
            unhide(`${this.clickArea} .scroll-right`);
        (domEl(this.displayArea).scrollLeft === 0) ?
            hide(`${this.clickArea} .scroll-left`) :
            unhide(`${this.clickArea} .scroll-left`);
    }

    labelTemplate = (label, value) => {
        return `<span class="bg-slate-200 hover:bg-slate-300 inline-flex items-center text-slate-700 py-[2.5px] pl-2.5 pr-1 ` +
            `mr-2 text-sm rounded-md bw-sp-${value} animate__animated animate__bounceIn animate__faster" ` +
            `onclick="event.stopPropagation();window.event.cancelBubble = true">${label}` +
            `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" ` +
            `class="w-5 h-5 fill-slate-400 hover:fill-slate-600 text-slate-100" data-value="${value}"><path stroke-linecap="round" ` +
            `stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>`;
    }

    removeLabel = () => {
        domEls(`${this.displayArea} span svg`).forEach((el) => {
            el.addEventListener('click', (e) => {
                let value = el.getAttribute('data-value');
                this.unsetValue(domEl(`.bw-select-item[data-value="${value}"]`));
            });
        });
    }

    selectByValue = (value) => {
        domEls(this.selectItems).forEach((el) => {
            if (el.getAttribute('data-value') === value) this.setValue(el);
        });
    }

    reset = () => {
        if (this.enabled) {
            domEls(this.selectItems).forEach((el) => {
                this.unsetValue(el);
            });
            hide(this.displayArea);
            unhide(this.placeholder);
        }
    }

    disable = () => {
        changeCss(this.clickArea, 'disabled');
        changeCss(this.clickArea, 'enabled, readonly', 'remove');
        // hide(`${this.clickArea} .reset`);
        domEl(this.clickArea).addEventListener('click', () => {
            hide(this.itemsContainer);
        });
        this.enabled = false;
    }

    enable = () => {
        changeCss(this.clickArea, 'readonly, disabled', 'remove');
        changeCss(this.clickArea, 'enabled');
        domEl(this.clickArea).addEventListener('click', (e) => {
            unhide(this.itemsContainer);
        });
        this.enabled = true;
    }

    callUserFunction = (item) => {
        let userFunction = item ? item.getAttribute('data-user-function') : null;
        if (userFunction !== null && userFunction !== undefined) {
            let meta = (this.metaData) ? JSON.parse(JSON.stringify(this.metaData)) : null;
            callUserFunction(
                `${userFunction}(
                '${item.getAttribute('data-value')}',
                '${item.getAttribute('data-label')}',
                '${domEl(this.formInput).value}',
                ${meta})`
            );
        }
    }

    maxSelectable = (max_number, error_message) => {
        this.maxSelection = (this.isMultiple) ? max_number : false;
        this.maxSelectionError = error_message;
    }

    maxSelectableExceeded = () => {
        let input = domEl(this.formInput);
        let totalSelected = (input.value.split(',')).length;
        return ((this.maxSelection !== -1) && totalSelected === this.maxSelection);
    }

    filter = (element, by = '') => {
        this.toFilter = element;

        const els = domEls(`.bw-select-${element} .bw-select-items .bw-select-item`);
        let anyVisible = false;

        if (by !== '') { //this.selectedValue
            els.forEach(el => {
                const val = el.getAttribute('data-filter-value');
                (val === by) ? (unhide(el, true), anyVisible = true) : hide(el, true);
            });
        }

        const emptyEl = domEl(`.bw-select-${element} .bw-select-items .bw-select-item[data-empty-state="true"]`);
        if (emptyEl) {
            anyVisible ? hide(emptyEl, true) : unhide(emptyEl, true);
        }

        const searchWrapper = domEl(`.bw-select-${element} .bw-search-wrapper`);
        if (searchWrapper) {
            anyVisible ? unhide(searchWrapper, true) : hide(searchWrapper, true);
        }
    };


    clearFilter = (element, by = '') => {
        if (element) {
            // (new BladewindSelect(element, '')).reset();
            const elementItems = `.bw-select-${element}  .bw-select-items .bw-select-item`;
            if (by === '') { // clear all filters
                domEls(elementItems).forEach((el) => {
                    unhide(el, true);
                });
            } else { // clear specific values' filters
                domEls(elementItems).forEach((el) => {
                    const filterValue = el.getAttribute('data-filter-value');
                    (filterValue === this.selectedValue) ? hide(el, true) : unhide(el, true);
                });
            }
        }
    }
}
