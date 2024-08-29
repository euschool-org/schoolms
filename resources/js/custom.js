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
        const toggleVisibility = (buttonId, formId) => {
            const button = document.getElementById(buttonId);
            const form = document.getElementById(formId);

            if (button && form) {
                button.addEventListener('click', () => {
                    form.classList.toggle('hidden');
                });
            }
        };

        toggleVisibility('addPaymentBtn', 'paymentForm');
        toggleVisibility('addAttachmentBtn', 'attachmentForm');
    });
}
