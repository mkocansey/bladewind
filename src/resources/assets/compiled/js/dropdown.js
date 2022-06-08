var dropdownIsOpen = false;
dom_el(`.${el_name} .bw-dropdown`).addEventListener('click', function (e){
    this.nextElementSibling.classList.toggle('hidden');
    dropdownIsOpen = true;
    e.stopImmediatePropagation();
});

dom_els(`.${el_name} .dropdown-items>div.dd-item`).forEach((el) => {
    el.addEventListener('click', function (e){
        let value = el.getAttribute('data-value');
        let label = el.getAttribute('data-label');
        let href = el.getAttribute('data-href');
        let href_target = el.getAttribute('data-href-target');
        let parent_tag = el.getAttribute('data-parent');
        let user_function = el.getAttribute('data-user-function');
        if(parent_tag != null) {
            dom_el(`.bw-${parent_tag}`).value = value;
            dom_el(`.${parent_tag}>button>label`).innerHTML = `<div class="flex items-center">${el.innerHTML}</div>`;
            el.parentElement.parentElement.classList.toggle('hidden');

            if(href !== '' && href !== null && href !== undefined) {
                (href_target == 'self') ? location.href = href : window.open(href, 'bladewind');
                e.stopImmediatePropagation();
            }
            if(user_function !== '') callUserFunction(`${user_function}('${value}', '${label}')`);
            if (el.classList.contains('default')){
                dom_el(`.${parent_tag} .dropdown-items>.default`).classList.add('hidden');
            } else {
                dom_el(`.${parent_tag} .dropdown-items>.default`).classList.remove('hidden');
            }
            hide(el.parentElement.parentElement, true);
            dropdownIsOpen = false;
        }

    });
});

selectSelectedValues = () => {
    dom_els('.dropdown-items>div').forEach((el) => {
        let value = el.getAttribute('data-value');
        let selected_value = el.getAttribute('data-selected-value');
        if (value === selected_value) el.click();
    });
}

searchDropdown = (value, parent) => {
    dom_els(`.${parent} .dropdown-items>div.dd-item`).forEach((el) => {
        let text = el.innerText.toLowerCase();
        if(text.indexOf(value.toLowerCase()) !== -1) {
            unhide(el, true);
        } else {
            hide(el, true);
        }
    });
}

if(dom_els('.search-dropdown')){
    dom_els('.search-dropdown').forEach((el) => {
        el.addEventListener('click', function (e){
            e.stopImmediatePropagation();
        });
    });
}
window.onload = () => { selectSelectedValues(); }