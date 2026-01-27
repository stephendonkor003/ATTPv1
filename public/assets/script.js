// Background slider
let slides = document.querySelectorAll('.slide');
let index = 0;
function showNextSlide() {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}
setInterval(showNextSlide, 6000);

// Typewriter effect
const text = "The ATTP \nAdministrative Portal!";

const speed = 70; // milliseconds per letter
let i = 0;
const element = document.getElementById("typewriter");

function typeWriter() {
    if (i < text.length) {
        if (text.charAt(i) === "\n") {
            element.innerHTML += "<br>";
        } else {
            element.innerHTML += text.charAt(i);
        }
        i++;
        setTimeout(typeWriter, speed);
    }
}
window.onload = typeWriter;



