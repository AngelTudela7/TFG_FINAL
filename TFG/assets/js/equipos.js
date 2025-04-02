// Recuperar elementos del DOM
const selectCompeticion = document.getElementById("select-competicion");
const selectEquipo = document.getElementById("select-equipo");

async function cargar_competiciones() {

    // Manipular el DOM
    selectCompeticion.innerHTML = `<option value="" disabled selected>Selecciona una competición</option>`;
    
    // Petición a la API
    let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();

    // Manipular el DOM
    data.competitions.forEach(competition => {
        selectCompeticion.innerHTML += `<option value="${competition.id}">${competition.name}</option>`;
    });

    //Gestionar los eventos en el elemento <select> para evitar que se acumulen múltiples eventListener cad vez que se ejecuta la función
    selectCompeticion.removeEventListener("change", configurarCambioCompeti);
    selectCompeticion.addEventListener("change", configurarCambioCompeti);
}

// Función para manejar el cambio de competición en el select
function configurarCambioCompeti() {
    // Cada vez que se cambia de competición en el select, se recoge la nueva id y se ejecuta la función para recuperar sus datos
    let id_competicion = selectCompeticion.value;
    cargar_equipos(id_competicion);
}

// Función para recuperar los equipos de cada competición y mostrarlos en el elemento "<select>"
async function cargar_equipos(id_competicion) {

    // Manipular el DOM
    selectEquipo.innerHTML = "<option value='' disabled selected>Selecciona un equipo</option>";

    // Petición a la API 
    let response = await fetch(`https://api.football-data.org/v4/competitions/${id_competicion}/teams`, {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();

    // Manipular el DOM
    data.teams.forEach(equipo => {
        selectEquipo.innerHTML += `<option value="${equipo.id}">${equipo.name}</option>`;
    });

    //Gestionar los eventos en el elemento <select> para evitar que se acumulen múltiples eventListener cad vez que se ejecuta la función
    selectEquipo.removeEventListener("change", configurarCambioEquipo);
    selectEquipo.addEventListener("change", configurarCambioEquipo);
}

// Función para manejar el cambio de equipo en el select
function configurarCambioEquipo() {
    // Cada vez que se cambia de equipo en el select, se recoge la nueva id y también la de la competición,después se ejecuta la función para recuperar sus datos
    let id_equipo = selectEquipo.value;
    let id_competicion = selectCompeticion.value;
    cargar_datos_equipo(id_equipo, id_competicion);
}

// Función para cargar los datos de un equipo
async function cargar_datos_equipo(id_equipo, id_competicion) {
    // Cargar funciones 
    let jugadores = await recuperar_jugadores(id_equipo);
    mostrar_plantilla(jugadores);
    ultimos_5_partidos(id_competicion, id_equipo);
    proximos_partidos_equipo(id_equipo);
  
    // Mostrar las secciones de partidos
    document.getElementById("contenedor-last-partidos").style.display = "block";
    document.getElementById("contenedor-proximos-partidos").style.display = "block";
}

// Recuperar los jugadores de un equipo y mostrar la plantilla 
async function recuperar_jugadores(id_equipo) {
    try {
       
        // Consulta a la API
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });
        let data = await response.json();
        return data.squad;
    } catch (error) {
        console.error("Error al recuperar jugadores:", error);
        return [];
    }
}

// Mostrar la plantilla del equipo
function mostrar_plantilla(jugadores) {
    
    // Manipular el DOM
    let contenedor = document.getElementById("contenedor-plantilla");
    contenedor.innerHTML = "<h3>Plantilla de Jugadores</h3>";

    if (jugadores.length === 0) {
        contenedor.innerHTML += "<p>No hay jugadores disponibles.</p>";
        return;
    }

    let plantillaHTML = "<table class='table table-dark table-striped'>";
    plantillaHTML += "<thead><tr><th>Nombre</th><th>Nacionalidad</th><th>Posición</th></tr></thead><tbody>";
    
    // Recorrer los jugadores e ir añadiendo sus datos a la tabla
    jugadores.forEach(jugador => {
        plantillaHTML += `<tr><td>${jugador.name}</td><td>${jugador.nationality}</td><td>${jugador.position}</td></tr>`;
    });
    plantillaHTML += "</tbody></table>";
    // Añadir tabla al DOM
    contenedor.innerHTML += plantillaHTML;
}

// Función para mostrar los últimos 5 partidos que ha jugado el equipo seleccionado
async function ultimos_5_partidos(id_competicion, id_equipo) {
    let contenedor = document.getElementById("ultimo-partido");
    contenedor.innerHTML = ""; // Limpiar el contenedor antes de agregar partidos de otro equipo

    try {
        // Consulta a la API
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}/matches?status=FINISHED&competitions=${id_competicion}&limit=5`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });
        let data = await response.json();

        // Ordenar partidos de más reciente a más antiguo con la función sort y convirtiendo las fechas para poder compararlas
        data.matches.sort((a, b) => new Date(b.utcDate) - new Date(a.utcDate));

        // Añadir contenido al DOM
        data.matches.forEach(partido => {
            contenedor.innerHTML += `
            <div class="card-partido">
                <div class="card-header">
                    <div class="equipo-local">
                        <img src="https://crests.football-data.org/${partido.homeTeam.id}.png" alt="${partido.homeTeam.name}">
                        <span class="equipo-nombre">${partido.homeTeam.name}</span>
                    </div>
                    <span class="resultado">${partido.score.fullTime.home}-${partido.score.fullTime.away}</span>
                    <div class="equipo-visitante">
                        <img src="https://crests.football-data.org/${partido.awayTeam.id}.png" alt="${partido.awayTeam.name}">
                        <span class="equipo-nombre">${partido.awayTeam.name}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="fecha">${new Date(partido.utcDate).toLocaleString()}</div>
                    <div class="competicion">${partido.competition.name}</div>
                </div>
            </div>
            `;
        });
    } catch (error) {
        console.error("Error al obtener partidos:", error);
    }
}


// Función para mostrar los próximos 5 partidos de un equipo 
async function proximos_partidos_equipo(id_equipo) {
    let contenedor = document.getElementById("proximos-partidos");
    contenedor.innerHTML = ""; // Limpiar el contenedor 

    // Petición a la API
    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}/matches?status=SCHEDULED&limit=5`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });
        let data = await response.json();

        // Añadir datos al DOM
        data.matches.forEach(partido => {
            contenedor.innerHTML += `
            <div class="card-partido">
                <div class="card-header">
                    <div class="equipo-local">
                        <img src="https://crests.football-data.org/${partido.homeTeam.id}.png" alt="${partido.homeTeam.name}">
                        <span class="equipo-nombre">${partido.homeTeam.name}</span>
                    </div>
                    <div class="fecha">${new Date(partido.utcDate).toLocaleString()}</div>
                    <div class="equipo-visitante">
                        <img src="https://crests.football-data.org/${partido.awayTeam.id}.png" alt="${partido.awayTeam.name}">
                        <span class="equipo-nombre">${partido.awayTeam.name}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="competicion">${partido.competition.name}</div>
                </div>
            </div>
            `;
        });
    } catch (error) {
        console.error("Error al obtener partidos:", error);
    }
}

// Cargar la función al abrir la página
cargar_competiciones();
