<?php
session_start();
include('includes/database.php');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles de la Noticia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <style>
    
    
    body {
      background-color: #121212;
      color: white;
      font-family: "Tourney", sans-serif;
    }


    .dropdown-menu {
      background-color: #212529;
      border: none;
    }

    .dropdown-item {
      color: white;
    }

    .dropdown-item:hover {
      background-color: #ffcc00;
      color: black;
    }

    .content-container {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 40px;
      align-items: center;
    }

    img {
      width: 100%;
      height: 500px;
      object-fit: cover;
      border-radius: 16px;
    }

    .badge-custom {
      font-size: 0.9rem;
    }

    .content-text {
      text-align: justify;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      font-size: 18px;

    }

    .fecha {

      color: white;
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;

    }

/* Estilo de la sección de comentarios */
.comment-section {
    background-color: #121212;  /* Fondo oscuro para la sección */
    padding: 20px;
    border-radius: 10px;  /* Bordes redondeados */
    margin-bottom: 20px;
}

/* Estilo de cada caja de comentario */
.comment-box {
    background-color: #2f2f2f;  /* Fondo gris oscuro para cada comentario */
    border-radius: 10px;  /* Bordes redondeados */
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);  /* Sombra suave */
}

.comment-box strong {
    color: #f4f4f4;  /* Color blanco claro para el nombre del autor */
}

.comment-box p {
    color: #ccc;  /* Color claro para el contenido del comentario */
    font-size: 14px;
    line-height: 1.6;  /* Espaciado de las líneas del comentario */
}

/* Estilo para la fecha dentro del comentario */
.comment-box .d-flex small {
    font-size: 0.85rem;
    color: #888;  /* Color gris para la fecha */
}

/* Estilo del formulario de comentario */
.comment-form {
    background-color: #2f2f2f;  /* Fondo gris oscuro para el formulario */
    padding: 20px;
    border-radius: 10px;  /* Bordes redondeados */
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);  /* Sombra suave */
}

.comment-form h4 {
    color: #fff;
    font-size: 1.2rem;
    margin-bottom: 15px;
    font-weight: 600;
}

/* Estilo de los inputs y textarea dentro del formulario */
.comment-form input,
.comment-form textarea {
    background-color: #121212;  /* Fondo oscuro */
    color: #fff;  /* Color del texto */
    border: 1px solid #555;  /* Borde gris */
    border-radius: 5px;
    padding: 12px;
    width: 100%;
    margin-bottom: 15px;
}

.comment-form input:focus,
.comment-form textarea:focus {
    border-color: #007bff;  /* Borde azul al hacer foco */
    box-shadow: none;
}

/* Estilo del botón de enviar comentario */
.comment-form button {
    font-size: 1rem;
    font-weight: bold;
    background-color: #007bff;  /* Fondo azul */
    color: white;
    border: none;
    border-radius: 8px;  /* Bordes redondeados */
    padding: 12px;
    width: 100%;
    transition: background-color 0.3s ease, transform 0.2s ease;  /* Transición para el hover */
}

.comment-form button:hover {
    background-color: #0056b3;  /* Fondo azul más oscuro en hover */
    transform: scale(1.05);  /* Agranda el botón al pasar el cursor */
}

/* Barra de desplazamiento personalizada para la sección de comentarios */
.comentarios {
    max-height: 400px;
    overflow-y: auto;
    background-color: #121212;  /* Fondo oscuro */
    border-radius: 10px;  /* Bordes redondeados */
    padding: 15px;
}

/* Personaliza la barra de desplazamiento */
.comentarios::-webkit-scrollbar {
    width: 8px;  /* Ancho de la barra */
}

.comentarios::-webkit-scrollbar-thumb {
    background-color: #888;  /* Color de la barra */
    border-radius: 10px;  /* Bordes redondeados */
    transition: background-color 0.3s ease;  /* Transición suave */
}

.comentarios::-webkit-scrollbar-thumb:hover {
    background-color: #555;  /* Cambio de color al pasar el cursor */
}

.comentarios::-webkit-scrollbar-track {
    background-color: #222;  /* Fondo de la pista de la barra */
    border-radius: 10px;
}

/* Color del texto dentro de los comentarios */
.texto-comentario {
    color: white;  /* Texto blanco para que se lea bien */
    font-family: Arial, Helvetica, sans-serif;
}

/* Estilo del mensaje de invitación si el usuario no está autenticado */
.alert-info {
    background-color: #333;  /* Fondo gris oscuro para la alerta */
    color: #fff;  /* Texto blanco */
    border-radius: 8px;  /* Bordes redondeados */
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);  /* Sombra suave */
}

.alert-link {
    color: #007bff;  /* Enlaces de color azul */
    font-weight: bold;  /* Hacer los enlaces más visibles */
}

.alert-link:hover {
    text-decoration: underline;  /* Subrayar los enlaces al pasar el ratón */
}

img {
  width: 100%;
  height: auto;
  object-fit: cover;
  border-radius: 16px;
}

