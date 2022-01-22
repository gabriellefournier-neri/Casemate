window.addEventListener("scroll", () => {
    let header = document.querySelector(".header-menu");
    header.classList.toggle("sticky", window.scrollY > 0);
  });