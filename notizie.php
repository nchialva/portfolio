<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "chialva_portfolio";

$conn = new mysqli($host, $user, $pass, $dbname);


if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}


$sql = "SELECT n.idNotizia, n.titolo, n.immagine, n.testo, n.data_pubblicazione, u.nome 
        FROM notizie n
        JOIN users_data u ON n.idUser = u.idUser
        ORDER BY n.data_pubblicazione DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notizie — Nicolas Chialva</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(180deg, #0b1522, #101f35);
    margin: 0;
    padding: 0;
    color: #fff;
}

/* 🔝 NAVBAR */
nav {
    width: 100%;
    background: #0e1f36;
    padding: 15px 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.4);
    position: sticky;
    top: 0;
    z-index: 10;
}

nav h1 {
    margin: 0;
    font-size: 1.6rem;
    color: #7fe0e6;
    letter-spacing: 1px;
}

nav a {
    color: #fff;
    text-decoration: none;
    font-size: 1.1rem;
    padding: 8px 20px;
    border-radius: 8px;
    background: #7fe0e6;
    color: #0b1522;
    transition: 0.3s;
    font-weight: bold;
}

nav a:hover {
    background: #5bcad3;
    transform: translateY(-2px);
}

/* 📰 CONTENUTO */
h1 {
    text-align: center;
    margin: 50px 0 40px;
    font-size: 2.5rem;
    color: #7fe0e6;
}

.noticia {
    background: #fff;
    color: #000;
    border-radius: 15px;
    padding: 25px;
    margin: 30px auto;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    max-width: 850px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.noticia:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.3);
}

.noticia img {
    max-width: 100%;
    border-radius: 12px;
    margin-bottom: 20px;
}

.titolo {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #0e1f36;
}

.data_pubblicazione {
    font-size: 0.95rem;
    color: #777;
    margin-bottom: 20px;
}

.testo {
    font-size: 1.15rem;
    margin-bottom: 20px;
    color: #333;
    line-height: 1.6;
}

.autore {
    font-size: 1rem;
    font-weight: bold;
    color: #0e1f36;
}

.noticia a {
    text-decoration: none;
    color: inherit;
    display: block;
}

.noticia a:hover .titolo {
    color: #007BFF;
}

/* 📱 Responsive */
@media (max-width: 768px) {
    h1 {
        font-size: 2rem;
    }
    .noticia {
        padding: 20px;
        margin: 20px;
    }
    .titolo {
        font-size: 1.6rem;
    }
    nav h1 {
        font-size: 1.3rem;
    }
    nav a {
        padding: 6px 15px;
        font-size: 1rem;
    }
}
</style>
</head>
<body>

<!-- 🔝 NAVBAR -->
<nav>
    <a href="index.html">🏠 Home</a>
</nav>

<h1>Ultime Notizie</h1>

<?php
// Mostrar noticias
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='noticia'>";
        echo "<a href='notizia.php?id=" . $row['idNotizia'] . "'>";
        echo "<h2 class='titolo'>" . htmlspecialchars($row['titolo']) . "</h2>";
        echo "<p class='data_pubblicazione'>📅 " . date("d/m/Y", strtotime($row['data_pubblicazione'])) . "</p>";
        echo "<img src='assets/images/notizie/" . htmlspecialchars($row['immagine']) . "' alt='Immagine notizia'>";
        echo "<p class='testo'>" . nl2br(htmlspecialchars($row['testo'])) . "</p>";
        echo "<p class='autore'>✍️ Pubblicato da: " . htmlspecialchars($row['nome']) . "</p>";
        echo "</a>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;font-size:1.2rem;'>Non ci sono notizie disponibili al momento.</p>";
}

$conn->close();
?>

</body>
</html>
