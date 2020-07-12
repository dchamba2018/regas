var app = new Vue({
    el: '#appJustificaciones',
    //prueba: '',
    data: {
        // Input nombre
        fecha: mostrarFecha(),
        editar: false,
        registros: [],
        docente:"",
        entrada:"00:00:00",
        salida:"00:00:00",
        id:"0"
    },
    mounted: function () {
        this.listarRegistros();       
    },
    methods: {
        listarRegistros: function(){
            axios.get('apiregistros.php?fecha='+this.fecha).then(function (response) {
                app.registros = response.data;
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
        },
        cancelarRegistro: function(){
            this.editar=!this.editar;
        },
        guardarRegistro: function(){
            let formData = new FormData();
            formData.append('id', this.id)
            formData.append('fecha', this.fecha)
            formData.append('entrada', this.entrada)
            formData.append('salida', this.salida)
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
    return yyyy+"-"+mm+"-"+dd;
}