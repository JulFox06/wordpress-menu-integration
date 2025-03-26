// # ----------------------------------------------------------------------------------------- #
// # HELPERS
// # ----------------------------------------------------------------------------------------- #

// # ------------------------------------------- #
// # SUPPORT PASSIVE
// # ------------------------------------------- #

// Add passive event to improve performance
// https://developer.mozilla.org/fr/docs/Web/API/EventTarget/addEventListener#Am%C3%A9lioration_des_performances_de_d%C3%A9filement_avec_les_%C3%A9couteurs_passifs

// Usage example :
// window.addEventLister('scroll', (event) => { console.log(event) }, window.supportPassive);

window.supportPassive = false;

try {
  window.addEventListener(
    'test',
    null,
    Object.defineProperty({}, 'passive', {
      get: () => {
        window.supportPassive = { passive: true };

        return true;
      },
    })
  );
} catch (err) {
  // eslint-disable-next-line no-console
  console.warn(err, 'SupportPassive si not supported with this browser.');
}
