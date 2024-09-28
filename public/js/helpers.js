/**
 * ----------------------------------------------
 * Helper functions for BladeWindUI components
 * ----------------------------------------------
 */

const current_modal = [];
let el_name;

/**
 * Shortcut for document.querySelector.
 * @param {string} element - The element to find in the DOM.
 * @return {(DOM element|null)} The matching DOM element.
 * @see {@link https://bladewindui.com/extra/helper-functions#domel}
 */
var domEl = (element) => {
    return (document.querySelector(element) != null) ? document.querySelector(element) : false;
}

/**
 * Alias for domEl(element)
 */
var dom_el = (element) => {
    return domEl(element);
}

/**
 * Shortcut for document.querySelectorAll.
 * @param {string} element - The element(s) to find in the DOM.
 * @return {(DOM element(s)|null)} The collection of DOM elements.
 * @see {@link https://bladewindui.com/extra/helper-functions#domels}
 */
var domEls = (element) => {
    return (document.querySelectorAll(element).length > 0) ? document.querySelectorAll(element) : false;
}

/**
 * Alias for domEls(element)
 */
var dom_els = (element) => {
    return domEls(element);
}

/**
 * Check to see if val is empty
 * @param {string} val - The string to test emptiness for
 * @return {boolean} True if string is empty
 */
var isEmpty = (val) => {
    let regex = /^\s*$/;
    return regex.test(val);
}

/**
 * Validate a form and highlight each field that fails validation.
 * @param {string} element - The class name or ID of the element containing the fields to validate.
 *   element does not need to be a <form> tag. Can be any element containing form fields.
 * @return {boolean} True if validation passes and False if validation fails.
 * @see {@link https://bladewindui.com/extra/helper-functions#validateform}
 */
var validateForm = (form) => {
    let has_error = 0;
    let BreakException = {};
    try {
        domEls(`${form} .required`).forEach((el) => {
            changeCss(el, '!border-red-500', 'remove', true);
            if (isEmpty(el.value)) {
                let el_name = el.getAttribute('name');
                let el_parent = el.getAttribute('data-parent');
                let error_message = el.getAttribute('data-error-message');
                let show_error_inline = el.getAttribute('data-error-inline');
                let error_heading = el.getAttribute('data-error-heading');

                (el_parent !== null) ?
                    changeCss(`.${el_parent} .clickable`, '!border-red-400') :
                    changeCss(el, '!border-red-400', 'add', true);
                el.focus();
                if (error_message) {
                    (show_error_inline) ? unhide(`.${el_name}-inline-error`) :
                        showNotification(error_heading, error_message, 'error');
                }

                let listenerObj = {
                    'el': el,
                    'el_parent': el_parent,
                    'show_error_inline': show_error_inline
                };

                el.addEventListener('keyup', clearErrors.bind(null, listenerObj), false);

                has_error++;
                throw BreakException;
            }
        });
    } catch (e) {
    }
    return has_error === 0;
}

/**
 * Clear validation errors. Used together with validateForm().
 * If the user provides a value for a form field, that was earlier marked as an error, clear it.
 * @param {DOM element} obj - The DOM element to target for clearing.
 * @return {void}
 */
var clearErrors = (obj) => {
    let el = obj.el;
    let el_parent = obj.el_parent;
    let el_name = obj.el_name;
    let show_error_inline = obj.show_error_inline;
    if (el.value !== '') {
        (el_parent !== null) ?
            domEl(`.${el_parent} .clickable`).classList.remove('!border-red-400') :
            el.classList.remove('!border-red-400');
        (show_error_inline) ? hide(`.${el_name}-inline-error`) : '';
    } else {
        (el_parent !== null) ?
            domEl(`.${el_parent} .clickable`).classList.add('!border-red-400') :
            el.classList.add('!border-red-400');
        (show_error_inline) ? unhide(`.${el_name}-inline-error`) : '';
    }
}

/**
 * Allow only numeric input in a text input field.
 * @param {event} event - The event object. Key events.
 * @param {boolean} with_dots - Should dots be allowed in the input. Useful when entering decimals.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#isnumberkey}
 * @example
 * onkeypress="return isNumberKey(event)"
 */
