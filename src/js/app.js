let pagina=1;
document.addEventListener('DOMContentLoaded', function (){
    iniciarApp();
})

function iniciarApp() {

    mostrarSeccion();
    cambiarSeccion();

}




function mostrarSeccion(){

    //Eliminar mostrar-seccion de la seccion Anterior
    const seccionAnterior = document.querySelector('.mostrar-seccion');
    if (seccionAnterior){
        seccionAnterior.classList.remove('mostrar-seccion');
    }

    const seccionActual= document.querySelector(`#paso-${pagina}`);
    seccionActual.classList.add('mostrar-seccion');

    //Eliminar la clase Actual en el tab anterior
    const tabAnterior = document.querySelector(' .tabs .actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    //Resalta el tab actual
    const tab= document.querySelector(`[data-paso="${pagina}"]`);
    tab.classList.add('actual');
}

function cambiarSeccion(){
    const enlaces = document.querySelectorAll('.tabs button');

    enlaces.forEach(enlace => {
        enlace.addEventListener('click', e =>{
            e.preventDefault();
            pagina = parseInt(e.target.dataset.paso);

            //Lamar la funcion de mostrar seccion
            mostrarSeccion();
            //botonesPaginador();
        })
    })

}