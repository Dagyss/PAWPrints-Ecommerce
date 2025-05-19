import BookController from '../controllers/BookController.js';
import MobileToggleComponent from '../components/MobileFiltrosFuncionalidad.js';

document.addEventListener('DOMContentLoaded', () => {
  const bookContainer       = document.getElementById('listaLibros');
  const filterForm          = document.getElementById('form-filtros');
  const paginationContainer = document.getElementById('paginador');

  const controller = new BookController({
    bookContainer,
    filterForm,
    paginationContainer
  });
  controller.init().catch(console.error);

  const filterBtn = document.querySelector('.buttom-filtros');
  const orderBtn  = document.querySelector('.button-ordenar');
  const filterContainer = document.getElementById('.filtros-container');
  new MobileToggleComponent(filterBtn, orderBtn, filterForm, filterContainer);
});
