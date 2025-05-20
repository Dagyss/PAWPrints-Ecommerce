export default class FilterComponent {

    constructor(form, onChange) {
        this.form = form;
        this.onChange = onChange;
        this.state = {
            orden: 'novedades',
            categorias: new Set(),
            precioMin: null,
            precioMax: null,
            autor: '',
            idiomas: new Set(),
            formatos: new Set()
        };
        this.bindEvents();
    }

    bindEvents() {
        // evento de cambio de orden (ordenamiento)
        this.form.orden.addEventListener('change', e => {
            this.state.orden = e.target.value;
            this.emit();
        });

        // eventos de cambio de filtros (filtrar)

        //  categorías
        this.form.querySelectorAll('input[name="categorias[]"]')
            .forEach(chk => chk.addEventListener('change', e => {
                e.target.checked
                    ? this.state.categorias.add(e.target.value)
                    : this.state.categorias.delete(e.target.value);
                this.emit();
            }));

        //  precio minimo
        this.form.precioMin.addEventListener('input', e => {
            this.state.precioMin = e.target.value ? +e.target.value : null;
            this.emit();
        });

        // precio maximo
        this.form.precioMax.addEventListener('input', e => {
            this.state.precioMax = e.target.value ? +e.target.value : null;
            this.emit();
        });

        // autor
        this.form.autor.addEventListener('input', e => {
            this.state.autor = e.target.value.trim().toLowerCase();
            this.emit();
        });

        //idiomas
        this.form.querySelectorAll('input[name="idiomas[]"]')
            .forEach(chk => chk.addEventListener('change', e => {
                e.target.checked
                    ? this.state.idiomas.add(e.target.value)
                    : this.state.idiomas.delete(e.target.value);
                this.emit();
            }));

        // formatos
        this.form.querySelectorAll('input[name="formatos[]"]')
            .forEach(chk => chk.addEventListener('change', e => {
                e.target.checked
                    ? this.state.formatos.add(e.target.value)
                    : this.state.formatos.delete(e.target.value);
                this.emit();
            }));

        // prevent default submit para no recargar la página cuando se envía el formulario
        this.form.addEventListener('submit', e => e.preventDefault());
    }

    emit() {
        // emitir evento con los datos del formulario actual (orden y filtros), se activa cuando se cambia algo en el formulario
        this.onChange({
            orden: this.state.orden,
            categorias: new Set(this.state.categorias),
            precioMin: this.state.precioMin,
            precioMax: this.state.precioMax,
            autor: this.state.autor,
            idiomas: new Set(this.state.idiomas),
            formatos: new Set(this.state.formatos)
        });
    }
}