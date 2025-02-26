
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

    selectCompeticiones.addEventListener("change", function() {
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

    selectEquipos.addEventListener("change", function() {
        let id_equipo = selectEquipos.value;
        console.log("ID del equipo seleccionado:", id_equipo);
        recuperar_jugadores(id_equipo);
       
    });
}


async function recuperar_jugadores(id_equipo) {
    const selectJugadores = document.getElementById("select-jugador");

    
    selectJugadores.innerHTML = "<option value='' disabled selected>Selecciona un jugador</option>";

    try {
        let response = await fetch(`https://api.football-data.org/v4/teams/${id_equipo}`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();
        console.log("Datos del equipo:", data);

        if (!data.squad || data.squad.length === 0) {
            console.warn("Este equipo no tiene jugadores disponibles.");
            return;
        }

        data.squad.forEach(jugador => {
            selectJugadores.innerHTML += `<option value="${jugador.id}">${jugador.name}</option>`;
        });

       
        const newSelectJugadores = selectJugadores.cloneNode(true);
        selectJugadores.replaceWith(newSelectJugadores);

 
        newSelectJugadores.addEventListener("change", function() {
            var id_jugador = this.value;
            console.log("ID del jugador seleccionado:", id_jugador);
            recuperar_datos_jugador(id_jugador);
        });

    } catch (error) {
        console.error("Error al recuperar jugadores:", error);
    }
}




async function recuperar_datos_jugador(id_jugador) {
    if (!id_jugador) {
        console.warn("No se ha seleccionado ningún jugador.");
        return;
    }

    console.log("ID del jugador:", id_jugador);

    try {
        let response = await fetch(`https://api.football-data.org/v4/persons/${id_jugador}`, {
            method: "GET",
            headers: { "X-Auth-Token": "05a381fe6cfc42949e6c52abd91774c0" }
        });

        let data = await response.json();
        console.log(data);

        mostrar_boton();
        mostrar_datos_jugador(data.name, data.nationality, data.section, data.position , data.shirtNumber,data.dateOfBirth);

    } catch (error) {
        console.error("Error al recuperar datos del jugador:", error);
    }
}

function mostrar_boton() {
    let contenedor_boton = document.getElementById("contenedor-boton");
    
   
    if (!document.getElementById("boton-mostrar")) {
        contenedor_boton.innerHTML = `<button id="boton-mostrar">Mostrar datos</button>`;
    }
}



function calcularEdad(fechaNac) {
    let fechaNacimiento = new Date(fechaNac);
    let fechaActual = new Date();

    let edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();

   
    let mesActual = fechaActual.getMonth();
    let diaActual = fechaActual.getDate();
    let mesNacimiento = fechaNacimiento.getMonth();
    let diaNacimiento = fechaNacimiento.getDate();

    if (mesActual < mesNacimiento || (mesActual === mesNacimiento && diaActual < diaNacimiento)) {
        edad--;
    }

    return edad;
}


function mostrar_datos_jugador(nombre, nacionalidad, posicion, posicion2,dorsal,fechaNac) {
    let boton_mostrar = document.getElementById("boton-mostrar");
    let contenedor_datos_jugador = document.getElementById("contenedor-datos");
    let edad = calcularEdad(fechaNac); 


    boton_mostrar.replaceWith(boton_mostrar.cloneNode(true));
    boton_mostrar = document.getElementById("boton-mostrar");

    boton_mostrar.addEventListener("click", function () {
        contenedor_datos_jugador.innerHTML = `
            <h1 class="titulo-datos">DATOS DEL FUTBOLISTA</h1>
            <table class="tabla-datos">
                <tr>
                    <th>Nombre</th>
                    <td>${nombre}</td>
                </tr>
                <tr>
                    <th>Nacionalidad</th>
                    <td>${nacionalidad}</td>
                </tr>
                <tr>
                    <th>Posición</th>
                    <td>${posicion} , ${posicion2}</td>
                </tr>
                <tr>
                <th>Dorsal</th>
                <td>${dorsal}</td>
                </tr>
                <tr>
                <th>Edad</th>
                <td>${fechaNac} , ${edad} años</td>
                </tr>
            </table>
        `;
    });
}





cargar_competiciones();
