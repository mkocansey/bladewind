(function () {
    if (typeof window.BladewindPopover === 'undefined') {
        window.BladewindPopover = class BladewindPopover {
            name;
            content;
            options;

            constructor(name, options = {}) {
                this.name = name;
                this.content = `.${name} .bw-popover-content`
                this.options = options;
                this.activate();
            }

            show = () => {
                changeCss(this.content, 'opacity-0,hidden', 'remove');
                domEl(this.content).setAttribute('data-open', '1');
                document.addEventListener('mouseup', (e) => {
                    let container = domEl(`.${this.name}`);
                    if (container && !container.contains(e.target)) this.hide();
                });
            }

            hide = () => {
                domEl(this.content).setAttribute('data-open', '0');
                changeCss(this.content, 'animate__fadeIn', 'remove');
                changeCss(this.content, 'animate__fadeOut');
                setTimeout(() => {
                    changeCss(this.content, 'opacity-0,hidden,animate__fadeIn');
                    changeCss(this.content, 'animate__fadeOut', 'remove');
                    window.clearTimeout();
                }, 500);
            }

            toggle = () => {
                (domEl(this.content).getAttribute('data-open') === '0') ? this.show() : this.hide();
            }

            activate = () => {
                domEl(`.${this.name} .bw-trigger`).addEventListener(this.options.triggerOn, () => {
                    this.toggle();
                });
            }
        }
    }
})();
