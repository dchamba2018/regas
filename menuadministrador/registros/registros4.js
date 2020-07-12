var app = new Vue({
    el: '#appJustificaciones',
    //prueba: '',
    data: {
        // Input nombre
        fecha: '2020-01-01',
        editar: false,
        registros: [],
        docente:"",
        entrada:"00:00:00",
        salida:"00:00:00",
        id:"0",
        observacion:"INASISTENCIA"
    },
    mounted: function () {
        this.fecha=mostrarFecha();
        this.listarRegistros();   
        
    },
    methods: {
        devuelvecolor: function(item){
            if(item.observacion=="ENTRADA"){
                return "bg-success";
            }else if(item.observacion=="INASISTENCIA"){
                return "bg-warning";
            }else if(item.observacion=="JUSTIFICADA"){
                return "bg-info";
            }
        },
        listarRegistros: function(){
            axios.get('apiregistros.php?fecha='+this.fecha).then(function (response) {
                app.registros = response.data;
                app.editar=false;
            }).catch(function (error) {
                console.log(error);
            });
        },
        editarRegistro: function(registro){
            this.editar=!this.editar;
            console.log(registro);
            this.docente=registro.docente;
            this.entrada=registro.entrada;
            this.salida=registro.salida;
            this.id=registro.id;
            this.observacion=registro.observacion;
        },
        cancelarRegistro: function(){
            this.editar=!this.editar;
        },
        guardarRegistro: function(){
            let formData = new FormData();            
            var ob= $('#txtobservacion').val();
            formData.append('id', this.id)
            formData.append('fecha', this.fecha)
            formData.append('entrada', this.entrada)
            formData.append('salida', this.salida)
            formData.append('observacion', ob)
            axios({
                method: 'post',
                url: 'apiregistros.php',
                data: formData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .then(function (response) {
                app.listarRegistros();
                app.editar=true;
            })
            .catch(function (response) {
                console.log(response)
            });
        }

    }
});
function mostrarFecha(){
    var hoy = new Date();
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