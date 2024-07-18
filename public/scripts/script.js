// LANDING PAGE ANIMATIONS

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
            entry.target.classList.remove('hidden');
        } else {
            entry.target.classList.add('hidden');
            entry.target.classList.remove('show');
        }
    });
});

const elements = document.querySelectorAll('.hidden');

elements.forEach((element) => observer.observe(element));

// HEADER SHRINK ANIMATION

window.addEventListener('scroll', function() {
    const header = document.getElementById('main-header');
    const scrollY = window.scrollY;

    if (scrollY > 0) {
        header.classList.add('shrink');
    } else {
        header.classList.remove('shrink');
    }
});

// HAMBURGER MENU

const hamburger = document.querySelector('.hamburger-menu');
const mainNav = document.querySelector('#main-navigation');
const subHeader = document.querySelector('#sub-header');

hamburger.addEventListener('click', () => {
    mainNav.classList.toggle('actived-menu');
    hamburger.classList.toggle('actived-hamburger');
    subHeader.classList.toggle('d-none');
});


 var links = document.querySelectorAll('.header-nav-link');

 links.forEach(function(link) {
     link.addEventListener('click', function(event) {

         var hamburger = document.querySelector('.hamburger-menu');
         hamburger.click();
     });
 });