export default class Book {
  constructor({ id, titulo, autor, precio, stock, imagen, descripcion, categoria, idioma, formato, cantidadVentas, descuento, created_at, updated_at }) {
    this.id = id;
    this.titulo = titulo;
    this.autor = autor;
    this.precio = precio;
    this.stock = stock;
    this.imagen = imagen;
    this.descripcion = descripcion;
    this.categoria = categoria;
    this.idioma = idioma;
    this.formato = formato;
    this.cantidadVentas = cantidadVentas;
    this.descuento = descuento;
    this.createdAt = created_at;
    this.updatedAt = updated_at;
  }

  precioConDescuento() {
    return +(this.precio * (1 - this.descuento / 100)).toFixed(2);
  }
}