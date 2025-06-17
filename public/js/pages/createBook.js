// public/js/pages/createBook.js
document.addEventListener('DOMContentLoaded', () => {
    const isbnInput   = document.getElementById('isbn');
    const buscarBtn   = document.getElementById('buscar-isbn');
    const spinner     = document.getElementById('isbn-spinner');
    const errorDiv    = document.getElementById('isbn-error');
    const tituloInput    = document.getElementById('titulo');
    const autorInput     = document.getElementById('autor');
    const editorialInput = document.getElementById('editorial');
    const idiomaSelect   = document.getElementById('idioma');
    const fechaPubInput  = document.getElementById('fecha_publicacion');
    const paginasInput   = document.getElementById('numero_paginas');
    const sinopsisInput  = document.getElementById('sinopsis');
    const portadaPreview = document.querySelector('.output-area');
  
    const langMap = {
      eng: 'ingles',
      spa: 'espanol',
      fre: 'frances',
      por: 'portugues'
    };
  
    buscarBtn.addEventListener('click', async () => {
      const isbn = isbnInput.value.trim();
      if (!isbn) {
        errorDiv.innerText = 'No cargo ningun ISBN';
        errorDiv.classList.remove('hidden');
        return;
      }
      errorDiv.innerText = '';
      errorDiv.classList.add('hidden');
      spinner.classList.remove('hidden');
      try {
        const res  = await fetch(`/books/isbn?isbn=${encodeURIComponent(isbn)}`);
        if (!res.ok) throw new Error('No se encontró ese ISBN');
        const data = await res.json();
        console.log('📦 datos recibidos:', data);
  
        // 1) Título + subtítulo
        tituloInput.value = data.title || '';
        if (data.subtitle) {
          tituloInput.value += `: ${data.subtitle}`;
        }
  
        // 2) Autor: si ya viene name, no hago fetch extra
        if (Array.isArray(data.authors) && data.authors.length) {
          const names = data.authors
            .map(a => a.name)
            .filter(n => !!n);
          autorInput.value = names.join(', ');
        } else {
          autorInput.value = '';
        }
        console.log('Autor cargado:', autorInput.value);
  
        // 3) Editorial
        if (Array.isArray(data.publishers)) {
          editorialInput.value = data.publishers.join(', ');
        } else {
          editorialInput.value = '';
        }
        console.log('Editorial cargada:', editorialInput.value);
  
        // 4) Idioma
        if (Array.isArray(data.languages) && data.languages.length) {
          const code = data.languages[0].key.split('/').pop();
          idiomaSelect.value = langMap[code] || 'otro';
        } else {
          idiomaSelect.value = 'otro';
        }
        console.log('Idioma cargado:', idiomaSelect.value);
  
        // 5) Fecha de publicación
        if (data.publish_date) {
            const pd = data.publish_date.trim();
            let pubDate = '';
        
            // 1) Solo año: "2012" → "2012‑01‑01"
            const yearOnly = pd.match(/^(\d{4})$/);
            if (yearOnly) {
            pubDate = `${yearOnly[1]}-01-01`;
        
            // 2) Año + mes: "2012 May" → "2012‑05‑01"
            } else {
            const ym = pd.match(/^(\d{4})\s+([A-Za-z]+)/);
            if (ym) {
                const [ , y, mName ] = ym;
                // uso Date sólo para convertir nombre de mes a número
                const mNum = new Date(`${mName} 1, 2000`).getMonth() + 1;
                pubDate = `${y}-${String(mNum).padStart(2,'0')}-01`;
            }
            // 3) Si viene todo (día, mes y año), lo parseo directo
            else {
                const d = new Date(pd);
                if (!isNaN(d)) {
                pubDate = d.toISOString().slice(0,10);
                }
            }
            }
        
            fechaPubInput.value = pubDate;
        } else {
            fechaPubInput.value = '';
        }
  
        // 6) Número de páginas
        paginasInput.value = data.number_of_pages || '';
        console.log('Páginas:', paginasInput.value);
  
        // 7) Sinopsis
        if (data.notes && data.notes.value) {
          sinopsisInput.value = data.notes.value;
        } else if (data.description) {
          sinopsisInput.value =
            typeof data.description === 'string'
              ? data.description
              : data.description.value || '';
        } else {
          sinopsisInput.value = '';
        }
        console.log('Sinopsis:', sinopsisInput.value);
  
        // 8) Portada
        let coverUrl;
        if (Array.isArray(data.covers) && data.covers.length) {
          coverUrl = `https://covers.openlibrary.org/b/id/${data.covers[0]}-L.jpg`;
        } else {
          coverUrl = `https://covers.openlibrary.org/b/isbn/${isbn}-L.jpg`;
        }
        portadaPreview.innerHTML = '';
        const img = document.createElement('img');
        img.src = coverUrl;
        img.alt = 'Portada desde Open Library';
        img.style.maxWidth  = '200px';
        img.style.maxHeight = '300px';
        portadaPreview.appendChild(img);

        // ocultar todo el drop-area
        const containerPortada = document.querySelector('.drop-area');
        if (containerPortada) {
        containerPortada.style.display = 'none';
        }
  
      } catch (err) {
        console.error('Error en carga de ISBN:', err);
        errorDiv.innerText = err.message;
        errorDiv.classList.remove('hidden');
      } finally {
        // oculto el spinner
        spinner.classList.add('hidden');
      }
    });

     // ===== Drag & Drop de portada =====
  const containerPortada = document.querySelector('.container-portada');
  const dropArea        = containerPortada.querySelector('.drop-area');
  const outputArea      = containerPortada.querySelector('.output-area');
  const fileInput       = document.getElementById('portada');

  // evitar comportamiento por defecto
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(ev => {
    dropArea.addEventListener(ev, e => {
      e.preventDefault();
      e.stopPropagation();
    });
  });

  // estilos al arrastrar
  dropArea.addEventListener('dragover', () => {
    dropArea.classList.add('highlight');
  });
  dropArea.addEventListener('dragleave', () => {
    dropArea.classList.remove('highlight');
  });

  // al soltar
  dropArea.addEventListener('drop', e => {
    dropArea.classList.remove('highlight');
    const files = Array.from(e.dataTransfer.files);
    if (!files.length) return;

    const file = files[0];
    // sólo imágenes
    if (!file.type.startsWith('image/')) return;

    // poblar el input para el form
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;

    // mostrar preview
    const reader = new FileReader();
    reader.onload = ev => {
      outputArea.innerHTML = '';
      const img = document.createElement('img');
      img.src = ev.target.result;
      img.alt = 'Portada cargada';
      img.style.maxWidth  = '200px';
      img.style.maxHeight = '300px';
      outputArea.appendChild(img);

      // ocultar todo el container-portada
      containerPortada.style.display = 'none';
    };
    reader.readAsDataURL(file);
  });

  // click sobre drop-area abre el file picker
  dropArea.addEventListener('click', () => fileInput.click());

  // si el usuario elige manualmente
  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (!file || !file.type.startsWith('image/')) return;

    const reader = new FileReader();
    reader.onload = ev => {
      outputArea.innerHTML = '';
      const img = document.createElement('img');
      img.src = ev.target.result;
      img.alt = 'Portada cargada';
      img.style.maxWidth  = '200px';
      img.style.maxHeight = '300px';
      outputArea.appendChild(img);
      dropArea.style.display = 'none';
    };
    reader.readAsDataURL(file);
  });
});
