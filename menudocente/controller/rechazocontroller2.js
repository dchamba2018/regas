var app = new Vue({
    el: '#appJustificacion',
    //prueba: '',
    data: {
        // Input nombre
        justificaciones: [],
        txtobservacion: '',
        docente:'',
        file: null,
    },
    mounted: function () {
        this.listarJutificacion(this.$refs.idmarcacion.value, this.$refs.tipo.value); 
        docente=this.$refs.docente.value;
    },
    methods: {
        getImage(event){
                //Asignamos la imagen a  nuestra data
            this.file = event.target.files[0];
            console.log(this.file);
        },
        listarJutificacion: function(idjustificacion, tipo){
            axios.get('api/apirechazo.php?idj='+idjustificacion+"&tipo="+tipo).then(function (response) {
                console.log(response.data);
                app.justificaciones = response.data;
            }).catch(function (error) {
                console.log(error);
            });
        },ReplicarAsistencia: function(){
            if(app.file==null){
                alert("Suba un archivo");
            }else{
                let formData = new FormData();
                formData.append('id', app.justificaciones[0].id)
                formData.append('newobservacion', app.txtobservacion)
                formData.append('observacion', app.justificaciones[0].observacion)
                formData.append('file', app.file)
                formData.append('docente', app.docente)
                if(confirm("A CONTINUACIÓN SE GENERARA UNA NUEVA SOLICITUD,\n Desea Procesar la solicitud!")){
                    bloquear();
                    axios({
                        method: 'post',
                        url: 'api/apirechazo.php',
                        data: formData,
                        config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then(function (response) {
                        console.log(response);
                        alert("SOLICITUD PROCESADA");
                        window.location="resumen.php";
                        setTimeout($.unblockUI,1000);  
                    })
                    .catch(function (response) {
                        console.log(response);
                        setTimeout($.unblockUI,2000);  
                    });
                }    
            }
            
        }
    }
});