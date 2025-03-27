<?php 
session_start();
include ('includes/config.php');
include('includes/permisos.php');
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    
    
    $(document).ready(function() {
    $('#comment-form').on('submit', function(event) {
        event.preventDefault(); // Prevenir el envío tradicional del formulario (sin recarga)

        var comentario = $('textarea[name="comentario"]').val();
        var ticket_id = <?php echo $_GET['id']; ?>; // Obtener el ID del ticket desde la URL

        // Depuración
        console.log("Comentario:", comentario);
        console.log("Ticket ID:", ticket_id);

        if (!comentario.trim()) {
            alert("Por favor, escribe un comentario.");
            return; // Si el comentario está vacío, no enviar la solicitud
        }

        $.ajax({
            url: 'agregar_comentario.php',  // Enviar la solicitud AJAX al archivo PHP
            method: 'POST',
            data: {
                comentario: comentario,
                ticket_id: ticket_id
            },
            success: function(response) {
                // Depuración de la respuesta del servidor
                console.log("Respuesta del servidor:", response);

                if (response.startsWith("Error")) {
                    alert(response); // Si la respuesta contiene "Error", mostrar el mensaje
                } else {
                    // Mostrar el comentario recién agregado
                    $('#comments-section').append(response);
                    $('textarea[name="comentario"]').val(''); // Limpiar el campo de comentario
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX:", error);
                console.log("Detalles del error:", xhr.responseText);  // Mostrar detalles de la respuesta de error
                alert("Error al agregar el comentario. Intenta nuevamente.");
            }
        });
    });
});

</script>


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
                <li class="nav-item"><a class="nav-link" href="gestion_tickets.php">Listado</a></li>
                    
                </ul>
            </div>

            <!-- Sección de usuario -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-white fw-bold"> <?php echo $_SESSION['nombre']; ?> </span>
                <img src="assets/images/icono.png" alt="Usuario" class="rounded-circle" style="width: 30px; height: 30px;">
                <a href="logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </nav>

<?php
    if (isset($_POST['Actualizar'])) {
    $cnx = conectar();

    $consulta = "UPDATE tickets SET 
    titulo = '" . $_POST['titulo'] . "',
    descripcion = '" . $_POST['descripcion'] . "',
    estado = '" . $_POST['estado'] . "',
    prioridad = '" . $_POST['prioridad'] . "',
    desarrollador_id = '" . $_SESSION['id'] . "'
    WHERE id = '" . $_POST['id'] . "'";
    $resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));
    echo "<div class='container mt-4 text-center'>";
    echo "<div class='alert alert-success' role='alert'>";
    echo "<h4 class='fw-bold'><i class='bi bi-check-circle'></i> Registro editado con éxito</h4>";
    echo "</div>";
    echo "<a href='gestion_tickets.php' class='btn btn-primary'><i class='bi bi-arrow-left'></i> Volver al listado</a>";
    echo "</div>";
    mysqli_close($cnx);

} else {

    $cnx = conectar();

    $consulta = "SELECT * FROM tickets WHERE id='".$_GET['id']."'";
    $resultado = mysqli_query($cnx,$consulta) or die(mysqli_error($cnx));

    if (mysqli_num_rows($resultado) > 0 ) {
    $fila = mysqli_fetch_array($resultado);	
   ?>

   <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4>Gestionar Ticket</h4>
        </div>
        <div class="card-body">
            <form name="formulario1" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input name="titulo" type="text" class="form-control" value="<?php echo $fila['titulo']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">descripcion</label>
                    <textarea name="descripcion" class="form-control" rows="4"><?php echo $fila['descripcion']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select">
                        <option value="Abierto" <?php echo ($fila['estado'] == 'Abierto') ? 'selected' : ''; ?>>Abierto</option>
                        <option value="En Proceso" <?php echo ($fila['estado'] == 'En Proceso') ? 'selected' : ''; ?>>En Proceso</option>
                        <option value="Resuelto" <?php echo ($fila['estado'] == 'Resuelto') ? 'selected' : ''; ?>>Resuelto</option>
                        <option value="Cerrado" <?php echo ($fila['estado'] == 'Cerrado') ? 'selected' : ''; ?>>Cerrado</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select">
                        <option value="Baja" <?php echo ($fila['prioridad'] == 'Baja') ? 'selected' : ''; ?>>Baja</option>
                        <option value="Media" <?php echo ($fila['prioridad'] == 'Media') ? 'selected' : ''; ?>>Media</option>
                        <option value="Alta" <?php echo ($fila['prioridad'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                        <option value="Crítica" <?php echo ($fila['prioridad'] == 'Crítica') ? 'selected' : ''; ?>>Crítica</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" name="Actualizar" class="btn btn-success">
                        <i class="bi bi-save"></i> Actualizar Ticket
                    </button>
                    <a href="gestion_tickets.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al listado
                    </a>
                </div>
            </form>
        </div>
    </div>


  

    <!-- Mostrar comentarios -->
    <div id="comments-section" class="mt-4">
    <?php
    $comentarios = mysqli_query($cnx, "SELECT c.comentario, c.fecha_comentario, u.nombre 
                                        FROM Comentarios_Tickets c
                                        JOIN usuarios u ON c.usuario_id = u.id
                                        WHERE c.ticket_id = " . $fila['id'] . "
                                        ORDER BY c.fecha_comentario DESC LIMIT 6");

    while ($comentario = mysqli_fetch_assoc($comentarios)) {
        echo "<div class='comment mt-3'>";
        echo "<strong>" . $comentario['nombre'] . "</strong> <span class='text-muted'>" . $comentario['fecha_comentario'] . "</span>";
        echo "<p>" . $comentario['comentario'] . "</p>";
        echo "</div>";
    }
?>
    </div>


<!-- Formulario para agregar comentarios -->
<div class="card mt-4">
        <div class="card-header bg-info text-white text-center">
            <h4>Agregar Comentario</h4>
        </div>
        <div class="card-body">
        <form id="comment-form">
    <textarea name="comentario" class="form-control" rows="4" placeholder="Escribe tu comentario..."></textarea>
    <button type="submit" id="add-comment" class="btn btn-primary mt-3">Agregar Comentario</button>
</form>
        </div>
    </div>


</div>



   <?php  
    } else {

    	echo "<h1>Error Fatal</h1>";
    }


}

?>

</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</html>