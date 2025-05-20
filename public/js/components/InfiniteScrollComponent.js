export default class InfiniteScrollComponent {

    constructor(scrollContainer, onLoadMore, threshold = 0.9) {
        this.scrollContainer = scrollContainer;
        // función que trae los libros a cargar
        this.onLoadMore = onLoadMore;
        // porcentaje de scroll para cargar contenido
        this.threshold = threshold;
        this.loading = false;

        // bindear el evento de scroll a la clase para que no se pierda el contexto en el objeto
        this._boundScroll = this.handleScroll.bind(this);
        this.addScrollEvent();
    }

    addScrollEvent() {
        // agregar evento de scroll al contenedor
        this.scrollContainer.addEventListener('scroll', this._boundScroll);
    }

    async handleScroll() {
        let scrollTop, scrollHeight, clientHeight;

        // el contenedor que se le pasa es el window, entonces trabajamos con eso
        scrollTop = window.scrollY || window.pageYOffset;
        scrollHeight = document.documentElement.scrollHeight;
        clientHeight = window.innerHeight;

        // si ya está cargando, salimos
        if (this.loading) return;
        // si no alcanza el umbral para cargar más libros, salimos
        if (scrollTop + clientHeight < scrollHeight * this.threshold) return;

        // true porque se está cargando
        this.loading = true;
        try {
            // carga de los libros
            await this.onLoadMore();
        } catch (e) {
            console.error('Error cargando más libros:', e);
        }
        // falso para permitir cargar contenido de nuevo
        this.loading = false;
    }

    destroy() {
        // desvinculamos el evento cuando no estamos en mobile
        this.scrollContainer.removeEventListener('scroll', this._boundScroll);
    }
}