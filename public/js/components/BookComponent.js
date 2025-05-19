export default class BookComponent {
  constructor(books, container) {
    this.originalBooks = [...books];
    this.books = books;
    this.container = container;
    this.defaultImage = '../icons/no_content.png';
  }

  updateData(newBooks) {
    this.books = newBooks;
    this.render();
  }

  render() {
    this.container.innerHTML = '';

    this.books.forEach(book => {
      const article = document.createElement('article');
      article.classList.add('book');

      // Imagen
      const figure = document.createElement('figure');
      const linkImg = document.createElement('a');
      linkImg.href = `./book?id=${encodeURIComponent(book.id)}`;
      const img = document.createElement('img');
      img.src = book.imagen;
      img.alt = `Portada de ${book.titulo}`;
      // Si falla al cargar, usamos la imagen por defecto
      img.addEventListener('error', () => {
        img.src = this.defaultImage;
      });
      linkImg.appendChild(img);
      figure.appendChild(linkImg);
      article.appendChild(figure);

      // Título
      const h3 = document.createElement('h3');
      const linkTitle = document.createElement('a');
      linkTitle.href = `./book?id=${encodeURIComponent(book.id)}`;
      linkTitle.textContent = book.titulo;
      h3.appendChild(linkTitle);
      article.appendChild(h3);

      // Autor
      const pAuthor = document.createElement('p');
      pAuthor.textContent = book.autor;
      article.appendChild(pAuthor);

      // Precio y Descuento
      const pPrice = document.createElement('p');
      if (book.descuento > 0) {
        const spanOriginal = document.createElement('span');
        spanOriginal.textContent = `$${book.precio.toFixed(2).replace('.', ',')}`;
        spanOriginal.classList.add('price-original');
        spanOriginal.style.textDecoration = 'line-through';

        const spanDescuento = document.createElement('span');
        const precioDesc = book.precioConDescuento();
        spanDescuento.textContent = ` $${precioDesc.toFixed(2).replace('.', ',')}`;
        spanDescuento.classList.add('price-discount');

        pPrice.appendChild(spanOriginal);
        pPrice.appendChild(spanDescuento);
      } else {
        pPrice.textContent = `$${book.precio.toFixed(2).replace('.', ',')}`;
      }
      article.appendChild(pPrice);

      // Botón Comprar
      const button = document.createElement('button');
      button.type = 'button';
      button.textContent = 'Comprar';
      article.appendChild(button);

      this.container.appendChild(article);
    });
  }
}