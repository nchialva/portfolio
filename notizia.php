<?php
include 'includes/db.php';
$id = intval($_GET['id']);
$sql = "SELECT n.*, u.nombre FROM noticias n JOIN users_data u ON n.idUser = u.idUser WHERE n.idNoticia = $id";
$result = $conn->query($sql);
$noticia = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($noticia['titulo']); ?></title>
<style>
  body {
    font-family: Georgia, serif;
    background: #fff;
    color: #111;
    max-width: 800px;
    margin: 60px auto;
    padding: 20px;
  }
  img {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 20px;
  }
  h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
  }
  .fecha {
    color: #555;
    margin-bottom: 20px;
  }
  .texto {
    font-size: 1.2rem;
    line-height: 1.8;
  }
  a {
    display: inline-block;
    margin-top: 30px;
    color: #007BFF;
    font-weight: bold;
  }
</style>
</head>
<body>

<h1><?php echo htmlspecialchars($noticia['titulo']); ?></h1>
<p class="fecha">📅 <?php echo date("d/m/Y", strtotime($noticia['fecha'])); ?> — ✍️ <?php echo htmlspecialchars($noticia['nombre']); ?></p>
<img src="assets/images/noticias/<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="">
<p class="texto"><?php echo nl2br(htmlspecialchars($noticia['texto'])); ?></p>

<a href="noticias.php">⬅️ Volver a noticias</a>

</body>
</html>
