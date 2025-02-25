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
    selectEquipos.onchange = function () {
        let id_equipo = selectEquipos.value;
        console.log("ID del equipo seleccionado:", id_equipo);
        recuperar_jugadores(id_equipo)
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
            return;
        }
        console.log("Jugadores del Equipo:")
        data.squad.forEach(jugador => {
        console.log(`${jugador.name} , ${jugador.nationality} , ${jugador.position}`);

        
        });

        
        

    } catch (error) {
        console.error("Error al recuperar jugadores:", error);
    }
}






async function ultimos_5_partidos(id_competicion, id_equipo) {
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
        });

    } catch (error) {
        console.error("Error al recuperar partidos:", error);
    }
}



async function proximos_partidos_equipo(id_equipo){


    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}/matches?status=SCHEDULED&limit=10`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();
        console.log(data);
        console.log('Próximos 10 partidos:')
    data.matches.forEach(partido => {
        console.log(`
            Fecha: ${partido.utcDate} 
            Competicion: ${partido.competition.name}, 
            ${partido.homeTeam.name} - ${partido.awayTeam.name} 
            `)
    });




    } catch (error) {
        console.error("Error al recuperar partidos:", error);
    }

}





cargar_competiciones()








