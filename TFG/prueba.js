async function foto_nombre_liga() {
   const div_competiciones = document.getElementById('contenedor-competiciones');
   if (!div_competiciones) {
      console.error("El contenedor de competiciones no se ha encontrado.");
      return;
   }

   try {
      let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });

      let data = await response.json();

      div_competiciones.innerHTML = `
         <div class="text-center text-white mb-4">
            <h3>COMPETICIONES POPULARES</h3>
         </div>
         <div class="d-flex flex-wrap justify-content-center gap-3" id="competitions-row"></div>
      `;

      const row = document.getElementById('competitions-row');

      data.competitions.forEach(competition => {
         let card = document.createElement('div');
         card.classList.add('d-flex', 'align-items-center', 'bg-secondary', 'text-white', 'p-2', 'rounded', 'shadow-sm');
         card.style.width = '200px';   // Controlas el largo
         card.style.height = '60px';   // Controlas el alto

         card.setAttribute('id_competi', competition.id);

         // Añadir efecto hover
         card.onmouseover = function () {
            card.style.transform = 'translateY(-5px)';
            card.style.backgroundColor = '#444';
            card.style.transition = 'transform 0.3s, background-color 0.3s';
            card.style.cursor = 'pointer';
         };

         card.onmouseout = function () {
            card.style.transform = 'translateY(0)';
            card.style.backgroundColor = 'rgb(108, 117, 125)'; // Color secundario por defecto
         };

         card.innerHTML = `
            <img src="${competition.emblem}" alt="${competition.id}" style="height: 40px; width: 40px; object-fit: contain; margin-right: 10px;">
            <span style="font-size: 14px; font-weight: bold;">${competition.name.toUpperCase()}</span>
         `;

         row.appendChild(card);
      });

   } catch (error) {
      console.error("Error al obtener datos:", error);
   }
   setupClickListeners();
}


let jornadaData = []; // Variable global para almacenar todas las jornadas
let jornadasVisibles = 4; // Inicialmente solo mostraremos 4 jornadas

// Agregar event listener a las tarjetas







let isLoading = false;
async function cargar_resultados(id_competicion) {

   if (isLoading) return; // Prevenir sobrecarga
   isLoading = true;

   const url = `https://api.football-data.org/v4/competitions/${id_competicion}/matches?status=FINISHED&limit=50`;
   const response = await fetch(url, {
      method: "GET",
      headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
   });

   if (!response.ok) {
      console.error("Error al obtener los datos de los partidos");
      return;
   }

   const dataPartidos = await response.json();
   const partidosTerminados = dataPartidos.matches.filter(partido => partido.status === 'FINISHED');

   const resultadosContainer = document.getElementById('resultados');
   resultadosContainer.innerHTML = ''; // Limpiar resultados anteriores

   let jornadas = {}; // Agrupar partidos por jornada
   partidosTerminados.forEach(partido => {
      const jornada = partido.matchday;
      if (!jornadas[jornada]) jornadas[jornada] = [];
      jornadas[jornada].push(partido);
   });

   jornadaData = Object.entries(jornadas).sort((a, b) => a[0] - b[0]);
   isLoading = false;
   mostrar_jornadas();
}

function mostrar_jornadas() {
   const resultadosContainer = document.getElementById('resultados');
   resultadosContainer.innerHTML = ''; // Limpiar resultados anteriores
   resultadosContainer.style.display = 'block';
   const jornadasAMostrar = jornadaData.slice(0, jornadasVisibles);
 
   jornadasAMostrar.forEach(([jornada, partidos]) => {
     // Crear título de jornada
     const jornadaDiv = document.createElement('div');
     jornadaDiv.classList.add('mb-4');
 
     const jornadaTitulo = document.createElement('h3');
     jornadaTitulo.classList.add('text-warning');
     jornadaTitulo.innerText = `Jornada ${jornada}`;
 
     jornadaDiv.appendChild(jornadaTitulo);
 
     // Crear contenedor para los partidos
     const filaPartidos = document.createElement('div');
     filaPartidos.classList.add('d-flex', 'flex-wrap', 'gap-3', 'justify-content-start');
 
     partidos.forEach(partido => {
       const partidoDiv = document.createElement('div');
       partidoDiv.classList.add('partido', 'card', 'bg-dark', 'text-white', 'p-3', 'rounded', 'shadow-sm', 'd-flex', 'flex-column', 'align-items-center', 'text-center');
       
       partidoDiv.style.width = '9.5%';  // Ajustamos para que haya 10 cards por fila (9.5% de ancho)
       partidoDiv.style.minWidth = '130px';  // Ancho mínimo para las cards
       partidoDiv.style.maxWidth = '150px';  // Ancho máximo para las cards

       // Crear equipos
       const equipoLocal = document.createElement('div');
       equipoLocal.classList.add('equipo', 'd-flex', 'flex-column', 'align-items-center');
       equipoLocal.innerHTML = `
         <img src="${partido.homeTeam.crest}" alt="${partido.homeTeam.name}" class="img-fluid mb-2" style="width: 35px; height: 35px; border-radius: 50%;"> <!-- Disminuimos el tamaño de la imagen -->
         <span style="font-size: 14px; font-weight: bold; text-align: center;">${partido.homeTeam.name}</span> <!-- Reducimos el tamaño del texto -->
       `;
       
       const equipoVisitante = document.createElement('div');
       equipoVisitante.classList.add('equipo', 'd-flex', 'flex-column', 'align-items-center');
       equipoVisitante.innerHTML = `
         <img src="${partido.awayTeam.crest}" alt="${partido.awayTeam.name}" class="img-fluid mb-2" style="width: 35px; height: 35px; border-radius: 50%;"> <!-- Disminuimos el tamaño de la imagen -->
         <span style="font-size: 14px; font-weight: bold; text-align: center;">${partido.awayTeam.name}</span> <!-- Reducimos el tamaño del texto -->
       `;
 
       // Crear marcador
       const marcador = document.createElement('div');
       marcador.classList.add('marcador', 'text-warning', 'mb-2');
       marcador.innerText = `${partido.score.fullTime.home} - ${partido.score.fullTime.away}`;
       marcador.style.fontSize = '16px';  // Reducimos el tamaño del marcador para hacerlo más equilibrado
 
       // Añadir todo al contenedor del partido
       partidoDiv.appendChild(equipoLocal);
       partidoDiv.appendChild(marcador);
       partidoDiv.appendChild(equipoVisitante);
 
       filaPartidos.appendChild(partidoDiv);
     });
 
     jornadaDiv.appendChild(filaPartidos);
     resultadosContainer.appendChild(jornadaDiv);
   });
 
   // Botón de cargar más si hay más jornadas
   if (jornadaData.length > jornadasVisibles) {
     const botonCargarMas = document.createElement('button');
     botonCargarMas.textContent = 'Cargar más';
     botonCargarMas.classList.add('btn', 'btn-warning', 'mt-3', 'd-block', 'mx-auto');  // 'btn-warning' para dorado, 'd-block mx-auto' para centrar
     botonCargarMas.onclick = () => {
       jornadasVisibles += 4;
       mostrar_jornadas();
     };
     resultadosContainer.appendChild(botonCargarMas);
   }
}


