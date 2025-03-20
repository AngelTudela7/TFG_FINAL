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
  <link rel="stylesheet" href="../../assets/css/competiciones.css">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <script defer src="../../assets/js/competiciones.js"></script>
</head>

<body>

  Menú hamburguesa
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
      <li><a href="../../modules/jugadores/jugadores.php">Jugadores</a></li>

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
      <li><a href="../../modules/jugadores/jugadores.php">Jugadores</a></li>
        </ul>
      </nav>
    </div>
  </header>


  <div class="competitions">

    <h3>COMPETICIONES POPULARES</h3>







  </div>


  <div class="tabs">
    <button class="tab" id="resultados-tab">Resultados</button>
    <button class="tab" id="clasificacion-tab">Clasificación</button>
    <button class="tab" id="goleadores-tab">Tabla Goleadores</button>
    <button class="tab" id="limpiar-tab">Limpiar</button>
  </div>

  <div class="content">
    <div id="resultados" class="section"></div>
   
    <div id="clasificacion" class="section" style="display:none;"></div>
    <div id="goleadores" class="section" style="display: none;"></div>
  </div>

  <div id="boton-cargar"></div>

  <footer class="footer">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>

</body>



</html>