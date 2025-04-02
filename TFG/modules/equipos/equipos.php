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

  <!-- Enlace a Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../assets/css/equipos.css">
  <script defer src="../../assets/js/equipos.js"></script>
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


  <div class="container my-3">
    <h1 class="text-center mb-4">DATOS DE EQUIPOS</h1>

    <div class="col-12 col-md-4 select-wrapper">
    <h2 class="text-warning">Selecciona la competición</h2>
    <select id="select-competicion" class="form-select mb-3">
      <option value="" disabled selected>Selecciona una competición</option>
    </select>
</div>

<div class="col-12 col-md-4 select-wrapper">
    <h2 class="text-warning">Selecciona el equipo</h2>
    <select id="select-equipo" class="form-select mb-3">
      <option value="" disabled selected>Selecciona un equipo</option>
    </select>
</div>

    <!-- Sección para mostrar la plantilla de jugadores, últimos y próximos partidos -->
    <div class="row mt-5">
      <!-- Plantilla de jugadores -->
      <div class="col-12 col-md-4" id="contenedor-plantilla" style="max-height: 450px; overflow-y: auto;"></div>

      <!-- Últimos 5 partidos -->
      <div class="col-12 col-md-4 mt-3" id="contenedor-last-partidos" style="display: none;">
        <h3 class="text-warning">Últimos 5 Partidos</h3>
        <div id="ultimo-partido"></div>
      </div>

      <!-- Próximos 5 partidos -->
      <div class="col-12 col-md-4 mt-3" id="contenedor-proximos-partidos" style="display: none;">
        <h3 class="text-warning">Próximos 5 Partidos</h3>
        <div id="proximos-partidos"></div>
      </div>
    </div>
  </div>

  <footer class="footer bg-dark text-white text-center py-3">
    <p>&copy; 2024 Fortune Football. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
