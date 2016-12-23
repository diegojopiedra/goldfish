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