document.addEventListener("DOMContentLoaded", () => {
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
});
