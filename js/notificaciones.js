function mostrarNotificacion(mensaje, tipoMensaje) {

    switch(tipoMensaje){
        case "success": swal("¡Acción realizada exitosamente!", mensaje, tipoMensaje);
            break;
        
        case "error": swal("¡Algo ha salido mal!", mensaje, tipoMensaje);
            break;
        
        case "warning": swal("¡Algo ha salido mal!", mensaje, tipoMensaje);
            break;
    }
    
}