var isNumberKey = (event, with_dots = 1) => {
    let accepted_keys = (with_dots === 1) ? /[\d\b\\.]/ : /\d\b/;
    if (!event.key.toString().match(accepted_keys) && event.keyCode !== 8 && event.keyCode !== 9) {
        event.preventDefault();
    }
}

/**
 * Execute a user-defined function.
 * @param {string} func - The function to execute, with or without parameters.
 * @return {void}
 */
var callUserFunction = (func) => {
    if (func !== '' && func !== undefined) eval(func);
};

/**
 * Serialize a form into key/value pairs for ajax submission.
 * @param {string} form - The form to serialize.
 * @return {object} The serialized object.
 * @see {@link https://bladewindui.com/extra/helper-functions#serialize}
 */
var serialize = (form) => {
    let data = new FormData(domEl(form));
    let obj = {};
    for (let [key, value] of data) {
        /***
         ** in some cases the form field name and api parameter differ, and you want to
         ** display a more meaningful error message from Laravels $errors.. set an attr
         ** data-serialize-as on the form field. that value will be used instead of [key]
         ** example: input name="contact_name" data-serialize-as="contact_person"
         ** Laravel will display contact name field is required but contact_person : value
         ** will be sent to the API
         **/
        let this_element = document.getElementsByName(key);
        let serialize_as = this_element[0].getAttribute('data-serialize-as');
        obj[serialize_as ?? key] = value;
    }
    return obj;
}

/**
 * Check if string contains a keyword.
 * @param {string} str - The string to check for keyword existence.
 * @param {string} keyword - The keyword to check for.
 * @return {boolean} True if string contains keyword. False if it does not.
 * @see {@link https://bladewindui.com/extra/helper-functions#stringcontains}
 */
var stringContains = (str, keyword) => {
    if (typeof (str) !== 'string') return false;
    return (str.indexOf(keyword) !== -1);
}

var doNothing = () => {
}

/**
 * Modify the css for DOM elements of the same type.
 * @param {string} elements - The class name of ID of the DOM elements to modify.
 * @param {string} css - Comma separated list of css classes to apply to <elements>.
 * @param {string} mode - Add|Remove. Determines if <css> should be added or removed from <elements>.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#changecssfordomarray}
 */
var changeCssForDomArray = (elements, css, mode = 'add') => {
    if (domEls(elements).length > 0) {
        domEls(elements).forEach((el) => {
            changeCss(el, css, mode, true);
        });
    }
}

/**
 * Modify the css for a DOM element.
 * @param {boolean|Element} element - The class name of ID of the DOM element to modify.
 * @param {string} css - Comma separated list of css classes to apply to <element>.
 * @param {string} mode - Add|Remove. Determines if <css> should be added or removed from <element>.
 * @param {boolean} elemntIsDomObject - If true, <element> will not be treated as a string but DOM element.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#changecss}
 * @example
 * changeCss('.email', 'border-2, border-red-500');
 * changeCss('.email', 'border-2, border-red-500', 'remove');
 * changeCss(domEl('.email'), 'border-2, border-red-500', 'remove', true);
 */
var changeCss = (element, css, mode = 'add', elementIsDomObject = false) => {
    // css can be comma separated
    // if !elementIsDomObject run it through domEl
    if (!elementIsDomObject) element = domEl(element);
    if (element) {
        if (css.indexOf(',') !== -1 || css.indexOf(' ') !== -1) {
            css = css.replace(/\s+/g, '').split(',');
            for (let classname of css) {
                (mode === 'add') ? element.classList.add(classname.trim()) : element.classList.remove(classname.trim());
            }
        } else {
            if (element.classList !== undefined) {
                (mode === 'add') ? element.classList.add(css) : element.classList.remove(css);
            }
        }
    }
}

/**
 * Display a modal.
 * @param {string} element - The css class (name) of the modal.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#showmodal}
 */
var showModal = (element) => {
    unhide(`.bw-${element}-modal`);
    document.body.classList.add('overflow-hidden');
    domEl(`.bw-${element}-modal`).focus();
    let current_index = (current_modal.length === 0) ? 0 : current_modal.length + 1;
    animateCSS(`.bw-${element}`, 'zoomIn').then(() => {
        current_modal[current_index] = element;
    });
}

/**
 * Hide a modal.
 * @param {string} element - The css class (name) of the modal.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#hidemodal}
 */
