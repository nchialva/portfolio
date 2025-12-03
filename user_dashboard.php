<?php
session_start();

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'user') {
    header("Location: ../login.php");
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

header {
    background-color: #111;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header h1 {
    margin: 0;
    font-size: 1.5rem;
    color: #7fe0e6;
}

header a {
    color: #7fe0e6;
    text-decoration: none;
    font-size: 1.1rem;
}

header a:hover {
    text-decoration: underline;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 30px;
    margin-top: 50px;
}

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

#msg {
    margin-top: 40px;
    font-size: 1.3rem;
    color: #ff4444;
    text-align: center;
    display: none;
}
</style>
</head>
<body>

<header>
    <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <a href="login.php">🚪 Logout</a>
</header>

<div class="container">
    <div class="cards">
        <div class="card" onclick="showMessage()">📁 I miei progetti</div>
        <div class="card" onclick="showMessage()">✉️ Messaggio diretto</div>
        <div class="card" onclick="showMessage()">💳 Le mie fatture</div>
    </div>
    <div id="msg">Servizio di prova</div>
</div>

<script>
function showMessage() {
    const msg = document.getElementById('msg');
    msg.style.display = 'block';
}
</script>

</body>
</html>
