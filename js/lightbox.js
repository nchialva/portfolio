
//skills

document.addEventListener("DOMContentLoaded", () => {
  const lightboxes = document.querySelectorAll(".lightbox");

  lightboxes.forEach(lb => {
    const openBtn = document.querySelector(`[data-lightbox-target="${lb.id}"]`);
    const closeBtn = lb.querySelector(".close-lightbox");

    if (openBtn) {
      openBtn.addEventListener("click", e => {
        e.preventDefault();
        lb.style.display = "flex";
        document.body.style.overflow = "hidden"; 
      });
    }

    closeBtn.addEventListener("click", () => {
      lb.style.display = "none";
      document.body.style.overflow = ""; 
    });

    window.addEventListener("click", e => {
      if (e.target === lb) {
        lb.style.display = "none";
        document.body.style.overflow = ""; 
      }
    });
  });
});
document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modalProyecto');
  const modalCarousel = modal.querySelector('.modal-carousel');
  const modalTitle = modal.querySelector('.modal-right h3');
  const modalDesc = modal.querySelector('.modal-right p');
  const modalTechIcons = modal.querySelector('.modal-tech-icons');
  const modalLink = modal.querySelector('.modal-links a');
  const modalClose = modal.querySelector('.modal-close');
  const prevBtn = modal.querySelector('.prev-btn');
  const nextBtn = modal.querySelector('.next-btn');

  let currentIndex = 0;
  let images = [];

  const cards = document.querySelectorAll('.project-card');

  cards.forEach(card => {
    const btn = card.querySelector('.see-more-btn');
    if (!btn) return;

    btn.addEventListener('click', () => {
      // Cargar imágenes (pueden venir separadas por comas)
      const imgData = card.dataset.images || card.querySelector('img').src;
      images = imgData.split(',').map(img => img.trim());
      currentIndex = 0;

      showImage(currentIndex);

      // Título y descripción
      modalTitle.textContent = card.dataset.title;
      modalDesc.textContent = card.dataset.desc;

      // Tecnologías
      modalTechIcons.innerHTML = '';
      if (card.dataset.tech) {
        card.dataset.tech.split(',').map(t => t.trim()).forEach(t => {
          const span = document.createElement('span');
          span.textContent = t;
          span.style.marginRight = "10px";
          span.style.background = "#007BFF";
          span.style.padding = "5px 10px";
          span.style.borderRadius = "6px";
          span.style.color = "#fff";
          modalTechIcons.appendChild(span);
        });
      }

      // Link de GitHub
      modalLink.href = card.dataset.github || '#';

      // Mostrar modal
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    });
  });

  // Función para mostrar una imagen del carrusel
  function showImage(index) {
    modalCarousel.innerHTML = '';
    const img = document.createElement('img');
    img.src = images[index];
    img.alt = 'Proyecto imagen ' + (index + 1);
    img.style.width = '100%';
    img.style.borderRadius = '10px';
    modalCarousel.appendChild(img);
  }

  // Botones de navegación
  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
  });

  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
  });

  // Cerrar modal
  modalClose.addEventListener('click', () => {
    modal.style.display = 'none';
    document.body.style.overflow = '';
  });

  // Cerrar al hacer clic fuera
  window.addEventListener('click', e => {
    if (e.target === modal) {
      modal.style.display = 'none';
      document.body.style.overflow = '';
    }
  });
});
