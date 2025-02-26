const hamburgerMenu = document.getElementById('hamburger-menu');
const mobileMenu = document.getElementById('mobile-menu');

hamburgerMenu.addEventListener('click', () => {
    hamburgerMenu.classList.toggle('active');
    mobileMenu.classList.toggle('active');
});


async function cargar_competiciones() {
    const selectCompeticiones = document.getElementById("select-competicion");

    selectCompeticiones.innerHTML = `<option value="" disabled selected>Selecciona una competición</option>`;

    let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();

    data.competitions.forEach(competition => {
        selectCompeticiones.innerHTML += `<option value="${competition.id}">${competition.name}</option>`;
    });

    selectCompeticiones.addEventListener("change", function () {
        let id_competicion = selectCompeticiones.value;
        console.log("ID de la competición seleccionada:", id_competicion);
        cargar_equipos(id_competicion);
    });
}


async function cargar_equipos(id_competicion) {
    const selectEquipos = document.getElementById("select-equipo");

    selectEquipos.innerHTML = "<option value='' disabled selected>Selecciona un equipo</option>";

    let response = await fetch(`https://api.football-data.org/v4/competitions/${id_competicion}/teams`, {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();

    data.teams.forEach(equipo => {
        selectEquipos.innerHTML += `<option value="${equipo.id}">${equipo.name}</option>`;
    });

    // Limpiar y agregar nuevo event listener
    selectEquipos.onchange = async function () {
        let id_equipo = selectEquipos.value;
        console.log("ID del equipo seleccionado:", id_equipo);

        let jugadores = await recuperar_jugadores(id_equipo);  // 🔹 Obtener plantilla de jugadores
        mostrar_plantilla(jugadores);  // 🔹 Mostrar en tabla

        ultimos_5_partidos(id_competicion, id_equipo);
        proximos_partidos_equipo(id_equipo);
    };
}


async function recuperar_jugadores(id_equipo) {

    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();


        if (!data.squad || data.squad.length === 0) {
            console.warn("Este equipo no tiene jugadores disponibles.");
            return [];
        }

        return data.squad;

    } catch (error) {
        console.error("Error al recuperar jugadores:", error);
        return [];
    }
}


function mostrar_plantilla(jugadores) {
    let contenedor_plantilla = document.getElementById('contenedor-plantilla');

    // Limpiar contenido anterior
    contenedor_plantilla.innerHTML = "";

    if (jugadores.length === 0) {
        contenedor_plantilla.innerHTML = "<p>No hay jugadores disponibles.</p>";
        return;
    }

    // Crear el contenedor general
    let plantillaHTML = `<div style="width: fit-content; margin-left: 50px;">`;

    // Agregar título "Plantilla"
    plantillaHTML += `<h1 id="titulo-plantilla" style="color: #FFA500; font-size: 22px; font-weight: bold; margin-bottom: 15px; text-align: left;">
                        Plantilla
                      </h1>`;

    // Contenedor de la tabla con scroll
    plantillaHTML += `
        <div style="max-height: 550px; overflow-y: auto; border: 2px solid #FFA500; border-radius: 8px;">
            <table id="tabla-plantilla">
                <tr>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
                    <th>Posición</th>
                </tr>`;

    jugadores.forEach(jugador => {
        plantillaHTML += `<tr>
                            <td>${jugador.name}</td>
                            <td>${jugador.nationality}</td>
                            <td>${jugador.position}</td>
                          </tr>`;
    });

    plantillaHTML += `</table></div></div>`;

    // Insertar en el contenedor
    contenedor_plantilla.innerHTML = plantillaHTML;
}




async function ultimos_5_partidos(id_competicion, id_equipo) {

    let contenedor = document.getElementById('contenedor-last-partidos')

    if (!id_equipo || !id_competicion) {
        console.warn("No hay datos suficientes para obtener los partidos.");
        return;
    }

    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}/matches?status=FINISHED&competitions=${id_competicion}&limit=5`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();
        console.log("Últimos 5 partidos:");

        data.matches.forEach(partido => {
            console.log(`Fecha: ${partido.utcDate} 
            Jornada: ${partido.matchday}, 
            ${partido.homeTeam.name} ${partido.score.fullTime.home}-${partido.score.fullTime.away} ${partido.awayTeam.name} 
            Colegiado de campo: ${partido.referees[0].name}
            `)
            contenedor.innerHTML += `<p> ${partido.homeTeam.name} ${partido.score.fullTime.home}-${partido.score.fullTime.away} ${partido.awayTeam.name}</p> `
        });

    } catch (error) {
        console.error("Error al recuperar partidos:", error);
    }
}



async function proximos_partidos_equipo(id_equipo) {
    let contenedor = document.getElementById('contenedor-proximos-partidos');
    contenedor.innerHTML = ""; // Limpia antes de añadir nuevos partidos

    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}/matches?status=SCHEDULED&limit=10`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();
        console.log('Próximos 10 partidos:', data);


        contenedor.style.backgroundColor = "black";
        contenedor.style.border = "2px solid gold";
        contenedor.style.borderRadius = "10px";

        contenedor.innerHTML += `<h3 style="text-align:center">Próximos partidos del equipo </h3>`
        data.matches.forEach(partido => {
            let card = document.createElement("div");
            card.classList.add("partido-card");

            card.innerHTML = `
                <div class="equipo equipo-local">
                    <img src="https://crests.football-data.org/${partido.homeTeam.id}.png" alt="${partido.homeTeam.name}" class="escudo">
                    <span class="nombre-equipo">${partido.homeTeam.name}</span>
                </div>
                <div class="info-partido">
                    <span class="fecha">${new Date(partido.utcDate).toLocaleString()}</span>
                    
                    <span class="competicion">${partido.competition.name}</span>
                </div>
                <div class="equipo equipo-visitante">
                    <img src="https://crests.football-data.org/${partido.awayTeam.id}.png" alt="${partido.awayTeam.name}" class="escudo">
                    <span class="nombre-equipo">${partido.awayTeam.name}</span>
                </div>
            `;

            contenedor.appendChild(card);
        });

    } catch (error) {
        console.error("Error al recuperar partidos:", error);
    }
}







cargar_competiciones()

