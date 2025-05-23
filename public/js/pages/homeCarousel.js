document.addEventListener("DOMContentLoaded", () => {
  const booksCarousel = document.getElementById("books-carousel");
  const booksCarouselBestSales = document.getElementById(
    "books-carousel-best-sales"
  );
  const next = document.querySelector(".nav.next");
  const prev = document.querySelector(".nav.prev");

  const nextBestSales = document.querySelector(".nav.next-best-sales");
  const prevBestSales = document.querySelector(".nav.prev-best-sales");

  const cardWidth = booksCarousel.querySelector(".book-card").offsetWidth + 16;
  const cardWidthBestSales =
    booksCarouselBestSales.querySelector(".book-card").offsetWidth + 16;

  next.addEventListener("click", () => {
    booksCarousel.scrollBy({ left: cardWidth, behavior: "smooth" });
  });

  prev.addEventListener("click", () => {
    booksCarousel.scrollBy({ left: -cardWidth, behavior: "smooth" });
  });

  nextBestSales.addEventListener("click", () => {
    booksCarouselBestSales.scrollBy({
      left: cardWidthBestSales,
      behavior: "smooth",
    });
  });

  prevBestSales.addEventListener("click", () => {
    booksCarouselBestSales.scrollBy({
      left: -cardWidthBestSales,
      behavior: "smooth",
    });
  });
});
