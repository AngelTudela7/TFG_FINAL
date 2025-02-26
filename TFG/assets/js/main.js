

const hamburgerMenu = document.getElementById('hamburger-menu');
const mobileMenu = document.getElementById('mobile-menu');

// Alternar el menú hamburguesa
hamburgerMenu.addEventListener('click', () => {
  hamburgerMenu.classList.toggle('active');
  mobileMenu.classList.toggle('active');
});