var hideModal = (element) => {
    animateCSS(`.bw-${element}`, 'zoomOut').then(() => {
        hide(`.bw-${element}-modal`);
        current_modal.pop();
        document.body.classList.remove('overflow-hidden');
        domEl(`.bw-${element}-modal`).removeEventListener('keydown', trapFocusInModal);
    });
}

/**
 * Display the spinning icon on a button.
 * @param {string} element - The css class (name) of the button.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#showbuttonspinner}
 */
var showButtonSpinner = (element) => {
    unhide(`${element} .bw-spinner`);
}

/**
 * Hide the spinning icon on a button.
 * @param {string} element - The css class (name) of the button.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#hidebuttonspinner}
 */
var hideButtonSpinner = (element) => {
    hide(`${element} .bw-spinner`);
}

/**
 * Show the action buttons on a modal.
 * @param {string} element - The css class (name) of the modal.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#showmodalactionbuttons}
 */
var showModalActionButtons = (element) => {
    unhide(`.bw-${element} .modal-footer`);
}

/**
 * Hide the action buttons on a modal.
 * @param {string} element - The css class (name) of the modal.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#hidemodalactionbuttons}
 */
var hideModalActionButtons = (element) => {
    hide(`.bw-${element} .modal-footer`);
}

/**
 * Hide an element.
 * @param {Element} element - The css class (name) of the element to hide.
 * @param {boolean} elementIsDomObject - If true, <element> will not be treated as a string but DOM element.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#hide}
 */
var hide = (element, elementIsDomObject = false) => {
    if ((!elementIsDomObject && domEl(element) != null) || (elementIsDomObject && element != null)) {
        changeCss(element, 'hidden', 'add', elementIsDomObject);
    }
}

/**
 * Display an element.
 * @param {Element} element - The css class (name) of the element to hide.
 * @param {boolean} elementIsDomObject - If true, <element> will not be treated as a string but DOM element.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#unhide}
 */
var unhide = (element, elementIsDomObject = false) => {
    if ((!elementIsDomObject && domEl(element) != null) || (elementIsDomObject && element != null)) {
        changeCss(element, 'hidden', 'remove', elementIsDomObject);
    }
}

/**
 * Alias for unhide().
 * @see {@link https://bladewindui.com/extra/helper-functions#show}
 */
var show = (element, elementIsDomObject = false) => {
    unhide(element, elementIsDomObject);
}

/**
 * Animate an element.
 * @param {string} element - The css class (name) of the element to animate.
 * @param {string} animation - The css animation class to be applied.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#animatecss}
 */
var animateCSS = (element, animation) =>
    new Promise((resolve, reject) => {
        const animationName = `animate__${animation}`;
        const node = document.querySelector(element);
        node.classList.remove('hidden');
        node.classList.add('animate__animated', animationName);
        document.documentElement.style.setProperty('--animate-duration', '.5s');

        function handleAnimationEnd(event) {
            node.classList.remove('animate__animated', animationName);
            event.stopPropagation();
            resolve('Animation ended');
        }

        node.addEventListener('animationend', handleAnimationEnd, {once: true});
    });

/**
 * Add a key/value pair to client's storage.
 * @param {string} key - The key.
 * @param {string} val - The value corresponding to key.
 * @param {string} storageType - The storage key/val should be added to. sessionStorage | localStorage.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#addtostorage}
 */
var addToStorage = (key, val, storageType = 'localStorage') => {
    if (window.localStorage || window.sessionStorage) {
        (storageType === 'localStorage') ?
            localStorage.setItem(key, val) : sessionStorage.setItem(key, val);
    }
}

/**
 * Retrieve a value from client's storage based on its key.
 * @param {string} key - The key.
 * @param {string} storageType - The storage to retrieve value from. sessionStorage | localStorage.
 * @return {string} The value of <key>
 * @see {@link https://bladewindui.com/extra/helper-functions#getfromstorage}
 */
var getFromStorage = (key, storageType = 'localStorage') => {
    if (window.localStorage || window.sessionStorage) {
        return (storageType === 'localStorage') ?
            localStorage.getItem(key) : sessionStorage.getItem(key);
    }
}
/**
 * Delete a key/value pair from client's storage.
 * @param {string} key - The key.
 * @param {string} storageType - The storage to remove key/val from. sessionStorage | localStorage.
 * @return {void}
 * @see {@link https://bladewindui.com/extra/helper-functions#removefromstorage}
 */
