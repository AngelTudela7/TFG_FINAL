<?php


function conectar(){
include ('config.php');
$cnx = mysqli_connect($HOST, $USER, $PASSWD, $DATABASE,$PORT);

if (!$cnx){
    echo "Error de conexión: ".mysqli_connect_error();
}

return $cnx;
}


?>
