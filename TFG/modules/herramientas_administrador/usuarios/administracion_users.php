<?php
session_start();
include('../../../includes/config.php');
include('../../../includes/permisos.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <!-- Botón para colapsar el menú en móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Enlaces del menú -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-2 me-auto">
                    <li class="nav-item"><a class="nav-link" href="usuarios_crear.php">Dar de alta</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios_eliminar.php">Eliminar</a></li>
                    <li class="nav-item"><a class="nav-link" href="../noticias/herramientas_admin.php">Noticias</a></li>
                    <li class="nav-item"><a class="nav-link" href="../tickets/gestion_tickets.php">Tickets</a></li>

                </ul>
            </div>

            <!-- Sección de usuario -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-white fw-bold"> <?php echo $_SESSION['nombre']; ?> </span>
                <img src="../../../assets/images/icono.png" alt="Usuario" class="rounded-circle" style="width: 30px; height: 30px;">
                <a href="../../../autenticaciones/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <?php

$cnx = conectar();

$consulta = "SELECT usu.id, usu.nombre, usu.email,rol.nombre  FROM usuarios usu INNER JOIN roles rol WHERE usu.rol_id = rol.id;";
$resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));

?>

<div class="container mt-4">
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark align-middle">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Nombre Usuario</th>
                    <th style="width: 40%;">E-Mail</th>
                    <th style="width: 20%;">Rol</th>
                    <th style="width: 20%;">Acciones</th>
                </tr>
            </thead>
            <tbody class="align-middle">

            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while (list($id, $nombre, $email, $rol) = mysqli_fetch_array($resultado)) {
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td class='text-start'>$nombre</td>";
                    echo "<td class='text-start'>$email</td>";
                    echo "<td class='text-start'><strong>$rol</strong></td>";
                    echo "<td>
                        <div class='d-flex justify-content-center gap-2'>
                            <a href='usuarios_update.php?id=$id' class='btn btn-warning btn-sm'>Gestionar</a>
                            <a href='usuarios_eliminar.php?id=$id' class='btn btn-danger btn-sm'>Eliminar</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center text-danger'>No hay usuarios disponibles</td></tr>";
            }
            mysqli_free_result($resultado);
            mysqli_close($cnx);
            ?>

            </tbody>
        </table>
    </div>
</div>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>