var removeFromStorage = (key, storageType = 'localStorage') => {
    if (window.localStorage || window.sessionStorage) {
        (storageType === 'localStorage') ?
            localStorage.removeItem(key) : sessionStorage.removeItem(key);
    }
}

/**
 * Navigate to a tab.
 * @param {string} element - The css class (name) of the tab to navigate to.
 * @param {string} colour - The colour of the tab.
 * @param {string} context - The context within which to find <element>. More like a parent element.
 * @return {(void|boolean)}
 */
var goToTab = (element, colour, context) => {
    let context_ = context.replace(/-/g, '_');
    let tab_content = domEl('.bw-tc-' + element);
    if (tab_content === null) {
        alert('no matching x-bladewind.tab-content div found for this tab');
        return false;
    }

    changeCssForDomArray(`.${context}-headings li.atab span`, `${colour}, is-active`, 'remove');
    changeCssForDomArray(`.${context}-headings li.atab span`, 'is-inactive');
    changeCss(`.atab-${element} span`, 'is-inactive', 'remove');
    changeCss(`.atab-${element} span`, `is-active, ${colour}`);
    domEls(`.${context_}-tab-contents > div.atab-content`).forEach((element) => {
        hide(element, true);
    });
    unhide(tab_content, true);
}

/**
 * Position a prefix in an input field.
 * @param {string} element - The css class (name) of the input field.
 * @param {string} mode - Event to trigger the positioning.
 * @return {void}
 */
var positionPrefix = (element, mode = 'blur') => {
    let transparency = domEl(`.dv-${element} .prefix`).getAttribute('data-transparency');
    let offset = (transparency === '1') ? -5 : 7;
    let prefix_width = ((getPrefixSuffixOffsetWidth(`.dv-${element} .prefix`)) + offset) * 1;
    let default_label_left_pos = '0.875rem';
    let input_field = domEl(`input.${element}`);
    let label_field = domEl(`.dv-${element} label`);

    if (mode === 'blur') {
        if (label_field) {
            label_field.style.left = (input_field.value === '') ? `${prefix_width}px` : default_label_left_pos;
        }
        domEl(`input.${element}`).style.paddingLeft = `${prefix_width}px`;
        input_field.addEventListener('focus', (event) => {
            positionPrefix(element, event.type);
            // for backward compatibility where {once:true} is not supported
            input_field.removeEventListener('focus', positionPrefix);
        }, {once: true});
    } else if (mode === 'focus') {
        if (label_field) label_field.style.left = default_label_left_pos;
        input_field.addEventListener('blur', (event) => {
            positionPrefix(element, event.type);
            // for backward compatibility where {once:true} is not supported
            input_field.removeEventListener('blur', positionPrefix);
        }, {once: true});
    }
}


/**
 * Get the offsetWidth of a prefix/suffix label
 * @param {string} element - The css class (name) of the prefix/suffix field.
 * @return {int}
 */
var getPrefixSuffixOffsetWidth = (element) => {
    let ps_element = domEl(element);
    const clone = ps_element.cloneNode(true);
    clone.style.visibility = 'hidden';
    clone.style.position = 'absolute';
    clone.style.display = 'block';
    document.body.appendChild(clone);
    let offsetWidth = clone.offsetWidth;
    document.body.removeChild(clone);
    return offsetWidth;
}

/**
 * Position a suffix in an input field.
 * @param {string} element - The css class (name) of the input field.
 * @param {string} mode - Event to trigger the positioning.
 * @return {void}
 */
var positionSuffix = (element) => {
    let transparency = domEl(`.dv-${element} .suffix`).getAttribute('data-transparency');
    let offset = (transparency === '1') ? -5 : 7;
    let suffix_width = ((getPrefixSuffixOffsetWidth(`.dv-${element} .suffix`)) + offset) * 1;
    domEl(`input.${element}`).style.paddingRight = `${suffix_width}px`;
}

/**
 * Show or hide password in a password input fiield.
 * @param {string} element - The css class (name) of the input field.
 * @param {string} mode - Show or hide.
 * @return {void}
 */
