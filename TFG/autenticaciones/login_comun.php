<?php
include('../includes/config.php');
include('../includes/database.php');

$nombreVacio = false;
$contravacia = false;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #121212; /* Fondo oscuro para toda la página */
            color: #ccc; /* Color de texto suave para que contraste bien con el fondo */
        }

        .card {
            background-color: #1e1e1e; /* Fondo oscuro para la tarjeta del formulario */
            border-radius: 10px;
        }

        .form-label {
            color: #ccc; /* Color suave para las etiquetas */
        }

        .form-control {
            background-color: #333; /* Fondo oscuro para los inputs */
            color: #fff; /* Color de texto blanco para los inputs */
            border: 1px solid #444; /* Borde más suave y oscuro */
        }

        .form-control:focus {
            background-color: #444; /* Fondo más claro para cuando el input está seleccionado */
            border-color: #007bff; /* Borde azul para resaltar el input seleccionado */
        }

        .btn-primary {
    background-color: #007bff; /* Azul para el botón de inicio de sesión */
    border-color: #0056b3;
    color: #fff; /* Texto blanco para que coincida con los inputs */
}
        .btn-primary:hover {
            background-color: #0056b3; /* Azul más oscuro al pasar el ratón por encima */
        }

        a {
            color: #66b3ff; /* Color de enlace suave en azul claro */
        }

        a:hover {
            color: #ffb3b3; /* Color de enlace al pasar el ratón */
        }

        .text-center p {
            color: #bbb; /* Texto suave en la sección del enlace */
        }
    </style>
</head>
<body>
    

<?php
echo $_SESSION['nombre'];
//Comprobación de si el botón de iniciar sesión ha sido pulsado
if (isset($_POST["Iniciar"])) {

    //Si ha sido pulsado pero el campo de nombre está vacío, salta el error. Esta comprobación se hace primero en html, pero si se cambia maliciosamente sigue habiendo otra comprobación
    if (empty($_POST['userName'])) {
        echo "<center>";
        echo "<h1 style='color:red;'>El nombre es obligatorio</h1>"; 
        echo "<br>";
        echo "<a href='login_comun.php'>VOLVER AL FORMULARIO</a>";
        echo "</center>";
    } else {
    
//Misma comprobación que arriba, si la contraseña está vacía salta el error
    if (empty($_POST["passwd"])) {
        echo "<center>";
        echo "<h1 style='color:red;'>La contraseña es obligatoria</h1>"; 
        echo "<br>";
        echo "<a href='login_comun.php'>VOLVER AL FORMULARIO</a>";
        echo "</center>";
    } else {
       
//Cuando ambos datos son introducidos se pasa a la conexión con la base de datos

//Conexión mediante la funcion del archivo de funciones.
        $conexion = conectar();

//Se recogen las variables de usuario y contraseña
        $usuario = mysqli_real_escape_string(( $conexion), $_POST["userName"]);
        $contraseña = mysqli_real_escape_string(( $conexion), $_POST["passwd"]);

        //Instrucción MYSQL, que compara los datos introducidos con los que hay en la database para verificar si el usuario es correcto 
        $consulta = "SELECT id, nombre, rol_id FROM usuarios WHERE nombre = '" .  $usuario   . "' AND password ='" .    $contraseña   . "'";


        //Se guarda el resultado de la consulta en una variable
        $resultado = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));

        //Si el resultado devuelve 1 es que el usuario existe
        if (mysqli_num_rows($resultado) == 1) {
            $datos = mysqli_fetch_array($resultado);
        
            session_start();

            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['rol_id'] = $datos['rol_id'];
            $_SESSION['id'] = $datos['id'];
            session_write_close();
            

            header("location:../index.php");


//Si el usuario es incorrecto salta un error y te devuelve al login
        } else {
            echo "<center>";
            echo "<h1>ERROR:DATOS INCORRECTOS";
            echo "<br>";
            echo "<a href='login_comun.php'>VOLVER AL FORMULARIO</a>";
            echo "</center>";
        }
    }
}
} else {
?>

<!-- Si el botón de iniciar sesión no ha sido pulsado, muestra el formulario para hacerlo -->

<div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 350px;">
        <h4 class="text-center mb-4" style="color: #ccc;">Iniciar Sesión</h4>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="mb-3">
                    <label for="userName" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="userName" required>
                </div>
                <div class="mb-3">
                    <label for="passwd" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="passwd" required>
                </div>
                <button type="submit" name="Iniciar" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>

            <!-- Enlace para registrar una nueva cuenta -->
            <div class="text-center mt-3">
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
</div>

<?php
}
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
