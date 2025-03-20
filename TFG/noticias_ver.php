<?php
session_start();
include ('includes/config.php');
include('includes/permisos.php');
  ?>


  <!DOCTYPE html>
  <html>
  <head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<title></title>
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
                    <li class="nav-item"><a class="nav-link" href="herramientas_admin.php">Listado</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Crear</a></li>
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
$cnx = conectar();
$consulta = "SELECT * FROM Noticias WHERE id='".$_GET['id']."'";
$resultado = mysqli_query($cnx, $consulta) or die(mysqli_error($cnx));


if (mysqli_num_rows($resultado) > 0) {
	$fila = mysqli_fetch_array($resultado);
	?>

<table class="table table-bordered table-striped table-hover mt-4 shadow-sm">
    <thead class="table-dark">
        <tr>
            <th colspan="2" class="text-center fs-4">Detalles de la Noticia</th>
        </tr>
    </thead>
    <tbody class="bg-white">
        <tr>
            <th class="bg-light">Título</th>
            <td><?php echo $fila['titulo']; ?></td>
        </tr>
        <tr>
            <th class="bg-light">Contenido</th>
            <td><?php echo $fila['contenido']; ?></td>
        </tr>
        <tr>
            <th class="bg-light">Imagen</th>
            <td>
                <img src="<?php echo $fila['imagen']; ?>" alt="Imagen de la Noticia" class="img-thumbnail" style="max-width: 200px;">
            </td>
        </tr>
        <tr>
            <th class="bg-light">Prioridad</th>
            <td>
                <span class="badge bg-<?php echo ($fila['prioridad'] == 'Alta') ? 'danger' : 'secondary'; ?>">
                    <?php echo $fila['prioridad']; ?>
                </span>
            </td>
        </tr>
        <tr>
            <th class="bg-light">Fecha de Publicación</th>
            <td><?php echo date("d/m/Y", strtotime($fila['fecha_publicacion'])); ?></td>
        </tr>
        <tr>
            <th class="bg-light">Publicada Por</th>
            <td><?php echo $fila['autor_id']; ?></td>
        </tr>
    </tbody>
</table>





<?php 
} else {
 echo "Error recuperando los datos";
}
?>


<div class="text-center mt-3">
    <a href="herramientas_admin.php" class="btn btn-primary">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
</div>





	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

  </body>
  </html>