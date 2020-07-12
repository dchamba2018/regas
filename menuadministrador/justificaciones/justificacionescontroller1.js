var app = new Vue({
    el: '#appJustificaciones',
    //prueba: '',
    data: {
        // Input nombre
        justificaciones: [],
        seleccionar: "REVISION",
        estados: [
            { value: 'REVISION', text: 'REVISION' },
            { value: 'JUSTIFICADO', text: 'JUSTIFICADO' },
            { value: 'NEGADO', text: 'NEGADO' }
        ],
        seleccionado:""
    },
    mounted: function () {
        this.listarJutificaciones();       
    },
    methods: {
        listarJutificaciones: function(){
            axios.get('apijustificaciones.php?estado='+this.seleccionar).then(function (response) {
                app.justificaciones = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        leerDatos: function(){
            //this.prueba = this.$refs.id.value;
            console.log(this.prueba+" aqui")
        },
        onChange: function(){
            var conf = $('#select').val();
            this.seleccionar=conf;            
            this.listarJutificaciones();
        }

    }
});