/* Ajustes específicos para pantallas pequeñas */
@media (max-width: 768px) {
  .content-container {
    grid-template-columns: 1fr; /* Cambia a una sola columna en móvil */
    text-align: center; /* Centra el texto */
  }

  img {
    height: 300px; /* Ajusta la altura de la imagen en móvil */
    object-fit: cover;
  }
}

  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <!-- Logo -->
      <a class="navbar-brand" href="#">Fortune Football</a>

      <!-- Botón del menú hamburguesa -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Contenido del menú -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Links de navegación -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Partidos</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Noticias</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Equipos</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Jugadores</a></li>
        </ul>

        <!-- Sección de usuario -->
        <ul class="navbar-nav ms-3">
          <?php if (!isset($_SESSION['id']) || !$_SESSION['id']) { ?>
            <li class="nav-item">
              <a class="btn btn-outline-light" href="login_comun.php">Iniciar Sesión</a>
            </li>
          <?php } else { ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                <img src="assets/images/icono.png" alt="Usuario" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                <?php echo htmlspecialchars($_SESSION['nombre']); ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                <li><a class="dropdown-item" href="#">Soporte</a></li>
                <li><a class="dropdown-item text-danger" href="logout_comun.php">Cerrar sesión</a></li>
              </ul>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>


  <div class="container mt-5">
    <?php
    $cnx = conectar();
    $consulta = "SELECT * FROM Noticias WHERE id='" . $_GET['id'] . "'";
    $resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));

    if (mysqli_num_rows($resultado) > 0) {
      $fila = mysqli_fetch_array($resultado);
    ?>
      <div class="content-container">
        <div>
          <strong>
            <h1 class="mb-3"><?php echo $fila['titulo']; ?></h1>
          </strong>
          <p class=" mb-3 fecha">Publicada el <?php echo date("d/m/Y", strtotime($fila['fecha_publicacion'])); ?></strong></p>

        </div>
        <div>
          <img src="<?php echo $fila['imagen']; ?>" alt="Imagen de la Noticia">
        </div>
      </div>

      <div class="mt-5 content-text">
        <p> <?php echo nl2br($fila['contenido']); ?></p>
      </div>

      <a href="index.php" class="btn btn-primary mt-4">Volver a la página principal</a>
    <?php
    } else {
      echo "<p class='text-center text-warning'>Error recuperando los datos</p>";
    }
    ?>
  </div>


  <!-- Sección de Comentarios -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">Comentarios</h2>



<!-- Lista de Comentarios -->
<div class="comment-section">
    <!-- Contenedor de comentarios con scroll -->
    <div class="comentarios p-4 rounded bg-dark text-white" style="max-height: 400px; overflow-y: auto;">
        <?php
        // Consulta para obtener comentarios con los nombres de los autores
        $consulta_comentarios = "SELECT Comentarios.*, Usuarios.nombre FROM Comentarios 
                                 JOIN Usuarios ON Comentarios.autor_id = Usuarios.id 
                                 WHERE Comentarios.noticia_id='" . $_GET['id'] . "'";

        $res = mysqli_query($cnx, $consulta_comentarios) or die(mysqli_error($cnx));

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                // Mostrar cada comentario
                echo '<div class="comment-box mb-3 p-3 rounded shadow-sm bg-secondary">';
                echo '    <div class="d-flex justify-content-between">';
                echo '        <strong class="text-light">' . htmlspecialchars($row['nombre']) . '</strong>';
                echo '        <small class="text-muted">' . date("d/m/Y", strtotime($row['fecha_comentario'])) . '</small>';
                echo '    </div>';
                echo '    <p class="mb-0 text-justify texto-comentario">' . nl2br(htmlspecialchars($row['contenido'])) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<div class="text-center text-white p-4">📝 Aún no hay comentarios. ¡Sé el primero en comentar! 🎉</div>';
        }
        ?>
    </div>
</div>

<?php if (isset($_SESSION['id'])): ?>
    <!-- Si el usuario está autenticado, mostrar el formulario para dejar un comentario -->
    <div class="container mt-4">
        <div class="comment-form mx-auto" style="max-width: 600px; background-color: #2f2f2f; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <h4 class="text-center mb-4 text-white">Deja tu comentario</h4>
            <form action="procesar_comentario.php" method="post">
                <div class="mb-3">
                    <textarea class="form-control" name="contenido" rows="4" placeholder="Escribe tu comentario aquí..." required></textarea>
                </div>
                <input type="hidden" name="noticia_id" value="<?php echo $_GET['id']; ?>">
                <button type="submit" class="btn btn-primary w-100 btn-lg">Publicar Comentario</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <!-- Si el usuario no está autenticado, mostrar el mensaje de invitación -->
    <div class="container mt-4">
    <div class="alert alert-dark text-center p-4" style="border: 2px dashed #6c757d; border-radius: 10px; background: rgba(0, 0, 0, 0.8); color: white;">
        <h5 class="fw-bold">🔒 ¿Quieres comentar?</h5>
        <p class="mb-3">Para participar en la conversación, inicia sesión o regístrate.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-center">
            <a href="login_comun.php" class="btn btn-primary">Iniciar sesión</a>
            <a href="registro.php" class="btn btn-outline-light">Registrarse</a>
        </div>
    </div>
</div>
<?php endif; ?>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>