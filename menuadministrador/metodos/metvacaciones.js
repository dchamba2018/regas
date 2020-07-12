var app=new Vue({
  el: '#app',
  data: {
    vacaciones: [],
    txtestado: 'REVISION',
    txtarchivo: '../img/cabecera.png',
    docentes: [],
    docente: ""
  },
  mounted(){
    this.cargarDocentes();
    this.cargarVacaciones();
  },
  methods: {
    cargarDocentes: function(){
      axios.get("consultas/apidocentes.php?dato&estado=activo")
      .then(function (response) {
        app.docentes = response.data;
        app.docente=app.docentes[0].persona;
      }).catch(function (error) {
          console.log(error);
      });
    },
    cargarVacaciones: function(){
      axios.get('consultas/apivacaciones.php')
      .then(function (response) {
        app.vacaciones = response.data;
        app.docente=app.vacaciones[0].docente;
      }).catch(function (error) {
          console.log(error);
      });
    },
    abrirmodal: function(archivo){
      this.txtarchivo="../menudocente/archivos/"+archivo;
      $('#ModalArchivo').modal('show');
    },
    aprobar: function(item, op){
      var resp=confirm("Esta Seguro de realizar esta la solicitud");
      if(resp){
        let formData = new FormData();
          formData.append('idvacacion', item.id);
          formData.append('op', op);
          axios({
            method: 'post',
            url: 'consultas/apivacaciones.php',
            data: formData,
            config: { headers: { 'Content-Type': 'multipart/form-data' } }
          })
          .then(function(response) {
            app.cargarVacaciones();
          }).catch(function(response) {
        });
      }
    }
  }
});