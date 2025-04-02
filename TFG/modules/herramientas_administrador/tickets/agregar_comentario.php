<?php 
session_start();
include ('../../../../includes/config.php');
include('../../../includes/permisos.php');
 ?>

<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegurarse de que el usuario esté autenticado y tenga el ID de usuario disponible en la sesión
if (!isset($_SESSION['id'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

// Conexión a la base de datos
$cnx = conectar();  // Asegúrate de tener la función de conexión

// Comprobar si los parámetros necesarios están presentes
if (isset($_POST['comentario']) && isset($_POST['ticket_id']) && !empty($_POST['comentario'])) {
    $comentario = mysqli_real_escape_string($cnx, $_POST['comentario']); // Escapar comentario para evitar inyecciones
    $ticket_id = (int) $_POST['ticket_id']; // Asegurarse de que el ID sea un número entero
    $usuario_id = $_SESSION['id'];  // ID del usuario autenticado

    // Consulta de inserción
    $consulta = "INSERT INTO Comentarios_Tickets (comentario, ticket_id, usuario_id, fecha_comentario) 
                 VALUES ('$comentario', $ticket_id, $usuario_id, NOW())";



    // Ejecutar la consulta
    if (mysqli_query($cnx, $consulta)) {
        // Si se inserta correctamente, devolver el nuevo comentario
        $nuevo_comentario = "<div class='comment mt-3'>
                                <strong>" . $_SESSION['nombre'] . "</strong> <span class='text-muted'>" . date("Y-m-d H:i:s") . "</span>
                                <p>" . $comentario . "</p>
                             </div>";
        echo $nuevo_comentario; // Esto será lo que se muestre en el frontend
    } else {
        // Si ocurre un error, mostrar el error de MySQL
        echo "Error al agregar el comentario: " . mysqli_error($cnx);
    }
} else {
    echo "Faltan parámetros para agregar el comentario.";
}

?>
