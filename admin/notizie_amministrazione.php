<?php
session_start();
require_once "./../db.php";

// ✅ Verifica se l'utente è loggato ed è admin
if (!isset($_SESSION['ruolo']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// ✅ Controlla che l'idUser esista nella sessione
if (!isset($_SESSION['idUser']) || empty($_SESSION['idUser'])) {
    die("❌ Errore: ID utente non valido. Accedi di nuovo come amministratore.");
}

$errore = "";
$successo = "";

// ✅ Inserimento di una nuova notizia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titolo = trim($_POST['titolo']);
    $testo = trim($_POST['testo']);
    $immagine = trim($_POST['immagine']); // puoi lasciarlo vuoto o gestire un upload
    $idUser = $_SESSION['idUser'];

    if (!empty($titolo) && !empty($testo)) {
        $stmt = $conn->prepare("INSERT INTO notizie (titolo, testo, immagine, data_pubblicazione, idUser) VALUES (?, ?, ?, NOW(), ?)");
        $stmt->bind_param("sssi", $titolo, $testo, $immagine, $idUser);

        if ($stmt->execute()) {
            $successo = "✅ Notizia pubblicata con successo!";
        } else {
            $errore = "❌ Errore durante l'inserimento della notizia: " . $conn->error;
        }
    } else {
        $errore = "⚠️ Inserisci almeno titolo e testo.";
    }
}

// ✅ Recupera tutte le notizie esistenti
$result = $conn->query("SELECT n.idNotizia, n.titolo, n.testo, n.data_pubblicazione, u.nome, u.cognome 
                        FROM notizie n 
                        JOIN users_data u ON n.idUser = u.idUser 
                        ORDER BY n.data_pubblicazione DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestione Notizie — Admin</title>
<style>
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
}

header nav a:hover {
    text-decoration: underline;
}

.container {
    width: 90%;
    max-width: 900px;
    margin: 40px auto;
    background: #1c1c1c;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,255,255,0.3);
}

h2 {
    color: #7fe0e6;
    text-align: center;
}

form {
    margin-bottom: 40px;
}

input, textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: none;
    font-size: 1rem;
}

textarea {
    min-height: 120px;
    resize: vertical;
}

button {
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

button:hover {
    background: #00c2c7;
}

.successo {
    background: #28a745;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
}

.errore {
    background: #dc3545;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
    text-align: center;
}

.tabella {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}

.tabella th, .tabella td {
    padding: 12px;
    border-bottom: 1px solid #555;
    text-align: left;
}

.tabella th {
    background: #0e1f36;
    color: #7fe0e6;
}

@media(max-width: 768px){
    .container { width: 95%; padding: 20px; }
    header nav a { display: block; margin: 10px 0; }
}
</style>
</head>
<body>

<header>
    <h1>Gestione Notizie</h1>
    <nav>
        <a href="admin_dashboard.php">🏠 Dashboard</a>
        <a href="./../logout.php">🚪 Logout</a>
    </nav>
</header>

<div class="container">
    <h2>➕ Pubblica una nuova notizia</h2>

    <?php if($successo) echo "<div class='successo'>$successo</div>"; ?>
    <?php if($errore) echo "<div class='errore'>$errore</div>"; ?>

    <form method="POST" action="">
        <input type="text" name="titolo" placeholder="Titolo della notizia" required>
        <textarea name="testo" placeholder="Contenuto della notizia" required></textarea>
        <input type="text" name="immagine" placeholder="URL immagine (opzionale)">
        <button type="submit">Pubblica Notizia</button>
    </form>

    <h2>🗞️ Elenco delle notizie pubblicate</h2>

    <table class="tabella">
        <tr>
            <th>ID</th>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Data</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['idNotizia'] ?></td>
                <td><?= htmlspecialchars($row['titolo']) ?></td>
                <td><?= htmlspecialchars($row['nome'] . " " . $row['cognome']) ?></td>
                <td><?= $row['data_pubblicazione'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
