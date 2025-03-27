<?php
include('includes/config.php');
include('includes/database.php');
?>


<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Tourney:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
    <style>
      body {
        background-color: #181414;
        font-family: "Tourney", sans-serif;
      }

      



    </style>
  </head>
  <body>
    
 

    <!-- Competiciones Populares -->
    <div id="contenedor-competiciones" class="container-fluid  bg-dark text-white py-4 mt-5">
    </div>

    <!-- Botones de navegacion -->

    <div class="container mt-5">
    <div class="row justify-content-center">
        <!-- Primer botón -->
        <div class="col-auto mb-3">
            <button class="btn btn-warning btn-lg shadow-sm" style="width: 200px;" id="boton-resultados">Resultados</button>
        </div>

        <!-- Segundo botón -->
        <div class="col-auto mb-3">
            <button class="btn btn-warning btn-lg shadow-sm" style="width: 200px;" id="boton-clasificacion">Clasifiación</button>
        </div>

        <!-- Tercer botón -->
        <div class="col-auto mb-3">
            <button class="btn btn-warning btn-lg shadow-sm" style="width: 220px;">Tabla Goleadores</button>
        </div>

        <!-- Cuarto botón -->
        <div class="col-auto mb-3">
            <button class="btn btn-warning btn-lg shadow-sm" style="width: 200px;" id="boton-limpiar">Botón 4</button>
        </div>
    </div>
</div>


    <!-- Contenedores partidos, clasificación y tabla -->
    <div class="content ">

        <div id="resultados" class="container py-4" style="background-color: #181414; color: white; display: none;">
            <div id="resultados-jornadas"></div>
        </div>

        <div id="clasificacion" style="display:none;">
        </div>

        <div id="goleadores"  style="display: none;">
        </div>
    </div>
    <!-- Botón de cargar más -->

    <script src="prueba.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>