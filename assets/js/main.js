// # ----------------------------------------------------------------------------------------- #
// # MAIN SCRIPTS
// # ----------------------------------------------------------------------------------------- #

// Import scss main style files
import '../scss/main.scss';

// Global imports
import './helpers.js';

// Component imports
import ExampleComponent from './components/ExampleComponent.js';

// # ----------------------------------------------------------------------------------------- #
// # Fill the array with the components needed right after the page fully loaded
// # ----------------------------------------------------------------------------------------- #
const componentsOnLoad = () => {
  [
    // For exemple : header behavior, form validation, swiper generation, etc.
    new ExampleComponent(),
  ].forEach((component) => component.init());
};

// # ----------------------------------------------------------------------------------------- #
// # Fill the array with the components needed right after one of the action
// # ----------------------------------------------------------------------------------------- #
const componentsOnUserEvent = () => {
  [
    // For exemple : components impacting performances, like cookie banner, etc..
  ].forEach((component) => component.init());

  window.removeEventListener('scroll', componentsOnUserEvent);
  window.removeEventListener('wheel', componentsOnUserEvent);
  window.removeEventListener('touchstart', componentsOnUserEvent);
  window.removeEventListener('mouseover', componentsOnUserEvent);
};

// # ----------------------------------------------------------------------------------------- #
// # DEFAULT EVENTS
// # ----------------------------------------------------------------------------------------- #

window.addEventListener(
  'load',
  () => {
    componentsOnLoad();
  },
  window.supportPassive
);

window.addEventListener('scroll', componentsOnUserEvent, window.supportPassive);
window.addEventListener('wheel', componentsOnUserEvent, window.supportPassive);
window.addEventListener(
  'mouseover',
  componentsOnUserEvent,
  window.supportPassive
);
window.addEventListener(
  'touchstart',
  componentsOnUserEvent,
  window.supportPassive
);
