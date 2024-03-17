@props([
    // name of the input field for use in forms
    'name' => 'pin-code-'.uniqid(),

    // total number of boxes to display
    'total_digits' => 4,
    'totalDigits' => 4,

    /*
    what function should be called when the user is done entering the verification code.
    this should just be the function name without parenthesis and parameters.
    example: verifyPin ... when the user is done entering the code Bladewind will call verifyPin(code)
    note that the code is passed to your function as the only parameter so you need to expect a parameter
    when defining your function... using the above example: verifyPin = (pin_code) => {}
    */
    'on_verify' => null,
    'onVerify' => null,

    // error message to display when pin is wrong
    'error_message' => 'You entered a wrong code',
    'errorMessage' => 'You entered a wrong code',

    // should input text be masked to hide code
    'mask' => false,

    // after how many seconds should the link to resend a code be displayed
    'timer' => null,
])
@php
    // reset variables for Laravel 8 support
    $total_digits = $totalDigits;
    $error_message = $errorMessage;
    //--------------------------------------------------------------------

    $name = preg_replace('/[\s-]/', '_', $name);
    $mask = filter_var($mask, FILTER_VALIDATE_BOOLEAN);
@endphp

<div class="dv-{{ $name }} relative">
    <div class="flex {{ $name }}-boxes">
        <div class="flex space-x-3 mx-auto">
            @for ($x = 0; $x < $total_digits; $x++)
                <x-bladewind::input
                        numeric="true"
                        type="{{ ($mask) ? 'password' : 'text' }}"
                        with_dots="false"
                        add_clearing="false"
                        onkeydown="hidePinError('{{ $name }}')"
                        onkeyup="movePinNext('{{ $name }}', {{ $x }}, {{ $total_digits }}, '{{ $on_verify }}', event)"
                        class="w-14 shadow-sm text-center text-xl font-light text-black dark:text-white focus:!border-primary-600 {{ $name }}-pin-code {{ $name }}-pcode{{ $x }}"
                        maxlength="1"
                />
            @endfor
        </div>
    </div>
    <div class="text-center text-sm text-error-500 my-6 hidden bw-{{ $name }}-pin-error">
        {!! $error_message !!}
    </div>
    <div class="text-center tracking-wider text-sm my-6 bw-{{ $name }}-pin-timer">
        <div class="countdown hidden"><span class="minutes"></span>:<span class="seconds"></span></div>
        <div class="done"></div>
    </div>
    <div class="bg-transparent absolute w-full text-center hidden top-0 py-5 bw-{{ $name }}-pin-spinner">
        <x-bladewind::spinner/>
    </div>
    <div class="bg-transparent hidden w-full text-center absolute top-0 py-3.5 bw-{{ $name }}-pin-valid">
        <x-bladewind::icon name="check-circle" type="solid" class="!h-9 !w-9 text-green-500 mx-auto"/>
    </div>
    <div class="bg-transparent hidden w-full absolute top-0 h-16 bw-{{ $name }}-pin-cloak"></div>
</div>
<x-bladewind::input type="hidden" name="{{ $name }}"/>

<script>
    var movePinNext = (name, index, total_digits, user_function, evt) => {
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

        (index < total_digits) ? dom_el(`.${name}-pcode${index}`).focus() : setPin(name, user_function);
    }

    var setPin = (name, user_function) => {
        dom_el(`.${name}`).value = '';
        dom_els(`.${name}-pin-code`).forEach((el) => {
            dom_el(`.${name}`).value += el.value;
        });
        let pin_code = dom_el(`.${name}`).value;
        (user_function) ? callUserFunction(`${user_function}('${pin_code}','${name}')`) : doNothing();
    }

    var clearPin = (name) => {
        dom_els(`.${name}-pin-code`).forEach((el) => {
            el.value = '';
        });
        dom_el(`.${name}-pcode0`).focus();
    }

    var showPinError = (name, autoHide = true) => {
        unhide(`.bw-${name}-pin-error`);
        if (autoHide) setTimeout(() => {
            hidePinError(name);
        }, 10000);
    }

    var hidePinError = (name) => {
        hide(`.bw-${name}-pin-error`);
    }

    var showSpinner = (name) => {
        hide(`.bw-${name}-pin-valid`);
        unhide(`.bw-${name}-pin-spinner`);
        dom_el(`.${name}-pcode0`).focus();
        dom_el(`.${name}-pcode0`).blur();
    }

    var hideSpinner = (name) => {
        hide(`.bw-${name}-pin-spinner`);
    }

    var showPinSuccess = (name) => {
        hide(`.bw-${name}-pin-spinner`);
        unhide(`.bw-${name}-pin-valid`);
        loseFocus(name);
    }

    var loseFocus = (name) => {
        dom_el(`.${name}-pcode0`).focus();
        dom_el(`.${name}-pcode0`).blur();
    }

    var setFocus = (name) => {
        dom_el(`.${name}-pcode0`).focus();
    }

    var disablePin = (name) => {
        loseFocus(name);
        unhide(`.bw-${name}-pin-cloak`);
    }

    var enablePin = (name) => {
        hide(`.bw-${name}-pin-cloak`);
        setFocus(name);
    }

    var bw_timer_interval;
    var showTimer = (name, duration = 60) => {
        let minutes_ = Math.floor(duration / 60);
        let seconds_ = (duration % 60);
        let countdown_div = dom_el(`.bw-${name}-pin-timer .countdown`);
        let minutes_span = dom_el(`.bw-${name}-pin-timer .minutes`);
        let seconds_span = dom_el(`.bw-${name}-pin-timer .seconds`);
        let done_div = dom_el(`.bw-${name}-pin-timer .done`);
        unhide(`.bw-${name}-pin-timer .countdown`);
        disablePin(name);
        countdown({
            name: name,
            minutes: minutes_,
            seconds: seconds_,
            countdownDiv: countdown_div,
            minutesSpan: minutes_span,
            secondsSpan: seconds_span,
            doneDiv: done_div,
        });
    }

    var countdown = (options = {}) => {
        let name = options.name;
        options.minutesSpan.innerHTML = options.minutes;
        options.secondsSpan.innerHTML = options.seconds;
        options.doneDiv.innerHTML = '';
        unhide(options.countdownDiv, true);

        bw_timer_interval = setInterval(() => {
            if (options.seconds !== 0) {
                options.seconds--;
                options.secondsSpan.innerHTML = (options.seconds < 10) ? `0${options.seconds}` : options.seconds;
            } else {
                if (options.minutes !== 0) {
                    options.minutes--;
                    options.seconds = 60;
                    options.minutesSpan.innerHTML = options.minutes;
                } else {
                    clearInterval(bw_timer_interval);
                    options.secondsSpan.innerHTML = options.minutesSpan.innerHTML = '';
                    if (dom_el('.bw-code-timer-done')) {
                        hide(options.countdownDiv, true);
                        options.doneDiv.innerHTML = dom_el('.bw-code-timer-done').innerHTML;
                        enablePin(name);
                    }
                }
            }
        }, 1000);
    }

    @if(is_numeric($timer)) showTimer('{{$name}}', {{$timer}}); @endif

</script>
