<?php
session_start();

// Verificar que el usuario haya iniciado sesión y que sea un 'user'
if (!isset($_SESSION['utente']) || $_SESSION['ruolo'] !== 'user') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Utente — Nicolas Chialva</title>
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #0b1522;
    color: #fff;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* Barra de navegación */
nav {
    background-color: #111;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
}

nav h1 {
    margin: 0;
    font-size: 1.5rem;
    color: #7fe0e6;
}

nav a {
    color: #7fe0e6;
    text-decoration: none;
    font-size: 1.1rem;
    margin-left: 20px;
}

nav a:hover {
    text-decoration: underline;
}

/* Contenedor principal */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 30px;
    margin-top: 50px;
}

/* Tarjetas de opciones */
.cards {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
}

.card {
    background-color: #1c1c1c;
    padding: 50px 30px;
    border-radius: 15px;
    width: 250px;
    text-align: center;
    box-shadow: 0 0 15px #7fe0e6;
    transition: transform 0.3s, background 0.3s;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-5px);
    background-color: #0e1f36;
}

.card h2 {
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.card p {
    font-size: 1.05rem;
    line-height: 1.4;
    color: #ccc;
}

/* Mensaje de prueba */
#msg {
    margin-top: 40px;
    font-size: 1.2rem;
    color: #ff4444;
    text-align: center;
    display: none;
}

/* Responsive */
@media(max-width: 768px){
    .cards {
        flex-direction: column;
        align-items: center;
    }
}
</style>
</head>
<body>

<!-- Barra de navegación -->
<nav>
    <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['utente']); ?>!</h1>
    <div>
        <a href="citazioni.php">📅 Citazioni</a>
        <a href="profilo.php">👤 Profilo</a>
        <a href="./../logout.php">🚪 Logout</a>
    </div>
</nav>


<div class="container">
    <div class="cards">
        <div class="card" onclick="showMessage('📁 Le mie progetti')">
            <h2>📁 Progetti</h2>
            <p>Visualizza i tuoi progetti attivi</p>
        </div>
        <div class="card" onclick="showMessage('✉️ Messaggi')">
            <h2>✉️ Messaggi</h2>
            <p>Invia e ricevi messaggi</p>
        </div>
        <div class="card" onclick="showMessage('💳 Fatture')">
            <h2>💳 Fatture</h2>
            <p>Visualizza e scarica le tue fatture</p>
        </div>
    </div>
    <div id="msg"></div>
</div>

<script>
function showMessage(msgText) {
    const msg = document.getElementById('msg');
    msg.textContent = msgText;
    msg.style.display = 'block';
}
</script>

</body>
</html>
