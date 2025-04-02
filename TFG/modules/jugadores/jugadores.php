<?php
include('../../includes/config.php');
include('../../includes/database.php');
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fortune Football</title>
  
  <!-- Enlaces a Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/jugadores.css">

  <script defer src="../../assets/js/jugadores.js"></script>
</head>

<body>

  <!-- Barra de navegación de Bootstrap -->
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
                <li class="nav-item"><a class="nav-link" href="../../modules/equipos/equipos.php">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../modules/competiciones/competiciones.php">Competiciones</a></li>
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

<h1 class="text-center">DATOS DE JUGADOR</h1>

<div id="selectores" class="d-flex flex-column align-items-center" style="top: 20px; left: 20px; padding-left: 10px; padding-top: 20px;">
    <h2 id="titulo1" class="fs-5 text-warning mb-2">Selecciona la competición</h2>
    <select name="select-competicion" id="select-competicion" class="form-select w-auto mb-3">
    </select>

    <h2 id="titulo2" class="fs-5 text-warning mb-2">Selecciona el equipo</h2>
    <select name="select-equipo" id="select-equipo" class="form-select w-auto mb-3">
    </select>

    <h2 id="titulo3" class="fs-5 text-warning mb-2">Selecciona el jugador</h2>
    <select name="select-jugador" id="select-jugador" class="form-select w-auto mb-3">
    </select>

    <div id="contenedor-boton" class="mt-3"></div>
</div>


<div id="contenedor-datos">



</div>



  <footer class="footer">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
</body>



</html>