const wss = "http://localhost:8000/";
Vue.config.debug = true
const LoanPanel = { 
	template: `<div id="loan"><div class="col-xs-12 col-sm-4">
				<div class="well container-fluid">
					<h4>Usuario</h4>
					<div>
						<div class="input-group" v-bind:class="'has-'+[searchUser.state]">
							<span class="input-group-addon" id="user">
								<i class="fa fa-user" aria-hidden="true"></i>
							</span>
							<input autofocus type="text" v-model="user.identification " id="identification" class="form-control" placeholder="Carné/Cédula" aria-describedby="user"  v-on:keyup="(searchUser.state != 'default')?searchUser.state = 'default':''" v-on:keyup.enter="getUserData" :disabled="searchUser.disabled">
							<span class="input-group-addon" v-if="searchUser.state == 'default'">
								<i class="fa fa-search" aria-hidden="true"></i>
							</span>
							<span class="input-group-addon" v-if="searchUser.state == 'success'">
								<i class="fa fa-check" aria-hidden="true"></i>
							</span>
							<span class="input-group-addon" v-if="searchUser.state == 'warning'">
								<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true" ></i>
							</span>
							<span class="input-group-addon" v-if="searchUser.state == 'error'">
								<i class="fa fa-times text-danger" aria-hidden="true" ></i>
							</span>
						</div>
					</div>
					<div class="row"> 
						<div class="col-xs-12">
							<div class="btn-group pull-right" style="margin-top: 10px;margin-bottom: 10px;">
								<button class="btn btn-default" v-on:click="clearUser()" :disabled="searchUser.disabled">
									Limpiar
								</button>
								<button class="btn btn-primary" v-on:click="getUserData()" :disabled="searchUser.disabled">
									Buscar
								</button>
							</div>
						</div>
					</div>
					<div v-if="user.id == null" style="font-size: 25px;border: 1px solid #999;border-radius: 6px;" class="text-muted text-center"><i aria-hidden="true" style="font-size: 4em;" class="fa fa-user text-muted"></i> <br>
						Sin usuario seleccionado
					</div>
					<ul v-if="user.id != null" class="list-group">
						<li class="list-group-item">
							<b class="text-primary">Nombre:</b>
							{{user.name}} {{user.last_name}}
						</li>
						<li class="list-group-item" v-if="user.student != null">
							<b class="text-primary">Carné:</b> {{user.student.license}}
						</li>
						<li class="list-group-item">
							<b class="text-primary">Cedula:</b> {{user.identity_card}}
						</li>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-8">
				<div class="well container-fluid">

					<h4>Préstamo</h4>
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<select class="form-control" aria-describedby="type_loan" v-model="auto">
								<option value="true">Automático</option>
								<option value="false">Manual</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3">
							<input type="text" class="form-control" placeholder="Fecha de devolución" aria-describedby="date" id="datePicker" :disabled="auto=='true'" v-model="return_time">
						</div>
						<div class="col-xs-12 col-sm-3">
							<select class="form-control" placeholder="Hora de devolución" aria-describedby="time" :disabled="auto=='true'">
								<option value="" disabled="" selected="">Hora de devolución</option>
								<option v-for="n in hours">{{n}}</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3">
							<input type="text" class="form-control" id="barcode" placeholder="Código de barras" aria-describedby="barcode" v-model="barcode" style="text-transform:uppercase" v-on:keyup.enter="createLoan" :disabled="loan.disabled">
						</div>
					</div>	
					<div class="row">
						<div class="col-xs-12">
							<button v-on:click="createLoan" style="margin-top: 10px;" class="btn btn-primary pull-right" :disabled="loan.disabled">
								Préstamo/Devolución
							</button>
						</div>
					</div>
				</div>
				<div class="well container-flud">
					<h4>Préstamos actuales</h4>
					<table class="table table-striped" v-if="currentLoans.length != 0">
						<tr>
							<th>Código de barras</th>
							<th>Elemento</th>
							<th>Prestado el</th>
							<th>Devolver el</th>
							<th>Estado</th>
						</tr>
						<tr v-for="loan in currentLoans">
							<td>{{loan.loanable.barcode}}</td>
							<td>{{loan.loanable.audiovisual_equipment.type.name}} - {{loan.loanable.audiovisual_equipment.brand.name}} - {{loan.loanable.audiovisual_equipment.model.name}}</td>
							<td>{{loan.departure_time}}</td>
							<td>{{loan.return_time}}</td>
							<td>A tiempo</td>
						</tr>
					</table>
					<div v-if="currentLoans.length == 0" style="font-size: 25px;border: 1px solid #999;border-radius: 6px;" class="text-muted text-center">
						<i class="fa fa-tag" aria-hidden="true" style="font-size: 4em"></i>
						<br>
						No se registran préstamos
					</div>
				</div>
			</div>
			</div>
			
			`,
	data: function () {
		return {
		  	auto: 'true',
		  	searchUser:{
		  		state: 'default',
		  		disabled: false,
		  	},
		  	loan:{
		  		state: 'default',
		  		disabled: false,
		  	},
		  	user: new User({identification: '207400490'}),
		  	currentLoans:[],
		  	barcode: '',
		  	return_time: '',
		  	hours: getHours()
	  };
	},
  	methods:{
	  	createLoan: function() {
	  		//createLoan(this);
	  		automaticLoan(this);
	  	},
	  	clearUser: function () {
	  		this.user.clear();
	  		this.searchUser.state = 'default';
	  		this.currentLoans = [];
	  		$("#identification").focus();
	  	},
	  	getUserData: function () {
			this.searchUser.state = 'warning';
			this.searchUser.disabled = true; 
	  		getUserData(this.user.identification, this);
	  	}
  	}

};

