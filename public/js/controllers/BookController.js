// src/js/controllers/BookController.js

import BookService from '../services/BookService.js';
import BookComponent from '../components/BookComponent.js';
import FilterComponent from '../components/FilterComponent.js';
import PaginationComponent from '../components/PaginationComponent.js';

export default class BookController {
    constructor({ bookContainer, filterForm, paginationContainer }) {
        this.bookContainer = bookContainer;
        this.filterForm = filterForm;
        this.paginationContainer = paginationContainer;

        this.pageSize = 8;          // Libros por página
        this.currentPage = 1;
        this.originalBooks = [];
        this.filteredBooks = [];

        this.bookComponent = null;
        this.paginationComponent = null;
    }

    async init() {
        // Carga datos
        this.originalBooks = await BookService.getBooks();

        // Instancia vista libros
        this.bookComponent = new BookComponent([], this.bookContainer);

        // Instancia filtros
        new FilterComponent(this.filterForm, filtros => {
            this.currentPage = 1;
            this.onFilterChange(filtros);
        });

        // Instancia paginación
        this.paginationComponent = new PaginationComponent(
            this.paginationContainer,
            this.originalBooks.length,
            this.pageSize,
            page => {
                this.currentPage = page;
                this.renderPage();
            }
        );

        // Render inicial
        this.filteredBooks = [...this.originalBooks];
        this.renderPage();
    }

    onFilterChange(filtros) {
        this.filteredBooks = this.applyFilters(this.originalBooks, filtros);
        this.paginationComponent.setTotalItems(this.filteredBooks.length);
        this.renderPage();
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