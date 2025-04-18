
<?php 
session_start();
include ('../../../includes/config.php');
include('../../../includes/permisos.php');
?>



<!DOCTYPE html>
<html lang="es">
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
                <li class="nav-item"><a class="nav-link" href="../noticias/herramientas_admin.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="../usuarios/administracion_users.php">Usuarios</a></li>
                <li class="nav-item"><a class="nav-link" href="listado_total_tickets.php">Listado Total Tickets</a></li>

                    

                </ul>
            </div>

            <!-- Seccion del usuario -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-white fw-bold"> <?php echo $_SESSION['nombre']; ?> </span>
                <img src="../../../assets/images/icono.png" alt="Usuario" class="rounded-circle" style="width: 30px; height: 30px;">
                <a href="../../../autenticaciones/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
            </div>
        </div>
        </div>
    </nav>

    <?php

$cnx = conectar();

$consulta = "SELECT tickets.*, usuarios.nombre AS nombre_usuario 
             FROM tickets
             JOIN usuarios ON tickets.usuario_id = usuarios.id
             WHERE (tickets.desarrollador_id = " . $_SESSION['id'] . " 
             AND tickets.estado != 'Cerrado' 
             AND (tickets.estado = 'Abierto' OR tickets.estado = 'En proceso' OR tickets.estado = 'Resuelto')) 
             ORDER BY tickets.fecha_actualizacion DESC";

$resultado = mysqli_query($cnx, $consulta);
if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($cnx));
}

?>

<div class="container mt-4">
    <h1 class="text-center">Tus tickets</h1>
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark align-middle">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha Creación</th>
                    <th>Última Actualización</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="align-middle">

            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while (list($id, $titulo, $descripcion, $usuario_id, $estado, $prioridad, $desarrollador_id, $fecha_creacion, $ult_update, $nombre_usuario) = mysqli_fetch_array($resultado)) {
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td class='text-start'><strong>$titulo</strong></td>";
                    echo "<td class='text-start'><strong>$estado</strong></td>";
                    echo "<td class='text-start'><strong>$prioridad</strong></td>";
                    echo "<td>" . date("d/m/Y", strtotime($fecha_creacion)) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($ult_update)) . "</td>";
                    echo "<td>$nombre_usuario</td>";
                    echo "<td>
                        <div class='d-flex justify-content-center gap-2'>
                            <a href='ticket_update.php?id=$id' class='btn btn-info btn-sm'>Gestionar</a>  
                            <a href='ticket_cerrar.php?id=$id' class='btn btn-warning btn-sm'>Cerrar</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center text-danger'>¡Todo despejado! No tienes ninguna incidencia que tratar</td></tr>";
            }
            mysqli_free_result($resultado);
            mysqli_close($cnx);
            ?>

            </tbody>
        </table>
    </div>


    <?php
$cnx = conectar();

$consulta2 = "SELECT tickets.id, tickets.titulo, tickets.usuario_id , tickets.estado , tickets.prioridad , tickets.fecha_creacion , tickets.fecha_actualizacion, usuarios.nombre AS nombre_usuario 
             FROM tickets
             JOIN usuarios ON tickets.usuario_id = usuarios.id
             WHERE tickets.desarrollador_id IS NULL
             AND tickets.estado!= 'Cerrado'
             ORDER BY tickets.fecha_creacion DESC";

$resultado2 = mysqli_query($cnx, $consulta2);
if (!$resultado2) {
    die("Error en la consulta: " . mysqli_error($cnx));
}

?>
    

    <h1 class="text-center">Tickets sin asociar </h1>
    <div class="table-responsive">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark align-middle">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Fecha Creación</th>
                    <th>Última Actualización</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="align-middle">

            <?php


            if (mysqli_num_rows($resultado2) > 0) {
                while (list($id, $titulo, $usuario_id, $estado, $prioridad, $fecha_creacion, $ult_update, $nombre_usuario) = mysqli_fetch_array($resultado2)) {
                    echo "<tr>";
                    echo "<td>$id</td>";
                    echo "<td class='text-start'><strong>$titulo</strong></td>";
                    echo "<td class='text-start'><strong>$estado</strong></td>";
                    echo "<td class='text-start'><strong>$prioridad</strong></td>";
                    echo "<td>" . date("d/m/Y", strtotime($fecha_creacion)) . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($ult_update)) . "</td>";
                    echo "<td>$nombre_usuario</td>";
                    echo "<td>
                        <div class='d-flex justify-content-center gap-2'>
                            <a href='ticket_update.php?id=$id' class='btn btn-info btn-sm'>Gestionar</a>  
                            <a href='ticket_cerrar.php?id=$id' class='btn btn-warning btn-sm'>Cerrar</a>
                        </div>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center text-danger'>No hay tickets disponibles</td></tr>";
            }
            mysqli_free_result($resultado2);
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