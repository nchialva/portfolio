
/* ==================================================================================================================================================================
                                                                                SEZIONE PROGETTI
================================================================================================================================================================== */

#progetti .section-title {
  text-align: center;
  font-size: 2.4rem;       
  margin-top: 220px;        
  margin-bottom: 50px;      
  font-weight: 700;
  letter-spacing: 1.5px;
  color: #fff;
}

.projects-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 28px;
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
}

.project-card {
  position: relative;
  overflow: hidden;
  border-radius: 14px;
  cursor: pointer;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(8px);
  box-shadow: 0 0 0 rgba(0, 0, 0, 0);
  transition: transform 0.35s ease, box-shadow 0.35s ease;
  text-align: center;
  padding-bottom: 40px;
}

.project-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  transition: transform 0.35s ease;
}

.project-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
}

.project-card:hover img {
  transform: scale(1.07);
}

.project-title {
  position: relative;
  z-index: 2;
  margin: 16px 0 8px;
  font-weight: 700;
  font-size: 1.1rem;
  color: #fff;
  letter-spacing: 0.5px;
}

.see-more-btn {
  position: absolute;
  bottom: -40px;
  left: 50%;
  transform: translateX(-50%);
  padding: 8px 18px;
  border: none;
  border-radius: 6px;
  background: linear-gradient(135deg, #007BFF, #00C0FF);
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.9rem;
  transition: all 0.3s ease;
  z-index: 2;
}

.project-card:hover .see-more-btn {
  bottom: 16px;
  box-shadow: 0 6px 14px rgba(0, 123, 255, 0.4);
}

.see-more-btn:hover {
  background: linear-gradient(135deg, #00C0FF, #007BFF);
  transform: scale(1.05);
}

/* ===========================
   LIGHTBOX MODAL
=========================== */
.modal {
  display: none;
  position: fixed;
  z-index: 100;
  inset: 0;
  background: rgba(0,0,0,0.85);
  justify-content: center;
  align-items: center;
  padding: 20px;
}

.modal-content {
  display: flex;
  flex-wrap: wrap;
  background: #111;
  border-radius: 12px;
  max-width: 900px;
  width: 100%;
  overflow: hidden;
}

.modal-left {
  flex: 1 1 50%;
}

.modal-left img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.modal-right {
  flex: 1 1 50%;
  padding: 24px;
  color: #fff;
}

.modal-right h3 {
  font-size: 1.8rem;
  margin-bottom: 16px;
}

.modal-right p {
  margin-bottom: 12px;
}

.modal-links a {
  display: inline-block;
  margin-right: 12px;
  padding: 8px 12px;
  border-radius: 6px;
  background: #007BFF;
  color: #fff;
  text-decoration: none;
  transition: background 0.2s;
}

.modal-links a:hover {
  background: #00C0FF;
}

/* Cerrar modal */
.modal-close {
  position: absolute;
  top: 12px;
  right: 20px;
  font-size: 2rem;
  cursor: pointer;
  color: #fff;
}

/* Modal fondo */
.modal {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 100;
  background: rgba(0,0,0,0.95);
  justify-content: center;
  align-items: center;
  padding: 20px;
  font-family: 'Poppins', sans-serif; 
}

/* Contenido */
.modal-content {
  display: flex;
  flex-wrap: wrap;
  background: #111;
  border-radius: 20px;
  max-width: 1200px;   
  width: 95%;          
  height: 80vh;       
  overflow: hidden;
  box-shadow: 0 15px 40px rgba(0,0,0,0.6);
  transform: translateY(-20px);
  transition: transform 0.4s, opacity 0.4s;
  font-family: 'Poppins', sans-serif;
}

/* Left (imagen) */
.modal-left {
  flex: 1 1 50%;
}

.modal-left img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 20px 0 0 20px;
}

/* Right (contenido) */
.modal-right {
  flex: 1 1 50%;
  padding: 40px;
  color: #fff;
}

.modal-right h3 {
  font-size: 2.2rem;
  margin-bottom: 18px;
  font-weight: 700;
}

.modal-right p {
  font-size: 1.2rem;
  margin-bottom: 24px;
  line-height: 1.6;
}

.modal-tech-icons {
  display: flex;
  gap: 16px;
  margin-bottom: 28px;
}

.modal-tech-icons img {
  width: 60px;
  height: 60px;
}

/* Botones grandes */
.modal-links {
  display: flex;
  gap: 20px;
}

.modal-links .big-btn {
  padding: 16px 26px;
  border-radius: 10px;
  background: #007BFF;
  color: #fff;
  text-decoration: none;
  font-weight: 700;
  font-size: 1.1rem;
  transition: background 0.3s, transform 0.2s;
}

.modal-links .big-btn:hover {
  background: #00C0FF;
  transform: translateY(-3px);
}

/* Botón cerrar */
.modal-close {
  position: absolute;
  top: 20px;
  right: 28px;
  font-size: 3rem;
  cursor: pointer;
  color: #fff;
}

/* Responsive */
@media (max-width: 900px) {
  .modal-content {
    flex-direction: column;
    height: auto;
  }
  .modal-left, .modal-right {
    flex: 1 1 100%;
  }
  .modal-right {
    padding: 24px;
  }
  .modal-tech-icons img {
    width: 50px;
    height: 50px;
  }
  .modal-links {
    flex-direction: column;
    gap: 12px;
  }
}


/* ===========================
   MEDIA QUERIES - RESPONSIVE
=========================== */
@media (max-width: 900px) {
  .projects-container {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
  }

  .project-card img {
    width: 100%;
  }
}

@media (max-width: 700px) {
  .projects-container {
    grid-template-columns: 1fr; 
  }

  .modal-content {
    flex-direction: column;
  }

  .modal-left, .modal-right {
    flex: 1 1 100%;
  }

  .modal-right h3 {
    font-size: 1.5rem;
  }
}


.project-card {
  position: relative;
  overflow: hidden;
  border-radius: 12px;
  cursor: pointer;
  transition: transform 0.3s;
  text-align: center;
}

.project-card img {
  width: 100%;
  display: block;
  transition: transform 0.3s;
}

.project-card:hover img {
  transform: translateY(-10px) scale(1.05); 
}

.project-title {
  position: relative;
  z-index: 2;
  margin-bottom: 8px;
  font-weight: 600;
  color: #fff;
}

.see-more-btn {
  position: absolute;
  bottom: -40px; 
  left: 50%;
  transform: translateX(-50%);
  padding: 8px 16px;
  border: none;
  border-radius: 6px;
  background: #007BFF;
  color: #fff;
  cursor: pointer;
  font-weight: 600;
  transition: bottom 0.3s;
  z-index: 2;
}

.project-card:hover .see-more-btn {
  bottom: 16px; 
}
