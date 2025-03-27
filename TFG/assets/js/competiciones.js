// Lógica para el menú hamburguesa
const hamburgerMenu = document.getElementById('hamburger-menu');
const mobileMenu = document.getElementById('mobile-menu');

hamburgerMenu.addEventListener('click', () => {
   hamburgerMenu.classList.toggle('active');
   mobileMenu.classList.toggle('active');
});

//----------------------------------------------------------
// Cargar las competiciones en el menú
async function foto_nombre_liga() {
   const div_competiciones = document.querySelector('.competitions');
   if (!div_competiciones) {
      console.error("El contenedor de competiciones no se ha encontrado.");
      return;
   }

   let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
      method: "GET",
      headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
   });

   let data = await response.json();
   div_competiciones.innerHTML = `<h3>COMPETICIONES POPULARES</h3>`;
   data.competitions.forEach(competition => {
      let competicion = document.createElement('div');
      competicion.classList.add('competition');
      competicion.setAttribute('id_competi', competition.id);
      competicion.innerHTML = `<img src="${competition.emblem}" alt="${competition.id}" /><h5>${competition.name.toUpperCase()}</h5>`;
      div_competiciones.appendChild(competicion);
   });
}

//----------------------------------------------------------
// Función para cargar los resultados de una competición (partidos finalizados)
let jornadaData = []; // Variable global para almacenar todas las jornadas
let jornadasVisibles = 4; // Inicialmente solo mostraremos 4 jornadas

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
    resultadosContainer.innerHTML = ''; // Limpiar resultados anteriores

    let jornadas = {}; // Agrupar partidos por jornada
    partidosTerminados.forEach(partido => {
        const jornada = partido.matchday;
        if (!jornadas[jornada]) jornadas[jornada] = [];
        jornadas[jornada].push(partido);
    });

    jornadaData = Object.entries(jornadas); // Convertimos las jornadas a un array de entradas

    jornadasVisibles = 4; // Restablecemos a 4 jornadas al cambiar de competición

    mostrarJornadas(jornadasVisibles); // Mostrar las primeras 4 jornadas
    document.getElementById('boton-cargar').innerHTML = ''; // Eliminar el botón al cambiar de competición

    mostrarBotonCargar(); // Mostrar el botón "Cargar todos"
}

// Mostrar las jornadas según el número de jornadas visibles
function mostrarJornadas(numJornadas) {
    const resultadosContainer = document.getElementById('resultados');
    resultadosContainer.innerHTML = ''; // Limpiar resultados anteriores

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
    jornadasVisibles = jornadaData.length; // Mostrar todas las jornadas
    mostrarJornadas(jornadasVisibles); // Volver a mostrar todas las jornadas
    document.getElementById('boton-cargar').innerHTML = ''; // Eliminar el botón de cargar todos
}

// Mostrar las jornadas según el número de jornadas visibles
function mostrarJornadas(numJornadas) {
    const resultadosContainer = document.getElementById('resultados');
    resultadosContainer.innerHTML = ''; // Limpiar resultados anteriores

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
    jornadasVisibles = jornadaData.length; // Mostrar todas las jornadas
    mostrarJornadas(jornadasVisibles); // Volver a mostrar todas las jornadas
    document.getElementById('boton-cargar').innerHTML = ''; // Eliminar el botón de cargar todos
}




// Función para cargar todas las jornadas de la competición
async function cargar_partidos(id_competicion) {
   try {
      const url = `https://api.football-data.org/v4/competitions/${id_competicion}/matches`;
      let response = await fetch(url, {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });
      let dataPartidos = await response.json();

      // Agrupar los partidos por jornada (matchday)
      const partidosPorJornada = {};
      dataPartidos.matches.forEach(partido => {
         const jornada = partido.matchday;
         if (!partidosPorJornada[jornada]) {
            partidosPorJornada[jornada] = [];
         }
         partidosPorJornada[jornada].push(partido);
      });

      const partidosContainer = document.getElementById('partidos');
      partidosContainer.innerHTML = ''; // Limpiar contenido anterior

      // Generar el HTML para cada jornada
      for (const jornada in partidosPorJornada) {
         let jornadaHTML = `<h3>Jornada ${jornada}:</h3><div class="jornada">`; // Contenedor para los partidos de esta jornada
         partidosPorJornada[jornada].forEach(partido => {
            jornadaHTML += `
   <div class="jornada">
      <h3>Jornada ${jornada}:</h3>
      <div class="grid-partidos">
         ${jornadas[jornada].map(partido => `
            <div class="partido">
               <div class="equipo">
                  <img src="${partido.homeTeam.crest}" alt="${partido.homeTeam.name}">
                  <span>${partido.homeTeam.name}</span>
               </div>
               <div class="marcador">${partido.score.fullTime.home} - ${partido.score.fullTime.away}</div>
               <div class="equipo">
                  <img src="${partido.awayTeam.crest}" alt="${partido.awayTeam.name}">
                  <span>${partido.awayTeam.name}</span>
               </div>
            </div>
         `).join('')}
      </div>
   </div>
`;
         });
         jornadaHTML += `</div>`; // Cerrar el contenedor de la jornada
         partidosContainer.innerHTML += jornadaHTML; // Añadir al contenedor principal
      }
   } catch (error) {
      console.error("Error al cargar los partidos:", error);
      const partidosContainer = document.getElementById('partidos');
      partidosContainer.innerHTML = `<p>Error al cargar los partidos. Por favor, inténtalo más tarde.</p>`;
   }
}

