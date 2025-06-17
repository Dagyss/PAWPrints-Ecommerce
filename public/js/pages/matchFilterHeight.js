// public/js/pages/matchFilterHeight.js
document.addEventListener('DOMContentLoaded', () => {
    const searchPanel  = document.querySelector('main search');
    const booksWrapper = document.querySelector('.books-wrapper');
    if (!searchPanel || !booksWrapper || typeof ResizeObserver === 'undefined') return;
  
    let ro = null;  // nuestro ResizeObserver
  
    const ajustarAltura = height => {
      searchPanel.style.minHeight = `${height}px`;
    };
  
    const startObserving = () => {
      if (ro) return; // ya está activo
      ro = new ResizeObserver(entries => {
        for (let entry of entries) {
          ajustarAltura(entry.contentRect.height);
        }
      });
      ro.observe(booksWrapper);
    };
  
    const stopObserving = () => {
      if (!ro) return;
      ro.disconnect();
      ro = null;
      searchPanel.style.minHeight = '';  // limpio el estilo
    };
  
    // Media query para >= 900px
    const mql = window.matchMedia('(min-width: 900px)');
    // listener para cambios de ancho
    mql.addEventListener('change', e => {
      if (e.matches) startObserving();
      else stopObserving();
    });
  
    // inicializo según el ancho actual
    if (mql.matches) startObserving();
    else stopObserving();
  });