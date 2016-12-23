const Login = {
	template: '#loginTemplate',
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