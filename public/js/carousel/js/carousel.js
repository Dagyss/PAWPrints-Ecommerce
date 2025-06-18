import { preloadImages } from "./utils.js";

export class Carousel {
  constructor(selector, options = {}) {
    this.container = document.querySelector(selector);
    if (!this.container) throw new Error("Contenedor no encontrado");

    this.options = {
      images: [],
      transition: "fade",
      autoplay: true,
      interval: 5000,
      imagePath: "images/",
      ...options,
    };

    this.images = [];
    this.currentIndex = 0;
    this.autoplayInterval = null;

    this.init();
  }

  async init() {
    try {
      const imageSources = await this.loadImageSources();
      const imgs = await preloadImages(imageSources, this.options.imagePath);
      this.images = imgs;

      this.renderStructure();
      this.initCarousel();
    } catch (err) {
      console.error("Error inicializando el carrusel:", err);
    }
  }

  async loadImageSources() {
    if (Array.isArray(this.options.images)) {
      return this.options.images;
    } else if (typeof this.options.images === "string") {
      const res = await fetch(this.options.images);
      return await res.json();
    } else {
      throw new Error("Formato de imágenes inválido");
    }
  }

  renderStructure() {
    while (this.container.firstChild) {
      this.container.removeChild(this.container.firstChild);
    }

    this.imageContainer = document.createElement("div");
    this.imageContainer.className = "carousel-images";
    this.container.appendChild(this.imageContainer);

    this.thumbnailsContainer = document.createElement("div");
    this.thumbnailsContainer.className = "carousel-thumbnails";
    this.container.appendChild(this.thumbnailsContainer);

    this.prevBtn = document.createElement("button");
    this.prevBtn.className = "carousel-button prev";
    this.prevBtn.innerText = "❮";
    this.container.appendChild(this.prevBtn);

    this.nextBtn = document.createElement("button");
    this.nextBtn.className = "carousel-button next";
    this.nextBtn.innerText = "❯";
    this.container.appendChild(this.nextBtn);

    this.images.forEach((img, i) => {
      const slide = document.createElement("img");
      slide.src = img.src;
      slide.alt = `Imagen ${i + 1}`;
      slide.className = "carousel-image";
      this.imageContainer.appendChild(slide);

      const thumb = document.createElement("img");
      thumb.src = img.src;
      thumb.alt = `Thumbnail ${i + 1}`;
      thumb.className = "carousel-thumb";
      thumb.dataset.index = i;
      this.thumbnailsContainer.appendChild(thumb);
    });
  }

  initCarousel() {
    const imgs = Array.from(this.imageContainer.querySelectorAll("img"));
    const thumbs = Array.from(this.thumbnailsContainer.querySelectorAll("img"));

    const showImage = (index) => {
      imgs.forEach((img, i) => {
        img.style.display = i === index ? "block" : "none";
        img.className = `carousel-image ${this.options.transition}`;
      });

      thumbs.forEach((thumb, i) => {
        thumb.classList.toggle("active", i === index);
      });

      this.currentIndex = index;
    };

    showImage(this.currentIndex);

    this.prevBtn.addEventListener("click", () => {
      const i = (this.currentIndex - 1 + imgs.length) % imgs.length;
      showImage(i);
    });

    this.nextBtn.addEventListener("click", () => {
      const i = (this.currentIndex + 1) % imgs.length;
      showImage(i);
    });

    thumbs.forEach((thumb) => {
      thumb.addEventListener("click", () => {
        showImage(Number(thumb.dataset.index));
      });
    });

    this.setupControls(imgs.length, showImage);

    if (this.options.autoplay) {
      this.autoplayInterval = setInterval(() => {
        const i = (this.currentIndex + 1) % imgs.length;
        showImage(i);
      }, this.options.interval);
    }
  }

  setupControls(total, showImage) {
    let startX = 0;
    this.imageContainer.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX;
    });
    this.imageContainer.addEventListener("touchend", (e) => {
      let endX = e.changedTouches[0].clientX;
      if (startX - endX > 50) this.nextBtn.click();
      else if (endX - startX > 50) this.prevBtn.click();
    });

    window.addEventListener("keydown", (e) => {
      if (e.key === "ArrowRight") this.nextBtn.click();
      else if (e.key === "ArrowLeft") this.prevBtn.click();
    });
  }
}
