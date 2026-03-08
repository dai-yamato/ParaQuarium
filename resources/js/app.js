import './bootstrap';

// In Livewire 3, Alpine is bundled and initialized automatically by Livewire.
// We remove the manual Alpine initialization to prevent "Detected multiple instances of Alpine running" error 
// which breaks event listeners like @click and wire:click.
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();
