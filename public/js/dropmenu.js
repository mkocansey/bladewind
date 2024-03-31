class BladewindDropmenu {
    name;
    items;
    options;

    constructor(name, options = {}) {
        this.name = name;
        this.items = `.${name} .bw-dropmenu-items`
        this.options = options;
        this.activate();
    }

    show = () => {
        // do this is only there are items
        if (this.hasItems()) {
            changeCss(this.items, 'opacity-0,hidden', 'remove');
            dom_el(this.items).setAttribute('data-open', '1');
            if (this.options.hideAfterClick && dom_els(`${this.items} .bw-item`)) {
                dom_els(`${this.items} .bw-item`).forEach((item) => {
                    item.addEventListener('click', () => {
                        this.hide();
                    });
                });
            }
            document.addEventListener('mouseup', (e) => {
                let container = dom_el(`.${this.name}`);
                if (container && !container.contains(e.target)) this.hide();
            });
        }
    }

    hide = () => {
        dom_el(this.items).setAttribute('data-open', '0');
        changeCss(this.items, 'animate__fadeIn', 'remove');
        changeCss(this.items, 'animate__fadeOut');
        setTimeout(() => {
            changeCss(this.items, 'opacity-0,hidden,animate__fadeIn');
            changeCss(this.items, 'animate__fadeOut', 'remove');
            window.clearTimeout();
        }, 500);
    }

    reposition = () => {
        // TODO: reposition menu if too close to edge of browser window
    }

    toggle = () => {
        (dom_el(this.items).getAttribute('data-open') === '0') ? this.show() : this.hide();
    }

    activate = () => {
        dom_el(`.${this.name} .bw-trigger`).addEventListener(this.options.triggerOn, () => {
            this.toggle();
        });
    }

    hasItems = () => {
        return dom_els(`${this.items} .bw-item`);
    }


}