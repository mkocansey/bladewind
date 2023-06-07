/**  
** helper functions for BladeWind UI components using vanilla JS
** September 2021 by @mkocansey <@mkocansey>
**/
var     notification_timeout,
        user_function, 
        el_name;
var     dropdownIsOpen = false;

domEl = (element) => { return dom_el(element); }
dom_el = (element) => { return (document.querySelector(element) != null) ? document.querySelector(element) : false;  }

domEls = (element) => { return dom_els(element); }
dom_els = (element) => { return (document.querySelectorAll(element).length>0) ? document.querySelectorAll(element) : false;  }

validateForm = (form) => {
    let has_error = 0;
    let BreakException = {};
    try{
        dom_els(`${form} .required`).forEach((el) => {
            el.classList.remove('!border-red-400');
            if ( el.value === '' ) {
                let el_name = el.getAttribute('name');
                let error_message = el.getAttribute('data-error-message');
                let show_error_inline = el.getAttribute('data-error-inline');
                let error_heading = el.getAttribute('data-error-heading');
                el.classList.add('!border-red-400');
                el.focus();
                if(error_message){
                    console.log(show_error_inline);
                    (show_error_inline) ? unhide(`.${el_name}-inline-error`) : 
                    showNotification(error_heading, error_message, 'error');
                }
                el.addEventListener('keyup', () => { 
                    if(el.value !== '') {
                        el.classList.remove('!border-red-400');
                        (show_error_inline) ? hide(`.${el_name}-inline-error`) : '';
                     } else {
                        el.classList.add('!border-red-400'); 
                        (show_error_inline) ? unhide(`.${el_name}-inline-error`) : '';
                     }
                });
                has_error++;
                throw BreakException;
            }
        });
    } catch(e) {}
    return has_error === 0;
}

isNumberKey = (evt, with_dots=1) => {   // usage:  onkeypress="return isNumberKey(event)"
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (with_dots==0 && charCode == 46) return false;
    if (charCode > 31 && (charCode != 46 && (charCode < 48 || charCode > 57))) {
        return false;
    }
    return true;
}

callUserFunction = (func) => { 
    if (func !== '' && func !== undefined) eval(func); 
};

