<?php
session_start();
include('includes/config.php');
include('includes/database.php');



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
    <h1 class="text-center text-danger mb-4">Debes iniciar sesión</h1>
    <a class="btn btn-outline-light" href="login_comun.php">Iniciar Sesión</a>
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

            /* Personaliza la barra de desplazamiento */
            .comentarios::-webkit-scrollbar {
                width: 8px;
                /* Ancho de la barra de desplazamiento */
            }

            .comentarios::-webkit-scrollbar-thumb {
                background-color: #888;
                /* Color de la "cacha" de la barra */
                border-radius: 10px;
                /* Bordes redondeados */
                transition: background-color 0.3s ease;
                /* Transición suave para el hover */
            }

            .comentarios::-webkit-scrollbar-thumb:hover {
                background-color: #555;
                /* Color de la barra cuando el usuario pasa el cursor sobre ella */
            }

            .comentarios::-webkit-scrollbar-track {
                background-color: #222;
                /* Fondo de la pista de la barra de desplazamiento */
                border-radius: 10px;
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
                                    <li><a class="dropdown-item" href="mi_perfil.php">Mi perfil</a></li>
                                    <li><a class="dropdown-item" href="soporte.php">Soporte</a></li>
                                    <li><a class="dropdown-item text-danger" href="logout_comun.php">Cerrar sesión</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <?php


        if (isset($_POST['Insertar'])) {
            $cnx = conectar();



            // Recoger y sanitizar datos
            $ticket_id = trim($_POST['ticket_id']);
            $usuario_id = trim($_POST['usuario_id']);
            $comentario = trim($_POST['comentario']);


            // Verificar que ningún campo esté vacío
            if (empty($ticket_id) || empty($usuario_id) || empty($comentario)) {
                echo "<div class='alert alert-danger text-center'><strong>Hay que introducir un comentario.</strong></div>";
            } else {
                // Evitar inyección SQL
                $ticket_id = mysqli_real_escape_string($cnx, $ticket_id);
                $usuario_id = mysqli_real_escape_string($cnx, $usuario_id);
                $comentario = mysqli_real_escape_string($cnx, $comentario);



                // Insertar en la base de datos
                $consulta = "INSERT INTO comentarios_tickets (ticket_id, usuario_id, comentario) 
                                 VALUES ('$ticket_id', '$usuario_id', '$comentario')";

                if (mysqli_query($cnx, $consulta)) {
                    echo "
                    <div class=' container alert alert-success text-center m-t 4 p-4 shadow-lg rounded' role='alert' style='background-color: #28a745; color: white; border: 2px solid #155724;'>
                        <h4 class='alert-heading'><i class='bi bi-check-circle-fill'></i> ¡Ticket Enviado!</h4>
                        <p><strong>comentario enviado con éxito. Pronto recibirás una respuesta por parte del moderador.</strong></p>
                    </div>";
                    echo "
                    <div class='text-center mt-4'>
                        <a href='soporte.php' class='btn btn-primary btn-lg px-4 py-2' style='border-radius: 50px; font-weight: bold;'>Volver tus tickets</a>
                    </div>
                ";
                } else {
                     echo "
                    <div class=' container alert alert-success text-center m-t 4 p-4 shadow-lg rounded' role='alert' style='background-color: #28a745; color: white; border: 2px solid #155724;'>
                        <h4 class='alert-heading'><i class='bi bi-check-circle-fill'></i> Error</h4>
                        <a href='comentarios_tickets.php?id=" . $_GET['id'] . "' class='btn btn-primary btn-lg px-4 py-2' style='border-radius: 50px; font-weight: bold;'>Volver al ticket</a>
                    </div>";
                }
            }


            

            mysqli_close($cnx);
        } else {
        ?>


            <?php
            $cnx = conectar();
            $consulta = "SELECT ct.id, ct.ticket_id, ct.usuario_id, ct.comentario , ct.fecha_comentario, usu.nombre
               FROM comentarios_tickets ct
               INNER JOIN usuarios usu ON ct.usuario_id = usu.id
               WHERE ct.ticket_id = " . $_GET['id'] . " 
               ORDER BY ct.fecha_comentario DESC ";

            $resultado = mysqli_query($cnx, $consulta);
            if (!$resultado) {
                die("Error en la consulta: " . mysqli_error($cnx));
            }
            ?>

            <div class="container mt-4">
                <h2 class="text-center text-white">Conversación del Ticket</h2>

                <!-- Contenedor de comentarios con scroll -->
                <div class="comentarios p-4 rounded bg-dark text-white" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "<div class='comentario mb-3 p-3 rounded bg-secondary'>";
                            echo "<strong class='d-block'>" . htmlspecialchars($row['nombre']) . "</strong>";
                            echo "<p class='m-0' style='color: #f0f0f0;   font-family: Arial, Helvetica, sans-serif;'>" . nl2br(htmlspecialchars($row['comentario'])) . "</p>";
                            echo "<small class='text-light' style='font-family: Arial, Helvetica, sans-serif;'>" . date("d/m/Y H:i", strtotime($row['fecha_comentario'])) . "</small>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='text-center text-muted'>Aún no hay comentarios en este ticket.</p>";
                    }
                    ?>
                </div>
            </div>
                    

            <div class="container mt-5">
                <h2 class="text-center text-white">Deja un nuevo comentario en este ticket</h2>
                

                <!-- Formulario de Ticket -->
                <div class="card p-4" style="background-color: #212529; color: white;">
                    <form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
                       
                    <!-- Descripción del ticket -->
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Comentario:</label>
                            <textarea class="form-control" id="comentario" name="comentario" rows="4" required style="background-color: #495057; color: white; border: 1px solid #6c757d;  font-family: Arial, Helvetica, sans-serif;"></textarea>
                        </div>


                        <!-- Usuario ID (esto se llenaría dinámicamente con la sesión del usuario) -->
                        <input type="hidden" name="ticket_id" value="<?php echo $_GET['id']; ?>">
                        <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['id']; ?>">

                        <!-- Enviar formulario -->
                        <div class="text-center">
                            <button type="submit" name="Insertar" class="btn btn-primary">Enviar Ticket</button>
                        </div>
                    </form>
                </div>
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