var app=new Vue({
  el: '#app',
  data: {
    docentes: [],
    txtbusqueda: '',
    txtestado: 'ACTIVO'
  },
  mounted(){
    this.cargardocentes();
  },
  methods: {
    cargardocentes: function(){
      axios.get('consultas/apidocentes.php?dato='+this.txtbusqueda+'&estado='+this.txtestado)
      .then(function (response) {
        app.docentes = response.data;
      }).catch(function (error) {
          console.log(error);
      });
    },
    devuelvecolor: function(item){
      if(item.estado=="ACTIVO"){
      }else{
        return "bg-warning text-primary";
      }
    },
    activar: function(item){
      var estado="ACTIVO";
      if(item.estado=="ACTIVO"){
        estado="INACTIVO";
      }
      var resp=confirm("Esta Seguro de realizar esta la solicitud");
      if(resp){
        let formData = new FormData();
          formData.append('iddocente', item.id);
          formData.append('estado', estado);
          axios({
            method: 'post',
            url: 'consultas/apidocentes.php',
            data: formData,
            config: { headers: { 'Content-Type': 'multipart/form-data' } }
          })
          .then(function(response) {
            console.log(response.data);
          if(response.data.codigo==0){
            alert(response.data.detalle);
            app.cargardocentes();
          }else{
            alert(response.data.detalle);
          }
        }).catch(function(response) {
        });
      }
    },
    actualizar: function(item){
        let formData = new FormData();
        formData.append('iddocente', item.id);
        formData.append('nombres', item.nombres);
        formData.append('apellidos', item.apellidos);
        formData.append('op', item.apellidos);
        axios({
          method: 'post',
          url: 'consultas/apidocentes.php',
          data: formData,
          config: { headers: { 'Content-Type': 'multipart/form-data' } }
        })
        .then(function(response) {
          console.log(response.data);
        if(response.data.codigo==0){
          alert(response.data.detalle);
          app.cargardocentes();
        }else{
          alert(response.data.detalle);
        }
      }).catch(function(response) {
      });
    }
  }

});