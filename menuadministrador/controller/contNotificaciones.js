
var app1 = new Vue({
    el: '#listanotificaciones',
    //prueba: '',
    data: {
        // Input nombre
        justificaciones: [],
        txtobservacion: '12'
    },
    mounted: function () {
        this.listarJutificacion(); 
    },
    methods: {
        listarJutificacion: function(){
            axios.get('api/apijustificacion.php?op=todos').then(function (response) {
                console.log(response.data);
                app1.justificaciones= response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        devuelvefoto: function(foto){
            if(foto==""){
                return "../img/fotos/foto.png";
            }else{
                return "../img/fotos/"+foto;
            }
        }
    }
});