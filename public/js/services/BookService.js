import Book from "../models/Book.js";

export default class BookService {
    static async getBooks() {
        const books = await fetch('/books.json').then(res => res.json());

        console.log(books);

        return books.map(book => new Book(book.fields));
    }
}