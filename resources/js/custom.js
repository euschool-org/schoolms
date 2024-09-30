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

export function alignTableRows() {
    window.addEventListener('load', function() {
        const leftTableRows = document.querySelectorAll('#leftTable tbody tr');
        const rightTableRows = document.querySelectorAll('#rightTable tbody tr');
        const leftTableHeaders = document.querySelectorAll('#leftTable thead th');
        const rightTableHeaders = document.querySelectorAll('#rightTable thead th');

        // Align row heights
        for (let i = 0; i < leftTableRows.length; i++) {
            const leftRow = leftTableRows[i];
            const rightRow = rightTableRows[i];
            const maxHeight = Math.max(leftRow.offsetHeight, rightRow.offsetHeight);

            leftRow.style.height = maxHeight + 'px';
            rightRow.style.height = maxHeight + 'px';
        }

        // Align header heights
        for (let i = 0; i < leftTableHeaders.length; i++) {
            const leftHeader = leftTableHeaders[i];
            const rightHeader = rightTableHeaders[i];
            const maxHeight = Math.max(leftHeader.offsetHeight, rightHeader.offsetHeight);

            leftHeader.style.height = maxHeight + 'px';
            rightHeader.style.height = maxHeight + 'px';
        }
    });
}
export function synchronizeHoverEffect() {
    const leftTableRows = document.querySelectorAll('#leftTable tbody tr');
    const rightTableRows = document.querySelectorAll('#rightTable tbody tr');

    if (leftTableRows.length === rightTableRows.length) {
        for (let i = 0; i < leftTableRows.length; i++) {
            const leftRow = leftTableRows[i];
            const rightRow = rightTableRows[i];

            // When hovering over the left table row
            leftRow.addEventListener('mouseenter', () => {
                leftRow.classList.add('bg-gray-100');
                rightRow.classList.add('bg-gray-100');
            });
            leftRow.addEventListener('mouseleave', () => {
                leftRow.classList.remove('bg-gray-100');
                rightRow.classList.remove('bg-gray-100');
            });

            // When hovering over the right table row
            rightRow.addEventListener('mouseenter', () => {
                leftRow.classList.add('bg-gray-100');
                rightRow.classList.add('bg-gray-100');
            });
            rightRow.addEventListener('mouseleave', () => {
                leftRow.classList.remove('bg-gray-100');
                rightRow.classList.remove('bg-gray-100');
            });
        }
    }
}
