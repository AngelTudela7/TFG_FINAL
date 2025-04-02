<?php 
session_start();
include ('../../../includes/config.php');
include('../../../includes/permisos.php');

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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
                <li class="nav-item"><a class="nav-link" href="../noticias/herramientas_admin.php">Listado</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios_crear.php">Crear</a></li>
                </ul>
            </div>

           <!-- Sección de usuario -->
           <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-white fw-bold"> <?php echo $_SESSION['nombre']; ?> </span>
                <img src="../../../assets/images/icono.png" alt="Usuario" class="rounded-circle" style="width: 30px; height: 30px;">
                <a href="../../../autenticaciones/logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </nav>

<?php
    if (isset($_POST['Actualizar'])) {
    $cnx = conectar();

    $consulta = "UPDATE usuarios SET 
    nombre = '" . $_POST['nombre'] . "',
    email = '" . $_POST['email'] . "',
    password = '" . $_POST['contrasena'] . "',
    rol_id = '" . $_POST['rol'] . "'
    WHERE id = '" . $_POST['id'] . "'";
    $resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));
    echo "<div class='container mt-4 text-center'>";
    echo "<div class='alert alert-success' role='alert'>";
    echo "<h4 class='fw-bold'><i class='bi bi-check-circle'></i> Usuario editado con éxito</h4>";
    echo "</div>";
    echo "<a href='administracion_users.php' class='btn btn-primary'><i class='bi bi-arrow-left'></i> Volver al listado</a>";
    echo "</div>";
    mysqli_close($cnx);

} else {

    $cnx = conectar();

    $consulta = "SELECT * FROM usuarios WHERE id='".$_GET['id']."'";
    $resultado = mysqli_query($cnx,$consulta) or die(mysqli_error($cnx));

    if (mysqli_num_rows($resultado) > 0 ) {
    $fila = mysqli_fetch_array($resultado);	
   ?>

   <div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4>Editar usuario</h4>
        </div>
        <div class="card-body">
            <form name="formulario1" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input name="nombre" type="text" class="form-control" value="<?php echo $fila['nombre']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <textarea name="email" class="form-control" rows="4"><?php echo $fila['email']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input name="contrasena" type="text" class="form-control" value="<?php echo $fila['password']; ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="1" <?php echo ($fila['rol_id'] == '1') ? 'selected' : ''; ?>>admin</option>
                        <option value="2" <?php echo ($fila['rol_id'] == '2') ? 'selected' : ''; ?>>comun</option>
                        
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" name="Actualizar" class="btn btn-success">
                        <i class="bi bi-save"></i> Actualizar Usuario
                    </button>
                    <a href="administracion_users.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al listado
                    </a>
                </div>
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