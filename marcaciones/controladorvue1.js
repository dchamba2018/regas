const app=new Vue({
	el:"#app",
	data:{
		titulo: 'ASIS-DOCENTES',
		cedula:'',
		ubicacion:'',
		fecha: mostrarFecha(new Date()),
		hora: '', 
		latitud:'',
		longitud: '',
		precision: '',
		docente: [], 
		marcacion: [],
		btnvalidar: true,
		txtfoto: '',
		cronometro: '00:01:00',
		textomensaje: 'Estimado docente tiene 30 segundos para realizar su registro!',
		loading: false,
		click: 0
	},
	methods: {
		validar: function(){
			if(this.cedula.length==10){
				//bloquear();
				axios.get('apidocente.php?cedula='+this.cedula).then(function (response) {
					if(response.data.error==="cedula incorrecta"){
						alert("Cedula Incorrecta");
						app.cedula="";
					}else{
						app.docente = response.data;
						if(app.docente.length>0){
		                	app.btnvalidar=false;
		                	axios.get('apimarcaciones.php?iddocente='+app.docente[0].id).then(function (response) {
								app.marcacion = response.data;
								console.log(response.data);
								if(app.marcacion.length>0){
			                		if(app.marcacion[0].observacion!="SALIDA"){
				                		iniciar();
										$('#dialogocamara').modal('show');
				                		app.ejecutarCronometro();
				                	}else if(app.marcacion[0].observacion=="SALIDA"){
					            		app.textomensaje="Estimado docente Ud. ya cumplio con su registro diario!";
					            		app.cronometro="";
				                	}else{
				                		console.log("mensja");
				                		app.textomensaje= 'Estimado docente no es posible realizar su registro!';
				                		app.cronometro="";
				                	}	
			                	}else{
			                		app.textomensaje= 'Estimado docente no es posible realizar su registro!';
			                		app.cronometro="";
			                	} 

				            }).catch(function (error) {
				                console.log(error);
				            });            	
		                }else{
		                	alert("Docente No registrado");
		          			window.location="../register.php?cedula="+app.cedula;
		            	}	
					}
					setTimeout($.unblockUI,1000); 
	            }).catch(function (error) {
	                console.log(error);
	                setTimeout($.unblockUI,1000);
	            });
			}else{
				alert("Cedula Incorrecta");
				this.cedula="";
			}
		}, registrar: function(op){
			this.click+=1;
			var validador=true;
			this.loading=true;
			var hora=this.devuelveHora();
			if(op=="SALIDA" && hora<2230){
				resp=confirm("Esta seguro de registrar su salida!");
				if(!resp){
					validador=false;
				}
			}
			this.latitud=this.$refs.latitudtxt.value;	
		    this.longitud=this.$refs.longitudtxt.value;	
		    this.precision=this.$refs.precision1.value;
		    let formData = new FormData();
            formData.append('iddocente', app.docente[0].id);
            formData.append('observacion', op);
            formData.append('latitud', app.latitud);
            formData.append('longitud', app.longitud);
            formData.append('precision', app.precision);
            formData.append('foto', app.txtfoto);
            formData.append('idmarca', app.marcacion[0].id);
            axios({
                method: 'post',
                url: 'apimarcaciones.php',
                data: formData,
                config: { headers: {'Content-Type': 'multipart/form-data' }}
            })
            .then(function (response) {
                alert("REGISTRO  DE "+op+" EXITOSO");
            	app.buscarMarcacion(); 
            	app.guardaFoto(validador);
            	setTimeout($.unblockUI,500);
            })
            .catch(function (response) {
                console.log(response); 
                setTimeout($.unblockUI,500);
            });	
			//captura foto
		}, guardaFoto: function(validador){
			var xhr=capturar();
			xhr.onreadystatechange = function() {
		    	if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
			        app.txtfoto=xhr.responseText;
			        if(validador){
						bloquear();
						let formData = new FormData();
			            formData.append('idmarcacion', app.marcacion[0].id);
			            formData.append('foto', app.txtfoto);
			            axios({
			                method: 'post',
			                url: 'apimarcaciones.php',
			                data: formData,
			                config: { headers: {'Content-Type': 'multipart/form-data' }}
			            })
			            .then(function (response) {
			            	console.log(response.data+'foto cargada');
			            })
			            .catch(function (response) {
			                console.log(response); 
			                setTimeout($.unblockUI,500);
			            });	
					}
			    }
			}
			
		}, buscarMarcacion: function(){
			this.loading=false;
			axios.get('apimarcaciones.php?iddocente='+this.docente[0].id).then(function (response) {
				app.marcacion = response.data;
				if(app.marcacion[0].observacion=="SALIDA"){
            		app.textomensaje="Estimado docente Ud. ya cumplio con su registro diario!";
            	}
            }).catch(function (error) {
                console.log(error);
            });
        }, ejecutarCronometro: function(){
        	var sec=60;
        	setInterval(() => {
        		sec--;
        		if(sec<10){
		    		this.cronometro="00:00:0"+sec;	
		    	}else{
		    		this.cronometro="00:00:"+sec;
		    	}
		    	if(sec==0){
		    		window.location="index.php";
		    	}        		
	       	}, 1000);
		},actualizarFecha: function(){
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
		    this.fecha=day+'/'+month+'/'+year;
		}, devuelveHora: function(){
		    var today = new Date();
            var hr = today.getHours();
		    if(hr<10){
		    	hr="0"+hr;
		    }
		    var min = today.getMinutes();
		    if(min<10){
		    	min="0"+min;
		    }
		    var sec = today.getSeconds();  
		    if(sec<10){
		    	sec="0"+sec;
		    }
		    this.hora=hr+':'+min+':'+sec;		    
		    return hr+""+min;
		},verificarhora: function(){
			var hora=this.devuelveHora();
	    	if(hora>=1330 && hora<=2359){	    		
			}else{
		    	window.location="../blank/"; 				  	
		    }
		}, verificarposicion: function(){			
			this.latitud=this.$refs.latitudtxt.value;	
		    this.longitud=this.$refs.longitudtxt.value;	
		    this.precision=this.$refs.precision1.value;
			axios.get('../clases/distancias.php?latitud='+this.latitud+"&"+"longitud="+this.longitud).then(function (response) {
                var datos=parseInt(response.data);
                if(datos==0){
                	console.log("entre");
	          		window.location="../blank/"; 				  	
	            }else{
	            	console.log("no entre");
	            }
            }).catch(function (error) {
                console.log(error);
            });			
		},
		verificardia: function(){

			var d = new Date ()
			console.log(d.getDay());
			if(d.getDay ()==6 || d.getDay()==0){
				window.location="../blank/"; 	
			}
		}
	},
    mounted: function () {
    	this.verificardia();
    	this.verificarhora();
    	var i=0;
	    setInterval(() => {
            this.latitud=this.$refs.latitudtxt.value;	
    	    this.longitud=this.$refs.longitudtxt.value;	
    	    this.precision=this.$refs.precision1.value;
    	    if(this.longitud!=0 && i==0){
    	        this.verificarposicion(); 
    	        i++;
    	        console.log("longitud"+this.longitud);
    	        console.log("Latitud"+this.latitud);
    	        console.log(this.precision);
    	        
    	    }
    	    this.devuelveHora();
			this.actualizarFecha();
       	}, 1000);       	
        //this.actualizarHora();        
    }	
});