export default class BookComponent {

    constructor(books, container) {
        this.books = books;
        this.container = container;
    }

    async render() {
        this.container.innerHTML = this.books.map(book => `
        <div class="book">
          <img src="${book.image}" alt="">
          <div class="book-info">
            <h2 class="book-title">${book.title}</h2>
            <p class="book-author">${book.author}</p>
            <p class="book-description">${book.description}</p>
          </div>
        </div>
      `).join('');
    }
}