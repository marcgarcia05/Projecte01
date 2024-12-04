function eliminarAccents(str) {
  str = str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
  return str.toLowerCase();
}
// Actualizar paises
function actualizarPaises() {
    var desti = document.getElementById('continent').value.toLowerCase();
    var pais = document.getElementById('pais');
    
    // Limpiar las opciones existentes
    pais.innerHTML = '';
  
    // Crear un array de países según el continente seleccionado
    var paises = [];
  
    if (desti === 'europa') {
      paises = ['Itàlia', 'Espanya', 'Londres'];
    } else if (desti === 'asia') {
      paises = ['Japó', 'Xina'];
    } else if (desti === 'africa') {
      paises = ['Sudáfrica', 'Egipte', 'Nigèria'];
    } else if (desti === 'america') {
      paises = ['EEUU', 'Méxic', 'Brasil'];
    }
  
    // Añadir las opciones de país al select
    paises.forEach(function(paisNombre) {
      var option = document.createElement('option');
      option.value = paisNombre.toLowerCase();
      option.text = paisNombre;
      pais.appendChild(option);
    });
  
    // Actualizar el precio cuando se carga la página o se actualiza el país
    actualizarPreu();
    actualizarImagen();
}
  
// Actualizar el precio según el país y el número de personas
function actualizarPreu() {
    let paisSeleccionado = document.getElementById('pais').value.toLowerCase();
    let numPersones = document.getElementById('persones').value;
    let preu = 0;
  
    // Precios base según el país
    switch (paisSeleccionado) {
      case 'itàlia':
        preu = 1000;
        break;
      case 'espanya':
        preu = 800;
        break;
      case 'londres':
        preu = 1500;
        break;
      case 'japó':
        preu = 1500;
        break;
      case 'xina':
        preu = 1200;
        break;
      case 'sudáfrica':
        preu = 1300;
        break;
      case 'egipte':
        preu = 1100;
        break;
      case 'nigèria':
        preu = 1000;
        break;
      case 'eeuu':
        preu = 2000;
        break;
      case 'méxic':
        preu = 950;
        break;
      case 'brasil':
        preu = 1100;
        break;
      default:
        preu = 0;
        break;
    }
    var totalPreu = preu * numPersones;
    // Multiplicar por el número de personas
    if (document.getElementById('descompte').checked){
        totalPreu *= 0.8;
    }
  
    // Asignar el precio calculado al campo de entrada 'preu'
    document.getElementById('preu').value = preu;
    document.getElementById('total').value = totalPreu;
}

// Actualizar la imagen del país seleccionado
function actualizarImagen() {
    var paisSeleccionado = document.getElementById('pais').value.toLowerCase();
    var imagenPais = document.getElementById('imagenPais');
  
    // Establecer la ruta de la imagen según el país seleccionado
    imagenPais.src = "../IMG/" + eliminarAccents(paisSeleccionado) + ".jpeg";
    console.log(eliminarAccents(paisSeleccionado));
}

// Función para hacer que la imagen se haga más grande al pasar el ratón
function aumentarImagen() {
    var imagenPais = document.getElementById('imagenPais');
    imagenPais.style.transform = "scale(1.8) translateX(20%)"; // Aumentar el tamaño de la imagen
    imagenPais.style.transition = "transform 0.3s ease"; // Añadir una transición suave
}

// Función para devolver la imagen a su tamaño original cuando el ratón sale
function reducirImagen() {
    var imagenPais = document.getElementById('imagenPais');
    imagenPais.style.transform = "scale(1) translateX(0)"; // Restaurar el tamaño original
}

// Llamar a la función al cargar la página para establecer los países por defecto y el precio
window.onload = function() {
    // Llamamos a la función para poner los países por defecto
    actualizarPaises();
  
    // Añadir el event listener para el cambio de continente
    document.getElementById('continent').addEventListener('change', actualizarPaises);
  
    // Añadir el event listener para el cambio de país
    document.getElementById('pais').addEventListener('change', function() {
        actualizarPreu();
        actualizarImagen();
    });
  
    // Añadir el event listener para el cambio de número de personas
    document.getElementById('persones').addEventListener('input', actualizarPreu);
    document.getElementById('descompte').addEventListener('change', actualizarPreu)
  
    // Event listeners para cambiar el tamaño de la imagen cuando el cursor está encima
    var imagenPais = document.getElementById('imagenPais');
    imagenPais.addEventListener('mouseover', aumentarImagen); // Cuando el cursor pasa por encima
    imagenPais.addEventListener('mouseout', reducirImagen);   // Cuando el cursor sale
};
