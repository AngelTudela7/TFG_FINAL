<?php
session_start();
include('../../../includes/config.php');
include('../../../includes/database.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Insertar Nueva Noticia</h2>

        <?php
        if (isset($_POST['Insertar'])) {
            
            $cnx = conectar();

            // Verificar que el usuario está logueado
            if (!isset($_SESSION['rol_id'])) {
                die("No hay un usuario logueado.");
            }

            // Recoger y sanitizar datos
            $autor_id = $_SESSION['rol_id'];
            $titulo = trim($_POST['titulo']);
            $descripcion_corta = trim($_POST['descripcion_corta']);
            $contenido = trim($_POST['contenido']);
            $imagen = trim($_POST['imagen']);
            $prioridad = trim($_POST['prioridad']);

            // Verificar que ningún campo esté vacío
            if (empty($titulo) || empty($contenido) || empty($imagen) || empty($prioridad)) {
                echo "<div class='alert alert-danger text-center'><strong>Todos los campos son obligatorios.</strong></div>";
            } else {
                // Evitar inyección SQL
                $titulo = mysqli_real_escape_string($cnx, $titulo);
                $contenido = mysqli_real_escape_string($cnx, $contenido);
                $imagen = mysqli_real_escape_string($cnx, $_POST['imagen']);
                $descripcion_corta = mysqli_real_escape_string($cnx, $descripcion_corta);

                // Asegurar que la prioridad sea válida
                $prioridades_permitidas = ['Principal', 'Izquierda', 'Derecha'];
                if (!in_array($prioridad, $prioridades_permitidas)) {
                    echo "<div class='alert alert-danger text-center'><strong>Prioridad no válida.</strong></div>";
                } else {
                    // Insertar en la base de datos
                    $consulta = "INSERT INTO Noticias (titulo, contenido, imagen, prioridad, autor_id, descripcion_corta) 
                                 VALUES ('$titulo', '$contenido', '$imagen', '$prioridad', '$autor_id', '$descripcion_corta')";

                    if (mysqli_query($cnx, $consulta)) {
                        echo "<div class='alert alert-success text-center'><strong>Registro Insertado con éxito.</strong></div>";
                    } else {
                        echo "<div class='alert alert-danger text-center'><strong>Error al insertar la noticia: " . mysqli_error($cnx) . "</strong></div>";
                    }
                }
            }

            echo "<div class='text-center mt-3'><a href='herramientas_admin.php' class='btn btn-primary'>Volver al listado</a></div>";

            mysqli_close($cnx);
        } else {
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Título Noticia</label>
                <input name="titulo" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion Corta</label>
                <textarea name="descripcion_corta" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Contenido Noticia</label>
                <textarea name="contenido" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">URL de la Imagen</label>
                <input name="imagen" type="url" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prioridad Noticia</label>
                <select name="prioridad" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Principal">Principal</option>
                    <option value="Izquierda">Izquierda</option>
                    <option value="Derecha">Derecha</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" name="Insertar" class="btn btn-success">Insertar Noticia</button>
                <a href="herramientas_admin.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
