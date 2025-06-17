
  function recalcularTotal() {
    let total = 0;
    document.querySelectorAll('.cart-item').forEach(item => {
      // tomamos el precio formateado: "1.234,56"
      const precioText = item
        .querySelector('.cart-price [itemprop="price"]')
        .innerText.trim();
      // lo convertimos a número JS: 1234.56
      const precioNum = parseFloat(
        precioText.replace(/\./g, '').replace(',', '.')
      );
      const cantidad = parseInt(
        item.querySelector('.cart-quantity').value,
        10
      );
      total += precioNum * cantidad;
    });

    // formateamos el total de vuelta: "1.234,56"
    const totalFormateado = total
      .toFixed(2)               // 2 decimales
      .replace('.', ',')        // coma decimal
      .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // puntos miles

    // lo ponemos en el span del total
    const totalSpan = document.querySelector(
      'p.total [itemprop="totalPrice"]'
    );
    totalSpan.innerText = totalFormateado;
  }

  // al cargar la página y cada vez que cambie un input, recalculamos
  window.addEventListener('DOMContentLoaded', () => {
    recalcularTotal();
    document.querySelectorAll('.cart-quantity').forEach(input => {
        input.addEventListener('change', e => {
          // si pisa el max, lo ajustamos
          if (e.target.value > 10) e.target.value = 10;
          if (e.target.value < 1)  e.target.value = 1;  // también chequeo mínimo
          recalcularTotal();
        });
      });
    });