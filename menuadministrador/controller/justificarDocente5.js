var app = new Vue({
    el: '#appJustificacion',
    //prueba: '',
    data: {
        // Input nombre
        docentes: [],
        txtobservacion: '',
        idm: 0
    },
    mounted: function () {
        this.listarJutificacion(this.$refs.idmarcacion.value); 
    },
    methods: {
        escribir: function(){
            
        },
        listarJutificacion: function(idmarcacion){
            this.idm=idmarcacion;
            axios.get('api/apijustificacion.php?idm='+idmarcacion).then(function (response) {
                app.docentes = response.data;
            }).catch(function (error) {
            });
        },JustificarAsistencia: function(){
            let formData = new FormData();
            formData.append('id', app.docentes[0].id)
            formData.append('estado', "JUSTIFICADO")
            formData.append('observacion', app.txtobservacion)
            formData.append('detalle', app.docentes[0].detalle)
            formData.append('tipo', app.docentes[0].op)
            console.log(app.docentes[0].op)
            if(confirm("ESTA SEGURO DE JUSTIFICAR!")){
                bloquear();
                axios({
                    method: 'post',
                    url: 'api/apijustificacion.php',
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then(function (response) {
                    console.log(response);
                    window.location="justificar.php?idma="+app.idm; 
                    alert("JUSTIFICADO");
                    app.docentes[0].estado="JUSTIFICADO";               
                    setTimeout($.unblockUI,1000);  
                })
                .catch(function (response) {
                    console.log(response);
                    setTimeout($.unblockUI,2000);  
                });
            }
        },RechazarAsistencia: function(){
            let formData = new FormData();
            formData.append('id', app.docentes[0].id)
            formData.append('estado', "NEGADO")
            formData.append('observacion', app.txtobservacion)
            formData.append('detalle', app.docentes[0].detalle)
            if(confirm("ESTA SEGURO DE RECHAZAR!")){
                bloquear();
                axios({
                    method: 'post',
                    url: 'api/apijustificacion.php',
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then(function (response) {
                    console.log(response);
                    alert("RECHAZADO");
                    app.docentes[0].estado="RECHAZADO";               
                    window.location="justificar.php?idma="+app.idm;  
                    setTimeout($.unblockUI,1000);                    
                })
                .catch(function (response) {
                    console.log(response);
                    setTimeout($.unblockUI,2000);  
                });
            }
        }
    }
});