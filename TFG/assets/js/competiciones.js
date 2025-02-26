
const hamburgerMenu = document.getElementById('hamburger-menu');
const mobileMenu = document.getElementById('mobile-menu');

hamburgerMenu.addEventListener('click', () => {
   hamburgerMenu.classList.toggle('active');
   mobileMenu.classList.toggle('active');
});


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

    let jornadas = {}; 
    partidosTerminados.forEach(partido => {
        const jornada = partido.matchday;
        if (!jornadas[jornada]) jornadas[jornada] = [];
        jornadas[jornada].push(partido);
    });

    jornadaData = Object.entries(jornadas); 

    jornadasVisibles = 4; 

    mostrarJornadas(jornadasVisibles); 
    document.getElementById('boton-cargar').innerHTML = '';

    mostrarBotonCargar();
}


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


function mostrarBotonCargar() {
    const botonContainer = document.getElementById('boton-cargar');
    if (jornadaData.length > jornadasVisibles) {
        botonContainer.innerHTML = `<button id="cargar-todos" class="btn-cargar">Cargar todos</button>`;
        document.getElementById('cargar-todos').addEventListener('click', cargarTodos);
    }
}


function cargarTodos() {
    jornadasVisibles = jornadaData.length; 
    mostrarJornadas(jornadasVisibles); 
    document.getElementById('boton-cargar').innerHTML = ''; 
}


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


function mostrarBotonCargar() {
    const botonContainer = document.getElementById('boton-cargar');
    if (jornadaData.length > jornadasVisibles) {
        botonContainer.innerHTML = `<button id="cargar-todos" class="btn-cargar">Cargar todos</button>`;
        document.getElementById('cargar-todos').addEventListener('click', cargarTodos);
    }
}


function cargarTodos() {
    jornadasVisibles = jornadaData.length; 
    mostrarJornadas(jornadasVisibles); 
    document.getElementById('boton-cargar').innerHTML = ''; 
}





async function cargar_partidos(id_competicion) {
   try {
      const url = `https://api.football-data.org/v4/competitions/${id_competicion}/matches`;
      let response = await fetch(url, {
         method: "GET",
         headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
      });
      let dataPartidos = await response.json();

      
      const partidosPorJornada = {};
      dataPartidos.matches.forEach(partido => {
         const jornada = partido.matchday;
         if (!partidosPorJornada[jornada]) {
            partidosPorJornada[jornada] = [];
         }
         partidosPorJornada[jornada].push(partido);
      });

      const partidosContainer = document.getElementById('partidos');
      partidosContainer.innerHTML = ''; 

      
      for (const jornada in partidosPorJornada) {
         let jornadaHTML = `<h3>Jornada ${jornada}:</h3><div class="jornada">`;
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
         jornadaHTML += `</div>`; 
         partidosContainer.innerHTML += jornadaHTML; 
      }
   } catch (error) {
      console.error("Error al cargar los partidos:", error);
      const partidosContainer = document.getElementById('partidos');
      partidosContainer.innerHTML = `<p>Error al cargar los partidos. Por favor, inténtalo más tarde.</p>`;
   }
}


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

      
      tablaHTML += `
            </tbody>
         </table>
      `;

     
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
      goleadoresContainer.innerHTML = ''; 

     
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

      tablaHTML += `
            </tbody>
         </table>
      `;

     
      goleadoresContainer.innerHTML = tablaHTML;
   } catch (error) {
      console.error("Error al cargar los goleadores:", error);
      const goleadoresContainer = document.getElementById('goleadores');
      goleadoresContainer.innerHTML = `<p>Error al cargar los goleadores. Por favor, inténtalo más tarde.</p>`;
      document.getElementById('cargar-todos').style.display = 'none';
   }
}





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
      }
   });
}

//----------------------------------------------------------

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

document.addEventListener("DOMContentLoaded", async function () {
   await foto_nombre_liga();
   await configurarClickCompetitions();
   await configurarNavegacionTabs(); 
});
