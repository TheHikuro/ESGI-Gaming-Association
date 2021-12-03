import ScrollReveal from "scrollreveal";

const sr = ScrollReveal({ reset: true });
// Navbar
sr.reveal('.home', {origin: 'right' , distance: '20px', duration: 800, delay: 100, opacity: 0, scale: 1});
sr.reveal('.profil', {origin: 'right', distance: '20px', duration: 800, delay: 200, opacity: 0, scale: 1});
sr.reveal('.association', {origin: 'right', distance: '20px', duration: 800, delay: 300, opacity: 0, scale: 1});
sr.reveal('.forum', {origin: 'right', distance: '20px', duration: 800, delay: 400, opacity: 0, scale: 1});
sr.reveal('.settings', {origin: 'right', distance: '20px', duration: 800, delay: 500, opacity: 0, scale: 1});