/* Enquiry form: inline validation messages, a submitting state and focus handling */

export function initForms() {
    document.querySelectorAll('form[data-enquiry]').forEach((form) => {
        const submit = form.querySelector('[type="submit"]');

        const messageFor = (field) => {
            const v = field.validity;
            if (v.valueMissing) return field.dataset.required || 'This field is required.';
            if (v.typeMismatch && field.type === 'email') return 'That email address does not look right.';
            if (v.tooShort) return `Please write at least ${field.minLength} characters.`;
            if (v.patternMismatch) return field.dataset.pattern || 'Please check this value.';
            return field.validationMessage;
        };

        const show = (field) => {
            const error = document.getElementById(`${field.id}-error`);
            if (!error) return;
            const valid = field.checkValidity();
            field.setAttribute('aria-invalid', String(!valid));
            error.textContent = valid ? '' : messageFor(field);
            error.hidden = valid;
        };

        form.noValidate = true;
        const fields = [...form.querySelectorAll('input[id], textarea[id], select[id]')];

        fields.forEach((field) => {
            field.addEventListener('blur', () => {
                if (field.value || field.getAttribute('aria-invalid') === 'true') show(field);
            });
            field.addEventListener('input', () => {
                if (field.getAttribute('aria-invalid') === 'true') show(field);
            });
            field.addEventListener('change', () => {
                if (field.type === 'checkbox') show(field);
            });
        });

        form.addEventListener('submit', (e) => {
            const invalid = fields.filter((f) => !f.checkValidity());
            if (invalid.length) {
                e.preventDefault();
                invalid.forEach(show);
                invalid[0].focus();
                return;
            }
            submit.setAttribute('data-loading', 'true');
            submit.setAttribute('aria-disabled', 'true');
        });
    });

    // Undo the submitting state if the page is restored from the back/forward cache
    window.addEventListener('pageshow', (e) => {
        if (e.persisted) document.querySelectorAll('[data-loading]').forEach((b) => b.removeAttribute('data-loading'));
    });

    // Move focus to server-rendered confirmation or error summaries
    document.querySelector('[data-autofocus]')?.focus();
}
