<?php
session_start();
include('../../../includes/config.php');
include('../../../includes/database.php');



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
<body class="d-flex flex-column align-items-center justify-content-center vh-100 bg-dark text-white">
    <h1 class="text-center text-danger mb-4">Debes iniciar sesión para abrir un ticket de soporte</h1>
    <a class="btn btn-outline-light" href="../../../autenticaciones/login_comun.php">Iniciar Sesión</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';
} else {
?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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
        </style>



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
                <li class="nav-item"><a class="nav-link" href="../../../index.php">Noticias</a></li>
                <li class="nav-item"><a class="nav-link" href="../../../modules/competiciones/competiciones.php">Competiciones</a></li>
                <li class="nav-item"><a class="nav-link" href="../../../modules/equipos/equipos.php">Equipos</a></li>
                <li class="nav-item"><a class="nav-link" href="../../../modules/jugadores/jugadores.php">Jugadores</a></li>
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
                            <img src="../../../assets/images/icono.png" alt="Usuario" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                            <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="mi_perfil.php">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="soporte.php">Soporte</a></li>
                            <li><a class="dropdown-item text-danger" href="../../autenticaciones/logout_comun.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
  </nav>


        <?php
        if (isset($_POST['Insertar'])) {
            $cnx = conectar();



            // Recoger y sanitizar datos
            $titulo = trim($_POST['titulo']);
            $descripcion = trim($_POST['descripcion']);
            $usuario_id = trim($_POST['usuario_id']);


            // Verificar que ningún campo esté vacío
            if (empty($titulo) || empty($descripcion) || empty($usuario_id)) {
                echo "<div class='alert alert-danger text-center'><strong>Todos los campos son obligatorios.</strong></div>";
            } else {
                // Evitar inyección SQL
                $titulo = mysqli_real_escape_string($cnx, $titulo);
                $descripcion = mysqli_real_escape_string($cnx, $descripcion);
                $usuario_id = mysqli_real_escape_string($cnx, $usuario_id);



                // Insertar en la base de datos
                $consulta = "INSERT INTO Tickets (titulo, descripcion, usuario_id) 
                                 VALUES ('$titulo', '$descripcion', '$usuario_id')";

                if (mysqli_query($cnx, $consulta)) {
                    echo "
                    <div class=' container alert alert-success text-center m-t 4 p-4 shadow-lg rounded' role='alert' style='background-color: #28a745; color: white; border: 2px solid #155724;'>
                        <h4 class='alert-heading'><i class='bi bi-check-circle-fill'></i> ¡Ticket Enviado!</h4>
                        <p><strong>Tu ticket ha sido enviado con éxito. Nos aseguraremos de atender tu solicitud lo antes posible.</strong></p>
                    </div>
                    ";
                } else {
                    echo "
                    <div class='text-center mt-4'>
                        <a href='soporte.php' class='btn btn-primary btn-lg px-4 py-2' style='border-radius: 50px; font-weight: bold;'>Volver a tu soporte</a>
                    </div>
                    ";
                }
            }


            echo "<div class='text-center mt-3'><a href='soporte.php' class='btn btn-primary'>Volver a tu soporte</a></div>";

            mysqli_close($cnx);
        } else {
        ?>









            <div class="container mt-5">
                <h2 class="text-center text-white">Enviar ticket de soporte</h2>
                <p class="text-center text-white">Completa el siguiente formulario para crear un ticket de soporte. Nos aseguraremos de atender tu solicitud lo antes posible.</p>

                <!-- Formulario de Ticket -->
                <div class="card p-4" style="background-color: #212529; color: white;">
                    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
                        <!-- Título del ticket -->
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del Ticket</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required style="background-color: #495057; color: white; border: 1px solid #6c757d;">
                        </div>

                        <!-- Descripción del ticket -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required style="background-color: #495057; color: white; border: 1px solid #6c757d;"></textarea>
                        </div>


                        <!-- Usuario ID (esto se llenaría dinámicamente con la sesión del usuario) -->
                        <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['id']; ?>">


                        <!-- Enviar formulario -->
                        <div class="text-center">
                            <button type="submit" name="Insertar" class="btn btn-primary">Enviar Ticket</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
           $cnx = conectar();
           $consulta = "SELECT tickets.id AS ticket_id, tickets.titulo, tickets.estado, 
                               tickets.fecha_actualizacion, tickets.fecha_creacion
                        FROM tickets
                        JOIN usuarios ON tickets.usuario_id = usuarios.id
                        WHERE usuarios.id = " . $_SESSION['id'] . " 
                        AND (estado = 'Abierto' OR estado = 'En Proceso')
                        ORDER BY tickets.fecha_creacion DESC;";

            $resultado = mysqli_query($cnx, $consulta);
            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($cnx));
            }

            ?>

            <div class="container mt-4">
                <h1 class="text-center">Tus tickets abiertos</h1>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="table-dark align-middle">
                            <tr>
                                <th>Título</th>
                                <th>Estado</th>
                                <th>Fecha Creación</th>
                                <th>Última Actualización</th>
                                <th>Comentarios del moderador</th>

                            </tr>
                        </thead>
                        <tbody class="align-middle">

                            <?php
                            if (mysqli_num_rows($resultado) > 0) {
                                // Modificado para acceder a los campos correctamente utilizando el alias
                                while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                                    // Usamos los alias para los campos de la tabla tickets y usuarios
                                    $id = $row['ticket_id'];
                                    $titulo = $row['titulo'];
                                    $estado = $row['estado'];
                                    $fecha_creacion = $row['fecha_creacion'];
                                    $ult_update = $row['fecha_actualizacion'];

                                    echo "<tr>";
                                    echo "<td class='text-start text-center'><strong>$titulo</strong></td>";
                                    echo "<td class='text-start text-center'><strong>$estado</strong></td>";
                                    echo "<td style='color: black;'>" . date("d/m/Y", strtotime($fecha_creacion)) . "</td>";
                                    echo "<td style='color: black;'>" . date("d/m/Y", strtotime($ult_update)) . "</td>";
                                    echo "<td>
                                    <div class='d-flex justify-content-center gap-2'>
                                        <a href='../tickets/comentarios_tickets.php?id=$id' class='btn btn-success btn-sm'>Ver</a>  
                                        
                                    </div>
                                </td>";    
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center text-danger'>Aún no has abierto ningún ticket</td></tr>";
                            }
                            mysqli_free_result($resultado);
                            mysqli_close($cnx);
                            ?>

                        </tbody>
                    </table>
                </div>

                    




                


            <?php
        }

            ?>



    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </html>
<?php
}

?>