var togglePassword = (element, mode) => {
    let input_field = domEl(`input.${element}`);
    if (mode === 'show') {
        input_field.setAttribute('type', 'text');
        unhide(`.dv-${element} .suffix svg.hide-pwd`);
        hide(`.dv-${element} .suffix svg.show-pwd`);
    } else {
        input_field.setAttribute('type', 'password')
        unhide(`.dv-${element} .suffix svg.show-pwd`);
        hide(`.dv-${element} .suffix svg.hide-pwd`);
    }
}

/**
 * Filter a table based on keyword.
 * @param {string} keyword - The keyword to filter table by.
 * @param {string} table - The css class (name) of the table to filter.
 * @return {void}
 */
var filterTable = (keyword, table) => {
    domEls(`${table} tbody tr`).forEach((tr) => {
        (tr.innerText.toLowerCase().includes(keyword.toLowerCase())) ?
            unhide(tr, true) : hide(tr, true);
    });
}

/**
 * Select a tag.
 * @param {string} value - The value or uuid to pass when tag is selected.
 * @param {string} name - The name of the tag.
 * @return {void}
 */
var selectTag = (value, name) => {
    let input = domEl(`input[name="${name}"]`);
    let max_selection = input.getAttribute('data-max-selection');
    let tag = domEl(`.bw-${name}-${value}`);
    let css = tag.getAttribute('class');
    if (input.value.includes(value)) { // remove
        let keyword = `(,?)${value}`;
        input.value = input.value.replace(input.value.match(keyword)[0], '');
        changeCss(tag, css.match(/bg-[\w]+-500/)[0], 'remove', true);
        changeCss(tag, (css.match(/bg-[\w]+-500/)[0]).replace('500', '200/80'), 'add', true);
        changeCss(tag, css.match(/text-[\w]+-50/)[0], 'remove', true);
        changeCss(tag, (css.match(/text-[\w]+-50/)[0]).replace('50', '600'), 'add', true);
    } else { // add
        let total_selected = (input.value === '') ? 0 : input.value.split(',').length;
        if (total_selected < max_selection) {
            input.value += `,${value}`;
            changeCss(tag, css.match(/bg-[\w]+-200\/80/)[0], 'remove', true);
            changeCss(tag, (css.match(/bg-[\w]+-200\/80/)[0]).replace('200/80', '500'), 'add', true);
            changeCss(tag, css.match(/text-[\w]+-600/)[0], 'remove', true);
            changeCss(tag, (css.match(/text-[\w]+-600/)[0]).replace('600', '50'), 'add', true);
        } else {
            showNotification(input.getAttribute('data-error-heading'), input.getAttribute('data-error-message'), 'error');
        }
    }
    stripComma(input)
}

/**
 * Remove trailing comma from string.
 * @param {string} element - The input field to remove trailing comma from.
 * @return {void}
 */
var stripComma = (element) => {
    if (element.value.startsWith(',')) {
        element.value = element.value.replace(/^,/, '');
    }
    const event = new Event('change', {
        bubbles: true,
        cancelable: true
    });
    element.dispatchEvent(event);
}

/**
 * Highlight selected tags.
 * @param {string} values - Comma separated list of values corresponding to tags to highlight.
 * @param {string} name - The name of the tags.
 * @return {void}
 */
var highlightSelectedTags = (values, name) => {
    if (values !== '') {
        let values_array = values.split(',');
        for (let x = 0; x < values_array.length; x++) {
            selectTag(values_array[x].trim(), name);
        }
    }
}

/**
 * Compare two dates and display an error if second date is less than first date.
 * This is used in the range Datepicker component to ensure dates make sense.
 * @param {string} element1 - The first date input field.
 * @param {string} element2 - The second date input field.
 * @param {string} message - Error message to display if validation fails.
 * @param {boolean} inline - Display error inline or in a notification component.
 * @return {boolean} True if date 2 is greater than date 1.
 * @see {@link https://bladewindui.com/extra/helper-functions#comparedates}
 */
var compareDates = (element1, element2, message, inline) => {
    let date1_el = domEl(`.${element1}`);
    let date2_el = domEl(`.${element2}`);

    setTimeout(() => {
        let start_date = new Date(date1_el.value).getTime();
        let end_date = new Date(date2_el.value).getTime();

        if (start_date !== '' && end_date !== '') {
            if (start_date > end_date) {
                changeCss(date2_el, '!border-red-400', 'add', true);
                (inline !== 1) ? showNotification('', message, 'error') : domEl(`.error-${element1}${element2}`).innerHTML = message;
                return false;
            } else {
                changeCss(date2_el, '!border-red-400', 'remove', true);
                return true;
            }
        }
    }, 100);
}


