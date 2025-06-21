import './bootstrap';  // Import axios, echo, pusher setup

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'; // <-- Tambahkan ini

Alpine.plugin(collapse); // <-- Daftarkan plugin collapse

window.Alpine = Alpine;

Alpine.start();

