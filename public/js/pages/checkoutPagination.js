import PaginationComponent from '../components/PaginationComponent.js';

document.addEventListener('DOMContentLoaded', () => {
  const itemsContainer = document.getElementById('order-items-container');
  const items = Array.from(itemsContainer.querySelectorAll('.order-summary-item'));
  const paginationEl = document.getElementById('order-pagination');
  const pageSize = 3;

  // función que muestra sólo los ítems de la página `n`
  const renderPage = page => {
    const start = (page - 1) * pageSize;
    const end = page * pageSize;
    items.forEach((item, idx) => {
      item.style.display = (idx >= start && idx < end) ? '' : 'none';
    });
  };

  // instancio el paginador
  const paginator = new PaginationComponent(
    paginationEl,
    items.length,
    pageSize,
    renderPage
  );

  // muestro la primer página al cargar
  renderPage(1);
});