const Login = {
	template: `
		<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
			<div class="well row">
				<h3 class="text-center">Inicio de sesión</h3>
				<div class="form-group">
					<div class="input-group">
					  <span class="input-group-addon" id="email">
						<i class="fa fa-user" aria-hidden="true"></i>
					  </span>
					  <input type="text" class="form-control" placeholder="Correo" aria-describedby="email" v-model="email" v-on:keyup.enter="$('#passW').focus();" autofocus>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
					  <span class="input-group-addon" id="pass">
					  	<i class="fa fa-lock" aria-hidden="true"></i>
					  </span>
					  <input type="password" class="form-control" placeholder="Contrseña" aria-describedby="pass" v-on:keyup.enter="login" v-model="password" id="passW">
					</div>
				</div>
				<div class="form-group">
					<button :disabled="loading" class="btn btn-primary pull-right" v-on:click="login">
						Entrar
					</button>
				</div>
			</div>
		</div>
	`,
	data: function () {
		return {
		  	email: 'vanessa.arce@ucr.ac.cr',
		  	password: '1234',
		  	loading: false
		}
	},
	methods:{
  	login: function() {
		this.loagin = true;
  		var xhr = $.ajax({
			method: "POST",
			dataType: 'json',
			url: wss + "login",
			data: {
			  	email: this.email,
			  	password: this.password
			},
			context: this
		});
		xhr.done(function( msg ){
			if(msg && msg.token){
				sessionStorage.setItem('token', msg.token);
				sessionStorage.setItem('user', JSON.stringify(msg.user));
				toastr["success"]("Hola " + msg.user.name);
				this.email = "";
				user.autoFill(msg.user);
				router.push('prestamos');
			}else{
				toastr["error"](msg.error);
			}
		});
		xhr.fail(function (msg) {
			toastr["error"]("Se ha presentador un error de conexón");
		});
		xhr.always(function (msg) {
			console.log(this);
			this.password = "";
			this.loagin = false;
		});
  	}
  }

}

