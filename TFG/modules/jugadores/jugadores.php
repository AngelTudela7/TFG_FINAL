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
  <link rel="stylesheet" href="../../assets/css/jugadores.css">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <script defer src="../../assets/js/jugadores.js"></script>
</head>

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
      <li><a href="../../modules/partidos/partidos.php">Partidos</a></li>
      <li><a href="../../index.php">Noticias</a></li>
      <li><a href="../../modules/equipos/equipos.php">Equipos</a></li>
      <li><a href="../../modules/competiciones/competiciones.php">Competiciones</a></li>
    </ul>


  </nav>
  <!-- Barra de navegación normal (desktop) -->
  <header class="navbar">
    <div class="navbar-content">
      <a href="../../index.php" class="logo">Fortune Football</a>
      <nav>
        <ul>
        <li><a href="../../modules/partidos/partidos.php">Partidos</a></li>
      <li><a href="../../index.php">Noticias</a></li>
      <li><a href="../../modules/equipos/equipos.php">Equipos</a></li>
      <li><a href="../../modules/competiciones/competiciones.php">Competiciones</a></li>
        </ul>
      </nav>
    </div>
  </header>

<h1 id="titulo_inicial">ESTADÍSTICAS DE JUGADORES</h1>



<!-- Selección de jugadores -->



<div id="selectores">
<h2 id="titulo1">Selecciona la competición</h2>
<br>
<select name="select-competicion" id="select-competicion">
</select>

<h2 id="titulo2">Selecciona el equipo</h2>

<select name="select-equipo" id="select-equipo">
</select>

<h2 id="titulo3">Selecciona el jugador</h2>

<select name="select-jugador" id="select-jugador">
</select>
</div>

  <footer class="footer">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>

</body>



</html>