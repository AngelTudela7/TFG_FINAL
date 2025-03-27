<?php
include ('includes/database.php');
error_reporting(E_ALL);  // Habilitar reporte de todos los errores
ini_set('display_errors', 1);  // Mostrar errores en pantalla
session_start();

if (isset($_POST['contenido']) && isset($_POST['noticia_id']) && isset($_SESSION['id'])) {
    $cnx = conectar();
    $contenido = mysqli_real_escape_string($cnx, $_POST['contenido']);
    $noticia_id = $_POST['noticia_id'];
    $autor_id = $_SESSION['id'];

    // Insertar comentario en la base de datos
    $consulta_comentario = "INSERT INTO Comentarios (contenido, autor_id, noticia_id) 
                            VALUES ('$contenido', $autor_id, $noticia_id)";

    if (mysqli_query($cnx, $consulta_comentario)) {
        // Redirigir al usuario a la misma página de la noticia después de insertar el comentario
        header("Location: noticias_detalle.php?id=" . $noticia_id);
        exit();
    } else {
        echo "Error al insertar el comentario.";
    }
} else {
    echo "No estás autorizado para comentar.";
}
?>