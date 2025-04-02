// Función para cargar todas las competiciones en el DOM
async function foto_nombre_liga() {
   const div_competiciones = document.querySelector('.competitions');
   if (!div_competiciones) {
      console.error("El contenedor de competiciones no se ha encontrado.");
      return;
   }

   div_competiciones.innerHTML = `<h3 class="text-center mb-4">COMPETICIONES POPULARES</h3>`;
   
   // Petición a la API
   let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
      method: "GET",
      headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
   });

   let data = await response.json();


   const row = document.createElement('div');
   row.classList.add('row', 'g-4'); 

   data.competitions.forEach(competition => {
    
      let col = document.createElement('div');
      col.classList.add('col-4', 'col-sm-4', 'col-md-3', 'col-lg-2'); 

   
      let competicion = document.createElement('div');
      competicion.classList.add('competition', 'd-flex', 'align-items-center', 'justify-content-center', 'flex-column', 'p-3');  
      competicion.setAttribute('id_competi', competition.id);

   
      const imageUrl = competition.emblem ? competition.emblem : 'https://via.placeholder.com/200x200?text=Sin+Imagen';

      
      competicion.innerHTML = `
         <img src="${imageUrl}" class="competition-img" alt="${competition.name}" />
         <h5 class="competition-text">${competition.name.toUpperCase()}</h5>
      `;

      
      col.appendChild(competicion);

     
      row.appendChild(col);
   });

 
   div_competiciones.appendChild(row);
}







// Función para cargar los resultados de una competición buscando sus partidos finalizados
let jornadaData = []; 
let jornadasVisibles = 4; 

async function cargar_resultados(id_competicion) {
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
    resultadosContainer.innerHTML = ''; 

    //Agrupar partidos por jornada
    let jornadas = {}; 
    partidosTerminados.forEach(partido => {
        const jornada = partido.matchday;
        if (!jornadas[jornada]) jornadas[jornada] = [];
        jornadas[jornada].push(partido);
    });

    //Convertir las jornadas en un array de entries para recorrerlo bien
    jornadaData = Object.entries(jornadas); 

    //Límite de jornadas visibles
    jornadasVisibles = 4;

    mostrarJornadas(jornadasVisibles); 
    document.getElementById('boton-cargar').innerHTML = ''; 

    mostrarBotonCargar(); 
}



// Mostrar las jornadas según el número de jornadas visibles
function mostrarJornadas(numJornadas) {
    const resultadosContainer = document.getElementById('resultados');
    resultadosContainer.innerHTML = ''; 

    let jornadaHTML = '';
    for (let i = 0; i < numJornadas && i < jornadaData.length; i++) {
        const [jornada, partidos] = jornadaData[i];
        jornadaHTML += `<div class="jornada">`;
        jornadaHTML += `<h3>Jornada ${jornada}:</h3><div class="fila-partidos">`;
        partidos.forEach(partido => {
            jornadaHTML += `
                <div class="partido">
                    <div class="equipo equipo-home">
                        <img src="${partido.homeTeam.crest}" alt="${partido.homeTeam.name}">
                        <span>${partido.homeTeam.name}</span>
                    </div>
                    <div class="marcador">
                        ${partido.score.fullTime.home} - ${partido.score.fullTime.away}
                    </div>
                    <div class="equipo equipo-away">
                        <img src="${partido.awayTeam.crest}" alt="${partido.awayTeam.name}">
                        <span>${partido.awayTeam.name}</span>
                    </div>
                </div>
            `;
        });
        jornadaHTML += `</div></div>`;
    }

    resultadosContainer.innerHTML = jornadaHTML;
}

// Mostrar el botón de cargar todos
function mostrarBotonCargar() {
    const botonContainer = document.getElementById('boton-cargar');
    if (jornadaData.length > jornadasVisibles) {
        botonContainer.innerHTML = `<button id="cargar-todos" class="btn-cargar">Cargar todos</button>`;
        document.getElementById('cargar-todos').addEventListener('click', cargarTodos);
    }
}

// Función para cargar todas las jornadas
function cargarTodos() {
    jornadasVisibles = jornadaData.length; 
    mostrarJornadas(jornadasVisibles); 
    document.getElementById('boton-cargar').innerHTML = ''; 
}




