<?php
include('includes/config.php');
include('includes/database.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fortune Football</title>
  <link rel="stylesheet" href="assets/css/index.css">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
</head>
aaa
<body>
  <!-- Menú hamburguesa -->
  <div class="hamburger-menu" id="hamburger-menu">
    <span></span>
    <span></span>
    <span></span>
  </div> 

  <!-- Menú de navegación (oculto por defecto) -->
  <nav id="mobile-menu">
    <ul>
      <li><a href="jugadores.php">Jugadores</a></li>
      <li><a href="modules/partidos/partidos.php">Partidos</a></li>
      <li><a href="modules/competiciones/competiciones.php">Competiciones</a></li>
      <li><a href="modules/equipos/equipos.php">Equipos</a></li>
      <li><a href="modules/jugadores/jugadores.php">Jugadores</a></li>

    </ul>
  </nav>

  <!-- Barra de navegación normal (desktop) -->
  <header class="navbar">
    <div class="navbar-content">
      <a href="\TFG\index.php" class="logo">Fortune Football</a>
      <nav>
        <ul>
          <li><a href="modules/partidos/partidos.php">Partidos</a></li>
          <li><a href="modules/competiciones/competiciones.php">Competiciones</a></li>
          <li><a href="modules/equipos/equipos.php">Equipos</a></li>
          <li><a href="modules/jugadores/jugadores.php">Jugadores</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- Contenido principal -->
  <main class="content">
    <section class="featured-news">
      <h2>Últimas Noticias</h2>
      <div class="news-cards">
        <?php
        // Conexión y consulta de noticias
        $cnx = conectar();
        $consulta_fotos_principales = "SELECT id,titulo,contenido,imagen FROM noticias WHERE prioridad = 'Principal' ORDER BY fecha_publicacion DESC ";
        $res = mysqli_query($cnx, $consulta_fotos_principales);

        if (mysqli_num_rows($res) > 0) {
          while ($row = mysqli_fetch_assoc($res)) {
            echo '<div class="news-card">';
            echo '<img src="' . $row['imagen'] . '" alt="' . $row['titulo'] . '" />';
            echo '<div class="news-info">';
            echo '<h3>' . $row['titulo'] . '</h3>';
            echo '<p>' . $row['contenido'] . '</p>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo '<p>No hay noticias disponibles.</p>';
        }
        ?>
      </div>
    </section>

    <!-- Noticias a los lados -->
    <section class="side-news">
      <div class="left-side">
        <?php
        $consulta_fotos_izquierda = "SELECT id, titulo, contenido, imagen FROM noticias WHERE prioridad = 'Izquierda' ORDER BY fecha_publicacion DESC";
        $res_izquierda = mysqli_query($cnx, $consulta_fotos_izquierda);

        if (mysqli_num_rows($res_izquierda) > 0) {
          while ($row = mysqli_fetch_assoc($res_izquierda)) {
            echo '<div class="news-item">';
            echo '<img src="' . $row['imagen'] . '" alt="' . $row['titulo'] . '">';
            echo '<div class="news-content">';
            echo '<h3>' . $row['titulo'] . '</h3>';
            echo '<p>' . $row['contenido'] . '</p>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo '<p>No hay noticias en la izquierda.</p>';
        }
        ?>
      </div>

      <div class="right-side">
        <?php
        $consulta_fotos_derecha = "SELECT id, titulo, contenido, imagen FROM noticias WHERE prioridad = 'Derecha' ORDER BY fecha_publicacion DESC";
        $res_derecha = mysqli_query($cnx, $consulta_fotos_derecha);

        if (mysqli_num_rows($res_derecha) > 0) {
          while ($row = mysqli_fetch_assoc($res_derecha)) {
            echo '<div class="news-item">';
            echo '<img src="' . $row['imagen'] . '" alt="' . $row['titulo'] . '">';
            echo '<div class="news-content">';
            echo '<h3>' . $row['titulo'] . '</h3>';
            echo '<p>' . $row['contenido'] . '</p>';
            echo '</div>';
            echo '</div>';
          }
        } else {
          echo '<p>No hay noticias en la derecha.</p>';
        }
        ?>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>

  <script src="assets/js/main.js"></script>

</body>

</html>