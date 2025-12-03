<?php
session_start();
require_once "db.php"; 

$errore = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $data_nascita = trim($_POST['data_nascita']);
    $indirizzo = trim($_POST['indirizzo']);
    $sesso = trim($_POST['sesso']);
    $utente = trim($_POST['utente']);
    $password = trim($_POST['password']);

    if (!empty($nome) && !empty($cognome) && !empty($email) && !empty($telefono) && !empty($data_nascita) && !empty($sesso) && !empty($utente) && !empty($password)) {

        // Comprobar email y usuario existentes
        $checkEmail = $conn->prepare("SELECT idUser FROM users_data WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $resultEmail = $checkEmail->get_result();

        $checkUser = $conn->prepare("SELECT idLogin FROM users_login WHERE utente = ?");
        $checkUser->bind_param("s", $utente);
        $checkUser->execute();
        $resultUser = $checkUser->get_result();

        if ($resultEmail->num_rows > 0) {
            $errore = "❌ Email già registrata, scegli un'altra.";
        } elseif ($resultUser->num_rows > 0) {
            $errore = "❌ Nome utente già in uso, scegli un altro.";
        } else {
            // Insertar datos del usuario
            $stmt = $conn->prepare("INSERT INTO users_data (nome, cognome, email, telefono, data_nascita, indirizzo, sesso) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nome, $cognome, $email, $telefono, $data_nascita, $indirizzo, $sesso);

            if ($stmt->execute()) {
                $idUser = $stmt->insert_id;

                // Hashear la contraseña antes de guardar
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt2 = $conn->prepare("INSERT INTO users_login (utente, password, idUser) VALUES (?, ?, ?)");
                $stmt2->bind_param("ssi", $utente, $hashPassword, $idUser);

                if ($stmt2->execute()) {
                    echo "<script>alert('✅ Utente registrato con successo!'); window.location='login.php';</script>";
                    exit;
                } else {
                    $errore = "❌ Errore durante la creazione dell'account: " . $conn->error;
                }
            } else {
                $errore = "❌ Errore durante la registrazione: " . $conn->error;
            }
        }
    } else {
        $errore = "⚠️ Per favore completa tutti i campi obbligatori.";
    }
}
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione — Nicolas Chialva</title>
<style>
    
/* === Estilo responsive === */
body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.register-box {
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    width:90%;
    max-width:400px;
    text-align:center;
}

.register-box h2 {
    margin-bottom:25px;
    color:#007BFF;
}

.register-box input,
.register-box select {
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #ccc;
    font-size:1rem;
}

.register-box button {
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#007BFF;
    color:#fff;
    font-size:1.1rem;
    cursor:pointer;
    transition:0.3s;
}

.register-box button:hover {
    background:#0056b3;
}

.error-msg {
    color:red;
    margin-bottom:15px;
}

a {
    text-decoration:none;
    color:#007BFF;
    display:block;
    margin-top:15px;
}

/* Ajuste responsive para pantallas pequeñas */
@media(max-width:500px){
    .register-box {
        padding:20px;
    }
    .register-box input,
    .register-box select {
        padding:8px;
        font-size:0.95rem;
    }
    .register-box button {
        padding:10px;
        font-size:1rem;
    }
}
</style>
</head>
<body>

<div class="register-box">
    <h2>Registrati</h2>
    <?php if($errore) echo "<div class='error-msg'>$errore</div>"; ?>
    <form method="POST" action="">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cognome" placeholder="Cognome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="telefono" placeholder="Telefono" required>
        <input type="date" name="data_nascita" required>
        <input type="text" name="indirizzo" placeholder="Indirizzo">
        <select name="sesso" required>
            <option value="">Seleziona sesso</option>
            <option value="M">M</option>
            <option value="F">F</option>
            <option value="Otro">Altro</option>
        </select>
        <input type="text" name="utente" placeholder="Nome utente" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Registrati</button>
    </form>
    <a href="login.php">🔙 Torna al login</a>
</div>

</body>
</html>
