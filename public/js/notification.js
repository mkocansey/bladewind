class BladewindNotification {
    title;
    message;
    type;
    dismissInMinutes;
    dismissInSeconds;
    name;
    timeoutName;
    borderColors;

    constructor(title, message, type, dismissInMinutes) {
        this.title = title || '';
        this.message = message || '';
        this.type = type || 'success';
        this.dismissInMinutes = dismissInMinutes || 15;
        this.dismissInSeconds = this.dismissInMinutes * 1000;
        this.name = `notification-${Math.floor((Math.random() * 100) + 1)}`;
        this.timeoutName = this.name.replace('notification-', 'timeout_');
        this.borderColors = {
            "success" : "border-green-400/80",
            "error" : "border-red-400/80",
            "warning" : "border-orange-400/80",
            "info" : "border-blue-400/80",
        };
    }

    show = () => {
        // dom_el('.bw-notification-container').innerHTML += this.template();
        dom_el('.bw-notification-container').insertAdjacentHTML('beforeend', this.template());
        animateCSS(`.${this.name}`,'fadeInRight').then(() => {
            this.timeoutName = setTimeout(() => { this.hide(); }, this.dismissInSeconds);
            this.closable();
        });
    }

    hide = () => {
        animateCSS(`.${this.name}`,'fadeOutRight').then(() => {
            dom_el(`.${this.name}`).remove();
            clearTimeout(this.timeoutName);
        });
    }

    closable = () => {
        dom_el(`.${this.name} .close`).addEventListener('click', () => {
            this.hide();
        });
    }

    modalIcon = function (){
        return dom_el(`.bw-notification-icons .${this.type}`).outerHTML.replace('hidden', '');
    }

    template = () => {
        let border_color = eval(`this.borderColors.${this.type}`);
        return `<div class="flex border-2 ${this.name} ${border_color} bg-white dark:bg-slate-700 dark:border-0 dark:shadow-xl dark:shadow-slack-900 shadow-lg p-4 rounded-lg mb-3">
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
                    -top-1 text-gray-400 hover:bg-gray-200 dark:hover:bg-slate-800 p-1" fill="none" 
                    viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" 
                    stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>`;
    }

}