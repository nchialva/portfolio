<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require_once "./../db.php";

// === CREAR NUEVO USUARIO ===
if (isset($_POST['create_user'])) {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $data_nascita = $_POST['data_nascita'];
    $sesso = $_POST['sesso'];
    $ruolo = $_POST['ruolo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt1 = $conn->prepare("INSERT INTO users_data (nome, cognome, email, telefono, data_nascita, sesso) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssss", $nome, $cognome, $email, $telefono, $data_nascita, $sesso);
    $stmt1->execute();
    $idUser = $stmt1->insert_id;
    $stmt1->close();

    $utente = strtolower($nome) . "." . strtolower($cognome);
    $stmt2 = $conn->prepare("INSERT INTO users_login (utente, password, ruolo, idUser) VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("sssi", $utente, $password, $ruolo, $idUser);
    $stmt2->execute();
    $stmt2->close();

    header("Location: utenti_admin.php?created=1");
    exit();
}

// === ELIMINAR USUARIO ===
if (isset($_GET['delete'])) {
    $idDelete = intval($_GET['delete']);
    $conn->query("DELETE FROM users_login WHERE idUser = $idDelete");
    $conn->query("DELETE FROM users_data WHERE idUser = $idDelete");
    header("Location: utenti_admin.php?deleted=1");
    exit();
}

// === ACTUALIZAR CONTRASEÑA ===
if (isset($_POST['update_password'])) {
    $idUser = intval($_POST['idUser']);
    $newPass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users_login SET password = ? WHERE idUser = ?");
    $stmt->bind_param("si", $newPass, $idUser);
    $stmt->execute();
    $stmt->close();

    header("Location: utenti_admin.php?updated=1");
    exit();
}

// === OBTENER TODOS LOS USUARIOS ===
$result = $conn->query("
    SELECT ud.idUser, ud.nome, ud.cognome, ud.email, ul.ruolo 
    FROM users_data ud 
    JOIN users_login ul ON ud.idUser = ul.idUser 
    ORDER BY ud.idUser DESC
");
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestione Utenti - Admin</title>
<style>
/* === ESTILO UNIFICADO + RESPONSIVE === */
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background-color: #0b1522;
    color: #fff;
}

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

.container {
    width: 90%;
    max-width: 1000px;
    margin: 40px auto;
    background: #1c1c1c;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,255,255,0.3);
}

h2, h1 {
    color: #7fe0e6;
    text-align: center;
}

form input, form select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: none;
    font-size: 1rem;
}

form button {
    width: 100%;
    padding: 12px;
    background: #7fe0e6;
    color: #000;
    font-size: 1.1rem;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

form button:hover {
    background: #00c2c7;
}

.alert {
    padding: 12px;
    border-radius: 6px;
    text-align: center;
    margin-bottom: 20px;
}

.alert-success { background: #28a745; }
.alert-warning { background: #ffc107; color: #000; }
.alert-danger  { background: #dc3545; }

.tabella {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    overflow-x: auto;
    display: block;
}

.tabella th, .tabella td {
    padding: 12px;
    border-bottom: 1px solid #555;
    text-align: center;
    white-space: nowrap;
}

.tabella th {
    background: #0e1f36;
    color: #7fe0e6;
}

.azioni {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.azioni form {
    display: flex;
    flex-direction: column;
}

.azioni input[type="password"] {
    padding: 6px;
    margin-bottom: 5px;
    font-size: 0.9rem;
}

.azioni button {
    font-size: 0.9rem;
    padding: 8px;
    border-radius: 6px;
}

.delete-btn {
    background: #dc3545;
    color: #fff;
}

.change-btn {
    background: #ffc107;
    color: #000;
}

@media (min-width: 600px) {
    .azioni {
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
    .azioni form {
        flex-direction: row;
        align-items: center;
    }
    .azioni input[type="password"] {
        width: 150px;
        margin-right: 5px;
        margin-bottom: 0;
    }
}

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
    <h1>Gestione Utenti</h1>
    <nav>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="./../logout.php">🚪 Logout</a>
    </nav>
</header>

<div class="container">

    <?php if (isset($_GET['created'])): ?>
        <div class="alert alert-success">✅ Nuovo utente creato con successo.</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">✅ Utente eliminato con successo.</div>
    <?php endif; ?>
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">🔑 Password aggiornata con successo.</div>
    <?php endif; ?>

    <h2>➕ Crea Nuovo Utente</h2>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="cognome" placeholder="Cognome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="telefono" placeholder="Telefono" required>
        <input type="date" name="data_nascita" required>
        <select name="sesso">
            <option value="M">Maschio</option>
            <option value="F">Femmina</option>
            <option value="Altro">Altro</option>
        </select>
        <input type="password" name="password" placeholder="Password" required>
        <select name="ruolo">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="create_user">✅ Crea Utente</button>
    </form>

    <h2>📋 Elenco Utenti</h2>
    <div style="overflow-x:auto;">
    <table class="tabella">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Ruolo</th>
            <th>Azioni</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['idUser'] ?></td>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['cognome']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['ruolo']) ?></td>
                <td class="azioni">
                    <form method="GET">
                        <input type="hidden" name="delete" value="<?= $row['idUser'] ?>">
                        <button type="submit" class="delete-btn" onclick="return confirm('Sei sicuro di voler eliminare questo utente?')">🗑️ Elimina</button>
                    </form>
                    <form method="POST">
                        <input type="hidden" name="idUser" value="<?= $row['idUser'] ?>">
                        <input type="password" name="new_password" placeholder="Nuova password" required>
                        <button type="submit" name="update_password" class="change-btn">🔑 Cambia</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>
</div>
</body>
</html>