//----------------------------------------------------------
// Función para cargar la clasificación de la competición
// Función para cargar la clasificación de la competición
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
      clasificacionContainer.innerHTML = ''; // Limpiar contenido anterior

      // Crear una tabla para mostrar los datos
      let tablaHTML = `
         <table class="clasificacion-tabla">
            <thead>
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
                     <img src="${team.team.crest}" alt="Escudo de ${team.team.name}" class="team-crest" />
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
      `;

      // Insertar la tabla en el contenedor
      clasificacionContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error("Error al cargar la clasificación:", error);
      const clasificacionContainer = document.getElementById('clasificacion');
      clasificacionContainer.innerHTML = `<p>Error al cargar la clasificación. Por favor, inténtalo más tarde.</p>`;
   }
}


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
      goleadoresContainer.innerHTML = ''; // Limpiar contenido anterior

      // Crear una tabla para mostrar los datos
      let tablaHTML = `
         <table class="goleadores-tabla">
            <thead>
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

      // Recorrer los goleadores y agregar filas a la tabla
      dataGoleadores.scorers.forEach((jugador, index) => {
         tablaHTML += `
            <tr>
               <td>${index + 1}</td>
               <td>${jugador.player.name}</td>
               <td>
                  <img src="${jugador.team.crest}" alt="Escudo de ${jugador.team.name}" class="team-crest" />
                  ${jugador.team.name}
               </td>
               <td>${jugador.goals}</td>
               <td>${jugador.assists ?? 0}</td>
            </tr>
         `;
      });

      // Cerrar la tabla
      tablaHTML += `
            </tbody>
         </table>
      `;

      // Insertar la tabla en el contenedor
      goleadoresContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error("Error al cargar los goleadores:", error);
      const goleadoresContainer = document.getElementById('goleadores');
      goleadoresContainer.innerHTML = `<p>Error al cargar los goleadores. Por favor, inténtalo más tarde.</p>`;
      document.getElementById('cargar-todos').style.display = 'none';
   }
}



//----------------------------------------------------------
// Función para manejar el clic en las competiciones y cargar los datos correspondientes
function configurarClickCompetitions() {
   const container = document.querySelector('.competitions');
   if (!container) {
      console.error("El contenedor de competiciones no se encontró.");
      return;
   }

   container.addEventListener('click', (event) => {
      if (event.target.closest('.competition')) {
         let id_competicion_clicada = event.target.closest('.competition').getAttribute('id_competi');
        
         cargar_resultados(id_competicion_clicada);  // Cargar resultados
         cargar_clasificacion(id_competicion_clicada); // Cargar clasificación
         cargar_goleadores(id_competicion_clicada)
      }
   });
}

//----------------------------------------------------------
// Función para manejar la navegación entre las pestañas
function configurarNavegacionTabs() {

  
   document.getElementById('resultados-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'block';
      document.getElementById('cargar-todos').style.display = 'block';
      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('goleadores').style.display = 'none';

      
      if (document.getElementById('resultados').style.display = 'block') {
         document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('goleadores').style.display = 'none';
         
      }

   });
   document.getElementById('clasificacion-tab').addEventListener('click', () => {
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('cargar-todos').style.display = 'none';
      document.getElementById('clasificacion').style.display = 'block';
      document.getElementById('goleadores').style.display = 'none';
   });

   document.getElementById('limpiar-tab').addEventListener('click' , () => {

      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('cargar-todos').style.display = 'none';
      document.getElementById('goleadores').style.display = 'none';
   });

   document.getElementById('goleadores-tab').addEventListener('click' , () => {

      document.getElementById('clasificacion').style.display = 'none';
      document.getElementById('resultados').style.display = 'none';
      document.getElementById('cargar-todos').style.display = 'none';
      document.getElementById('goleadores').style.display = 'block';
   });

}

//----------------------------------------------------------
// Esperar a que el DOM esté cargado para ejecutar el código
document.addEventListener("DOMContentLoaded", async function () {
   await foto_nombre_liga();
   await configurarClickCompetitions();
   await configurarNavegacionTabs();  // Configuración de las pestañas para cambiar de sección
});
