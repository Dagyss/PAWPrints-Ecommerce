import Book from "../models/Book.js";

export default class BookService {
    static async getBooks() {
        // traemos los libros en formato json
        const books = await fetch('/books.json').then(res => res.json());
        console.log(books);
        // los mapeamos para crear un nuevo objeto de tipo Book
        return books.map(book => new Book(book.fields));
    }
}