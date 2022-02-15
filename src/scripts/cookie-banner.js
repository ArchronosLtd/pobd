function onLoad() {
  const banner = document.querySelector('#cookie-banner');
  const overlay = document.querySelector('#cookie-overlay');
  const storage = window.localStorage;

  banner.querySelector('.btn').addEventListener('click', () => {
    overlay.classList.add('hiding');
    banner.classList.add('hiding');

    setTimeout(() => {
      overlay.classList.remove('visible');
      banner.classList.remove('visible');
    }, 200);

    storage.setItem('agreed', true);
  });

  if(!storage.getItem('agreed')) {
    overlay.classList.add('visible');
    banner.classList.add('visible');
  }
}

window.addEventListener("load", onLoad, true);