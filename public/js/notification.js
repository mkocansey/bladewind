class BladewindNotification {
    title;
    message;
    type;
    dismissInSeconds;
    name;
    timeoutName;
    colours;

    constructor({
                    title = "",
                    message = "",
                    type = "success",
                    dismissInSeconds = 15,
                    size = "regular",
                    name = null
                }) {
        this.title = title;
        this.message = message;
        this.type = type;
        this.dismissInSeconds = (dismissInSeconds || 15) * 1000;
        this.name = name || Math.floor((Math.random() * 10000) + 1);
        this.name = `notification-${this.name}`;
        this.timeoutName = this.name.replace('notification-', 'timeout_');
        this.colours = {
            "success": {"border": "border-green-500/50", "bg": "bg-green-200/80"},
            "error": {"border": "border-red-500/50", "bg": "bg-red-200/80"},
            "warning": {"border": "border-yellow-500/50", "bg": "bg-amber-200/80"},
            "info": {"border": "border-blue-500/50", "bg": "bg-blue-200/80"},
        };
        this.size = size;
        this.sizes = {
            "small": {
                "container": "sm:!max-w-[350px]",
                "modal_icon": "!size-10",
                "close": "size-6",
                "heading": "text-base",
                "message": "text-sm"
            },
            "regular": {
                "container": "sm:!max-w-[450px]",
                "modal_icon": "!size-14",
                "close": "size-6",
                "heading": "text-lg",
                "message": "text-sm"
            },
            "big": {
                "container": "sm:!max-w-[550px]",
                "modal_icon": "!size-16",
                "close": "size-6",
                "heading": "text-3xl",
                "message": "text-base"
            }
        };
        this.setContainerSize();
    }

    show = () => {
        if (domEl(`.${this.name}`)) {
            clearTimeout(this.timeoutName);
            domEl(`.${this.name}`).remove();
        }
        domEl('.bw-notification-container').insertAdjacentHTML('beforeend', this.template());
        animateCSS(`.${this.name}`, 'fadeInRight').then(() => {
            this.timeoutName = setTimeout(() => {
                this.hide();
            }, this.dismissInSeconds);
            this.closable();
        });
    }

    hide = () => {
        animateCSS(`.${this.name}`, 'fadeOutRight').then(() => {
            domEl(`.${this.name}`).remove();
            clearTimeout(this.timeoutName);
        });
    }

    closable = () => {
        domEl(`.${this.name} .close`).addEventListener('click', () => {
            this.hide();
        });
    }

    setContainerSize = () => {
        changeCss('.bw-notification-container', this.sizes[this.size].container, 'add');
    }

    modalIcon = () => {
        changeCss(`.bw-notification-icons .${this.type}`, this.sizes[this.size].modal_icon, 'add');
        changeCss(`.bw-notification-icons .${this.type}`, 'hidden', 'remove');
        return domEl(`.bw-notification-icons .${this.type}`).outerHTML.replaceAll('[type]', this.typeColour(this.type));
    }

    template = () => {
        return `<div class="flex border-l-[6px] border-y-[1px] border-y-gray-200/50 border-opacity-80 ${this.name} border-l-${this.typeColour(this.type)}-500
                bg-white dark:bg-dark-800/95 shadow-md dark:shadow-slate-800/50 p-4 rounded-lg mb-3">
            <div class="pr-4 grow-0">${this.modalIcon()}</div>
            <div class="pb-1 pr-4 relative grow">
                <h1 class="font-semibold text-gray-700 dark:text-slate-300 ${this.sizes[this.size].heading}">${this.title}</h1>
                <div class="pt-1 !text-gray-600 dark:!text-slate-400 message ${this.sizes[this.size].message}">${this.message}</div>
                ${this.closeIcon()}
            </div>
        </div>`;
    }

    closeIcon = () => {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="close ${this.sizes[this.size].close} absolute -right-1 cursor-pointer
                    -top-1 text-gray-400 sm:!max-w-[350px] hover:bg-gray-200 hover:rounded-full dark:hover:bg-slate-900 p-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>`;
    }

    typeColour = (type) => {
        let colours = {
            warning: 'yellow',
            error: 'red',
            info: 'blue',
            success: 'green',
        }
        return colours[type];
    }

}

// TODO: change parameters to use an object so user can pass only needed parameters (v3.0)
/*var showNotification = ({
                            title='',
                            message='',
                            type='success',
                            dismiss_in=15,
                            size='regular',
                            name=null}) => {*/
var showNotification = (title, message, type = 'success', dismiss_in = 15, size = 'regular', name = null) => {
    new BladewindNotification({
        title: title,
        message: message,
        type: type,
        dismissInSeconds: dismiss_in,
        size: size,
        name: name
    }).show();
}
