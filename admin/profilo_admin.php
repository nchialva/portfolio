<?php
session_start();
require_once "./../db.php";

// Verificar si está logueado como admin
if (!isset($_SESSION['idLogin']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$idLogin = $_SESSION['idLogin'];

// Traer datos del admin
$stmt = $conn->prepare("SELECT ud.nome, ud.cognome, ud.email, ul.utente 
                        FROM users_data ud
                        JOIN users_login ul ON ud.idUser = ul.idUser
                        WHERE ul.idLogin = ?");
$stmt->bind_param("i", $idLogin);
$stmt->execute();
$result = $stmt->get_result();
$dati = $result->fetch_assoc();

// Cambiar contraseña
$successo = $errore = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuova_password'])) {
    $nuova_password = trim($_POST['nuova_password']);

    if (!empty($nuova_password)) {
        // ⚠️ Cambiar a password_hash() si quieres seguridad
        $stmt = $conn->prepare("UPDATE users_login SET password = ? WHERE idLogin = ?");
        $stmt->bind_param("si", $nuova_password, $idLogin);

        if ($stmt->execute()) {
            $successo = "✅ Password aggiornata con successo!";
        } else {
            $errore = "❌ Errore durante l'aggiornamento della password.";
        }
    } else {
        $errore = "⚠️ Inserisci una nuova password.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>👤 Profilo Amministratore</title>
<style>
/* === ESTILO OSCURO UNIFICADO === */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #0b1522;
    color: #fff;
}

/* Navbar */
header {
    background: #111;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}
header h1 {
    margin: 0;
    color: #7fe0e6;
    font-size: 1.5rem;
}
header nav a {
    margin-left: 20px;
    text-decoration: none;
    color: #7fe0e6;
    font-weight: 500;
}
header nav a:hover {
    text-decoration: underline;
}

/* Contenedor */
.container {
    width: 90%;
    max-width: 600px;
    margin: 50px auto;
    background: #1c1c1c;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,255,255,0.3);
}

h2 {
    text-align: center;
    color: #7fe0e6;
    margin-bottom: 30px;
}

/* Campos de información */
.info label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #7fe0e6;
}
.info input {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background: #16263e;
    color: #fff;
    margin-bottom: 15px;
    font-size: 1rem;
}
.info input[readonly] {
    opacity: 0.8;
}

/* Formulario de cambio de contraseña */
.form-password label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #7fe0e6;
}
.form-password input {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: 8px;
    border: none;
    background: #16263e;
    color: #fff;
}
button {
    width: 100%;
    padding: 14px;
    border: none;
    background: #7fe0e6;
    color: #000;
    font-size: 1.1rem;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background: #00c2c7;
}

/* Mensajes */
.messaggio {
    text-align: center;
    margin-top: 15px;
    font-weight: bold;
}
.successo { color: #28a745; }
.errore { color: #dc3545; }

/* Responsive */
@media (max-width: 768px) {
    header {
        flex-direction: column;
        align-items: flex-start;
    }
    header nav a {
        margin: 10px 0;
        display: block;
    }
}
</style>
</head>
<body>

<header>
    <h1>👤 Profilo Admin</h1>
    <nav>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="./../logout.php">🚪 Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Informazioni Personali</h2>

    <div class="info">
        <label>Nome:</label>
        <input type="text" value="<?php echo htmlspecialchars($dati['nome']); ?>" readonly>

        <label>Cognome:</label>
        <input type="text" value="<?php echo htmlspecialchars($dati['cognome']); ?>" readonly>

        <label>Email:</label>
        <input type="text" value="<?php echo htmlspecialchars($dati['email']); ?>" readonly>

        <label>Nome utente:</label>
        <input type="text" value="<?php echo htmlspecialchars($dati['utente']); ?>" readonly>
    </div>

    <form class="form-password" method="POST">
        <label>Nuova password:</label>
        <input type="password" name="nuova_password" placeholder="Inserisci nuova password">
        <button type="submit">🔐 Cambia Password</button>
    </form>

    <?php if ($successo): ?>
        <p class="messaggio successo"><?php echo $successo; ?></p>
    <?php elseif ($errore): ?>
        <p class="messaggio errore"><?php echo $errore; ?></p>
    <?php endif; ?>
</div>

</body>
</html>
