 document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll("section");

  const revealSection = () => {
    sections.forEach((section) => {
      const sectionTop = section.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;

      // Si la sección está dentro del viewport
      if (sectionTop < windowHeight - 100) {
        section.classList.add("visible");
      } else {
        section.classList.remove("visible");
      }
    });
  };

  // Llamar a revealSection cuando se carga la página y al hacer scroll
  revealSection();
  window.addEventListener("scroll", revealSection);
});