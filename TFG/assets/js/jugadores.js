async function cargar_competiciones() {
    const selectCompeticiones = document.getElementById("select-competicion");

    // Agregar opción predeterminada
    selectCompeticiones.innerHTML = `<option value="" disabled selected>Selecciona una competición</option>`;

    let response = await fetch("https://api.football-data.org/v4/competitions?limit=20", {
       method: "GET",
       headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });
 
    let data = await response.json();
    data.competitions.forEach(competition => {
        selectCompeticiones.innerHTML += `<option value="${competition.id}">${competition.name}</option>`; 
    });

    selectCompeticiones.addEventListener("change", function() {
        var id_competicion = selectCompeticiones.value;
        console.log("ID de la competición seleccionada:", id_competicion);
        cargar_equipos(id_competicion);
    });
}


async function cargar_equipos(id_competicion) {
    const selectEquipos = document.getElementById("select-equipo");

    // Limpiar el select antes de agregar nuevas opciones
    selectEquipos.innerHTML = "<option value='' disabled selected >Selecciona un equipo</option>";

    let response = await fetch(`https://api.football-data.org/v4/competitions/${id_competicion}/teams`, {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();

    data.teams.forEach(equipo => {
        selectEquipos.innerHTML += `<option value="${equipo.id}">${equipo.name}</option>`;
        
    });

    selectEquipos.addEventListener("change", function() {
        var id_equipo = selectEquipos.value;
        console.log("ID del equipo seleccionado:", id_equipo);
        recuperar_jugadores(id_equipo);
    });

}

async function recuperar_jugadores(id_equipo) {
    const selectJugadores = document.getElementById("select-jugador")

    selectJugadores.innerHTML = "<option value='' disabled selected >Selecciona un jugador</option>";

    let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}`, {
        method: "GET",
        headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
    });

    let data = await response.json();
    console.log(data)


    data.squad.forEach(jugador => {
        console.log(jugador.name, jugador.id)
        selectJugadores.innerHTML += `<option value="${jugador.id}">${jugador.name}</option>`;
    });



}



// Cargar las competiciones al iniciar
cargar_competiciones();
