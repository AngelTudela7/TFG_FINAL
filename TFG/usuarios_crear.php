<?php
session_start();
include('includes/config.php');
include('includes/permisos.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Insertar Nuevo Usuario</h2>

        <?php
        if (isset($_POST['Insertar'])) {
            $cnx = conectar();

            // Recoger y sanitizar datos
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $contrasena = trim($_POST['contrasena']);
            $rol = trim($_POST['rol']);

            // Verificar que ningún campo esté vacío
            if (empty($nombre) || empty($email) || empty($contrasena) || empty($rol)) {
                echo "<div class='alert alert-danger text-center'><strong>Todos los campos son obligatorios.</strong></div>";
            } else {
                // Evitar inyección SQL
                $nombre = mysqli_real_escape_string($cnx, $nombre);
                $email = mysqli_real_escape_string($cnx, $email);
                $contrasena = mysqli_real_escape_string($cnx, $contrasena);
                $rol = mysqli_real_escape_string($cnx, $rol);

                // Hashear la contraseña
               

                // Verificar rol permitido
                $roles_permitidos = ['1', '2'];
                if (!in_array($rol, $roles_permitidos)) {
                    echo "<div class='alert alert-danger text-center'><strong>Rol no válido.</strong></div>";
                } else {
                    // Insertar en la base de datos
                    $consulta = "INSERT INTO usuarios (nombre, email, password, rol_id) 
                                 VALUES ('$nombre', '$email', '$contrasena', '$rol')";
                    
                    if (mysqli_query($cnx, $consulta)) {
                        echo "<div class='alert alert-success text-center'><strong>Usuario Insertado con éxito.</strong></div>";
                    } else {
                        echo "<div class='alert alert-danger text-center'><strong>Error al insertar el Usuario: " . mysqli_error($cnx) . "</strong> <a href='usuarios_crear.php' class='btn btn-primary'>Volver al formulario </a></div>";
                    }
                }
            }

            echo "<div class='text-center mt-3'><a href='administracion_users.php' class='btn btn-primary'>Volver al listado </a></div>";

            mysqli_close($cnx);
        } else {
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Nombre Usuario</label>
                <input name="nombre" type="text" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input name="email" type="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input name="contrasena" type="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rol Usuario</label>
                <select name="rol" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <option value="1">Admin</option>
                    <option value="2">Comun</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" name="Insertar" class="btn btn-success">Insertar Usuario</button>
                <a href="administracion_users.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

        <?php } ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
