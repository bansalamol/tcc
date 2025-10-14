import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import 'flowbite';
window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
import {insertRandomCode} from "./patient-form.js";
if (document.readyState !== "loading") { insertRandomCode(); } else { document.addEventListener("DOMContentLoaded", insertRandomCode); }
