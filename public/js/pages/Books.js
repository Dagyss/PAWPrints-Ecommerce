import BookController from '../controllers/BookController.js';
import MobileFiltrosFuncionalidad from '../components/MobileFiltrosFuncionalidad.js';

// cuando se carga el DOM
document.addEventListener('DOMContentLoaded', () => {
  const bookContainer = document.getElementById('listaLibros');
  const filterForm = document.getElementById('form-filtros');
  const paginationContainer = document.getElementById('paginador');

  // instanciar el controlador de libros
  const controller = new BookController({
    // contenedor de libros
    bookContainer,
    // formulario de filtros
    filterForm,
    // contenedor de paginación
    paginationContainer
  });
  // inicio el controlador
  controller.init().catch(console.error);

  const filterBtn = document.querySelector('.button-filtros');
  const orderBtn = document.querySelector('.button-ordenar');

  const mql = window.matchMedia('(max-width: 900px)');
  // evento para saber si estamos en mobile
  const setupMobileToggle = e => {
    if (e.matches) {
      // crear el componente de filtros en mobile
      new MobileFiltrosFuncionalidad(filterBtn, orderBtn, filterForm);
    } else {
      // mostrar todos los filtros en desktop
      Array.from(filterForm.querySelectorAll('fieldset'))
        .forEach(fs => fs.style.display = '');
    }
  };
  setupMobileToggle(mql);
  // evento para saber si cambia el tamaño de la pantalla y cambiar el metodo de paginacion
  mql.addEventListener('change', setupMobileToggle);
});
