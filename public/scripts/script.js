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