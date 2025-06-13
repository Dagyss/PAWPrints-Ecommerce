document.addEventListener("DOMContentLoaded", () => {
  const menuCheckbox = document.getElementById('hamburger-checkbox');
  const mobileMenu = document.querySelector('.mobile-menu');

  const accountButton = document.getElementById("account-button");
  const accountMenu = document.getElementById("account-menu");

  accountButton.addEventListener("click", (e) => {
    e.stopPropagation();
    accountMenu.classList.toggle("show");
  });

  document.addEventListener("click", (e) => {
    if (!accountMenu.contains(e.target) && !accountButton.contains(e.target)) {
      accountMenu.classList.remove("show");
    }
  });

  let touchStartX = 0;
  let touchEndX = 0;

  mobileMenu.addEventListener('touchstart', function(e) {
      touchStartX = e.changedTouches[0].screenX;
  });

  mobileMenu.addEventListener('touchend', function(e) {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
  });

  function handleSwipe() {
    const swipeDistance = touchStartX - touchEndX;
    if (swipeDistance > 50) {
        menuCheckbox.checked = false;
    }
  }
});
