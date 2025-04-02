<!-- Incluir archivos e iniciar la sesión-->
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
  
  <!-- Enlaces a Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- <link rel="stylesheet" href="../../assets/css/competiciones.css"> -->
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/competiciones.css">

  <script defer src="../../assets/js/competiciones.js"></script>
</head>

<body>

  
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        
        <a class="navbar-brand" href="#">Fortune Football</a>
        
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

       
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="../../modules/partidos/partidos.php">Partidos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../index.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/equipos/equipos.php">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/jugadores/jugadores.php">Jugadores</a></li>
            </ul>

            <!-- Sección de usuario, si no tiene sesión iniciada mostrar un botón para que inicie. Si ya lo está, mostrar su nombre y ofrecerle el botón para cerrarla -->
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
                            <li><a class="dropdown-item" href="mi_perfil.php">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="soporte.php">Soporte</a></li>
                            <li><a class="dropdown-item text-danger" href="logout_comun.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
  </nav>

 
                    <!-- Estructura HTML -->

  <div class="competitions container mt-4">
  <h3 class="text-center mb-4">COMPETICIONES POPULARES</h3>
</div>

  <div class="container mt-4">
  <div class="d-flex justify-content-center">
    <div class="btn-group" >
      <button class="btn btn-outline-warning tab" id="resultados-tab" style="display:none;" >Resultados</button>
      <button class="btn btn-outline-warning tab" id="clasificacion-tab" style="display:none;">Clasificación</button>
      <button class="btn btn-outline-warning tab" id="goleadores-tab" style="display:none;">Tabla Goleadores</button>
      <button class="btn btn-outline-warning tab" id="limpiar-tab" style="display:none;">Limpiar</button>
    </div>
  </div>
</div>

  <div class="content">
    <div id="resultados" class="section"></div>
    <div id="clasificacion" class="section" style="display:none;"></div>
    <div id="goleadores" class="section" style="display: none;"></div>
  </div>

  <div id="boton-cargar"></div>


  <footer class="bg-dark text-center text-white py-3 mt-4">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>

  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
