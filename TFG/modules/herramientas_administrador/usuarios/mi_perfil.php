<?php
session_start();
include('../../../includes/config.php');
include('../../../includes/database.php');
?>

<?php

if (!isset($_SESSION['id']) || !$_SESSION['id']) {
    echo '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Restringido</title>
    <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column align-items-center justify-content-center vh-100 bg-dark text-white text-center">
    <h1 class="text-danger mb-4">¡¡Inicia sesión para ver tu perfil!!</h1>
    <a class="btn btn-outline-light" href="../../../autenticaciones/login_comun.php">Iniciar Sesión</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
} else {
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
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

        .profile-img {
            width: 150px;
            height: 150px;
        }

        @media (max-width: 576px) {
            .profile-img {
                width: 120px;
                height: 120px;
            }
        }

        .table-container {
    max-width: 600px;
    margin: auto;
}

.table-dark {
    table-layout: fixed;
    width: 100%;
}

.table-dark th, .table-dark td {
    white-space: nowrap;
    text-align: center;
}

    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="../../../index.php">Fortune Football</a>
        
        <!-- Botón del menú hamburguesa -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido del menú -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Links de navegación -->
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="../../competiciones/competiciones.php">Competiciones</a></li>
                <li class="nav-item"><a class="nav-link" href="../../../index.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="../../equipos/equipos.php">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../jugadores/jugadores.php">Jugadores</a></li>
            </ul>

            <!-- Sección de usuario -->
            <ul class="navbar-nav ms-3">
                <?php if (!isset($_SESSION['id']) || !$_SESSION['id']) { ?>
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="autenticaciones/login_comun.php">Iniciar Sesión</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <img src="../../../assets/images/icono.png" alt="Usuario" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                            <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="usuarios/mi_perfil.php">Mi perfil</a></li>
                            <li><a class="dropdown-item" href=soporte.php">Soporte</a></li>
                            <li><a class="dropdown-item text-danger" href="../../../autenticaciones/logout_comun.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center text-uppercase fw-bold">Tu perfil</h1>

    <div class="row mt-4 align-items-center text-center text-sm-start">
        <div class="col-12 col-sm-auto">
            <img src="../../../assets/images/icono.png" alt="Usuario" class="profile-img rounded-circle mx-auto d-block d-sm-inline me-sm-4">
        </div>
        <div class="col">
            <h3 class="mb-1 text-uppercase"> <?php echo htmlspecialchars($_SESSION['nombre']); ?> </h3>
        </div>
    </div>

    <div class="mt-5">
        <?php 
        $cnx = conectar();
        $consulta = "SELECT * FROM usuarios WHERE id = '". $_SESSION['id']. "'";
        $resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));
        
        if (mysqli_num_rows($resultado) > 0) {
            $usuario = mysqli_fetch_assoc($resultado);
        ?>

<div class="container mt-4 table-container">
    <h2 class="text-center mb-4">Datos de tu perfil</h2>
    
    <div class="table-responsive">
        <table class="table table-dark table-striped table-bordered">
            <tr>
                <th>Nombre</th>
                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
            </tr>
        </table>
    </div>
</div>
        <?php
        } else {
            echo '<div class="alert alert-danger text-center mt-4">No se encontraron datos del usuario.</div>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php } ?>
