<?php
include('../includes/config.php');
include('../includes/database.php');

$nombreVacio = false;
$emailVacio = false;
$contravacia = false;
$emailExistente = false;
$nombreExistente = false;
$registroExitoso = false;

// Comprobación de si el botón de registro ha sido pulsado
if (isset($_POST["Registrar"])) {

    // Si los campos no están vacíos, se procesan
    if (empty($_POST['userName']) || empty($_POST['email']) || empty($_POST["passwd"])) {
        if (empty($_POST['userName'])) {
            $nombreVacio = true;
        }
        if (empty($_POST['email'])) {
            $emailVacio = true;
        }
        if (empty($_POST['passwd'])) {
            $contravacia = true;
        }
    } else {
        // Si no están vacíos, conectamos con la base de datos
        $conexion = conectar();

        $usuario = mysqli_real_escape_string($conexion, $_POST["userName"]);
        $email = mysqli_real_escape_string($conexion, $_POST["email"]);
        $contraseña = mysqli_real_escape_string($conexion, $_POST["passwd"]);
        $rol_id = 2; // Se puede definir el rol por defecto, si no quieres asignar uno fijo, también puedes modificarlo

        // Verificamos si el email ya está registrado
        $consulta_email = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado_email = mysqli_query($conexion, $consulta_email);

        $consulta_nombre = "SELECT * FROM usuarios WHERE nombre = '$usuario'";
        $resultado_nombre = mysqli_query($conexion, $consulta_nombre);

        if (mysqli_num_rows($resultado_email) > 0) {
            $emailExistente = true;
        } else if (mysqli_num_rows($resultado_nombre ) >0) {

        $nombreExistente = true;
        } else {
            // Si no existe, registramos al usuario en la base de datos
            $consulta_registro = "INSERT INTO usuarios (nombre, email, password, rol_id) 
                                  VALUES ('$usuario', '$email', '$contraseña', '$rol_id')";
            if (mysqli_query($conexion, $consulta_registro)) {
                // Registro exitoso
                $registroExitoso = true;
            } else {
                echo "<center><h1 style='color:red;'>Error al registrar el usuario.</h1></center>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">

<?php if ($registroExitoso): ?>
    <!-- Mensaje de confirmación de registro -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 350px; text-align: center; background-color: #343a40; color: #fff;">
            <h4 class="text-center mb-4">¡Registro Exitoso!</h4>
            <p>Tu cuenta ha sido creada correctamente. Ahora puedes iniciar sesión.</p>
            <a href="login_comun.php" class="btn btn-primary w-100">Ir al Login</a>
        </div>
    </div>
<?php else: ?>
    <!-- Formulario de registro -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 350px; background-color: #343a40; color: #fff;">
            <h4 class="text-center mb-4">Registrarse</h4>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="userName" class="form-label" style="color: #ccc;">Usuario:</label>
                    <input type="text" class="form-control" name="userName" required style="background-color: #495057; color: #fff; border: 1px solid #6c757d;">
                    <?php if ($nombreVacio) { echo "<small class='text-danger'>El nombre es obligatorio</small>"; } ?>
                    <?php if ($nombreExistente) { echo "<small class='text-danger'>Este nombre ya está en uso</small>"; } ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label" style="color: #ccc;">Correo Electrónico:</label>
                    <input type="email" class="form-control" name="email" required style="background-color: #495057; color: #fff; border: 1px solid #6c757d;">
                    <?php if ($emailVacio) { echo "<small class='text-danger'>El correo es obligatorio</small>"; } ?>
                    <?php if ($emailExistente) { echo "<small class='text-danger'>Este correo ya está registrado</small>"; } ?>
                </div>
                <div class="mb-3">
                    <label for="passwd" class="form-label" style="color: #ccc;">Contraseña:</label>
                    <input type="password" class="form-control" name="passwd" required style="background-color: #495057; color: #fff; border: 1px solid #6c757d;">
                    <?php if ($contravacia) { echo "<small class='text-danger'>La contraseña es obligatoria</small>"; } ?>
                </div>
                <button type="submit" name="Registrar" class="btn btn-primary w-100">Registrar</button>
            </form>

            <!-- Enlace para ir a iniciar sesión -->
            <div class="text-center mt-3">
                <p>¿Ya tienes una cuenta? <a href="login_comun.php" style="color: #ccc;">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
