var app = new Vue({
    el: '#appJustificaciones',
    data: {
        // Input nombre
        justificaciones: [],
        fechas: mostrarMes(new Date())
        
    },
    mounted: function () {
        this.listarJutificaciones();
    },
    methods: {
        listarJutificaciones: function(){
            console.log(this.fechas);
            axios.get('apijustificaciones.php?fecha='+this.fechas).then(function (response) {
                console.log(response.data);
                app.justificaciones = response.data;
                console.log(app.justificaciones.length);
            }).catch(function (error) {
                console.log(error);
            });
        },
        devuelvecolor: function(item){
            if(item.estado=="JUSTIFICADO"){
                return "bg-success alert-primary";
            }else{
                return "bg-warning alert-danger";
            }
        }
    }
});
