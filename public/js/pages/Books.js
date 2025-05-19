import BookComponent from '../components/BookComponent.js';
import BookService from '../services/BookService.js';

document.addEventListener('DOMContentLoaded', async () => {
  try {
    const books = await BookService.getBooks();
    const container = document.getElementById('listaLibros');
    if (!container) throw new Error("Container element '#listarLibros' not found");
    
    const listView = new BookComponent(books, container);
    listView.render();
  } catch (error) {
    console.error('Failed to load books:', error);
  }
});