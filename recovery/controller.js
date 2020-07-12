var app = new Vue({
    el: '#appJustificacion',
    //prueba: '',
    data: {
        // Input nombre
        correo: '',
        cedula: '',
        mensaje: false,
        docente: []
    },
    methods: {
        VerificarCuenta: function(){
            bloquear();
            axios.get('apirecovery.php?correo='+this.correo+'&cedula='+this.cedula).then(function (response) {
                app.docente = response.data;
                if(app.docente.length>0){
                    app.enviarCorreo(app.docente[0].clave);
                }else{
                    app.mensaje=true;
                    setTimeout($.unblockUI,2000);
                }
                
            }).catch(function (error) {
                console.log(error);
            });
        }, enviarCorreo: function(clave){
            axios.get('apirecovery.php?clave='+clave+'&correo='+this.correo).then(function (response) {
                alert("Se ha enviado un correo con sus datos de acceso");
                window.location="../login.php"; 
                setTimeout($.unblockUI,2000);
            }).catch(function (error) {
                console.log(error);
                setTimeout($.unblockUI,2000);
            });

        }
    }
});
