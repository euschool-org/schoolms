export function initModalHandlers() {
    window.showModal = function(action, context, itemId) {
        const modal = document.getElementById(`modal-${action}-${context}-${itemId}`);
        modal.classList.remove('hidden');
    };

    window.hideModal = function(action, context, itemId) {
        const modal = document.getElementById(`modal-${action}-${context}-${itemId}`);
        modal.classList.add('hidden');
    };
}

export function initPaymentFormHandler() {
    document.addEventListener('DOMContentLoaded', function() {
        const toggleVisibility = (buttonId, formId, storageKey) => {
            const button = document.getElementById(buttonId);
            const form = document.getElementById(formId);

            // Ensure both button and form exist before proceeding
            if (!button || !form) return;

            const visibilityState = localStorage.getItem(storageKey);

            if (visibilityState === 'visible') {
                form.classList.remove('hidden');
            }

            button.addEventListener('click', () => {
                form.classList.toggle('hidden');

                if (form.classList.contains('hidden')) {
                    localStorage.setItem(storageKey, 'hidden');
                } else {
                    localStorage.setItem(storageKey, 'visible');
                }
            });
        };

        toggleVisibility('addPaymentBtn', 'paymentForm', 'paymentFormVisibility');
        toggleVisibility('addAttachmentBtn', 'attachmentForm', 'attachmentFormVisibility');
        toggleVisibility('toggleFiltersBtn', 'filterForm', 'filterFormVisibility');
    });
}
