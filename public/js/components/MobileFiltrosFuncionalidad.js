export default class MobileToggleComponent {

    constructor(filterBtn, orderBtn, form, container) {
        this.filterBtn = filterBtn;
        this.orderBtn = orderBtn;
        this.form = form;
        this.fieldsets = Array.from(form.querySelectorAll('fieldset'));

        this.filterGroups = {
            ordenar: this.fieldsets.filter(fs =>
                fs.querySelector('legend').textContent.trim() === 'Ordenar'
            ),
            filtrar: this.fieldsets.filter(fs =>
                fs.querySelector('legend').textContent.trim() !== 'Ordenar'
            )
        };

        this.activeGroup = null;
        this._bind();
        this._reset();
    }

    _bind() {
        this.filterBtn.addEventListener('click', () => this._toggleGroup('filtrar'));
        this.orderBtn.addEventListener('click', () => this._toggleGroup('ordenar'));
    }

    _reset() {
        this.fieldsets.forEach(fs => fs.style.display = 'none');
        this.activeGroup = null;
    }

    _toggleGroup(group) {
        if (this.activeGroup === group) {
            this._reset();
        } else {
            this.fieldsets.forEach(fs => fs.style.display = 'none');
            this.filterGroups[group].forEach(fs => fs.style.display = 'block');
            this.form.scrollIntoView({ behavior: 'smooth' });
            this.activeGroup = group;
        }
    }
}