const AudiovisualEquipmentManagement = {
	template: `
		<div class="col-xs-12 col-sm-10 col-sm-offset-1"  :listing-id="audiovisual_equipment_managment">
			<div class="well">
				<h3>
					Equipo audiovisual
				</h3>
				<span class="text-muted">
					Página {{$route.params.page}} de {{page.last_page}}
				</span>
				<table class="table table-striped" border="1">
					<tr>
						<th>
							Código de barras
						</th>
						<th>
							Nombre <!--Tipo-->
						</th>
						<th>
							Modelo
						</th>
						<th>
							Marca
						</th>
						<th>
							Estado
						</th>
					</tr>
					<tr v-for="equipment in page.data" v-bind:class="{'success': equipment.loanable.state_id == 1}">
						<td>
							<router-link  :to="{ name: 'equipo-audiovisual-panel', params: { id: equipment.loanable.id }}">
								{{equipment.loanable.barcode}}
							</router-link>
						</td>
						<td>
							<router-link  :to="{ name: 'equipo-audiovisual-panel', params: { id: equipment.loanable.id }}">
								{{equipment.type.name}}
							</router-link>
						</td>
						<td>
							{{equipment.model.name}}
						</td>
						<td>
							{{equipment.brand.name}}
						</td>
						<td>
							{{equipment.loanable.state.description}}
						</td>

					</tr>
				</table>
				<span class="text-muted">
					Resultados desde {{page.from}} hasta {{page.to}}
				</span>
				<nav aria-label="Page navigation">
				  <ul class="pagination">
				    <li>
				      	<router-link  :to="{ name: 'equipo-audiovisual', params: { page: 1 }}" aria-label="Previous">
				        	<span aria-hidden="true">&laquo;</span>
						</router-link>
				    </li>
				    <li v-for="index in page.last_page">
				    	<router-link  :to="{ name: 'equipo-audiovisual', params: { page: index }}">
							{{index}}
						</router-link>
				    </li>
				    <li>
				    	<router-link  :to="{ name: 'equipo-audiovisual', params: { page: page.last_page }}"  aria-label="Next">
							<span aria-hidden="true">&raquo;</span>
						</router-link>
				    </li>
				  </ul>
				</nav>
			</div>
		</div>
	`,
	data: function () {
		return {
			pageIndex: this.$route.params.pages,
			page: {},
			audiovisual_equipment_managment: audiovisualLoad(this)
		}
	},
	methods:{
	  	loading: function() {
			audiovisualLoad(this);
	  	}
  	},
  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	}
}

const AudiovisualEquipmentPanel = {
	template: `
		<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"  :listing-id="audiovisual_equipment_panel">
			<div class="well row">
				<h3>
					Panel de equipo
				</h3>
				<div class="col-xs-12 col-md-6">
					<div class="input-group has-default">
						<span id="user" class="input-group-addon">
							<i aria-hidden="true" class="fa fa-barcode"></i>
						</span>
						<input autofocus="autofocus" type="text" placeholder="Código de barras" aria-describedby="user" class="form-control">
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="input-group has-default">
						<!--<input style="display: none" autofocus="autofocus" type="text" placeholder="Nombre" aria-describedby="user" class="form-control">-->
						<select name="" id="" class="form-control" v-model="audiovisual_data.type_id">
							<option value="" disabled selected="selected">Nombre</option>
							<option v-for="type in types" value="{{type.id}}">{{type.name}}</option>
						</select>
						<span id="user" class="input-group-addon">
							Nuevo <input type="checkbox" />
						</span>
					</div>
				</div>	
				<br /> <br /> <br />
				<div class="col-xs-12 col-md-6">
					<div class="input-group has-default">
						<span id="user" class="input-group-addon">
							Nuevo <input type="checkbox" />
						</span>
						<!--<input style="display: none" autofocus="autofocus" type="text" placeholder="Marca" aria-describedby="user" class="form-control">-->
						<select name="" id="" class="form-control">
							<option value="" disabled selected="selected"  v-model="audiovisual_data.brand_id">Marca</option>
							<option v-for="brand in brands" value="{{brand.id}}">{{brand.name}}</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="input-group has-default">
						<!--<input style="display: none" autofocus="autofocus" type="text" placeholder="Modelo" aria-describedby="user" class="form-control">-->
						<select name="" id="" class="form-control" v-model="audiovisual_data.model_id">
							<option value="" disabled selected="selected">Modelo</option>
							<option v-for="model in models" value="{{model.id}}">{{model.name}}</option>
						</select>
						<span id="user" class="input-group-addon">
							Nuevo <input type="checkbox" />
						</span>
					</div>
				</div>	
				<br /> <br /> <br />	
				<div class="col-xs-12 col-md-6">
					<!--<input style="display: none" autofocus="autofocus" type="text" id="identification" placeholder="Código de barras" aria-describedby="user" class="form-control">-->
					<select name="" id="" class="form-control">
						<option value="" disabled selected="selected">Estado</option>
						<option v-for="state in states" value="{{state.id}}"">{{state.description}}</option>
					</select>
				</div>	
				<br /> <br /> <br />	
				<div class="col-xs-12">
					<textarea name="" id="" cols="30" rows="10" class="form-control" placeholder="Notas"></textarea>
				</div>
				<br /> <br /> <br />	
				<div class="col-xs-12"><button style="margin-top: 10px;" class="btn btn-primary pull-right">
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar
				</button></div>
			</div>
		</div>
	`,
	data: function () {
		return {
			types: [],
			brands: [],
			models: [],
			states: [],
			audiovisual_data:{},
			audiovisual_id: this.$route.params.id,
			audiovisual_equipment_panel: audiovisualPanelLoad(this)
		}
	},
	methods:{
	  	loading: function() {
			audiovisualPanelLoad(this);
	  	}
  	},
  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	}
}


