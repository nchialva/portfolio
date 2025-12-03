<?php
session_start();
require_once "./../db.php"; // db.php debe definir $conn

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['utente']) || $_SESSION['ruolo'] !== 'user') {
    header("Location: login.php");
    exit;
}

$errore = "";
$successo = "";

// Obtener datos actuales del usuario
$utente = $_SESSION['utente'];

$stmt = $conn->prepare("SELECT u.nome, u.cognome, u.email, u.telefono, u.data_nascita, u.indirizzo, u.sesso 
                        FROM users_data u 
                        JOIN users_login l ON u.idUser = l.idUser 
                        WHERE l.utente = ?");
$stmt->bind_param("s", $utente);
$stmt->execute();
$result = $stmt->get_result();
$utenteData = $result->fetch_assoc();

// Procesar actualización de password únicamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);

    if (!empty($password)) {
        $stmt2 = $conn->prepare("UPDATE users_login SET password=? WHERE utente=?");
        $stmt2->bind_param("ss", $password, $utente);

        if ($stmt2->execute()) {
            $successo = "✅ Password aggiornata con successo!";
        } else {
            $errore = "❌ Errore durante l'aggiornamento della password: " . $conn->error;
        }
    } else {
        $errore = "⚠️ Lascia il campo vuoto se non vuoi cambiare la password.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profilo — Nicolas Chialva</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #0b1522;
    color: #fff;
    margin: 0;
    padding: 65px 0 0 0; /* espacio para navbar */
}

/* ======= NAVBAR ======= */
.navbar {
    width: 100%;
    background: #111c2e;
    padding: 15px 20px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1001;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.nav-container {
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    justify-content: flex-end;
    gap: 20px;
}

.nav-link {
    color: #7fe0e6;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: 0.3s;
}

.nav-link:hover {
    color: #00c2c7;
}

@media(max-width: 480px){
    .nav-container {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
}

/* ======= BOTÓN PERFIL ======= */
.btn-perfil {
    display: block;
    margin: 30px auto;
    padding: 12px 25px;
    background-color: #007BFF;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    color: #fff;
    font-size: 1rem;
}
.btn-perfil:hover { background-color: #0056b3; }

/* ======= MODAL ======= */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.7);
}

.modal-content {
    background-color: #1c1c1c;
    margin: 10% auto;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    color: #fff;
    position: relative;
}

.modal-content h2 {
    text-align: center;
    margin-bottom: 20px;
}

.close {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Formulario */
.modal-content input, .modal-content select {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
    background-color: #2c2c2c;
    color: #fff;
}

.modal-content input[readonly], .modal-content select[disabled] {
    background-color: #444;
    color: #ccc;
    cursor: not-allowed;
}

.modal-content button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #007BFF;
    color: #fff;
    font-size: 1.1rem;
    cursor: pointer;
    transition: 0.3s;
}

.modal-content button:hover { background: #0056b3; }

/* Mensajes */
.success-msg { color: #00ff88; margin-bottom: 15px; text-align:center; }
.error-msg { color: #ff4444; margin-bottom: 15px; text-align:center; }
</style>
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="nav-container">
        <a href="user_dashboard.php" class="nav-link">🏠 Dashboard</a>
        <a href="./../logout.php" class="nav-link">🚪 Logout</a>
    </div>
</header>

<!-- Botón para abrir modal -->
<button class="btn-perfil" onclick="openModal()">👤 Il mio Profilo</button>

<!-- Modal -->
<div id="profiloModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Profilo Utente</h2>

        <?php if($successo) echo "<div class='success-msg'>$successo</div>"; ?>
        <?php if($errore) echo "<div class='error-msg'>$errore</div>"; ?>

        <form method="POST" action="">
            <input type="text" name="nome" value="<?php echo htmlspecialchars($utenteData['nome']); ?>" readonly>
            <input type="text" name="cognome" value="<?php echo htmlspecialchars($utenteData['cognome']); ?>" readonly>
            <input type="email" name="email" value="<?php echo htmlspecialchars($utenteData['email']); ?>" readonly>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($utenteData['telefono']); ?>" readonly>
            <input type="date" name="data_nascita" value="<?php echo htmlspecialchars($utenteData['data_nascita']); ?>" readonly>
            <input type="text" name="indirizzo" value="<?php echo htmlspecialchars($utenteData['indirizzo']); ?>" readonly>
            <select name="sesso" disabled>
                <option value="M" <?php if($utenteData['sesso']=='M') echo 'selected'; ?>>M</option>
                <option value="F" <?php if($utenteData['sesso']=='F') echo 'selected'; ?>>F</option>
                <option value="Otro" <?php if($utenteData['sesso']=='Otro') echo 'selected'; ?>>Altro</option>
            </select>
            <input type="password" name="password" placeholder="Nuova Password (lascia vuoto se non vuoi cambiare)">
            <button type="submit">Aggiorna Password</button>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('profiloModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('profiloModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('profiloModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
