
function mensajeLobibox(tipo,mensaje){
      Lobibox.notify(tipo, {
            msg: mensaje,
            iconSource: "fontAwesome",
            size: 'mini',
            width: 400,
            rounded: true,                
            delay: 5000,
            sound: false,
            position: 'top center',
            delayIndicator: false,
      });   
/*
success (verde)
info    (azul)
error   (rojo)
warning (naranja)
default (black)
*/
}


function mensajeHtml0k(mensaje){
      var mensaje;

      htmlCode = "<div>"+mensaje+" <strong class=\"verde\"> <i class=\"fa fa-check\"></i></strong></div>";
      return htmlCode;
}