var user = getUser();
function getUser() {
	if(sessionStorage.user){
		return new User(JSON.parse(sessionStorage.user));
	}else{
		return new User();
	}
}


const UserComponent = {template: '#asd'};

const router = new VueRouter({
  	routes: [

	  { path: '/login', component: Login, meta: { requiresLogout: true } },
	  { path: '/prestamos', alias: '/', component: LoanPanel, meta: { requiresAuth: true } },
	  { path: '/equipo-audiovisual/:page', name: 'equipo-audiovisual', component: AudiovisualEquipmentManagement, meta: { requiresAuth: true } },
	  { path: '/equipo-audiovisual-panel/:id', name: 'equipo-audiovisual-panel', component: AudiovisualEquipmentPanel, meta: { requiresAuth: true } },
	  { 
	  	path: '/user/:id', 
	  	component: UserComponent,
	  	watch: {
		    '$route' (to, from) {
		      console.log('to', to, 'from', from);
		    }
		} 
	  }
	]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (!user.isLogged()) {
      next({
        path: '/login'
      })
    } else {
      next()
    }
  }else if(user.isLogged() && to.matched.some(record => record.meta.requiresLogout)){
  	next({
        path: '/prestamos'
    })
  } else {
    next() // make sure to always call next()!
  }
})

const head = new Vue({
	el: "head",
	data: {
		tab: "Biblioteca"
	}
})

const app = new Vue({
  router,
  data: {
  	user: user,
	modal:{
		title:'',
		message:'',
		action:'',
		isOpen: false
	}
  },
  methods:{
  	logout: function () {
  		var xhr = $.ajax({
			method: "POST",
			dataType: 'json',
			url: wss + "logout",
			data: {
				token: sessionStorage.getItem('token')
			}
		});

		xhr.done(function () {
			sessionStorage.removeItem('token');
			sessionStorage.removeItem('user');
			user.clear();
			toastr['success']('Sesión cerrada con exito :)');
			router.push('login');
		});

		xhr.fail(function () {
			toastr['error']('Ha ocurrido un error, la sesión continúa abierta');
		});
  	}
  }
}).$mount('#app');

function datepicker_init() {
	$('#datePicker').datepicker({
	    language: "es",
		maxViewMode: 2,
	    todayHighlight: true,
	    startDate: "yesterdays",
    	daysOfWeekDisabled: "0",
    	autoclose: true
	});
}
$(document).ready(function () {

	datepicker_init();

	$('#modal').on('hidden.bs.modal', function () {
	    app.modal.isOpen = false;
	});

	$('#modal').on('show.bs.modal', function () {
	    app.modal.isOpen = true;
	});
});

function getHours() {
	var hours = [];
	var date = new Date();
	for (var i = date.getHours(); i < 24; i++) {
		hours.push(i+":00");
		hours.push(i+":30");
	}
	return hours;
}

function getUserData(identification, parent) {
	var xhr = $.ajax({
		method: "POST",
		dataType: 'json',
		url: wss + "search-by-identification",
		data: { 
			token: sessionStorage.getItem('token'),
			identification: identification
		}
	});
	xhr.done(function( msg ) {
		console.log(msg);
		if(msg != null && msg != '' && typeof msg.id == "number"){
			var userTemp = new User(msg);
			var date = new Date();
			if(!userTemp.active){
				parent.searchUser.state = "default";
				message("El usuario " + parent.user.identification + " a sido bloqueado por un administrador del sistema", "Usuario bloqueado")
			}else if(userTemp.next_update_time > date.sqlFormat()){
				parent.searchUser.state = 'success';
				parent.user.autoFill(msg);
				$( "#barcode" ).focus();
				console.log('parent',parent)
				getCurrentLoans(parent);	
			}else{
				parent.searchUser.state = "default";
				message("Antes de hacer un prestamo al usuario " + parent.user.identification + ", debe hacer una actualzación de datos", "Actulizar usuario", "Actualizar");
			}
			
		}else{
			var id = parent.user.identification;
		   	toastr["error"]("Con la identificación: " + id, "No se encuentra en usuario");
			parent.user.clear();
			parent.currentLoans = [];
			parent.searchUser.state = 'error';
			setTimeout(function () {
				$("#identification").focus();
			},500);
		}
			/*var date = new Date();
			user = parent.user = msg;
			if(user.next_update_time > date.sqlFormat()){
				parent.searchUser.state = 'success';
				$( "#barcode" ).focus();
				getCurrentLoans(user.id);
			}else{

			}
		}else{
			parent.user.clear();
			parent.currentLoans = [];
			parent.searchUser.state = 'error';
			$("#identification").focus();
		}*/
	});
	xhr.fail(function (msg) {
		parent.user.clear();
		parent.searchUser.state = 'error';
		$("#identification").focus();
		message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg) {
		parent.searchUser.disabled = false;
	});
}

