class BladewindSelect {
    clickArea;
    rootElement;
    itemsContainer;
    filterInput;
    selectItems;
    isMultiple;
    displayArea;
    formInput;

    constructor(name, placeholder) {
        this.name = name;
        this.placeholder = placeholder || 'Select One';
        this.rootElement = `.bw-select-${name}`;
        this.clickArea = `${this.rootElement} .clickable`;
        this.displayArea = `${this.rootElement} .display-area`;
        this.itemsContainer = `${this.rootElement} .bw-select-items-container`;
        this.filterInput = `${this.itemsContainer} .bw_filter`;
        this.selectItems = `${this.itemsContainer} .bw-select-items .bw-select-item`;
        this.isMultiple = (dom_el(this.rootElement).getAttribute('data-multiple') === 'true');
        this.formInput = `input.bw-${this.name}`;
        dom_el(this.displayArea).style.width = `${(dom_el(this.rootElement).offsetWidth-40)}px`;
    }
    
    activate = () => {
        dom_el(this.clickArea).addEventListener('click', (e) => {
            unhide(this.itemsContainer);
        });
        this.hide();
        this.filter();
        this.selectItem();
    }

    hide = () => {
        document.addEventListener('mouseup', (e) => {
            let searchArea = dom_el(this.filterInput);
            let container = dom_el((this.isMultiple) ? this.itemsContainer : this.clickArea);
            if (searchArea !== null && !searchArea.contains(e.target) && ! container.contains(e.target)) hide(this.itemsContainer);
        }); 
    }

    filter = () => {
        dom_el(this.filterInput).addEventListener('keyup', (e) => {
            let value = (dom_el(this.filterInput).value);
            dom_els(this.selectItems).forEach((el) => {
                (el.innerText.toLowerCase().indexOf(value.toLowerCase()) !== -1) ? unhide(el, true) : hide(el, true);
            });
        });
    }

    selectItem = () => {
        dom_els(this.selectItems).forEach((el) => {
            let selected = (el.getAttribute('data-selected') !== null);
            let user_function = el.getAttribute('data-user-function');
            if(selected) this.setValue(el);
            el.addEventListener('click', (e) => { 
                if(user_function !== null && user_function !== undefined) {
                    callUserFunction(`${user_function}('${el.getAttribute('data-value')}', '${el.getAttribute('data-label')}')`);
                }
                this.setValue(el); 
            });
        });
    }

    setValue = (item) => {
        let selectedValue = item.getAttribute('data-value');
        let selectedLabel = item.getAttribute('data-label');
        let svg = item.children[item.children.length-1];
        hide(`${this.rootElement} .placeholder`);
        unhide(this.displayArea);
        
        if(! this.isMultiple) {
            changeCssForDomArray(`${this.selectItems} svg`, 'hidden');
            dom_el(this.displayArea).innerText = selectedLabel;
            dom_el(this.formInput).value = selectedValue;
            unhide(`${this.clickArea} .reset`);
            unhide(svg, true);
            dom_el(`${this.clickArea} .reset`).addEventListener('click', (e) => {
                this.unsetValue(item);
                e.stopImmediatePropagation();
            });
        } else {
            unhide(svg, true);
            if(dom_el(`input.bw-${this.name}`).value.indexOf(`,${selectedValue}`) !== -1){
                this.unsetValue(item);
            } else {
                dom_el(this.formInput).value += `,${selectedValue}`;
                dom_el(this.displayArea).innerHTML += this.labelTemplate(selectedLabel, selectedValue);
                this.removeLabel(selectedValue);
            }
            this.scrollers();
        }
    }
    
    unsetValue = (item) => {
        let selectedValue = item.getAttribute('data-value');
        let svg = item.children[item.children.length-1];
        if(! this.isMultiple) {
            unhide(`${this.rootElement} .placeholder`);
            changeCssForDomArray(`${this.selectItems} svg`, 'hidden');
            dom_el(this.displayArea).innerText = '';
            dom_el(this.formInput).value = '';
            hide(this.displayArea);
            hide(`${this.clickArea} .reset`);
        } else {
            dom_el(this.formInput).value = dom_el(this.formInput).value.replace(`,${selectedValue}`,'');
            dom_el(`${this.displayArea} span.bw-sp-${selectedValue}`).remove();
            if(dom_el(this.displayArea).innerText == '') {
                unhide(`${this.rootElement} .placeholder`);
                hide(this.displayArea);
            }
        }
        hide(svg, true);
    }

    scrollers = () => {
        if(dom_el(this.displayArea).scrollWidth > dom_el(this.rootElement).clientWidth) {
            unhide(`${this.clickArea} .scroll-left`);
            unhide(`${this.clickArea} .scroll-right`);
            dom_el(`${this.clickArea} .scroll-right`).addEventListener('click', (e) => {  this.scroll(150); e.stopImmediatePropagation(); });
            dom_el(`${this.clickArea} .scroll-left`).addEventListener('click', (e) => {  this.scroll(-150); e.stopImmediatePropagation(); });
        } else {
            hide(`${this.clickArea} .scroll-left`);
            hide(`${this.clickArea} .scroll-right`);
        }
    }

    scroll = (amount) => {  
        dom_el(this.displayArea).scrollBy(amount,0);  
        ((dom_el(this.displayArea).clientWidth + dom_el(this.displayArea).scrollLeft) >= 
            dom_el(this.displayArea).scrollWidth) ? hide(`${this.clickArea} .scroll-right`) : unhide(`${this.clickArea} .scroll-right`);
         (dom_el(this.displayArea).scrollLeft == 0) ? hide(`${this.clickArea} .scroll-left`) : unhide(`${this.clickArea} .scroll-left`);
    }

    labelTemplate = (label, value) => {
        return `<span class="bg-slate-200 hover:bg-slate-300 inline-flex items-center text-slate-700 py-[2.5px] pl-2.5 pr-1 `+
                `mr-2 text-sm rounded-md bw-sp-${value} animate__animated animate__bounceIn animate__faster" `+
                `onclick="event.stopPropagation();window.event.cancelBubble = true">${label}`+ 
                `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" `+
                `class="w-5 h-5 fill-slate-600 hover:fill-slate-800 text-white" data-value="${value}"><path stroke-linecap="round" `+
                `stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>`;
    }

    removeLabel = () => {
        dom_els(`${this.displayArea} span svg`).forEach((el) => {
            el.addEventListener('click', (e) => {
                let value = el.getAttribute('data-value');
                this.unsetValue(dom_el(`.bw-select-item[data-value="${value}"]`));
            });
        });
    }

    selectByValue = (value) => {
        dom_els(this.selectItems).forEach( (el) => {
            if (el.getAttribute('data-value') == value) this.setValue(el);
        });
    }

    reset = () => {
        dom_els(this.selectItems).forEach( (el) => { this.unsetValue(el); });
        hide(this.displayArea);
        unhide(this.placeholder);
    }

    disable = () => {
        changeCss(this.clickArea, 'opacity-40, select-none, cursor-not-allowed');
        changeCss(this.clickArea, 'focus:border-blue-400, cursor-pointer', 'remove');
        hide(`${this.clickArea} .reset`);
        dom_el(this.clickArea).addEventListener('click', (e) => {
            hide(this.itemsContainer);
        });
    }

    enable = () => {
        changeCss(this.clickArea, 'opacity-40, select-none, cursor-not-allowed', 'remove');
        changeCss(this.clickArea, 'focus:border-blue-400, cursor-pointer');
        dom_el(this.clickArea).addEventListener('click', (e) => {
            unhide(this.itemsContainer);
        });
    }


}