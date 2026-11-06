// Pinta el campo de la cédula: verde si es válida, rojo si no
var campoCedula = document.getElementById("cedula");

//esto basicamente sirve para detectar cuando escribimos en el campo de la cédula,
//getElementById("cedula") busca el elemento de html con esa id (en este caso, el input.)
//keyup detecta cada vez que escribimos o borramos algo
//funcion contiene las instrucciones que se ejecutan cuando escribis
campoCedula.addEventListener("keyup", function () {
    //esto basicamente pinta el campo de la cédula de verde si es válida, rojo si no, y lo deja normal si tiene menos de 8 caracteres
//verifica que la cedula tenga al menos 8 digitos y comprueba si es valida, mostrando el campo en verde o rojo segun el resultado
  if (campoCedula.value.length < 8) {
    campoCedula.style.background = "";
  } else if (validate_ci(campoCedula.value)) {
    campoCedula.style.background = "#9deb91";
  } else {
    campoCedula.style.background = "#eb91ae";
  }
});