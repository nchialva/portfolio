// main.js - hamburguesa, idioma, hover chino solo en mobile, scroll arrow

// ======== HELPERS ========
const navItems = Array.from(document.querySelectorAll('.nav-links a')); // desktop
const mobileItems = Array.from(document.querySelectorAll('.mobile-panel .mobile-item')); // mobile



function applyLanguageLabels() {
    navItems.forEach(a => a.textContent = a.dataset[lang] || a.textContent);
    mobileItems.forEach(a => a.textContent = a.dataset[lang] || a.textContent);
    document.getElementById('langToggle').textContent = '🌐 ' + lang.toUpperCase() + ' ▼';
}

// ======== CUSTOM CURSOR ========
const cursor = document.createElement('div');
cursor.classList.add('custom-cursor');
document.body.appendChild(cursor);
document.addEventListener('mousemove', e => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
});

// ======== HAMBURGER & MOBILE PANEL ========
const hamburger = document.getElementById('hamburger');
const mobilePanel = document.getElementById('mobilePanel');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('open');       // animación de barras
    mobilePanel.classList.toggle('active');   // mostrar/ocultar panel
    mobilePanel.setAttribute('aria-hidden', mobilePanel.classList.contains('active') ? 'false' : 'true');
});

// cerrar panel al hacer click en un item
mobileItems.forEach(item => {
    item.addEventListener('click', () => {
        mobilePanel.classList.remove('active');
        hamburger.classList.remove('open');
        mobilePanel.setAttribute('aria-hidden','true');
    });

    // hover chino solo en mobile
    item.addEventListener('mouseenter', () => {
        mobileItems.forEach(i => {
            if(i === item) {
                i.textContent = i.dataset[lang] || i.textContent;
            } else {
                const key = (i.getAttribute('href')||'').replace('#','');
                i.textContent = zhMap[key] || i.dataset.zh || i.textContent;
            }
        });
    });
    item.addEventListener('mouseleave', () => {
        mobileItems.forEach(i => i.textContent = i.dataset[lang] || i.textContent);
    });
});

// cerrar panel al presionar Escape
document.addEventListener('keydown', e => {
    if(e.key === 'Escape') {
        mobilePanel.classList.remove('active');
        hamburger.classList.remove('open');
        mobilePanel.setAttribute('aria-hidden','true');
        langDropdown.classList.remove('active');
    }
});

// cerrar panel al hacer click fuera
document.addEventListener('click', e => {
    if(!e.composedPath().includes(hamburger) && !e.composedPath().includes(mobilePanel)) {
        mobilePanel.classList.remove('active');
        hamburger.classList.remove('open');
        mobilePanel.setAttribute('aria-hidden','true');
    }
});
const btnAbout = document.getElementById('btnAbout');
const aboutModal = document.getElementById('aboutModal');
const aboutClose = document.getElementById('aboutClose');

btnAbout.addEventListener('click', () => {
  aboutModal.style.display = 'flex';
});

aboutClose.addEventListener('click', () => {
  aboutModal.style.display = 'none';
});

// cerrar modal clic afuera
window.addEventListener('click', (e) => {
  if (e.target === aboutModal) {
    aboutModal.style.display = 'none';
  }
});

// ======== LANGUAGE DROPDOWN ========
const langDropdown = document.getElementById('langDropdown');
const langToggle = document.getElementById('langToggle');

langDropdown.addEventListener('click', e => {
    if(e.target.classList.contains('lang-btn')) {
        lang = e.target.dataset.lang;
        applyLanguageLabels();
        langDropdown.classList.remove('active');
        return;
    }
    langDropdown.classList.toggle('active');
});

// cerrar panel de idioma al click fuera
document.addEventListener('click', e => {
    if(!e.composedPath().includes(langDropdown)){
        langDropdown.classList.remove('active');
    }
});

scrollDown.addEventListener('click', () => {
  const target = document.getElementById('competenze');
  if (target) {
    const navbarHeight = 60; // altura del navbar
    const targetPosition = target.getBoundingClientRect().top + window.scrollY - navbarHeight;
    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
  }
});

