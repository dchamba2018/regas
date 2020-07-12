var app = new Vue({
    el: '#appJustificaciones',
    data: {
        // Input nombre
        docente: [{
            id: '0',
            cedula: '',
            nombres: '',
            apellidos: '',
            celular: '',
            email: '',
            foto: ''
        }],
        selectedFile: null,
        fotoanterior: 'foto.png'
    },
    mounted: function () {
        this.BuscarDocente();
    },
    methods: {
        BuscarDocente: function(){
            this.docente[0].id=this.$refs.iddocente.value;
            axios.get('apidocentes.php?iddocente='+this.docente[0].id).then(function (response) {
                console.log(response.data[0]);
                app.docente[0].id = response.data[0].id;
                app.docente[0].cedula = response.data[0].cedula;
                app.docente[0].nombres = response.data[0].nombres;
                app.docente[0].apellidos = response.data[0].apellidos;
                app.docente[0].celular = response.data[0].celular;
                app.docente[0].email = response.data[0].email;
                app.fotoanterior=response.data[0].foto;
                if(response.data[0].foto === ''){
                    app.docente[0].foto='foto.png';
                }else{
                    app.docente[0].foto = response.data[0].foto;
                }
            }).catch(function (error) {
                console.log(error);
            });
        },guardar: function(){
            if(app.docente[0].nombres===''){
                alert("Escriba su nombre!");
            }else if(app.docente[0].nombres===''){
                alert("Escriba su apellido!");
            }else if(validarEmail(app.docente[0].email)===false){
                alert("Dirección de email incorrecto");
            }else{
                let formData = new FormData();
                formData.append('iddocente', app.docente[0].id);
                formData.append('nombres', app.docente[0].nombres);
                formData.append('apellidos', app.docente[0].apellidos);
                formData.append('celular', app.docente[0].celular);
                formData.append('email', app.docente[0].email);
                if(this.selectedFile===null){
                    formData.append('file', 'sinfoto');    
                }else{
                    formData.append('file', this.selectedFile);
                    formData.append('fotoanterior', app.fotoanterior);    
                }

                axios({
                        method: 'post',
                        url: 'apidocentes.php',
                        data: formData,
                        config: { headers: { 'Content-Type': 'multipart/form-data' } }
                })
                .then(function(response) {
                    if(response.data==="-2"){
                        alert("Imagen demasiado pesada!");
                    }else if(response.data === "-3"){    
                        alert("Tipo de archivo no permitido!");
                    }else{
                        console.log(response);
                        alert("Actualizado")
                    }
                }).catch(function(response) {
                });
            }
            
        },
        onFileSelected: function(event) {
            this.selectedFile = event.target.files[0];
            this.foto=this.selectedFile.name;
        },
    }
});
var Loadfile = function(event) { // archivo cargado
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById("output");
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
   return true;
  } else {
   return false;
  }
}
function cargarFecha(){
    var diaActual = new Date();
    var day = diaActual.getDate();
    if(day<10){
        day="0"+day;
    }
    var month = diaActual.getMonth()+1;
    if(month<10){
        month="0"+month;
    }
    var year = diaActual.getFullYear();  
    return year+'-'+month+'-'+day;
}