// Evitar reenvio de formulario
if(window.history.replaceState){
    window.history.replaceState(null, null, window.location.href);
}