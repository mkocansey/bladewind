/**  
** helper functions for BladeWind UI components using vanilla JS
** September 2021 by @mkocansey <@mkocansey>
**/
var     notification_timeout,
        user_function, 
        el_name,
        momo_obj,
        delete_obj;
var     dropdownIsOpen = false;

dom_el = (element) => { return (document.querySelector(element) != null) ? document.querySelector(element) : false;  }

dom_els = (element) => { return (document.querySelectorAll(element).length>0) ? document.querySelectorAll(element) : false;  }

validateForm = (element) => {
    let has_error = 0;
    let BreakException = {};
    try{
        dom_els(`${element} .required`).forEach((el) => {
            el.classList.remove('!border-red-400');
            if ( el.value === '' ) {
                el.classList.add('!border-red-400');
                el.focus();
                el.addEventListener('keyup', () => { 
                    (el.value !== '') ? el.classList.remove('!border-red-400') : el.classList.add('!border-red-400'); 
                });
                has_error++;
                throw BreakException;
            }
        });
    } catch(e) {}
    return has_error === 0;
}

isNumberKey = (evt) => {   // usage:  onkeypress="return isNumberKey(event)"
    var charCode = (evt.which) ? evt.which : evt.keyCode
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
        let serialize_as = dom_el(form).elements[key].getAttribute('data-serialize-as');
        obj[serialize_as ?? key] = value;
    }   return obj;
}

showMessage = (message, type, dismissable=true) => {
    clearTimeout(notification_timeout);
    let notification_bar = dom_el('.bw-notification');
    let message_container = dom_el('.bw-notification .message-container');
    message_container.classList.remove('bg-red-500', 'bg-green-500', 'bg-blue-600', 'bg-orange-400');
    notification_bar.classList.remove('animate__animated', 'animate__slideOutUp');
    dom_el('.bw-notification .message').innerHTML = message;

    switch (type) {
        case 'error': message_container.classList.add('bg-red-500'); break;
        case 'info': message_container.classList.add('bg-blue-600'); break;
        case 'warning': message_container.classList.add('bg-orange-400'); break;
        default: message_container.classList.add('bg-green-500'); break;
    }

    notification_bar.classList.add('animate__animated', 'animate__slideInDown');
    notification_bar.classList.remove('hidden');

    if ( ! dismissable ){
        dom_el('.notification .cursor-pointer').classList.add('hidden');
    } else {    
        var notification_timeout = setTimeout(() => {
            notification_bar.classList.remove('animate__animated', 'animate__slideInDown');
            notification_bar.classList.add('animate__animated', 'animate__slideOutUp');
        }, 15000);
        dom_el('.notification .cursor-pointer').classList.remove('hidden');
        dom_el('.notification .cursor-pointer').addEventListener('click', function (e){
            clearTimeout(notification_timeout);
            notification_bar.classList.add('animate__animated', 'animate__slideOutUp');
        });
    }
}

displayFormErrors = (errors) => {
    if( errors) {
        let number_of_errors = Object.keys(errors).length;
        if ( number_of_errors > 0 ) {
            let message = errors[Object.keys(errors)[0]][0];
            showMessage(message, 'error');
        }
    }
}

stringContains = (str, keyword) => { 
    if(typeof(str) !== 'string') return false; 
    return (str.indexOf(keyword) != -1); 
}

doNothing = () => { }

changeCssForDomArray = (els, css, mode='add') => { 
    if(dom_els(els).length > 0){
        dom_els(els).forEach((el) => { 
            changeCss(el, css, mode, true);
        });
    }
}

changeCss = (el, css, mode='add', elIsDomObject=false) => { 
    // css can be comma separated
    // if elIsDomObject dont run it through dom_el
    if( (! elIsDomObject && dom_el(el) != null) || (elIsDomObject && el != null)){
        if(css.indexOf(',') != -1 || css.indexOf(' ') != -1) {
            css = css.replace(/\s+/g, '').split(',');
            for(let classname of css) {
                (mode == 'add') ?
                    ((elIsDomObject) ? el.classList.add(classname.trim()) : dom_el(el).classList.add(classname.trim())) :
                    ((elIsDomObject) ? el.classList.remove(classname.trim()) : dom_el(el).classList.remove(classname.trim()));
            }
        } else {
            if( (! elIsDomObject && dom_el(el).classList != undefined) || (elIsDomObject && el.classList != undefined)){
                (mode == 'add') ?
                    ((elIsDomObject) ? el.classList.add(css) : dom_el(el).classList.add(css)) : 
                    ((elIsDomObject) ? el.classList.remove(css) : dom_el(el).classList.remove(css));
            }
        }
    }
}

showModal = (el) => { unhide(`.bw-${el}-modal`); }

hideModal = (el) => { hide(`.bw-${el}-modal`); }

hide = (el, elIsDomObject=false) => { 
    if( (! elIsDomObject && dom_el(el) != null) || (elIsDomObject && el != null)){
        changeCss(el, 'hidden', 'add', elIsDomObject); 
    }
}

unhide = (el, elIsDomObject=false) => { 
    if( (! elIsDomObject && dom_el(el) != null) || (elIsDomObject && el != null)){ 
        changeCss(el, 'hidden', 'remove', elIsDomObject); 
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

  removeCommas = (amount) => {
    return amount.toString().replace(/,/g, '');
  }

  toCurrency = (amount) => {
    return ((parseFloat(amount).toFixed(2))*1).toLocaleString();
  }

  goToTab = (el, color) => {
      let tab_content = dom_el('.bw-tc-'+el);
      if( tab_content === null ) {
          alert('no matching x-bladewind.tab-content div found for this tab');
          return false;
      }
      changeCssForDomArray(
          'li.atab span', 
          `text-${color}-500,border-${color}-500,hover:text-${color}-500,hover:border-${color}-500`, 
          'remove');
      changeCssForDomArray(
          'li.atab span', 
          'text-gray-500,border-transparent,hover:text-gray-600,hover:border-gray-300');
      changeCss(
          `.atab-${el} span`, 
          'text-gray-500,border-transparent,hover:text-gray-600,hover:border-gray-300', 'remove');
      changeCss(
          `.atab-${el} span`, 
          `text-${color}-500,border-${color}-500,hover:text-${color}-500,hover:border-${color}-500`);
      
      dom_els('div.atab-content').forEach((el) => { hide(el, true); });
      unhide(tab_content, true);
  }