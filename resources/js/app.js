import './bootstrap';

import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { initModalHandlers, initPaymentFormHandler, alignTableRows, synchronizeHoverEffect } from './custom';

// Modal handlers
initModalHandlers();

// Payment form toggle handler
initPaymentFormHandler();

alignTableRows();

synchronizeHoverEffect();
