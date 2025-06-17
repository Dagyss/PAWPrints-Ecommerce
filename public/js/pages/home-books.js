// home-books.js
import BookService from '../services/BookService.js';
import BookComponent from '../components/BookComponent.js';

document.addEventListener('DOMContentLoaded', async () => {
  // contenedores
  const sugerenciasContainer = document.getElementById('books-carousel');
  const bestsellersContainer = document.getElementById('books-carousel-best-sales');
  if (!sugerenciasContainer || !bestsellersContainer) return;

  try {
    // 1) cargar todos los libros
    const allBooks = await BookService.getBooks();

    // 2) Sugerencias: toma los primeros 8 (o como quieras)
    const sugerencias = allBooks.slice(0, 8);
    const sugerenciasComponent = new BookComponent(sugerencias, sugerenciasContainer);
    sugerenciasComponent.render();

    // 3) Más vendidos: ordena por cantidadVentas descendente y toma 8
    const topVentas = [...allBooks]
      .sort((a, b) => b.cantidadVentas - a.cantidadVentas)
      .slice(0, 8);
    const bestsellersComponent = new BookComponent(topVentas, bestsellersContainer);
    bestsellersComponent.render();

    const setupNav = (container, btnPrev, btnNext) => {
      const card = container.querySelector('.book');
      if (!card) return;
    
      // ancho de la tarjeta incluyendo margin/gap
      const style = getComputedStyle(container);
      const gap   = parseInt(style.gap) || 0;
      const scrollAmount = card.offsetWidth + gap;
    
      btnPrev.addEventListener('click', () =>
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' })
      );
      btnNext.addEventListener('click', () =>
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' })
      );
    };
    
    setupNav(
      sugerenciasContainer,
      document.querySelector('.prev'),
      document.querySelector('.next')
    );
    setupNav(
      bestsellersContainer,
      document.querySelector('.prev-best-sales'),
      document.querySelector('.next-best-sales')
    );

  } catch (err) {
    console.error('No se pudieron cargar los libros para el home:', err);
  }
});