// Función para cargar en el DOM la clasifcación de una competición
async function cargar_clasificacion(id_competicion) {
   try {
      const url = `https://api.football-data.org/v4/competitions/${id_competicion}/standings`;
      const response = await fetch(url, {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });

      if (!response.ok) {
         console.error("Error al cargar la clasificación");
         return;
      }

      const dataClasificacion = await response.json();
      const clasificacionContainer = document.getElementById('clasificacion');
      clasificacionContainer.innerHTML = ''; 

      
      let tablaHTML = `
         <div class="table-responsive text-center">
            <table class="table table-striped table-hover clasificacion-tabla">
               <thead class="thead-dark">
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

     
      dataClasificacion.standings.forEach(group => {
         group.table.forEach(team => {
            tablaHTML += `
               <tr>
                  <td style= "color:white">${team.position}</td>
                  <td>
                     <div class="equipo-info">
                        <img src="${team.team.crest}" alt="Escudo de ${team.team.name}" class="team-crest" />
                        <span class="team-name">${team.team.name}</span>
                     </div>
                  </td>
                  <td style= "color:white">${team.playedGames}</td>
                  <td style= "color:white">${team.won}</td>
                  <td style= "color:white">${team.draw}</td>
                  <td style= "color:white">${team.lost}</td>
                  <td style= "color:white">${team.goalDifference}</td>
                  <td style= "color:white">${team.points}</td>
               </tr>
            `;
         });
      });

     
      tablaHTML += `
            </tbody>
         </table>
      </div>
      `;

      
      clasificacionContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error("Error al cargar la clasificación:", error);
      const clasificacionContainer = document.getElementById('clasificacion');
      clasificacionContainer.innerHTML = `<p class="text-danger">Error al cargar la clasificación. Por favor, inténtalo más tarde.</p>`;
   }
}


// Función para cargar en el DOM la tabla de goleadore de una competición

async function cargar_goleadores(id_competicion) {
   try {
      const url = `https://api.football-data.org/v4/competitions/${id_competicion}/scorers`;
      const response = await fetch(url, {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });

      if (!response.ok) {
         console.error("Error al cargar los goleadores");
         return;
      }

      const dataGoleadores = await response.json();
      const goleadoresContainer = document.getElementById('goleadores');
      goleadoresContainer.innerHTML = ''; 

      
      let tablaHTML = `
         <div class="container-md mt-4">
            <div class="table-responsive">
               <table class="table table-striped table-hover clasificacion-tabla text-center">
                  <thead class="thead-dark">
                     <tr>
                        <th>#</th>
                        <th>Jugador</th>
                        <th>Equipo</th>
                        <th>Goles</th>
                        <th>Asistencias</th>
                     </tr>
                  </thead>
                  <tbody>
      `;

      
      dataGoleadores.scorers.forEach((jugador, index) => {
         tablaHTML += `
            <tr>
               <td style= "color:white">${index + 1}</td>
               <td>
                  <div class="d-flex align-items-center">
                     <img src="${jugador.team.crest}" alt="Escudo de ${jugador.team.name}" class="team-crest me-2"/>
                     <span class="team-name">${jugador.player.name}</span>
                  </div>
               </td>
               <td style= "color:white">${jugador.team.name}</td>
               <td style= "color:white">${jugador.goals}</td>
               <td style= "color:white">${jugador.assists ?? 0}</td>
            </tr>
         `;
      });

     
      tablaHTML += `
                  </tbody>
               </table>
            </div>
         </div>
      `;

      
      goleadoresContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error("Error al cargar los goleadores:", error);
      const goleadoresContainer = document.getElementById('goleadores');
      goleadoresContainer.innerHTML = `<p class="text-danger text-center">Error al cargar los goleadores. Por favor, inténtalo más tarde.</p>`;
   }
}





// Función para manejar el evento de click en las competiciones y cargar los datos correspondientes
function configurarClickCompetitions() {
   const container = document.querySelector('.competitions');
   if (!container) {
      console.error("El contenedor de competiciones no se encontró.");
      return;
   }

   container.addEventListener('click', (event) => {
      if (event.target.closest('.competition')) {
         let id_competicion_clicada = event.target.closest('.competition').getAttribute('id_competi');
         cargar_resultados(id_competicion_clicada);  
         cargar_clasificacion(id_competicion_clicada); 
         cargar_goleadores(id_competicion_clicada)
         document.getElementById('resultados-tab').style.display = 'block';
         document.getElementById('clasificacion-tab').style.display = 'block';
         document.getElementById('goleadores-tab').style.display = 'block';
         document.getElementById('limpiar-tab').style.display = 'block';
      }
   });
}


// Función para manejar la navegación con los botones
function configurarNavegacionTabs() {
   document.getElementById('resultados-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'flex';
      document.getElementById('resultados').style.height = 'auto';
      document.getElementById('boton-cargar').style.display = 'block'; 

      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('goleadores').style.display = 'none';
   });

   document.getElementById('clasificacion-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('boton-cargar').style.display = 'none'; 
      document.getElementById('clasificacion').style.display = 'block';
      document.getElementById('goleadores').style.display = 'none';
   });

   document.getElementById('goleadores-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('boton-cargar').style.display = 'none'; 
      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('goleadores').style.display = 'block';
   });

   document.getElementById('limpiar-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('boton-cargar').style.display = 'none'; 
      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('goleadores').style.display = 'none';
   });
}



// Esperar a que el DOM esté cargado para ejecutar las funciones
document.addEventListener("DOMContentLoaded", async function () {
   await foto_nombre_liga();
   await configurarClickCompetitions();
   await configurarNavegacionTabs();  
});
