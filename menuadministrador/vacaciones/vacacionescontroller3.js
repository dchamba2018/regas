var app = new Vue({
    el: '#appVacaciones',
    //prueba: '',
    data: {
        // Input nombre
        vacaciones: [],
        txtanio: new Date().getFullYear()
    },
    mounted: function () {
        this.listarVacaciones();  
    },
    methods: {
        listarVacaciones: function(){
            axios.get('apivacaciones.php?anio='+this.txtanio).then(function (response) {
                app.vacaciones = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
});