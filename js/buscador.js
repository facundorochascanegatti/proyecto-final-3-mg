// esto es un buscador para la tabla de jugadores en tiempo real, es decir que no se reinicia la pagina sino que
//aparece al instante al buscar el nombre o apellido de cualquier jugador.


// Esto espera que se cargue la pagina por completo, espera a que el html este cargado por completo
// Antes de ejecutar el codigo.
document.addEventListener("DOMContentLoaded", function() {

    //esto basicamente sirve para detectar cuando escribimos en el buscador,
    //getElementById("buscador") busca el elemento de html con esa id (en este caso, el input.)
    //input detecta cada vez que escribimos o borramos algo
    //funcion contiene las instrucciones que se ejecutan cuando escribis
    document.getElementById("buscador").addEventListener("input", function() {
        
        let texto = this.value.toLowerCase();
        //esto obtiene el texto ingresado, let texto crea una variable llamada texto,
        //this.value obtiene lo escrito en el buscador y toLowerCase() pasa todo a minusculas para q se ejecute bien.

        //esto obtiene las filas de la tabla,
        //Busca todas las filas (tr) de la tabla que tiene el ID tablaJugadores y las guarda en la variable filas.
        let filas = document.querySelectorAll("#tablaJugadores tr");

        //esto recorre todas las filas de la tabla una por una, fila indica que fila se revisa
        // y i la posicion de la fila, empezando por 0
        filas.forEach(function(fila, i) {

            //esto hace que la primera fila (la de los titulos) no se oculte,
            // ya que i es la posicion de la fila y si es 0 (la primera) no se oculta.
            if (i == 0) return;

            //esto basicamente muestra o oculta las tablas
            fila.style.display = fila.textContent.toLowerCase().includes(texto) ? "" : "none";
        });
    });
});
