/*!
 * BladewindUI input masking.
 * A small vanilla-JS port of the Alpine.js mask plugin (https://alpinejs.dev/plugins/mask).
 *
 * Wildcards inside a mask template:
 *   9  -> any digit        (0-9)
 *   a  -> any letter       (a-z, A-Z)
 *   *  -> any alphanumeric  (a-z, A-Z, 0-9)
 * Every other character in the template is treated as a literal and inserted automatically.
 */
(function () {
    if (typeof window.BladewindMask !== 'undefined') return;

    const wildcards = { '9': /[0-9]/, 'a': /[a-zA-Z]/, '*': /[a-zA-Z0-9]/ };
    const isWild = (c) => c === '9' || c === 'a' || c === '*';
    const isDigit = (c) => c >= '0' && c <= '9';

    // Reduce a raw value down to just the "data" characters that fill the
    // template's wildcard slots — dropping any literals and stray characters.
    function stripDown(template, input) {
        let remaining = Array.from(input);

        // remove one occurrence of each literal template character
        for (let i = 0; i < template.length; i++) {
            if (isWild(template[i])) continue;
            const idx = remaining.indexOf(template[i]);
            if (idx > -1) remaining.splice(idx, 1);
        }

        // keep only characters that satisfy the wildcard slots, in order
        const slots = Array.from(template).filter(isWild);
        let out = '';
        for (const slot of slots) {
            const idx = remaining.findIndex((ch) => wildcards[slot].test(ch));
            if (idx === -1) break;
            out += remaining[idx];
            remaining.splice(idx, 1);
        }
        return out;
    }

    // Re-insert the literals around the stripped data characters.
    function buildUp(template, data) {
        const chars = Array.from(data);
        let out = '';
        for (let i = 0; i < template.length; i++) {
            if (!isWild(template[i])) { out += template[i]; continue; }
            if (chars.length === 0) break;
            out += chars.shift();
        }
        return out;
    }

    function formatWithTemplate(input, template) {
        if (input === '' || !template) return input;
        return buildUp(template, stripDown(template, input));
    }

    // Money formatting, mirroring Alpine's $money helper.
    function formatMoney(input, decimal = '.', thousands = ',', precision = 2) {
        if (input === '') return '';
        precision = parseInt(precision, 10);
        if (isNaN(precision)) precision = 2;

        const negative = input.trim().charAt(0) === '-' ? '-' : '';
        const escDec = decimal.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');

        // keep digits and the decimal separator only
        const cleaned = input.replace(new RegExp('[^0-9' + escDec + ']', 'g'), '');
        const firstDec = cleaned.indexOf(decimal);

        let intPart, decPart = null;
        if (firstDec === -1) {
            intPart = cleaned;
        } else {
            intPart = cleaned.slice(0, firstDec);
            decPart = cleaned.slice(firstDec + decimal.length).replace(new RegExp(escDec, 'g'), '');
        }

        intPart = intPart.replace(/^0+(?=\d)/, '');           // trim leading zeros, keep one
        if (intPart === '' && decPart !== null) intPart = '0'; // typing ".5" -> "0.5"

        const grouped = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousands);
        let result = negative + grouped;
        if (decPart !== null && precision > 0) {
            result += decimal + decPart.slice(0, precision);
        }
        return result;
    }

    // Place the caret after the Nth data character in a template-formatted value.
    function templateCaret(template, value, dataBefore) {
        if (dataBefore <= 0) return 0;
        let seen = 0, i = 0;
        for (; i < value.length; i++) {
            if (isWild(template[i])) {
                seen++;
                if (seen === dataBefore) { i++; break; }
            }
        }
        while (i < value.length && !isWild(template[i])) i++; // sit before the next slot
        return i;
    }

    // Place the caret after the Nth digit in a money-formatted value.
    function moneyCaret(value, digitsBefore) {
        if (digitsBefore <= 0) return 0;
        let seen = 0, i = 0;
        for (; i < value.length; i++) {
            if (isDigit(value[i])) {
                seen++;
                if (seen === digitsBefore) { i++; break; }
            }
        }
        return i;
    }

    // Built-in dynamic masks, usable by name e.g. dynamicMask="creditCard".
    // A global function of the same name (window.creditCard) takes precedence,
    // so projects can still override or add their own.
    const dynamicMasks = {
        creditCard(input) {
            const digits = (input || '').replace(/\D/g, '');
            if (/^3[47]/.test(digits)) return '9999 999999 99999';      // American Express (15)
            if (/^3(0[0-5]|[68])/.test(digits)) return '9999 999999 9999'; // Diners Club (14)
            return '9999 9999 9999 9999';                                // Visa, Mastercard, Discover… (16)
        },
    };

    function isMoney(el) { return el.dataset.maskMoney === 'true'; }

    function moneyOptions(el) {
        return [
            el.dataset.maskDecimal || '.',
            el.dataset.maskThousands || ',',
            el.dataset.maskPrecision != null ? el.dataset.maskPrecision : '2',
        ];
    }

    // Resolve the active template for a value (handles static and dynamic masks).
    function templateFor(el, value) {
        if (el.dataset.maskDynamic) {
            const name = el.dataset.maskDynamic;
            const fn = window[name] || dynamicMasks[name]; // project global wins, then built-in
            if (typeof fn === 'function') return fn(value) || '';
            return el.dataset.mask || '';
        }
        return el.dataset.mask || '';
    }

    function setCaret(el, pos) {
        try { el.setSelectionRange(pos, pos); } catch (e) { /* unsupported input type */ }
    }

    function process(el) {
        const oldValue = el.value;
        const start = el.selectionStart ?? oldValue.length;

        let newValue, caret;
        if (isMoney(el)) {
            const [dec, thou, prec] = moneyOptions(el);
            newValue = formatMoney(oldValue, dec, thou, prec);
            const digitsBefore = (oldValue.slice(0, start).match(/[0-9]/g) || []).length;
            caret = moneyCaret(newValue, digitsBefore);
        } else {
            const template = templateFor(el, oldValue);
            if (!template) return;
            newValue = formatWithTemplate(oldValue, template);
            const dataBefore = stripDown(template, oldValue.slice(0, start)).length;
            caret = templateCaret(template, newValue, dataBefore);
        }

        if (newValue !== oldValue) {
            el.value = newValue;
            setCaret(el, caret);
        }
    }

    // Backspacing a literal should remove the data character before it, otherwise
    // the literal is just re-inserted and deletion appears to do nothing.
    function onKeydown(el, e) {
        if (isMoney(el) || e.key !== 'Backspace') return;
        if (el.selectionStart !== el.selectionEnd) return;

        const template = templateFor(el, el.value);
        if (!template) return;

        const pos = el.selectionStart;
        let p = pos;
        while (p > 0 && !isWild(template[p - 1])) p--; // walk back over literals
        if (p === 0 || p === pos) return;              // nothing but literals, or already at a slot

        e.preventDefault();
        const raw = el.value.slice(0, p - 1) + el.value.slice(pos); // drop the data char
        const tpl = templateFor(el, raw);
        const newValue = formatWithTemplate(raw, tpl);
        const dataBefore = stripDown(tpl, el.value.slice(0, p - 1)).length;
        el.value = newValue;
        setCaret(el, templateCaret(tpl, newValue, dataBefore));
    }

    function attach(el) {
        if (!el || el._bwMaskAttached) return;
        el._bwMaskAttached = true;

        el.addEventListener('input', () => process(el));
        el.addEventListener('keydown', (e) => onKeydown(el, e));

        // format any pre-filled value (edit mode / default value)
        if (el.value) {
            el.value = isMoney(el)
                ? formatMoney(el.value, ...moneyOptions(el))
                : formatWithTemplate(el.value, templateFor(el, el.value));
        }
    }

    window.BladewindMask = { attach, stripDown, buildUp, formatWithTemplate, formatMoney, dynamicMasks };
})();