function getUserDataById(id, parent) {
	parent.searchUser.state = 'warning';
	parent.searchUser.disabled = true; 
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "users/"+id,
		data: {
			token: sessionStorage.getItem('token')
		}
	});
	xhr.done(function( msg ) {
		console.log(msg);
		if(msg != null && msg != ''){
			parent.user.autoFill(msg);
			parent.searchUser.state = 'success';
			parent.identification = msg.identity_card;
			getCurrentLoans(parent);
		}else{
			parent.user.clear();
			parent.currentLoans = [];
			parent.searchUser.state = 'error';
		}
	});
	xhr.fail(function (msg) {
		parent.user.clear();
		parent.searchUser.state = 'error';
		$("#identification").focus();
		message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg) {
		parent.searchUser.disabled = false;
	});
}

function closeModal() {
	$('#modal').modal('hide');
}
function message(message, title = "Mensaje", action="Ok", actionCallback=closeModal) {
	app.modal.title = title;
	app.modal.message = message;
	app.modal.action = action;
	$('#modal').modal('show');
	tabAnimation(app.modal.title);
	$('#modal-action').off();
	$('#modal-action').click(actionCallback);
	onEnter($("#modal-action"));
}

function tabAnimation(text, oldText = head.tab) {

	head.tab = "(1) " + text;
	setTimeout(function () {
		head.tab = oldText;
	}, 2000);
	setTimeout(function () {
		if(app.modal.isOpen){
			tabAnimation(text, oldText);
		}
	}, 4000);
	
}

function onEnter(element) {
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        element.click();
	    }
	});
}

function getCurrentLoans(parent) {
	var xhr = $.ajax({
	  	method: "POST",
        dataType: 'json',
	  	url: wss + "loan-by-id",
	  	data: { 
	  		id: parent.user.id,
	  		token: sessionStorage.getItem('token')
	  	}
	});
	xhr.done(function( msg ) {
	    console.log(msg);
    	if(msg != null && msg != ''){
	    	parent.currentLoans = msg;
	    }else{
	    	console.log("the  loans are empty");
	    }
	});
	xhr.fail(function (msg) {
	    //app.user.clear();
		//app.searchUser.state = 'error';
	    $("#identification").focus();
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg, state, asd) {
		//app.searchUser.disabled = false;
		console.log(msg, state, asd)
	});
}

function createLoan(app) {
	var xhr = $.ajax({
	  	method: "POST",
        dataType: 'json',
	  	url: wss + "loan",
	  	data: { 
	  		user_id: app.user.id,
	  		return_time: "2016-10-16 02:00:00",
	  		barcode: app.barcode
	  	}
	});
	xhr.done(function( msg ) {
	    console.log('msg',msg,'msg.loanable',msg.loanable);
    	app.currentLoans.push(msg);
    	app.barcode = '';
    	$( "#barcode" ).focus();
	});
	xhr.fail(function (msg) {
	   
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg, asd) {
		//app.searchUser.disabled = false;
		console.log('Always msg = ', msg, " asd = ", asd)
	});
}

function login(email, password) {
	var xhr = $.ajax({
	  	method: "GET",
        dataType: 'json',
	  	url: wss + "login",
	  	data: { 
	  		email: email,//'diegojopiedra@gmail.com',
	  		password: password// "1234"
	  	}
	});
	xhr.done(function( msg ) {
	    console.log(msg);
    	
	});
	xhr.fail(function (msg) {
	   
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});

}

