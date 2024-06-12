class BladewindNotification {
    title;
    message;
    type;
    dismissInMinutes;
    dismissInSeconds;
    name;
    timeoutName;
    colours;

    constructor(title, message, type, dismissInMinutes) {
        this.title = title || '';
        this.message = message || '';
        this.type = type || 'success';
        this.dismissInMinutes = dismissInMinutes || 15;
        this.dismissInSeconds = this.dismissInMinutes * 1000;
        this.name = `notification-${Math.floor((Math.random() * 100) + 1)}`;
        this.timeoutName = this.name.replace('notification-', 'timeout_');
        this.colours = {
            "success": {"border": "border-green-500/50", "bg": "bg-green-200/80"},
            "error": {"border": "border-red-500/50", "bg": "bg-red-200/80"},
            "warning": {"border": "border-yellow-500/50", "bg": "bg-amber-200/80"},
            "info": {"border": "border-blue-500/50", "bg": "bg-blue-200/80"},
        };
    }

    show = () => {
        dom_el('.bw-notification-container').insertAdjacentHTML('beforeend', this.template());
        animateCSS(`.${this.name}`, 'fadeInRight').then(() => {
            this.timeoutName = setTimeout(() => {
                this.hide();
            }, this.dismissInSeconds);
            this.closable();
        });
    }

    hide = () => {
        animateCSS(`.${this.name}`, 'fadeOutRight').then(() => {
            dom_el(`.${this.name}`).remove();
            clearTimeout(this.timeoutName);
        });
    }

    closable = () => {
        dom_el(`.${this.name} .close`).addEventListener('click', () => {
            this.hide();
        });
    }

    modalIcon = () => {
        changeCss(`.bw-notification-icons .${this.type}`, 'hidden', 'remove');
        return dom_el(`.bw-notification-icons .${this.type}`).outerHTML.replaceAll('[type]', this.typeColour(this.type));
    }

    template = () => {
        return `<div class="flex border-l-[6px] border-opacity-80 ${this.name} border-${this.typeColour(this.type)}-500 
                bg-white dark:bg-dark-800/95 shadow dark:shadow-slate-800/50 p-4 rounded-lg mb-3">
            <div class="pr-4 grow-0">${this.modalIcon()}</div>
            <div class="pb-1 pr-4 relative grow">
                <h1 class="font-semibold text-gray-700 dark:text-slate-300">${this.title}</h1>
                <div class="pt-1 text-sm !text-gray-600 dark:!text-slate-400 message">${this.message}</div>
                ${this.closeIcon()}
            </div>
        </div>`;
    }

    closeIcon = () => {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="close size-5 absolute -right-1 cursor-pointer 
                    -top-1 text-gray-400 hover:bg-gray-200 hover:rounded-full dark:hover:bg-slate-900 p-1" fill="none" 
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

var showNotification = (title, message, type, dismiss_in) => {
    new BladewindNotification(title, message, type, dismiss_in).show();
}