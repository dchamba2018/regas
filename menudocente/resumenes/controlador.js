var app = new Vue({
    el: '#appJustificaciones',
    data: {
        // Input nombre
        fechas: [],
        registros: [],
        meses: [{dia: 'Enero'},{dia: 'Febrero'},{dia: 'Marzo'},{dia: 'Abril'},{dia: 'Mayo'},{dia: 'Junio'},
        {dia: 'Julio'},{dia: 'Agosto'},{dia: 'Septiembre'},{dia: 'Octubre'},{dia: 'Noviembre'},{dia: 'Diciembre'}],
        itemseleccionado: '',
        direccion: '',
        panelregistro: true,
        justificacion: [
        {
            titulosel: '',
            fechasel: '',
            motivosel: 'SELECCIONE UN MOTIVO',
            detallesel: '',
            file: null,
            idmarcacion: ''
        }
        ],
        motivos: [{data: 'SELECCIONE UN MOTIVO'},{data: 'CALAMIDAD DOMESTICA'}, {data: 'ENFERMEDAD'}, {data: 'CURSO-TALLER'}, 
        {data: 'DELEGACION'}, {data: 'COMISION'}, {data: 'OTRO'}]
        
    },
    mounted: function () {
        this.llenarfechas();
        this.listarRegistros();
    },
    methods: {
        llenarfechas: function(){
            var diaActual = new Date();
            var month = diaActual.getMonth()+1;
            var year = diaActual.getFullYear();  
            this.itemseleccionado=month+"/"+year;
            for (var i = 0; i < 10; i++) {
                this.fechas.push({
                    codigo: i+1,
                    value: month+"/"+year,
                    texto: this.meses[month-1].dia+"/"+year                   
                });
                month--;
                if(month==0){
                    month=0;
                    year--;
                }
            }

        },
        getImage(event){
                //Asignamos la imagen a  nuestra data

            this.justificacion[0].file = event.target.files[0];
        },
        JustificarAsistencia: function(){
            if(app.justificacion[0].motivosel === app.motivos[0].data){
                alert("Seleccione un motivo!");
            }else if(app.justificacion[0].detallesel===""){
                alert("Escriba un detalle!");
            }else if(app.justificacion[0].file===null){
                alert("Seleccione un archivo!");
            }else{
                let formData = new FormData();
                formData.append('idmarcacion', app.justificacion[0].idmarcacion)
                formData.append('motivo', app.justificacion[0].motivosel)
                formData.append('file', app.justificacion[0].file)
                formData.append('detalle', app.justificacion[0].detallesel)                
                formData.append('tipo', app.justificacion[0].titulosel)
                if(confirm("A CONTINUACIÓN SE GENERARA LA SOLICITUD DE JUSTIFICACIÓN,\n Desea Procesar la solicitud!")){
                    axios({
                        method: 'post',
                        url: 'apijustificacion.php',
                        data: formData,
                        config: { headers: {'Content-Type': 'multipart/form-data' }}
                    })
                    .then(function (response) {
                        alert("SOLICITUD PROCESADA");
                        app.listarRegistros();
                        app.abrir_cerrar_Justificacion(true, '',0);

                    })
                    .catch(function (response) {
                        console.log(response);  
                    });
                }    
            }
        },
        onChange: function(){
            this.listarRegistros();
        },
        abrirModal: function(url){
            this.direccion=url;
        },
        abrir_cerrar_Justificacion: function(op, titulo, index){
            this.panelregistro=op;  
            this.justificacion[0].titulosel=titulo;
            if(op){
                this.justificacion[0].detallesel="";
                this.justificacion[0].file=null;
            }else{
                this.justificacion[0].fechasel=this.registros[index].dia;
                this.justificacion[0].idmarcacion=this.registros[index].idmarcacion;                
            }
            
        },
        abrirRechazo: function(item){
            if(item.observacion==="ATRAZO"){
                window.location="../rechazo.php?idj="+item.idjustificacionatrazo+"&tipo="+item.observacion;    
            }else{
                window.location="../rechazo.php?idj="+item.idjustificacion+"&tipo="+item.observacion;
            }
            
        },
        crearMapa: function(item){
            var url="https://www.google.com/maps/@"+item.latitud+","+item.longitug+",20z";
            window.open(url, '_blank');
        },
        listarRegistros: function(){
            axios.get('apiresumen.php?mes='+this.itemseleccionado).then(function (response) {
                app.registros = response.data;
                console.log(response.data);
            }).catch(function (error) {
                console.log(error);
            });
        }
    }
});
