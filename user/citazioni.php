<?php
session_start();
require_once "./../db.php";

// Verifica che l'utente abbia effettuato il login
if (!isset($_SESSION['utente']) || $_SESSION['ruolo'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

$idUser = $_SESSION['idUser'];
$errore = "";
$successo = "";

// CREARE CITAZIONE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crea_citazione'])) {
    $titolo = trim($_POST['titolo']);
    $descrizione = trim($_POST['descrizione']);
    $data_cita = $_POST['data_cita'];
    $ora = $_POST['ora'];

    if (!empty($titolo) && !empty($data_cita) && !empty($ora)) {
        $stmt = $conn->prepare(
            "INSERT INTO citazioni (idUser, titolo, descrizione, data_cita, ora) 
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issss", $idUser, $titolo, $descrizione, $data_cita, $ora);

        if ($stmt->execute()) {
            $successo = "✅ Citazione creata con successo!";
        } else {
            $errore = "❌ Errore durante la creazione della citazione: " . $conn->error;
        }
    } else {
        $errore = "⚠️ Titolo, data e ora sono obbligatori.";
    }
}

// ELIMINARE CITAZIONE
if (isset($_GET['elimina'])) {
    $idCita = intval($_GET['elimina']);
    $stmt = $conn->prepare("DELETE FROM citazioni WHERE idCita = ? AND idUser = ?");
    $stmt->bind_param("ii", $idCita, $idUser);
    $stmt->execute();
    header("Location: citazioni.php");
    exit;
}

// MODIFICARE CITAZIONE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifica_citazione'])) {
    $idCita = intval($_POST['idCita']);
    $titolo = trim($_POST['titolo']);
    $descrizione = trim($_POST['descrizione']);
    $data_cita = $_POST['data_cita'];
    $ora = $_POST['ora'];

    if (!empty($titolo) && !empty($data_cita) && !empty($ora)) {
        $stmt = $conn->prepare(
            "UPDATE citazioni 
             SET titolo = ?, descrizione = ?, data_cita = ?, ora = ? 
             WHERE idCita = ? AND idUser = ?"
        );
        $stmt->bind_param("ssssii", $titolo, $descrizione, $data_cita, $ora, $idCita, $idUser);
        if ($stmt->execute()) {
            $successo = "✅ Citazione aggiornata con successo!";
        } else {
            $errore = "❌ Errore durante l'aggiornamento della citazione: " . $conn->error;
        }
    } else {
        $errore = "⚠️ Titolo, data e ora sono obbligatori.";
    }
}

// PRENDERE CITAZIONI UTENTE
$result = $conn->prepare("SELECT * FROM citazioni WHERE idUser = ? ORDER BY data_cita ASC, ora ASC");
$result->bind_param("i", $idUser);
$result->execute();
$citas = $result->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Citazioni — Nicolas Chialva</title>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background: #f5f7fa;
}

/* ✅ NAVBAR */
.navbar {
  background: #111;
  padding: 15px 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.navbar h2 {
  color: #7fe0e6;
  margin: 0;
  font-size: 1.3rem;
}
.navbar nav a {
  color: #7fe0e6;
  text-decoration: none;
  margin-left: 20px;
  font-weight: bold;
}
.navbar nav a:hover {
  text-decoration: underline;
}

.container {
  max-width: 1000px;
  margin: 40px auto;
  padding: 0 20px;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
}

.form-cita, .citazione {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.form-cita h2, .citazione h2 {
  margin-top: 0;
}

.citazione p {
  margin: 8px 0;
}

.citazione small {
  color: #777;
}

button {
  padding: 10px 15px;
  border: none;
  border-radius: 8px;
  background: #007BFF;
  color: #fff;
  cursor: pointer;
  transition: background 0.3s;
}
button:hover {
  background: #0056b3;
}

input, textarea, select {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 6px;
  border: 1px solid #ccc;
  font-size: 1rem;
}

.error { color: red; margin-bottom: 10px; }
.success { color: green; margin-bottom: 10px; }

@media(max-width: 600px) {
  .navbar {
    flex-direction: column;
    align-items: flex-start;
  }
  .navbar nav a {
    margin: 10px 0 0 0;
    display: block;
  }
  .form-cita, .citazione {
    padding: 15px;
  }
}
</style>
</head>
<body>

<!-- ✅ Navbar -->
<header class="navbar">
  <h2>📅 Citazioni di <?php echo htmlspecialchars($_SESSION['utente']); ?></h2>
  <nav>
    <a href="user_dashboard.php">🏠 Dashboard</a>
    <a href="../logout.php">🚪 Logout</a>
  </nav>
</header>

<div class="container">

<?php if($errore) echo "<div class='error'>$errore</div>"; ?>
<?php if($successo) echo "<div class='success'>$successo</div>"; ?>

<!-- FORM CREARE CITAZIONE -->
<div class="form-cita">
  <h2>➕ Crea nuova citazione</h2>
  <form method="POST" action="">
    <input type="text" name="titolo" placeholder="Titolo" required>
    <textarea name="descrizione" placeholder="Descrizione"></textarea>
    <input type="date" name="data_cita" required>
    <input type="time" name="ora" required>
    <button type="submit" name="crea_citazione">Crea citazione</button>
  </form>
</div>

<!-- ELENCO CITAZIONI -->
<h2>📜 Le tue citazioni</h2>
<?php while($cita = $citas->fetch_assoc()): ?>
  <div class="citazione">
    <h2><?php echo htmlspecialchars($cita['titolo']); ?></h2>
    <p><?php echo nl2br(htmlspecialchars($cita['descrizione'])); ?></p>
    <small>📅 <?php echo $cita['data_cita']; ?> ⏰ <?php echo $cita['ora']; ?></small><br><br>

    <!-- Modifica citazione -->
    <form method="POST" style="margin-top:10px;">
      <input type="hidden" name="idCita" value="<?php echo $cita['idCita']; ?>">
      <input type="text" name="titolo" value="<?php echo htmlspecialchars($cita['titolo']); ?>" required>
      <textarea name="descrizione"><?php echo htmlspecialchars($cita['descrizione']); ?></textarea>
      <input type="date" name="data_cita" value="<?php echo $cita['data_cita']; ?>" required>
      <input type="time" name="ora" value="<?php echo $cita['ora']; ?>" required>
      <button type="submit" name="modifica_citazione">✏️ Modifica</button>
      <a href="?elimina=<?php echo $cita['idCita']; ?>" onclick="return confirm('Sei sicuro di voler eliminare questa citazione?');">
        <button type="button" style="background:red;">🗑️ Elimina</button>
      </a>
    </form>
  </div>
<?php endwhile; ?>

</div>
</body>
</html>
