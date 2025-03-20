<?php
include('includes/config.php');
include('includes/database.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fortune Football</title>
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #121212;
      color: white;
    }

    


    .card:hover {
      transform: scale(1.05);
      transition: transform 0.3s ease-in-out;
    }
    .news-container {
      display: flex;
      gap: 1rem;
    }
    .left-side, .right-side {
      flex: 1;
    }

    


  </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">Fortune Football</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="modules/partidos/partidos.php">Partidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="modules/competiciones/competiciones.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="modules/equipos/equipos.php">Equipos</a></li>
                    <li class="nav-item"><a class="nav-link" href="modules/jugadores/jugadores.php">Jugadores</a></li>
                </ul>
            </div>
        </div>
    </nav>

<main class="container-fluid mt-4">
<section class="bg-dark p-4 rounded w-100">
  <h2 class="mb-4 text-white text-center">Últimas Noticias</h2>
  <div class="container-fluid">
    <div class="row">
      <?php
      $cnx = conectar();
      $consulta_fotos_principales = "SELECT id,titulo,contenido,imagen FROM noticias WHERE prioridad = 'Principal' ORDER BY fecha_publicacion DESC ";
      $res = mysqli_query($cnx, $consulta_fotos_principales);

      if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
          echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">'; // Ajusta para que siempre ocupe todo el ancho disponible
          echo '<div class="card h-100 bg-secondary text-white shadow-lg border-0">';
          echo '<img src="' . $row['imagen'] . '" class="card-img-top" alt="' . $row['titulo'] . '" />';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row['titulo'] . '</h5>';
          echo '<p class="card-text">' . $row['contenido'] . '</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo '<p class="text-muted">No hay noticias disponibles.</p>';
      }
      ?>
    </div>
  </div>
</section>


<section class="mt-4">
  <div class="container"> <!-- Añadido container para limitar el ancho -->
    <div class="news-container d-flex justify-content-between">
      <div class="left-side w-50 pe-2"> <!-- Le damos la mitad del espacio con padding a la derecha -->
        <?php
        $consulta_fotos_izquierda = "SELECT id, titulo, contenido, imagen FROM noticias WHERE prioridad = 'Izquierda' ORDER BY fecha_publicacion DESC";
        $res_izquierda = mysqli_query($cnx, $consulta_fotos_izquierda);

        while ($row = mysqli_fetch_assoc($res_izquierda)) {
          echo '<div class="card bg-dark text-white mb-3">';
          echo '<img src="' . $row['imagen'] . '" class="card-img-top" alt="' . $row['titulo'] . '">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row['titulo'] . '</h5>';
          echo '<p class="card-text">' . $row['contenido'] . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>

      <div class="right-side w-50 ps-2"> <!-- Le damos la otra mitad con padding a la izquierda -->
        <?php
        $consulta_fotos_derecha = "SELECT id, titulo, contenido, imagen FROM noticias WHERE prioridad = 'Derecha' ORDER BY fecha_publicacion DESC";
        $res_derecha = mysqli_query($cnx, $consulta_fotos_derecha);

        while ($row = mysqli_fetch_assoc($res_derecha)) {
          echo '<div class="card bg-dark text-white mb-3">';
          echo '<img src="' . $row['imagen'] . '" class="card-img-top" alt="' . $row['titulo'] . '">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row['titulo'] . '</h5>';
          echo '<p class="card-text">' . $row['contenido'] . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </div>
</section>

</main>

<footer class="bg-dark text-center text-white py-3 mt-4">
  <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
