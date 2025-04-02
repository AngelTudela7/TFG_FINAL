<?php
session_start();
include('../../includes/database.php');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalles de la Noticia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/noticias_detalle.css">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        
        <a class="navbar-brand" href="../../index.php">Fortune Football</a>
        
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

       
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../../index.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/competiciones/competiciones.php">Competiciones</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/equipos/equipos.php">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/jugadores/jugadores.php">Jugadores</a></li>
            </ul>

            <!-- Sección de usuario, si no tiene sesión iniciada mostrar un botón para que inicie. Si ya lo está, mostrar su nombre y ofrecerle el botón para cerrarla -->
            <ul class="navbar-nav ms-3">
                <?php if (!isset($_SESSION['id']) || !$_SESSION['id']) { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="../../autenticaciones/login_comun.php">Iniciar Sesión</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="../../assets/images/icono.png" alt="Usuario" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                            <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../herramientas_administrador/usuarios/mi_perfil.php">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="../herramientas_administrador/usuarios/soporte.php">Soporte</a></li>
                            <li><a class="dropdown-item text-danger" href="../../autenticaciones/logout_comun.php">Cerrar sesión</a></li>
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

      <a href="../../index.php" class="btn btn-primary mt-4">Volver a la página principal</a>
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
            echo '<div class="text-center text-white p-4"> Aún no hay comentarios. ¡Sé el primero en comentar! </div>';
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
        <h5 class="fw-bold"> ¿Quieres comentar?</h5>
        <p class="mb-3">Para participar en la conversación, inicia sesión o regístrate.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-center">
            <a href="../../autenticaciones/login_comun.php" class="btn btn-primary">Iniciar sesión</a>
            <a href="../../autenticaciones/registro.php" class="btn btn-outline-light">Registrarse</a>
        </div>
    </div>
</div>
<?php endif; ?>






  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>