serialize = (form) => {
    let data = new FormData(dom_el(form));
    let obj = {};
    for (let [key, value] of data) {
        /** 
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
    }   return obj;
}

stringContains = (str, keyword) => { 
    if(typeof(str) !== 'string') return false; 
    return (str.indexOf(keyword) != -1); 
}

doNothing = () => { }

changeCssForDomArray = (elements, css, mode='add') => { 
    if(dom_els(elements).length > 0){
        dom_els(elements).forEach((el) => { 
            changeCss(el, css, mode, true);
        });
    }
}

changeCss = (element, css, mode='add', elementIsDomObject=false) => { 
    // css can be comma separated
    // if elementIsDomObject dont run it through dom_el
    if( (! elementIsDomObject && dom_el(element) != null) || (elementIsDomObject && element != null)){
        if(css.indexOf(',') != -1 || css.indexOf(' ') != -1) {
            css = css.replace(/\s+/g, '').split(',');
            for(let classname of css) {
                (mode == 'add') ?
                    ((elementIsDomObject) ? element.classList.add(classname.trim()) : dom_el(element).classList.add(classname.trim())) :
                    ((elementIsDomObject) ? element.classList.remove(classname.trim()) : dom_el(element).classList.remove(classname.trim()));
            }
        } else {
            if( (! elementIsDomObject && dom_el(element).classList != undefined) || (elementIsDomObject && element.classList != undefined)){
                (mode == 'add') ?
                    ((elementIsDomObject) ? element.classList.add(css) : dom_el(element).classList.add(css)) : 
                    ((elementIsDomObject) ? element.classList.remove(css) : dom_el(element).classList.remove(css));
            }
        }
    }
}

showModal = (element) => { unhide(`.bw-${element}-modal`); }

hideModal = (element) => { hide(`.bw-${element}-modal`); }

showButtonSpinner = (element) => { unhide(`${element} .bw-spinner`); }

hideButtonSpinner = (element) => { hide(`${element} .bw-spinner`); }

hide = (element, elementIsDomObject=false) => { 
    if( (! elementIsDomObject && dom_el(element) != null) || (elementIsDomObject && element != null)){
        changeCss(element, 'hidden', 'add', elementIsDomObject); 
    }
}

unhide = (element, elementIsDomObject=false) => { 
    if( (! elementIsDomObject && dom_el(element) != null) || (elementIsDomObject && element != null)){ 
        changeCss(element, 'hidden', 'remove', elementIsDomObject); 
    }
}

animateCSS = (element, animation) => 
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

addToStorage = (key, val, storageType = 'localStorage') => {
    if(window.localStorage || window.sessionStorage){
    (storageType === 'localStorage') ? 
        localStorage.setItem(key, val) : sessionStorage.setItem(key, val);
    }
}

getFromStorage = (key, storageType = 'localStorage') => {
    if(window.localStorage || window.sessionStorage){
    return (storageType === 'localStorage') ? 
        localStorage.getItem(key) : sessionStorage.getItem(key);
    }
}

removeFromStorage = (key, storageType = 'localStorage') => {
    if(window.localStorage || window.sessionStorage){
    (storageType === 'localStorage') ? 
        localStorage.removeItem(key) : sessionStorage.removeItem(key);
    }
}

goToTab = (el, color, context) => {
    let context_ = context.replace(/-/g, '_');
    let tab_content = dom_el('.bw-tc-'+el);
    if( tab_content === null ) {
        alert('no matching x-bladewind.tab-content div found for this tab');
        return false;
    }
    changeCssForDomArray(
        `.${context}-headings li.atab span`,
        `text-${color}-500,border-${color}-500,hover:text-${color}-500,hover:border-${color}-500`, 
        'remove');
    changeCssForDomArray(
        `.${context}-headings li.atab span`,
        'text-gray-500,border-transparent,hover:text-gray-600,hover:border-gray-300');
    changeCss(
        `.atab-${el} span`, 
        'text-gray-500,border-transparent,hover:text-gray-600,hover:border-gray-300', 'remove');
    changeCss(
        `.atab-${el} span`, 
        `text-${color}-500,border-${color}-500,hover:text-${color}-500,hover:border-${color}-500`);
    
    dom_els(`.${context_}-tab-contents div.atab-content`).forEach((el) => { hide(el, true); });
    unhide(tab_content, true);
  }

  positionPrefix = (el, mode = 'blur') => {
    let transparency = dom_el(`.dv-${el} .prefix`).getAttribute('data-transparency');
    let offset = (transparency == '1') ? -5 : 7;
    let prefix_width = ((dom_el(`.dv-${el} .prefix`).offsetWidth)+offset)*1;
    let default_label_left_pos = '0.875rem';
    let input_field = dom_el(`input.${el}`);
    let label_field = dom_el(`.dv-${el} label`);

    if(mode == 'blur') {
        if(label_field) {
            label_field.style.left = (input_field.value == '') ? `${prefix_width}px` : default_label_left_pos ;
        }
        dom_el(`input.${el}`).style.paddingLeft = `${prefix_width}px`;
        input_field.addEventListener('focus', (event)=>{ positionPrefix(el, event.type) });
    } else if(mode == 'focus') {
        if(label_field) label_field.style.left = default_label_left_pos;
        input_field.addEventListener('blur', (event)=>{ positionPrefix(el, event.type) });
    }
  }

  positionSuffix = (el) => {
    let transparency = dom_el(`.dv-${el} .suffix`).getAttribute('data-transparency');
    let offset = (transparency == '1') ? -5 : 7;
    let suffix_width = ((dom_el(`.dv-${el} .suffix`).offsetWidth)+offset)*1;
    dom_el(`input.${el}`).style.paddingRight = `${suffix_width}px`;
  }

  togglePassword = (el, mode) => {
    let input_field = dom_el(`input.${el}`);
    if (mode == 'show'){
        input_field.setAttribute('type', 'text');
        unhide(`.dv-${el} .suffix svg.hide-pwd`);
        hide(`.dv-${el} .suffix svg.show-pwd`);
    }else {
        input_field.setAttribute('type', 'password')
        unhide(`.dv-${el} .suffix svg.show-pwd`);
        hide(`.dv-${el} .suffix svg.hide-pwd`);
    }
  }