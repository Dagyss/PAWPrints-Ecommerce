export default class MobileToggleComponent {

    constructor(filterBtn, orderBtn, form) {
        this.filterBtn = filterBtn;
        this.orderBtn = orderBtn;
        this.form = form;
        this.fieldsets = Array.from(form.querySelectorAll('fieldset'));

        // grupo de filtros
        this.filtergrupos = {
            ordenar: this.fieldsets.filter(fs =>
                fs.querySelector('legend').textContent.trim() === 'Ordenar'
            ),
            filtrar: this.fieldsets.filter(fs =>
                fs.querySelector('legend').textContent.trim() !== 'Ordenar'
            )
        };

        this.grupoActivo = null
        this.bind();
        this.reset();
    }

    bind() {
        // Evento click para ocultar el grupo de filtros
        this.filterBtn.addEventListener('click', () => this.ocultarGrupo('filtrar'));
        this.orderBtn.addEventListener('click', () => this.ocultarGrupo('ordenar'));
    }

    reset() {
        // Resetear los campos de filtros cuando se oculta el grupo
        this.fieldsets.forEach(fs => fs.style.display = 'none');
        // Resetear el grupo activo para que no se quede abierto
        this.grupoActivo = null
    }

    ocultarGrupo(grupo) {
        // Si el grupo activo es igual al grupo que se quiere ocultar, se oculta
        if (this.grupoActivo === grupo) {
            this.reset();
        } else {
            // si no, se oculta el grupo activo y se muestra el grupo que se quiere ocultar
            this.fieldsets.forEach(fs => fs.style.display = 'none');
            this.filtergrupos[grupo].forEach(fs => fs.style.display = 'block');
            this.form.scrollIntoView({ behavior: 'smooth' });
            //  actualizamos el grupo activo
            this.grupoActivo = grupo;
        }
    }
}
