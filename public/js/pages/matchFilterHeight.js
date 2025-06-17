// public/js/pages/matchFilterHeight.js
document.addEventListener('DOMContentLoaded', () => {
    const searchPanel  = document.querySelector('main search');
    const booksWrapper = document.querySelector('.books-wrapper');
  
    if (!searchPanel || !booksWrapper || typeof ResizeObserver === 'undefined') return;
  
    const ajustarAltura = height => {
      searchPanel.style.minHeight = `${height}px`;
    };
  
    // Observador de tamaño
    const ro = new ResizeObserver(entries => {
      for (let entry of entries) {
        const h = entry.contentRect.height;
        ajustarAltura(h);
      }
    });
  
    // arrancamos la observación
    ro.observe(booksWrapper);
  });