var app = new Vue({
    el: '#appJustificaciones',
    data: {
        // Input nombre
        vacaciones: [],
        year: 2019,
        form: false,
        desde: '',
        hasta:'',
        archivo:'', 
        id:0, 
        botonguardar: true,
        total:0
    },
    mounted: function () {
        this.listarVacaciones();
    },
    methods: {
        listarVacaciones: function(){
            axios.get('apivacaciones.php?year='+this.year).then(function (response) {
                app.vacaciones = response.data;
                app.sumarVacaciones();
            }).catch(function (error) {
                console.log(error);
            });
        },
        eliminarVacacion: function(vacacion){
            resp=confirm("Esta seguro de eliminar el registro");
            if(resp){
                let formData = new FormData();
                console.log("vacacion: "+vacacion.id);
                formData.append('idvacacion', vacacion.id);
                formData.append('respaldo', vacacion.respaldo);
                axios({
                    method: 'post',
                    url: 'apivacaciones.php',
                    data: formData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                .then(function (response) {
                    app.listarVacaciones();
                })
                .catch(function (response) {
                    alert("ERROR DE PROCESO");
                });
            }
        },
        sumarVacaciones: function(){
            app.total=0;
            for (var i = 0; i < this.vacaciones.length; i++) {
                app.total+=parseInt(this.vacaciones[i].dias, 10);
            }            
        },
        registrarVacaciones: function(){
            this.llenarfecha();
            this.form=!this.form;
        },
        guardarVacaciones: function(){
            if(app.desde === ""){
                alert("Escriba la fecha inicial!");
            }else if(app.hasta===""){
                alert("Escriba la fecha final!");
            }else if(app.archivo===null || app.archivo===""){
                alert("Seleccione un archivo!");
            }else{
                app.botonguaradar=false;
                let formData = new FormData();
                formData.append('idvacacion', app.id)
                formData.append('desde', app.desde)
                formData.append('file', app.archivo)
                formData.append('hasta', app.hasta)                
                if(confirm("A CONTINUACIÓN SE REGISTRARA SUS VACACIONES,\n Desea Procesar la solicitud!")){
                    axios({
                        method: 'post',
                        url: 'apivacaciones.php',
                        data: formData,
                        config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then(function (response) {
                        app.botonguaradar=true;
                        console.log(response);
                        if(response.data==="-1"){
                            alert("Verifique las fechas!");
                        }else if(response.data==="-2"){
                            alert("archivo demasiado grande!");
                        }else if(response.data==="-3"){
                            alert("Tipo de archivo no permitido!");
                        }else if(response.data==="0"){
                            alert("SOLICITUD PROCESADA");
                            app.listarVacaciones();
                            app.registrarVacaciones();
                        }else{
                            alert("SOLICITUD PROCESADA");
                            app.listarVacaciones();
                            app.registrarVacaciones();  
                        }                      
                    })
                    .catch(function (response) {
                        alert("ERROR DE PROCESO");
                    });
                }    
            }
        },
        getImage(event){
            this.archivo = event.target.files[0];
        },llenarfecha: function(){
            var diaActual = new Date();
            var month = diaActual.getMonth()+1;
            var year = diaActual.getFullYear();  
            var dia = diaActual.getDate();  
            this.desde=year+"-"+month+"-"+dia;          
            this.hasta=year+"-"+month+"-"+dia;
        }
    }
});