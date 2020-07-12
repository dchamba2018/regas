var app = new Vue({
    el: '#appJustificaciones',
    //prueba: '',
    data: {
        // Input nombre
        laborables: [],
        nuevo: false,
        id: 0,
        motivo: "",
        inicio: mostrarFecha(new Date()),
        fin: mostrarFecha(new Date()),
        txtanio: new Date().getFullYear()
    },
    mounted: function () {
        this.listarJutificaciones();  
    },
    methods: {
        listarJutificaciones: function(){
            axios.get('apilaborables.php?anio='+this.txtanio).then(function (response) {
                app.laborables = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },
        leerDatos: function(){
            //this.prueba = this.$refs.id.value;
            console.log(this.prueba+" aqui")
        }, nuevoregistro: function(){
            app.nuevo=!app.nuevo;
            this.id=0;
            this.inicio=mostrarFecha(new Date());
            this.fin=mostrarFecha(new Date());
            this.motivo="";
            console.log(this.inicio);
        }, formatearfechas: function() {
            diaActual = new Date();
            var day = diaActual.getDate();
            var month = diaActual.getMonth()+1;
            var year = diaActual.getFullYear();            
            campo  = year + '-' + month + '-' + day;
            return campo;
        },guardaregistro: function(op){
            if(app.motivo===""){
                alert("Escriba el motivo")
            }else{
                let formData = new FormData();
                formData.append('id', app.id)
                formData.append('inicio', app.inicio)
                formData.append('fin', app.fin)
                formData.append('motivo', app.motivo)
                formData.append('op', op)
                if(confirm("ESTA SEGURO DE REGISTRAR!")){
                    bloquear();
                    axios({
                        method: 'post',
                        url: 'apilaborables.php',
                        data: formData,
                        config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then(function (response) {
                        app.listarJutificaciones();
                        app.nuevoregistro();
                        setTimeout($.unblockUI,500); 
                    })
                    .catch(function (response) {
                        console.log(response);
                        setTimeout($.unblockUI,500);  
                    });
                }    
            }
            
        },editarregistro: function(dianolab){
            app.nuevoregistro();
            app.id=dianolab.id;
            app.inicio=dianolab.inicio;
            app.fin=dianolab.fin;
            app.motivo=dianolab.motivo;
        }
    }
});