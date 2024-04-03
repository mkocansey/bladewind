class BladewindNotification {
    title;
    message;
    type;
    dismissInMinutes;
    dismissInSeconds;
    name;
    timeoutName;
    colors;

    constructor(title, message, type, dismissInMinutes) {
        this.title = title || '';
        this.message = message || '';
        this.type = type || 'success';
        this.dismissInMinutes = dismissInMinutes || 15;
        this.dismissInSeconds = this.dismissInMinutes * 1000;
        this.name = `notification-${Math.floor((Math.random() * 100) + 1)}`;
        this.timeoutName = this.name.replace('notification-', 'timeout_');
        this.colors = {
            "success": {"border": "border-green-500", "bg": "bg-green-100"},
            "error": {"border": "border-red-500", "bg": "bg-red-100"},
            "warning": {"border": "border-amber-500", "bg": "bg-amber-100"},
            "info": {"border": "border-blue-500", "bg": "bg-blue-100"},
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

    modalIcon = function () {
        changeCss(`.bw-notification-icons .${this.type}`, 'hidden', 'remove');
        return dom_el(`.bw-notification-icons .${this.type}`).outerHTML.replaceAll('[type]', this.type);
    }

    template = () => {
        return `<div class="flex border-l-[6px] border-opacity-80 ${this.name} border-${this.type}-500 bg-white dark:bg-slate-700 dark:shadow-xl dark:shadow-slack-900 shadow-xl  p-4 rounded-lg mb-3">
            <div class="pr-4 grow-0">${this.modalIcon()}</div>
            <div class="pb-1 pr-4 relative grow">
                <h1 class="font-semibold text-gray-700 dark:text-slate-300">${this.title}</h1>
                <div class="pt-1 text-sm !text-gray-600 dark:!text-slate-400 message">${this.message}</div>
                ${this.closeIcon()}
            </div>
        </div>`;
    }

    closeIcon = () => {
        return `<svg xmlns="http://www.w3.org/2000/svg" class="close h-5 w-5 absolute -right-1 cursor-pointer 
                    -top-1 text-gray-400 hover:bg-gray-200 hover:rounded-full dark:hover:bg-slate-800 p-1" fill="none" 
                    viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" 
                    stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>`;
    }

}

var showNotification = (title, message, type, dismiss_in) => {
    new BladewindNotification(title, message, type, dismiss_in).show();
}