/**
 * Trap focus within an open modal to prevent scrolling behind the modal.
 * @param {Event} event - The event object.
 * @return {void}
 */
var trapFocusInModal = (event) => {
    let modal_name = current_modal[(current_modal.length - 1)];
    if (modal_name !== undefined) {
        const focusableElements = domEls(`.bw-${modal_name}-modal input:not([type='hidden']):not([class*='hidden']), .bw-${modal_name}-modal button:not([class*="hidden"]),  .bw-${modal_name}-modal a:not([class*="hidden"])`);
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        if (event.key === 'Tab') {
            if (event.shiftKey && document.activeElement === firstElement) {
                event.preventDefault();
                lastElement.focus();
            } else if (!event.shiftKey && document.activeElement === lastElement) {
                event.preventDefault();
                firstElement.focus();
            }
        }
    }
}

/**
 * Validate for mininum and maximum values of an input field
 * @param {number} min - The minimum value.
 * @param {number} max - The maximum value.
 * @param {string} element - The input field to validate.
 * @return {void}
 */
var checkMinMax = (min, max, element) => {
    let field = domEl(`.${element}`);
    let minimum = parseInt(min);
    let maximum = parseInt(max);
    let error_message = field.getAttribute('data-error-message');
    let show_error_inline = field.getAttribute('data-error-inline');
    let error_heading = field.getAttribute('data-error-heading');

    if (field.value !== '' && ((!isNaN(minimum) && field.value < minimum) || (!isNaN(maximum) && field.value > maximum))) {
        changeCss(field, '!border-red-400', 'add', true);
        if (error_message) {
            (show_error_inline) ? unhide(`.${el_name}-inline-error`) :
                showNotification(error_heading, error_message, 'error');
        }
    } else {
        if (error_message) hide(`.${el_name}-inline-error`);
        changeCss(field, '!border-red-400', 'remove', true);
    }
}

/**
 * Display a clear button in an input field that has text.
 * @param {string} element - The css class (name) of the input field.
 * @return {void}
 */
var makeClearable = (element) => {
    let field = domEl(`.${element}`);
    let suffix_element = domEl(`.${element}-suffix svg`);
    let table_element = element.replace('bw_search_', 'table.').replace('_', '-');
    let clearing_function = (domEl(table_element)) ? ` filterTable('',\'${table_element}\')` : '';
    if (!suffix_element.getAttribute('onclick')) {
        suffix_element.setAttribute('onclick', `domEl(\'.${element}\').value=''; hide(this, true); ${clearing_function}`);
    }
    (field.value !== '') ? unhide(suffix_element, true) : hide(suffix_element, true);
}

/**
 * Convert a selected file to base64.
 * @param {string} file - Url of selected file.
 * @param {string} element - The input field to write the base64 string to.
 * @return {void}
 */
var convertToBase64 = (file, element) => {
    const reader = new FileReader();
    reader.onloadend = () => {
        const base64String = reader.result;//.replace('data:', '').replace(/^.+,/, '');
        domEl(element).value = base64String;
    };
    reader.readAsDataURL(file);
}

/**
 * Check if selected file size falls within allowed file size.
 * @param {number} file_size - The selected file size.
 * @param {number} max_size - THe maximum file size.
 * @return {boolean} True if <file_size> if less than <max_size>
 */
var allowedFileSize = (file_size, max_size) => {
    return (file_size <= max_size * 1000000);
}

/**
 * Set the value of a datepicker
 * @return {void}
 * @param {string} el_name - name of the input field to update
 * @param {string} date - new value to set
 */
var setDatepickerValue = (el_name, date) => {
    let newValue = date;
    let input = domEl(`.${el_name}`);
    if (!input) {
        console.error(`No datepicker found with the name ${el_name}`);
        return;
    }
    // let alpineComponent = document.querySelector('[x-data]').__x.$data;
    if (!input._x_model) {
        console.error(`Alpine.js component not found for element ${el_name}`);
        return;
    }
    input._x_model.set(date);
    // input.dispatchEvent(new Event('input', {bubbles: true}));
}
