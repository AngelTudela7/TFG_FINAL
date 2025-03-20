<?php


function conectar(){
include ('config.php');
$cnx = mysqli_connect($HOST, $USER, $PASSWD, $DATABASE,$PORT);

if (!$cnx){
    echo "Error de conexión: ".mysqli_connect_error();
}

return $cnx;
}





function permiso($rol, $archivo) {
    $cnx = conectar();

    // Asegurarse de que el rol es un número válido
    if (!is_numeric($rol)) {
        
        return false;
    }

    // Consulta SQL para verificar permisos
    $sql = "SELECT * FROM rolespermisos rp 
            INNER JOIN permisos pe ON rp.permiso_id = pe.id 
            WHERE rp.rol_id = '$rol' AND pe.nombre = '$archivo'";

   

    $res = mysqli_query($cnx, $sql);

    if (!$res) {
        die("<pre>❌ Error en la consulta: " . mysqli_error($cnx) . "</pre>");
    }

    $num_rows = mysqli_num_rows($res);
   

    return $num_rows > 0;
}

// Verificar permisos antes de acceder a la página
if ((basename($_SERVER['PHP_SELF']) != 'login.php') && 
    (!permiso($_SESSION['rol_id'], basename($_SERVER['PHP_SELF'])))) {
    
        die('
        <div style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f8d7da; color: #721c24; font-family: Arial, sans-serif;">
            <div style="text-align: center; border: 2px solid #f5c6cb; padding: 20px; border-radius: 10px; background-color: white; box-shadow: 3px 3px 10px rgba(0,0,0,0.1);">
                <h2 style="margin-bottom: 10px;">⛔ Acceso Denegado</h2>
                <p style="margin-bottom: 10px;">No tienes permisos para acceder a esta dirección.</p>
            </div>
        </div>
    ');
} else {
   
}
?>
