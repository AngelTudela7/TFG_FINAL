<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

<h1>LISTADO DE CLIENTES</h1>

<?php
include('includes/config.php');
include('includes/permisos.php');
session_start();

echo "<a href='clientes_Insertar.php'><button>INSERTAR NUEVO CLIENTE</button></a>\n";

echo "<br>";
 ?>



<br>
<table border="1">
<tr>
	<th>Codigo</th>
	<th>Nombre:</th>
	<th>Telefono:</th>
	<th>Acciones</th>
</tr>



<?php



$cnx = conectar();

$consulta = "SELECT id,titulo,contenido,imagen FROM noticias  ORDER BY fecha_publicacion DESC ";

$resultado = mysqli_query($cnx,$consulta) or die(mysqli_error($cnx));

if (mysqli_num_rows($resultado) > 0) {
	while (list($id,$titulo,$contenido, $imagen) = mysqli_fetch_array($resultado)) {
		echo "<tr>";
		echo "<td>$id\n</td>";
		echo "<td>$titulo\n</td>";
		echo "<td>$contenido\n</td>";
		echo "<td>$imagen\n</td>";
		echo "<td><a href='clientes_Detalles.php?CodigoCliente=$codigo'><button>VER</button></a>  
		<a href='clientes_Update.php?CodigoCliente=$codigo'><button>Editar</button></a>
		<a href='clientes_Eliminar.php?CodigoCliente=$codigo'><button>Eliminar</button></a>

		   </td> ";
		

}



	} else {
		echo "<h1>ERROR FATAL</h1>";
}
mysqli_free_result($resultado);
mysqli_close($cnx);


  ?>
</table>

</body>
</html>




