<?php
session_start();
require_once "db.php"; 

$errore = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utente = trim($_POST['utente']);
    $password = trim($_POST['password']);

    if (!empty($utente) && !empty($password)) {
        $stmt = $conn->prepare("SELECT idLogin, utente, password, ruolo, idUser FROM users_login WHERE utente = ?");
        $stmt->bind_param("s", $utente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Comparación directa (sin password_hash)
            if ($password === $row['password']) {
                $_SESSION['idLogin'] = $row['idLogin'];
                $_SESSION['utente'] = $row['utente'];
                $_SESSION['ruolo'] = $row['ruolo'];
                $_SESSION['idUser'] = $row['idUser'];


                // Redirección según rol
                if ($row['ruolo'] === 'admin') {
                    $_SESSION['admin'] = true;
                    header("Location: admin/admin_dashboard.php");
                    exit;
                } else {
                    header("Location: user/user_dashboard.php");
                    exit;
                }
            } else {
                $errore = "❌ Utente o password errati.";
            }
        } else {
            $errore = "❌ Utente o password errati.";
        }
    } else {
        $errore = "⚠️ Per favore completa tutti i campi.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Nicolas Chialva</title>
<style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #0b1522;
    color: #fff;
}

.container {
    width: 100%;
    max-width: 900px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: stretch;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
}

.info-section {
    flex: 1;
    min-width: 300px;
    background: linear-gradient(180deg, #0d1a2b, #0b1522);
    color: #fff;
    padding: 40px;
}

.info-section h1 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #7fe0e6;
}

.info-section p {
    font-size: 1rem;
    line-height: 1.5;
}

.login-section {
    flex: 1;
    min-width: 300px;
    padding: 40px;
    background: #f5f5f5;
    color: #000;
}

.login-box {
    width: 100%;
}

.login-box h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #0b1522;
}

.login-box input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
}

.login-box button {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: none;
    background: #0b1522;
    color: #fff;
    font-size: 1.1rem;
    cursor: pointer;
    transition: 0.3s;
}

.login-box button:hover {
    background: #0e1f36;
}

.error-msg {
    color: red;
    margin-bottom: 15px;
    text-align: center;
}

.back-home, .register-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #0b1522;
    text-decoration: none;
    font-weight: bold;
}

.back-home:hover, .register-link:hover {
    text-decoration: underline;
}

@media(max-width: 768px){
    .container { flex-direction: column; }
}
</style>
</head>
<body>

<div class="container">
    <div class="info-section">
        <h1>Benvenuto!</h1>
        <p>Accedi alla tua area riservata per gestire i tuoi progetti e informazioni personali.</p>
    </div>

    <div class="login-section">
        <div class="login-box">
            <h2>Login</h2>
            <?php if($errore) echo "<div class='error-msg'>$errore</div>"; ?>
            <form method="POST" action="">
                <input type="text" name="utente" placeholder="Nome utente" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Accedi</button>
            </form>
            <a class="register-link" href="register.php">📝 Registrati</a>
            <a class="back-home" href="index.html">🏠 Torna alla home</a>
        </div>
    </div>
</div>

</body>
</html>
