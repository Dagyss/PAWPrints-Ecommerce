// public/js/pages/createBook.js
document.addEventListener('DOMContentLoaded', () => {
    const isbnInput      = document.getElementById('isbn');
    const tituloInput    = document.getElementById('titulo');
    const autorInput     = document.getElementById('autor');
    const editorialInput = document.getElementById('editorial');
    const fechaPubInput  = document.getElementById('fecha_publicacion');
    const paginasInput   = document.getElementById('numero_paginas');
    const sinopsisInput  = document.getElementById('sinopsis');
    const portadaPreview = document.querySelector('.output-area');
  
    isbnInput.addEventListener('blur', () => {
        const isbn = isbnInput.value.trim();
        if (!isbn) return;
    
        const apiUrl = `/books/isbn?isbn=${encodeURIComponent(isbn)}`;
    
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) throw new Error('Libro no encontrado en proxy');
                return response.json();
            })
            .then(data => {
                if (data.title) tituloInput.value = data.title;
                if (data.subtitle) tituloInput.value += `: ${data.subtitle}`;
                if (Array.isArray(data.authors) && data.authors.length) {
                    autorInput.value = data.authors.map(author => author.name).join(', ');
                }
                if (Array.isArray(data.publishers) && data.publishers.length) {
                    editorialInput.value = data.publishers.map(publisher => publisher.name).join(', ');
                }
                if (data.publish_date) {
                    const d = new Date(data.publish_date);
                    if (!isNaN(d)) fechaPubInput.value = d.toISOString().slice(0,10);
                }
                if (data.number_of_pages) {
                    paginasInput.value = data.number_of_pages;
                }
                if (data.notes) {
                    sinopsisInput.value = typeof data.notes === 'string' ? data.notes : data.notes.value;
                } else if (data.description) {
                    sinopsisInput.value = typeof data.description === 'string' ? data.description : data.description.value;
                }
    
                let coverUrl;
                if (data.cover && data.cover.large) {
                    coverUrl = data.cover.large;
                } else {
                    coverUrl = `https://covers.openlibrary.org/b/isbn/${isbn}-L.jpg`;
                }
                portadaPreview.innerHTML = '';
                const img = document.createElement('img');
                img.src = coverUrl;
                img.alt = 'Portada desde Open Library';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '300px';
                portadaPreview.appendChild(img);
            })
            .catch(err => {
                console.error('Error en proxy Open Library:', err);
            });
        });
  });