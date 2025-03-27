<?php 
session_start();
include ('includes/config.php');
include('includes/permisos.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <?php
        $cnx = conectar();

        if (isset($_POST['Cerrar'])) {
            $id = mysqli_real_escape_string($cnx, $_POST['id']);

            // Comprobar si la noticia existe antes de eliminarla
            $consulta_existencia = "SELECT * FROM tickets WHERE id = '$id'";
            $resultado_existencia = mysqli_query($cnx, $consulta_existencia);

            if (mysqli_num_rows($resultado_existencia) == 0) {
                echo "<div class='alert alert-warning text-center'><strong>El ticket con ID $id no existe.</strong></div>";
            } else {
                // Si existe, eliminarla
                $consulta_update = "UPDATE  tickets SET estado = 'Cerrado' WHERE id = '$id'";
                $resultado_update = mysqli_query($cnx, $consulta_update);

                if ($resultado_update) {
                    echo "<div class='alert alert-success text-center'><strong>Tickcet cerrado con éxito.</strong></div>";
                } else {
                    echo "<div class='alert alert-danger text-center'><strong>Error al cerrar el ticket.</strong></div>";
                }
            }
            echo "<div class='text-center'><a href='gestion_tickets.php' class='btn btn-primary'>Volver al listado</a></div>";
        } else {
            if (empty($_GET['id'])) { 
        ?> 
            <h2 class="text-center">Buscar Ticket</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="mt-4">
                <div class="mb-3">
                    <label class="form-label">Código:</label>
                    <input name='id' type='text' class="form-control" required/>
                </div>
                <div class="text-center">
                    <button type="submit" name="Buscar" class="btn btn-primary">Buscar</button>
                    <a href="gestion_tickets.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        <?php
            } else {
                $id = mysqli_real_escape_string($cnx, $_GET['id']);

                // Comprobar si la noticia existe
                $consulta_existencia = "SELECT * FROM tickets WHERE id = '$id'";
                $resultado_existencia = mysqli_query($cnx, $consulta_existencia);

                if (mysqli_num_rows($resultado_existencia) == 0) {
                    echo "<div class='alert alert-warning text-center'><strong>El ticket con ID $id no existe.</strong></div>";
                    echo "<div class='text-center'><a href='herramientas_admin.php' class='btn btn-primary'>Volver al listado</a></div>";
                } else {
        ?>
            <div class="alert alert-warning text-center">
                <h4><i class="bi bi-exclamation-triangle"></i> Confirmar Cierre</h4>
                <p>¿Seguro que quieres cerrar el ticket con ID <strong><?php echo $id; ?></strong>?</p>
            </div>

            <form name="formulario1" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="text-center">
                <input name="id" type="hidden" value="<?php echo $id; ?>">
                <button type="submit" name="Cerrar" class="btn btn-danger">Cerrar Ticket</button>
                <a href="gestion_tickets.php" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php  
                }
            }
        }
        mysqli_close($cnx);
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
