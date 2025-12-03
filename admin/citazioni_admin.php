<?php
session_start();

// Verificar sesión admin
if (!isset($_SESSION['idUser']) || $_SESSION['ruolo'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "chialva_portfolio";

$conn = new mysqli($host, $user, $pass, $dbname);

// Comprobar conexión
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Cancelar cita (eliminarla) si se solicita
if (isset($_GET['cancella'])) {
    $idCita = intval($_GET['cancella']);
    $stmt = $conn->prepare("DELETE FROM citazioni WHERE idCita = ?");
    $stmt->bind_param("i", $idCita);
    $stmt->execute();
    $stmt->close();

    header("Location: citazioni_admin.php?deleted=1");
    exit();
}

// Obtener todas las citas
$sql = "
    SELECT c.idCita, c.titolo, c.descrizione, c.data_cita, c.ora, 
           u.nome, u.cognome, u.email
    FROM citazioni c
    JOIN users_data u ON c.idUser = u.idUser
    ORDER BY c.data_cita DESC, c.ora DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>📅 Gestione Citazioni — Admin</title>
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

/* Contenedor principal */
.container {
  width: 90%;
  max-width: 1100px;
  margin: 40px auto;
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

/* Alertas */
.alert {
  padding: 12px;
  border-radius: 6px;
  text-align: center;
  margin-bottom: 20px;
}
.alert-success { background: #28a745; }
.alert-danger  { background: #dc3545; }

/* Tabla */
.table-container {
  width: 100%;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  color: #fff;
}

th, td {
  padding: 12px 16px;
  border-bottom: 1px solid #555;
  text-align: center;
  white-space: nowrap;
}

th {
  background: #0e1f36;
  color: #7fe0e6;
}

tr:hover {
  background: #16263e;
}

/* Botón cancelar */
.cancel-btn {
  display: inline-block;
  padding: 8px 14px;
  background: #dc3545;
  color: #fff;
  text-decoration: none;
  border-radius: 6px;
  font-size: 0.9rem;
  transition: 0.3s;
}
.cancel-btn:hover {
  background: #b02a37;
}

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
  th, td {
    font-size: 0.9rem;
    padding: 10px;
  }
}
</style>
</head>
<body>

<header>
  <h1>📅 Gestione Citazioni</h1>
  <nav>
    <a href="admin_dashboard.php">🏠 Dashboard</a>
    <a href="./../logout.php">🚪 Logout</a>
  </nav>
</header>

<div class="container">
  <?php if (isset($_GET['deleted'])): ?>
      <div class="alert alert-success">✅ Citazione cancellata con successo.</div>
  <?php endif; ?>

  <h2>Elenco delle Citazioni Prenotate</h2>

  <div class="table-container">
    <table>
      <tr>
        <th>Data</th>
        <th>Ora</th>
        <th>Titolo</th>
        <th>Descrizione</th>
        <th>Utente</th>
        <th>Email</th>
        <th>Azione</th>
      </tr>

      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['data_cita']) ?></td>
            <td><?= htmlspecialchars($row['ora']) ?></td>
            <td><?= htmlspecialchars($row['titolo']) ?></td>
            <td><?= htmlspecialchars($row['descrizione']) ?></td>
            <td><?= htmlspecialchars($row['nome'] . " " . $row['cognome']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
              <a class="cancel-btn" href="?cancella=<?= $row['idCita'] ?>" onclick="return confirm('Sei sicuro di voler cancellare questa citazione?');">🗑️ Cancella</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="7" style="text-align:center;">Nessuna citazione trovata.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
