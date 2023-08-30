@props([
    // name of the input field for use in forms
    'name' => 'pin-code-'.uniqid(),
    // what type of input box are you displaying
    // availalble options are text, password, email, search, tel
    'total_digits' => 4,
    'totalDigits' => 4,
    // what function should be called when the user is done entering the verification code
    // this should just be the function name without parenthesis and parameters.
    // example: verifyPin ... when the user is done entering the code Bladewind will call verifyPin(code)
    // note that the code is passed to your function as the only parameter so you need to expect a parameter
    // when defining your function... using the above example verifyPin = (pin_code) => {}
    'on_verify' => null,
    'onVerify' => null,
    // error message to display when pin is wrong
    'error_message' => 'Verification code is invalid',
    'errorMessage' => 'Verification code is invalid',
])
@php
    // reset variables for Laravel 8 support
    $total_digits = $totalDigits;
    $error_message = $errorMessage;
    //--------------------------------------------------------------------

    $name = preg_replace('/[\s-]/', '_', $name);
@endphp

<div class="dv-{{ $name }} relative">
    <div class="flex {{ $name }}-boxes">
        <div class="flex space-x-3 mx-auto">
            @for ($x = 0; $x < $total_digits; $x++)
                <x-bladewind::input
                    numeric="true"
                    with_dots="false"
                    add_clearing="false"
                    onkeydown="hidePinError('{{ $name }}')"
                    onkeyup="movePinNext('{{ $name }}', {{ $x }}, {{ $total_digits }}, '{{ $on_verify }}', event)"
                    class="w-14 shadow-sm text-center text-xl font-light text-black dark:text-white {{ $name }}-pin-code {{ $name }}-pcode{{ $x }}"
                    maxlength="1"
                />
            @endfor
        </div>
    </div>
    <div class="bw-{{ $name }}-pin-error text-center text-sm text-red-500 my-6 hidden">
        {!! $error_message !!}
    </div>
    <div class="bg-white/10 absolute w-full text-center hidden top-0 py-4 bw-{{ $name }}-pin-spinner">
        <x-bladewind::spinner/>
    </div>
    <div class="bg-white/10 absolute w-full text-center hidden top-0 py-1 bw-{{ $name }}-pin-valid">
        <x-bladewind::icon name="check-circle" type="solid" class="h-10 w-10 text-green-500 mx-auto" />
    </div>
</div>
<x-bladewind::input type="hidden" name="{{ $name }}"/>

<script>
    movePinNext = (name , index , total_digits , user_function , evt) => {
        if (evt.key === 'Backspace') {
            if (index > 0) {
                dom_el(`.${name}-pcode${index}`).value = '';
                index--;
            }
        } else {
            if (dom_el(`.${name}-pcode${index}`).value) {
                index++
            }
        }

        (index < total_digits) ? dom_el(`.${name}-pcode${index}`).focus() : setPin(name , user_function);
    }

    setPin = (name , user_function) => {
        dom_el(`.${name}`).value = '';
        dom_els(`.${name}-pin-code`).forEach((el) => {
            dom_el(`.${name}`).value += el.value;
        });
        let pin_code = dom_el(`.${name}`).value;
        (user_function) ? callUserFunction(`${user_function}('${pin_code}')`) : doNothing();
    }

    clearPin = (name) => {
        dom_els(`.${name}-pin-code`).forEach((el) => {
            el.value = '';
        });
        dom_el(`.${name}-pcode0`).focus();
    }

    showPinError = (name) => {
        unhide(`.bw-${name}-pin-error`);
    }

    hidePinError = (name) => {
        hide(`.bw-${name}-pin-error`);
    }

    showSpinner = (name) => {
        hide(`.bw-${name}-pin-valid`);
        unhide(`.bw-${name}-pin-spinner`);
        dom_el(`.${name}-pcode0`).focus();
        dom_el(`.${name}-pcode0`).blur();
    }

    hideSpinner = (name) => {
        hide(`.bw-${name}-pin-spinner`);
    }

    showPinSuccess = (name) => {
        hide(`.bw-${name}-pin-spinner`);
        unhide(`.bw-${name}-pin-valid`);
        dom_el(`.${name}-pcode0`).focus();
        dom_el(`.${name}-pcode0`).blur();
        //changeCss(`.${name}-boxes`, '');
    }

    setFocus = (name) => {
        dom_el(`.${$name}-pcode0`).focus();
    }
</script>
