export default class PaginationComponent {

    constructor(container, totalLibros, PaginaSize, onPaginaChange) {
        this.container = container;
        this.totalLibros = totalLibros;
        this.PaginaSize = PaginaSize;
        this.onPaginaChange = onPaginaChange;
        this.currentPagina = 1;
        this.render();
    }

    setTotalLibros(totalLibros) {
        // actualizar el total de libros
        this.totalLibros = totalLibros;
        const maxPagina = this.getMaxPagina();
        // si la página actual es mayor al total de páginas, actualizar la página actual
        if (this.currentPagina > maxPagina) this.currentPagina = maxPagina;
        // renderizar la paginación
        this.render();
    }

    goToPagina(Pagina) {
        const maxPagina = this.getMaxPagina();
        // si la página es menor a 1 o mayor a la cantidad de páginas, no hacer nada
        if (Pagina < 1 || Pagina > maxPagina) return;
        // actualizar la página actual
        this.currentPagina = Pagina;
        this.render();
        // emitir evento de cambio de página
        this.onPaginaChange(this.currentPagina);
    }

    getMaxPagina() {
        return Math.ceil(this.totalLibros / this.PaginaSize) || 1;
    }

    render() {
        this.container.innerHTML = '';
        const maxPagina = this.getMaxPagina();

        const wrapper = document.createElement('div');
        wrapper.classList.add('pagination-buttons');

        // anterior
        const prevBtn = document.createElement('button');
        prevBtn.textContent = '«';
        prevBtn.disabled = this.currentPagina === 1;
        prevBtn.classList.add('Pagina-btn');
        prevBtn.addEventListener('click', () => this.goToPagina(this.currentPagina - 1));
        wrapper.appendChild(prevBtn);

        // numero de paginas
        for (let i = 1; i <= maxPagina; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.disabled = i === this.currentPagina;
            btn.classList.add('Pagina-btn');
            if (i === this.currentPagina) btn.classList.add('active');
            btn.addEventListener('click', () => this.goToPagina(i));
            wrapper.appendChild(btn);
        }

        // siguiente
        const nextBtn = document.createElement('button');
        nextBtn.textContent = '»';
        nextBtn.disabled = this.currentPagina === maxPagina;
        nextBtn.classList.add('Pagina-btn');
        nextBtn.addEventListener('click', () => this.goToPagina(this.currentPagina + 1));
        wrapper.appendChild(nextBtn);

        this.container.appendChild(wrapper);
    }
}