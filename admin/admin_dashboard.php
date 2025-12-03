<?php
session_start();

// Verificar que el usuario haya iniciado sesión y sea admin
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin — Nicolas Chialva</title>

<style>
/* --- Estilo general --- */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #0b1522;
    color: #fff;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* --- Navbar --- */
nav {
    background-color: #111;
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 15px 0;
    flex-wrap: wrap;
}

nav a {
    color: #7fe0e6;
    text-decoration: none;
    font-size: 1.1rem;
    margin: 5px 10px;
}

nav a:hover {
    text-decoration: underline;
}

/* --- Container principal --- */
.container {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 30px;
    padding: 40px 20px;
}

/* --- Tarjetas --- */
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
    width: 300px;
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
    font-size: 1.4rem;
}

.card p {
    font-size: 1.1rem;
    line-height: 1.4;
    color: #ccc;
}

/* --- Mensaje de prueba --- */
#msg {
    margin-top: 40px;
    font-size: 1.3rem;
    color: #ff4444;
    text-align: center;
    display: none;
}

/* --- Responsive --- */
@media(max-width: 768px) {
    .cards {
        flex-direction: column;
        align-items: center;
    }
}
</style>
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="utenti_admin.php">Utenti Amministrazione</a>
    <a href="citazioni_admin.php">Citazioni Amministrazione</a>
    <a href="./notizie_amministrazione.php">Notizie Amministrazione</a>
    <a href="./profilo_admin.php" >Profilo</a>
    <a href="./../logout.php">🚪 Logout</a>
</nav>

<div class="container">
    <h1>Benvenuto Admin <?php echo htmlspecialchars($_SESSION['utente']); ?>!</h1>
    <div class="cards">
        <div class="card" onclick="showMessage()">📁 Gestione Progetti</div>
        <div class="card" onclick="showMessage()">✉️ Messaggi</div>
        <div class="card" onclick="showMessage()">💳 Fatture</div>
        <div class="card" onclick="showMessage()">📰 Gestione Notizie</div>
        <div class="card" onclick="showMessage()">👥 Gestione Utenti</div>
        <div class="card" onclick="showMessage()">📅 Gestione Citazioni</div>
    </div>
    <div id="msg">Funzione di prova</div>
</div>

<script>
function showMessage() {
    const msg = document.getElementById('msg');
    msg.style.display = 'block';
}
</script>

</body>
</html>
