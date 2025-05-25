import BookService from '../services/BookService.js';
import BookComponent from '../components/BookComponent.js';
import FilterComponent from '../components/FilterComponent.js';
import PaginationComponent from '../components/PaginationComponent.js';
import InfiniteScrollComponent from '../components/InfiniteScrollComponent.js';
import SearchComponent from '../components/SearchComponent.js'; 

const MOBILE_QUERY = '(max-width: 899px)';

export default class BookController {
    constructor({ bookContainer, filterForm, paginationContainer }) {
        this.bookContainer = bookContainer;
        this.filterForm = filterForm;
        this.paginationContainer = paginationContainer;

        this.pageSize = 8;
        this.currentPage = 1;
        // libros originales
        this.originalBooks = [];
        // libros filtrados
        this.filteredBooks = [];
        // libros a mostrar en la página actual (filtrados + paginados)
        this.booksBuffer = [];

        this.bookComponent = null;
        this.paginationComponent = null;
        this.scrollComponent = null;

        // media query para saber si estamos en mobile
        this.mql = window.matchMedia(MOBILE_QUERY);
        // eventos para saber si estamos en mobile
        this.handleViewportChange = this.handleViewportChange.bind(this);
    }

    async init() {
        const search = new SearchComponent({
            formSelector: '#search-form',
            inputSelector: '#search-input',
            historyContainerSelector: '#search-history',
            storageKey: 'paw-search-history',
            max: 5,
            onSearch: q => {
              this.currentPage = 1;
              this.filteredBooks = this.applyFilters(this.originalBooks, { ...this.currentFilters, autor: q.toLowerCase() });
              this.handleViewportChange(this.mql);
            }
          });

        // Carga datos
        this.originalBooks = await BookService.getBooks();

        // Instancia de BookComponent para mostrar libros en el DOM
        this.bookComponent = new BookComponent([], this.bookContainer);

        // Instancia de FilterComponent para filtrar libros
        new FilterComponent(this.filterForm, filtros => {
            this.currentPage = 1;
            this.filteredBooks = this.applyFilters(this.originalBooks, filtros);
            this.handleViewportChange(this.mql);
        });

        // Instancia paginación tradicional
        this.paginationComponent = new PaginationComponent(
            this.paginationContainer,
            this.originalBooks.length,
            this.pageSize,
            page => {
                // actualizar la página actual
                this.currentPage = page;
                // renderizar la página
                this.renderPage();
            }
        );

        // MediaQuery listener
        this.mql.addEventListener('change', this.handleViewportChange);

        // libros iniciales
        this.filteredBooks = [...this.originalBooks];
        // evento que decide si se muestra la paginación tradicional o el infinito
        this.handleViewportChange(this.mql);
    }

    handleViewportChange(e) {
        if (e.matches) {
            // si es mobile, instanciamos el infinite scroll
            this.enableInfiniteScroll();
        } else {
            // si es desktop, instanciamos la paginación
            this.enablePagination();
        }
    }

    enablePagination() {
        // limpia scroll infinito
        if (this.scrollComponent) {
            this.scrollComponent.destroy?.();
            this.scrollComponent = null;
        }
        // muestra paginación, resetea página
        this.paginationContainer.style.display = '';
        this.paginationComponent.setTotalLibros(this.filteredBooks.length);
        this.currentPage = 1;
        // renderiza los libros
        this.renderPage();
    }

    enableInfiniteScroll() {
        // oculta paginación de la versión desktop
        this.paginationContainer.style.display = 'none';
        // reseteo buffer de libros
        this.currentPage = 1;
        this.booksBuffer = [];
        // instanciar scroll infinito
        this.scrollComponent = new InfiniteScrollComponent(window, async () => {
            const start = (this.currentPage - 1) * this.pageSize;
            const nextItems = this.filteredBooks.slice(start, start + this.pageSize);
            // si no hay mas libros, no hacer nada
            if (nextItems.length === 0) return;
            // agregar los libros al buffer
            this.booksBuffer.push(...nextItems);
            // actualizar el componente de libros con los libros del buffer y los renderiza
            this.bookComponent.updateData(this.booksBuffer);
            this.currentPage++;
        });
        // carga inicial
        this.scrollComponent.onLoadMore();
    }

    renderPage() {
        const start = (this.currentPage - 1) * this.pageSize;
        const pageItems = this.filteredBooks.slice(start, start + this.pageSize);
        this.bookComponent.updateData(pageItems);
    }

    applyFilters(books, f) {
        return books
            .filter(b => f.categorias.size === 0 || f.categorias.has(b.categoria))
            .filter(b => f.idiomas.size === 0 || f.idiomas.has(b.idioma))
            .filter(b => f.formatos.size === 0 || f.formatos.has(b.formato))
            .filter(b => {
                const p = b.precioConDescuento();
                return (f.precioMin == null || p >= f.precioMin)
                    && (f.precioMax == null || p <= f.precioMax);
            })
            .filter(b => !f.autor || b.autor.toLowerCase().includes(f.autor))
            .filter(b =>
                !f.autor ||
                b.autor.toLowerCase().includes(f.autor) ||
                b.titulo.toLowerCase().includes(f.autor)
              )              
            .sort((a, b) => this.compare(a, b, f.orden));
    }

    compare(a, b, orden) {
        switch (orden) {
            case 'precio_asc': return a.precioConDescuento() - b.precioConDescuento();
            case 'precio_desc': return b.precioConDescuento() - a.precioConDescuento();
            case 'mas_vendidos': return b.cantidadVentas - a.cantidadVentas;
            case 'ofertas': return b.descuento - a.descuento;
            case 'novedades':
            default: return new Date(b.createdAt) - new Date(a.createdAt);
        }
    }
}