// inicializar labels
applyLanguageLabels();

// ======== MODAL PROYECTOS ========
const projectCards = document.querySelectorAll('.project-card');
const modal = document.getElementById('projectModal');
const modalImage = document.getElementById('modalImage');
const modalTitle = document.getElementById('modalTitle');
const modalDesc = document.getElementById('modalDesc');
const modalTech = document.getElementById('modalTech');
const modalWeb = document.getElementById('modalWeb');
const modalGithub = document.getElementById('modalGithub');
const modalClose = document.querySelector('.modal-close');

projectCards.forEach(card => {
    card.addEventListener('click', () => {
        modal.style.display = 'flex';
        modalImage.src = card.querySelector('img').src;
        modalTitle.textContent = card.dataset.title;
        modalDesc.textContent = card.dataset.desc;
        modalTech.textContent = card.dataset.tech;
        modalWeb.href = card.dataset.web;
        modalGithub.href = card.dataset.github;
    });
});

modalClose.addEventListener('click', () => modal.style.display = 'none');
window.addEventListener('click', e => { if(e.target === modal) modal.style.display = 'none'; });

// ======== CONTACT FORM ========
const contactForm = document.getElementById('contactForm');
const formMessage = document.getElementById('formMessage');

contactForm.addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(contactForm);

    fetch('send_mail.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        formMessage.textContent = data.message;
        formMessage.style.color = data.status==='success' ? '#7fe0e6' : '#ff6b6b';
        if(data.status==='success') contactForm.reset();
    })
    .catch(() => {
        formMessage.textContent = "Error al enviar. Intenta más tarde.";
        formMessage.style.color = '#ff6b6b';
    });
});



document.querySelectorAll('.project-card').forEach(card => {
  card.addEventListener('click', () => {
    // Título y descripción
    document.getElementById('modal-title').textContent = card.dataset.title;
    document.getElementById('modal-desc').textContent = card.dataset.desc;

    // Imagen
    document.getElementById('modal-img').src = card.querySelector('img').src;

    // Links
    document.getElementById('modal-web').href = card.dataset.web;
    document.getElementById('modal-github').href = card.dataset.github;

    // Tecnologías
    const techContainer = document.getElementById('modal-tech-icons');
    techContainer.innerHTML = ''; // limpia antes de cargar

    const techList = card.dataset.tech.split(',').map(t => t.trim().toLowerCase());

    techList.forEach(tech => {
      let iconPath = '';

      switch (tech) {
        case 'html': iconPath = 'assets/images/iconsFront/html.png'; break;
        case 'css': iconPath = 'assets/images/iconsFront/css.png'; break;
        case 'js':
        case 'javascript': iconPath = 'assets/images/iconsFront/js.png'; break;
        case 'react': iconPath = 'assets/images/iconsFront/react.png'; break;
        case 'php': iconPath = 'assets/images/iconsBack/php.png'; break;
        // 👉 agregá más según tus tecnologías
      }

      if (iconPath) {
        const img = document.createElement('img');
        img.src = iconPath;
        img.alt = tech.toUpperCase();
        img.title = tech.toUpperCase();
        techContainer.appendChild(img);
      }
    });

    // Mostrar modal
    document.getElementById('projectModal').style.display = 'flex';
  });
});

const techIconsMap = {
  "HTML": "assets/images/iconsFront/html.png",
  "CSS": "assets/images/iconsFront/css.png",
  "JS": "assets/images/iconsFront/js.png",
  "React": "assets/images/iconsFront/react.png",
  "Angular": "assets/images/iconsFront/angular.png",
  "Vue": "assets/images/iconsFront/vue.png",
  "Bootstrap": "assets/images/iconsFront/bootstrap.png"
};

function showTechIcons(techString) {
  const container = document.getElementById('modal-tech-icons');
  container.innerHTML = '';
  techString.split(',').map(t => t.trim()).forEach(tech => {
    if(techIconsMap[tech]){
      const img = document.createElement('img');
      img.src = techIconsMap[tech];
      img.alt = tech;
      img.title = tech;
      container.appendChild(img);
    }
  });
}
