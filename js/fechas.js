function mostrarFecha(hoy){
    var dd = hoy.getDate();
    var mm = hoy.getMonth()+1;
    var yyyy = hoy.getFullYear();
    return yyyy+"-"+devuelve2digitos(""+mm)+"-"+devuelve2digitos(""+dd);
}
function devuelve2digitos(numero){
    if(numero.length==1){
        numero="0"+numero;
    }
    return numero;
}
function mostrarMes(hoy){
    var mm = hoy.getMonth()+1;
    var yyyy = hoy.getFullYear();
    return yyyy+"-"+devuelve2digitos(""+mm);
}