function gets() {
	function myFunction(data) {
		console.log("callback data= ", data);
	}
	var xhr = $.ajax({
	  	method: "GET",
        dataType: 'json',
	  	url: wss + "gets",
	  	data: {},
	  	crossDomain: true,
    	contentType: 'application/json; charset=utf-8',
    	success: function (msg) {
    		console.log("Success = ", msg)
    	},
    	error: function (msg, error, desc) {
    		console.log("Error = ", msg, " error = ", error, " desc = ", desc)
    	}
	});
	/*xhr.done(function( msg ) {
	    console.log("OK = ", msg);
    	
	});
	xhr.fail(function (msg,a,b) {
	   console.log("Fail = ", msg, a, ' - ', b);
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});*/

}

function returnLaon(barcode) {
	var xhr = $.ajax({
	  	method: "POST",
        dataType: 'json',
	  	url: wss + "return-loan",
	  	data: { 
	  		barcode: barcode 
	  	}
	});
	xhr.done(function( msg ) {
	    console.log('return-loan',msg);
	   	for (var i = 0; i < app.currentLoans.length; i++) {
	   		var item = app.currentLoans[i];
	   		if(item.id == msg.id){
	   			app.currentLoans.splice(i, 1);
	   			ready = true;
	   		}
	   	}

	   	if(app.user.id == null){
	   		getUserDataById(msg.user_id);
	   	}
	});
	xhr.fail(function (msg) {
	   
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg, asd) {
		//app.searchUser.disabled = false;
		console.log('Always msg = ', msg, " asd = ", asd)
	});
}

function automaticLoan(parent) {
	parent.loan.disabled = true;
	var xhr = $.ajax({
	  	method: "POST",
        dataType: 'json',
	  	url: wss + "automatic-loan",
	  	data: { 
	  		user_id: parent.user.id,
	  		return_time: "2016-10-16 02:00:00",
	  		barcode: parent.barcode,
	  		token: sessionStorage.getItem("token")
	  	},
	  	context: parent
	});

	xhr.done(function( msg ) {
	    console.log('user_return_time', msg.user_return_time, 'return_time', msg.return_time);
	    
		parent.loan.disabled = false;
	    if(msg.response != null && msg.response == "empty"){
	    	message("No se encuentra este código de barras en el sistema");
	    }else  if(msg.response != null && msg.response == "not available"){
	    	message("El activo no se puede prestar en este momento");
	    }else if(msg.user_return_time == null){
	    	toastr["success"]("Placa: " + msg.loanable.barcode, "Préstamo exitoso");
	    	parent.currentLoans.push(msg);
	    }else if(msg.user_return_time <= msg.return_time){ 
		   	toastr["success"]("Placa: " + msg.loanable.barcode, "Devolución exitosa")
	    	for (var i = 0; i < parent.currentLoans.length; i++) {
		   		var item = parent.currentLoans[i];
		   		if(item.id == msg.id){
		   			parent.currentLoans.splice(i, 1);
		   		}
		   	}
	    }else{
		   	toastr["error"]("Placa: " + msg.loanable.barcode, "Devolución tardría")
	    	for (var i = 0; i < parent.currentLoans.length; i++) {
		   		var item = parent.currentLoans[i];
		   		if(item.id == msg.id){
		   			parent.currentLoans.splice(i, 1);
		   		}
		   	}
	    }
	    parent.barcode = '';
	    $( "#barcode" ).focus();

	   	if(parent.user.id == null){
	   		getUserDataById(msg.user_id, this);
	   	}else if(parent.user.id != msg.user_id){
	   		getUserDataById(msg.user_id, this);
	   		toastr["info"]("Se ha cambiado de usuario para realizar la operación")
	   	}

	    setTimeout(function () {
	    	$( "#barcode" ).focus();
	    },500);
	});
	xhr.fail(function (msg) {
	  
	});
	xhr.always(function (msg, asd) {
		console.log('Always automatic-loan = ', msg, " asd = ", asd)
	});
}

Date.prototype.sqlFormat = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(), !mm[1] && '-', mm, !dd[1] && '-', dd].join(''); // padding
};


