document.addEventListener('DOMContentLoaded', () => {
    const btnDecrement = document.getElementById('decrement');
    const btnIncrement = document.getElementById('increment');
    const cantidadDisplay = document.getElementById('cantidad-display');
    const inputCantidad = document.getElementById('cantidad');
    const precioUnitarioElement = document.getElementById('precio-unitario');
    const precioTotalElement = document.getElementById('precio-total');

    const precioUnitario = parseFloat(precioUnitarioElement.textContent);

    function actualizarPrecioTotal() {
        const cantidad = parseInt(inputCantidad.value) || 1;
        const precioTotal = precioUnitario * cantidad;
        precioTotalElement.textContent = precioTotal.toFixed(2);
    }

    btnIncrement.addEventListener('click', () => {
        let cantidad = parseInt(inputCantidad.value);
        cantidad++;
        inputCantidad.value = cantidad;
        cantidadDisplay.textContent = cantidad;
        actualizarPrecioTotal();
    });

    btnDecrement.addEventListener('click', () => {
        let cantidad = parseInt(inputCantidad.value);
        if (cantidad > 1) {
            cantidad--;
            inputCantidad.value = cantidad;
            cantidadDisplay.textContent = cantidad;
            actualizarPrecioTotal();
        }
    });
});
