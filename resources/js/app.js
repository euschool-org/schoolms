import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { initModalHandlers, initPaymentFormHandler } from './custom';

// Modal handlers
initModalHandlers();

// Payment form toggle handler
initPaymentFormHandler();