async function cargar_clasificacion(id_competicion) {

   if (isLoading) return; // Prevenir sobrecarga
   isLoading = true;

   const clasificacionContainer = document.getElementById('clasificacion');
   if (!clasificacionContainer) {
      console.error('Contenedor de clasificación no encontrado');
      return;
   }

   clasificacionContainer.innerHTML = `
      <div class="text-center py-4">
         <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Cargando...</span>
         </div>
      </div>
   `;

   try {
      const url = `https://api.football-data.org/v4/competitions/${id_competicion}/standings`;
      console.log('Solicitando datos a la API:', url);  // Depuración
      const response = await fetch(url, {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });

      if (!response.ok) {
         console.error('Error de red o la API:', response.status, response.statusText);
         throw new Error("Error al cargar la clasificación");
      }

      const dataClasificacion = await response.json();
      console.log('Datos recibidos:', dataClasificacion);  // Depuración

      if (!dataClasificacion.standings || dataClasificacion.standings.length === 0) {
         clasificacionContainer.innerHTML = '<p class="text-danger">No hay datos de clasificación disponibles.</p>';
         return;
      }

      // Crear una tabla responsiva con Bootstrap
      let tablaHTML = `
         <div class="table-responsive">
            <table class="table table-striped table-hover table-dark">
               <thead class="table-warning">
                  <tr>
                     <th>#</th>
                     <th>Equipo</th>
                     <th>Jugados</th>
                     <th>Ganados</th>
                     <th>Empatados</th>
                     <th>Perdidos</th>
                     <th>Diferencia de Goles</th>
                     <th>Puntos</th>
                  </tr>
               </thead>
               <tbody>
      `;

      // Recorrer los standings (tabla de clasificación)
      dataClasificacion.standings.forEach(group => {
         group.table.forEach(team => {
            tablaHTML += `
               <tr>
                  <td>${team.position}</td>
                  <td>
                     <img src="${team.team.crest}" alt="Escudo de ${team.team.name}" class="img-fluid" style="height: 30px; width: 30px; margin-right: 10px;" />
                     ${team.team.name}
                  </td>
                  <td>${team.playedGames}</td>
                  <td>${team.won}</td>
                  <td>${team.draw}</td>
                  <td>${team.lost}</td>
                  <td>${team.goalDifference}</td>
                  <td>${team.points}</td>
               </tr>
            `;
         });
      });

      // Cerrar la tabla
      tablaHTML += `
               </tbody>
            </table>
         </div>
      `;

      clasificacionContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error('Error al cargar la clasificación:', error);
      clasificacionContainer.innerHTML = `<p class="text-danger">Error al cargar la clasificación. Detalles: ${error.message}</p>`;
   }
   isLoading = false;
}


function configurarNavegacionTabs() {

  
   document.getElementById('boton-resultados').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'block';
      
      document.getElementById('clasificacion').style.display = 'none';
      

      if (document.getElementById('resultados').style.display === 'block') {
         document.getElementById('clasificacion').style.display = 'none';
      }

   });
   document.getElementById('boton-clasificacion').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'none';
      
      document.getElementById('clasificacion').style.display = 'block';
      
   });

   document.getElementById('boton-limpiar').addEventListener('click' , () => {

      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('resultados').style.display = 'none';
     
      
   });



}


function setupClickListeners() {
   document.querySelectorAll('[id_competi]').forEach(card => {
      card.removeEventListener('click', handleCardClick);
      card.addEventListener('click', handleCardClick);
   });
}

function handleCardClick(event) {
   const idCompeticion = event.currentTarget.getAttribute('id_competi');
   console.log(`Has seleccionado la competición ${idCompeticion}`);

   // Ocultar todas las secciones
   document.getElementById('resultados').style.display = 'none';
   document.getElementById('clasificacion').style.display = 'none';

   // Cargar los nuevos resultados y clasificación de la competición
   cargar_resultados(idCompeticion);
   cargar_clasificacion(idCompeticion);

   // Asegúrate de que la nueva clasificación se muestra
   document.getElementById('clasificacion').style.display = 'block';
}

document.addEventListener("DOMContentLoaded", async function () {
   await foto_nombre_liga();
  await configurarNavegacionTabs()
   await setupClickListeners();
});











































