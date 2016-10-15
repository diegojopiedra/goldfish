const wss = "http://localhost:8000/";
const Prestamos = { template: '<div>prestamos</div>' };
const User = {template: '<div>User {{ $route.params.id }}</div>'};

const router = new VueRouter({
  	routes: [
	  { path: '/prestamos', component: Prestamos },
	  { 
	  	path: '/user/:id', 
	  	component: User,
	  	watch: {
		    '$route' (to, from) {
		      console.log('to', to, 'from', from);
		    }
		} 
	  }
	]
});

const app = new Vue({
  router,
  data: {
  	identification: '',
  	auto: 'true',
  	searchUser:{
  		state: 'default',
  		disabled: false,
  	},
  	user:{},
  	modal:{
  		title:'',
  		message:'',
  		action:''
  	}
  },
  methods:{
  	clearUser: function () {
  		this.user = {};	
  		this.identification = '';
  		this.searchUser.state = 'default';
  	},
  	getUserData: function () {
  		this.searchUser.state = 'warning';
  		this.searchUser.disabled = true; 
  		var xhr = $.ajax({
		  	method: "POST",
		  	url: wss + "search-by-identification",
		  	data: { 
		  		identification: this.identification
		  	}
		});
		xhr.done(function( msg ) {
		    console.log(msg);
	    	if(msg != null && msg != ''){
		    	app.user = msg;
				app.searchUser.state = 'success';
		    	$( "#barcode" ).focus();
		    }else{
		    	app.user = {};
		    	app.searchUser.state = 'error';
		    	$("#identification").focus();
		    }
		});
		xhr.fail(function (msg) {
		    app.user = {};
			app.searchUser.state = 'error';
		    $("#identification").focus();
		    message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
		});
		xhr.always(function (msg) {
  			app.searchUser.disabled = false;
		});
  	}
  }
}).$mount('#app');
$(document).ready(function () {
	$("#identification").focus();
});

function closeModal() {
	$('#modal').modal('hide');
}
function message(message, title = "Mensaje", action="Ok", actionCallback=closeModal) {
	app.modal.title = title;
	app.modal.message = message;
	app.modal.action = action;
	$('#modal').modal('show');
	$('#modal-action').off();
	$('#modal-action').click(actionCallback);
	onEnter($("#modal-action"));
}

function onEnter(element) {
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        element.click();
	    }
	});
}