function User(json) {
	this.id = (json && json.id)?json.id:null;
	this.name = (json && json.name)?json.name:null;
	this.last_name = (json && json.last_name)?json.last_name:null;
	this.email = (json && json.email)?json.email:null;
	this.identity_card = (json && json.identity_card)?json.identity_card:null;
	this.birthdate = (json && json.birthdate)?json.birthdate:null;
	this.home_phone = (json && json.home_phone)?json.home_phone:null;
	this.cell_phone = (json && json.cell_phone)?json.cell_phone:null;
	this.next_update_time = (json && json.next_update_time)?json.next_update_time:null;
	this.active = (json && json.active)?json.active:null;
	this.role_id = (json && json.role_id)?json.role_id:null;
	this.student = (json && json.student)?json.student:null;
	this.identification = (json && json.identification)?json.identification:null;
	this.role = (json && json.role)?json.role:null;

	this.isLogged = function () {
		return (this.id != null && this.id != 0);
	}

	this.autoFill = function (obj) {
		for(property in this){
			if(obj.hasOwnProperty(property) && typeof this[property] != 'function'){
				this[property] = obj[property];
			}
		}
	}

	this.clear = function () {
		for(property in this){
			if(typeof this[property] != 'function' && property != 'ajaxFillBy')
				this[property] = null;
		}
	}

	this.ajaxFillBy = {
		parent: this,
		identification: function (identification) {
			var xhr = $.ajax({
				method: "POST",
				dataType: 'json',
				url: wss + "search-by-identification",
				data: { 
					identification: identification
				},
				context: this.parent
			});

			xhr.done(function (response) {
				this.autoFill(response);
			});
		}
	}
}

function Prueba(){
	// $.ajax({
	// 	url: "loginPrueba",
	// 	dataType: "json",
	// 	type: "POST",
	// 	data: {"email":"diegojopiedra@gmail.com","password":"1234"},
	// 	success: function (data) {
	// 		alert("user created successfully")
	// 	}
	// });

	var xhr = $.ajax({
	  	method: "GET",
        dataType: 'json',
	  	url: wss + "loginPrueba",
	  	data: { 
	  		email:'diegojopiedra@gmail.com',
	  		password: "1234",
	  		//token: 'eyJpdiI6IlwvWmJZM2dqQ3F3UkhMTU5cL0k3Z2psQT09IiwidmFsdWUiOiJCaWxoMEJRTjdTa0djTWdcL2tCVml1QzBabU5xYjY4NEM4UXJhWXNxQ2JPSDFacGozOGNQM1dkRTFqd0dpQzZNeVBQVmNxUGx2NEVVMDllNTAydlY3U1E9PSIsIm1hYyI6IjVjMGZmN2I2NDY4NzVmYTc0MzYyMGZiYzI5MmNlZTYzZGY0ODUxNDIwYTRiYmRmN2RiMTNlODZhNzliMmY3YzEifQ'
	  	}
	});
	xhr.done(function( msg ) {
	    console.log(msg);
    	
	});
	xhr.fail(function (msg) {
	   
	    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
}

function audiovisualLoad(parent) {
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-equipment",
		data: {
			page: parent.$route.params.page,
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	xhr.done(function (msg) {
		//console.log(parent);
		parent.page = msg;
	});

	xhr.fail(function () {
		//toastr['error']('Ha ocurrido un error, la sesión continúa abierta');
	});
}

function audiovisualPanelLoad(parent) {
	var types = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "type",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	types.done(function (msg) {
		console.log(msg);
		parent.types = msg;
	});

	types.fail(function () {
		toastr['error']('Al cargar los nombres de los equipos', 'Ha ocurrido un error');
	});

	var brands = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "brand",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	brands.done(function (msg) {
		console.log(msg);
		parent.brands = msg;
	});

	brands.fail(function () {
		toastr['error']('Al cargar las marcas de los equipos', 'Ha ocurrido un error');
	});

	var models = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "model",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	models.done(function (msg) {
		console.log(msg);
		parent.models = msg;
	});

	models.fail(function () {
		toastr['error']('Al cargar los modelos de los equipos', 'Ha ocurrido un error');
	});

	var state = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "state",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	state.done(function (msg) {
		console.log(msg);
		parent.states = msg;
	});

	state.fail(function () {
		toastr['error']('Al cargar los estados de los equipos', 'Ha ocurrido un error');
	});

		console.log('parent',parent);
	var audiovisual = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-equipment/" + parent.$route.params.id,
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	audiovisual.done(function (msg) {
		console.log('msg', msg);
		this.audiovisual_data = msg;
	});

	audiovisual.fail(function () {
		toastr['error']('Al cargar los datos del audiovisual', 'Ha ocurrido un error');
	});

}