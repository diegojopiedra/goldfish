const wss = "https://goldfish-juancub.c9users.io/public/index.php/";
Vue.config.debug = true

String.prototype.capitalizeFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

Date.prototype.sqlFormat = function(full) {
  var mm = ('00' + (this.getMonth() + 1)).slice(-2); // getMonth() is zero-based
  var dd = ('00' + this.getDate()).slice(-2);
	
	var time = (full)?" " + ('00' + this.getHours()).slice(-2) + ':' + ('00' + this.getMinutes()).slice(-2) + ':' + ('00' + this.getSeconds()).slice(-2):"";
  return ([this.getFullYear(),'-', mm, '-', dd].join('')) + time; // paddignfa
};

Date.prototype.addHours = function(h) {    
   this.setTime(this.getTime() + (h*60*60*1000)); 
   return this;   
}

function sqlToJavaScriptDate(sql) {
	var t = sql.split(/[- :]/);
	return new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
}

function dateToSQL(date){
	var list = date.split("/");
	list.reverse();
	return ('00' + list[0]).slice(-4) + "-" + ('00' +list[1]).slice(-2) + "-" + ('00' +list[2]).slice(-2);
}

Date.prototype.visualFormat = function() {
  var mm = ('00' + (this.getMonth() + 1)).slice(-2); // getMonth() is zero-based
  var dd = ('00' + this.getDate()).slice(-2);

  return [dd, '/', mm, '/', this.getFullYear()].join(''); // padding
};

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

const LoanPanel = { 
	template: "#loanTemplate",
	data: function () {
		return {
			textTime: (localStorage.getItem("textTime") != null)?(localStorage.getItem("textTime") === 'true'):true,
			havePenalty: '',
		  	auto: 'true',
		  	searchUser:{
		  		state: 'default',
		  		disabled: false,
		  	},
		  	loan:{
		  		state: 'default',
		  		disabled: false,
		  	},
		  	user: new User({identification: sessionStorage.getItem('searchIdentification')}),
		  	currentLoans:[],
		  	barcode: '',
		  	general_cofiguration:{},
		  	return_time: (new Date()).visualFormat(),
		  	return_hour: '',
		  	date: (new Date()).sqlFormat(true),
		  	init: initLoanPanel(this)
		  	
	  };
	},
  	methods:{
  		moment: function (data) {
  			return moment(data);
  		},
  		saReturn: function () {
  			var arr = this.general_cofiguration.saturday_hour_closing.split(':');
  			return arr[0] + ':' + arr[1];
  		},
  		weReturn: function () {
  			var arr = this.general_cofiguration.closing_hour_week.split(':');
  			return arr[0] + ':' + arr[1];
  		},
		hours: function () {
			return getHours(this.general_cofiguration, this.return_time);
		},
	  	createLoan: function() {
	  		automaticLoan(this);
	  	},
	  	clearUser: function () {
	  		sessionStorage.removeItem('searchIdentification');
	  		this.user.clear();
	  		this.searchUser.state = 'default';
	  		this.currentLoans = [];
	  		this.auto = 'true';
	  		this.return_time = (new Date()).visualFormat();
	  		
  				console.log("/************ return_hour - 4 **********************/");
	  		if((new Date()).getDay() == 6){
				var array = this.general_cofiguration.saturday_hour_closing.split(":");
				array.pop();
				this.return_hour = array.join(":");
			}else{
				var array = this.general_cofiguration.closing_hour_week.split(":");
				array.pop();
				this.return_hour = array.join(":");
			}
			this.barcode = "";
	  		$("#identification").focus();
	  	},
	  	getUserData: function () {
			this.searchUser.state = 'warning';
			this.searchUser.disabled = true; 
	  		getUserData(this.user.identification, this);
	  	},
	  	returns: function (barcode) {
	  		this.barcode = barcode;
	  		this.createLoan();
	  	}
  	},
  	watch:{
  		barcode: function () {
  			this.barcode = this.barcode.toUpperCase();
  		},
  		auto: function (val) {
  			if(val){
  				var date = new Date();
  				this.return_time = date.visualFormat();
  				console.log("/************ return_hour - 1 **********************/");
  				this.return_hour = (date.getDay() == 6)?this.saReturn():this.weReturn();
  			}
  		},
  		return_hour:function (newVal, oldVal) {
  			
  				console.log("/************ return_hour - 2 **********************/");
  				console.log('newVal = ', newVal, 'oldVal = ', oldVal);
  		/*	if(newVal == null || newVal == ''){
  				this.return_hour = oldVal;
  			}*/
  		},
  		textTime: function (val){
  			localStorage.setItem("textTime", val);
  		},
  		user: function (usr) {
  			console.log("searchUser");
  			var usrString = JSON.stringify(usr);
  			sessionStorage.setItem("searchUser", usrString);
  		}
  	}

};

const Login = {
	template: '#loginTemplate',
	data: function () {
		return {
		  	email: 'vanessa.calderon1@ucrso.info',
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
					var date = new Date();
					var next = date.addHours(4);
					var expireToken = next.sqlFormat(true);
					sessionStorage.setItem('expire', expireToken); 
					setTimeout(function () {
						logout();
					}, (4*59*60*1000));
					toastr["success"]("Hola " + msg.user.name);
					this.email = "";
					user.autoFill(msg.user);
					router.push('prestamos');
				}else{
					toastr["error"](msg.error);
				}
			});
			xhr.fail(function (msg) {
				toastr["error"]("Se ha presentador un error de conexión");
			});
			xhr.always(function (msg) {
				console.log(this);
				this.password = "";
				this.loagin = false;
			});
  		}
	}
}

const LoanablePanel = {
	template: '#loanableTemplate',
	data: function () {
		return {
			type: 'ss',
			scrollPosition: 0,
			scrollHeight: 0,
			clientHeight: 0,
			brands: [],
			models: [],
			types: [],
			states: [],
			loanable: {},
		  	init: initLoanablePanel(this)
		}
	},
	methods:{
		moment: function (data) {
  			return moment(data);
  		},
  		handleScroll: function(e) {
            var currentScrollPosition = e.srcElement.scrollTop;
            this.scrollPosition = currentScrollPosition;
            var scrollHeight = this.scrollHeight = e.srcElement.scrollHeight;
            var clientHeight = this.clientHeight = e.srcElement.clientHeight;
            
            if(clientHeight+currentScrollPosition >= (scrollHeight-20)){
            	console.log('Cargar más');
            }
		}
	},
	watch: {
		$route: function () {
			initLoanablePanel(this);
		},
		type: function (newVal, oldVal) {
			
		},
		loanable: function (newVal, oldVal) {
			console.log(newVal)
		},
		type: function (newVal, oldVal) {
			
		},
		loanable: function (newVal, oldVal) {
			console.log('loanable newVal = ', newVal, ', oldVal = ', oldVal);
		}
	}
}

const ConfigManager = {
	template: "#configTemplate",
	data: function () {
		return {
		
		}
	},
		methods:{
	  	loading: function() {
			
	  	}
  	},
	watch: {
		$route: function(){
			this.loanding()
		}
	},
}

const SearchPanel = {
	template: "#searchTemplate",
	data: function() {
		return {
			paginate: {},
			user: new User(JSON.parse(sessionStorage.getItem(('user')))),
			resultsPerPage: (localStorage.getItem("resultsPerPage") != null)?parseInt(localStorage.getItem("resultsPerPage")):20,
			types:[
				{
					name: "Equipo audiovisual",
					include: true,
					asParameter: "audiovisual-equipment"
				},
				{
					name: "Libro",
					include: true,
					asParameter: "book"
				},
				{
					name: "Publicación periódica",
					include: true,
					asParameter: "periodic-publication"
				},
				{
					name: "Material cartográfico",
					include: true,
					asParameter: "cartographic-material"
				},
				{
					name: "Material audiovisual",
					include: true,
					asParameter: "audiovisual-material"
				},
				{
					name: "Objeto tridimensional",
					include: true,
					asParameter: "threeDimensional-object"
				}
			],
			states:[
				{
					name: "Disponible",
					include: true,
					asParameter: "available",
					quantity: 0,
					color: '#73a839'
				},
				{
					name: "Prestado",
					include: true,
					asParameter: "borrowed",
					quantity: 0,
					color: '#2fa4e7'
				},
				{
					name: "Fuera de servicio",
					include: true,
					asParameter: "out-of-service",
					quantity: 0,
					color: '#999999'
				},
				{
					name: "En reparación",
					include: true,
					asParameter: "in-repair",
					quantity: 0,
					color: '#999999'
				},
				{
					name: "Devolución retrasada",
					include: true,
					asParameter: "not-returned",
					quantity: 0,
					color: '#d9534f'
				},
			],
			order:{
				index: 'barcode',
				highestToLowest: true
			},
			view: (localStorage.getItem("searchView") != null)?localStorage.getItem("searchView"):'list',
			initSearchPanel: initSearchPanel(this)
		}
	},
	methods:{
		deleteLoanable: function (loanable) {
			message("Tome en cuenta que si borrar el articulo " + loanable.barcode + " (" + loanable.named + ") perderá también su historial de prestamos", "¿Realmente desea borrar " + loanable.barcode + "?" , "Borrar", function() {
				closeModal();
				deleteLoanable(loanable.id, this);
				//router.push('usuario/' + msg.id);
			});
		},
		search: function() {
			initSearchPanel(this)
		},
		reorder: function (index) {
			if (index == this.order.index){
				this.order.highestToLowest = !this.order.highestToLowest;
			} else {
				this.order.index = index;
				this.order.highestToLowest = true;
			}
		}
	},
	watch: {
		$route: function(news){
			this.paginate.data = null;
			initSearchPanel(this);
		},
		view: function(view){
			localStorage.setItem("searchView", view);
		},
		resultsPerPage: function (value) {
			localStorage.setItem("resultsPerPage", value);
			initSearchPanel(this);
		},
	},
}

const Statistics = { 
	template: "#statisticsTemplate",
	data: function () {
		var f=new Date();
		var d=new Date();
		return {
			equipName:'',
		  	type_id:'',
		  	date1_stats: f.getDate() + "-" + (f.getMonth()+1)+ "-" + f.getFullYear(),
		  	date2_stats: d.getDate() + "-" + (d.getMonth()+1)+ "-" + d.getFullYear(),
		  	yearAmountLoans:'',
		  	monthAmountLoans:'',
		  	dayAmountLoans:'',
		  	yearAmountPendings:'',
		  	monthAmountPendings:'',
		  	dayAmountPendings:'',
		  	cant_prestv:'',
		  	cant_pendv:'',
		  	types: [],
		  	statistics_data:{},
			statistics_panel: statisticsTypes(this)
	  }
	},
  	methods:{
  	    createStats: function() { // se llama desde el index
  		getLoansByDate(this);
  		getPendingsByDate(this);//se llama al q envia los datos desde aqui
  		},
  	
	  	loading: function() {
	  		statisticsTypes(this);
	  	  },
	  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	  }
  	}
}

const Dashboard = {
	template: "#dashboardPanel",
	data: function(){
		return {
			multas: [],
			init: intiDashboard(this)
		}
	}
}
  	
const AllUsersManagement = { 
	template: "#allUsersManagementTemplate",
	data: function () {
		return {
			pageIndex: this.$route.params.pages,
			page: {},
			users_managment: usersLoad(this)
		}
	},
  	methods:{
  		
	  	loading: function() {
	  		usersLoad(this);
	  	  }
	  	},

	  	watch: {
  		$route: function () {
  			this.page.data = [];
  			this.loading()
  		}
  	  }
  	}
  	
const SingleUser= { 
	template: "#singleUserTemplate",
	data: function () {
		return {
			roles: [],
			states: [],
			user_data:{},
			date: new Date(),
			user_id: this.$route.params.id,
			single_user_panel: singleUserPanelLoad(this)
		}
	},
	
  	methods:{
	  	loading: function() {
			singleUserPanelLoad(this);
	  	},
	  	save: function () {
	  		if(this.user_data.id == ""){
	  			var xhr = $.ajax({
	  				method: "POST",
	  				dataType: "json",
	  				url: wss + "users",
	  				data:{
	  					token: sessionStorage.getItem('token'),
	  					
	  					name: this.user_data.name,
	  					last_name: this.user_data.last_name,
	  					role_id: this.user_data.role.id,
	  					home_phone: this.user_data.home_phone,
	  					identity_card: this.user_data.identity_card,
	  					next_update_time: this.user_data.next_update_time,
	  					email: this.user_data.email,
	  					cell_phone: this.user_data.cell_phone,
	  					direction: this.user_data.direction,
	  					password: this.user_data.password,
	  					active: this.user_data.active
	  				}
	  			});
	  		}else{
	  			var xhr = $.ajax({
	  			method: "PUT",
	  			dataType: "json",
	  			url: wss + "users/"+ this.$route.params.id,
	  			data: {
	  				token: sessionStorage.getItem('token'),
	  				
	  				name: this.user_data.name,
	  				last_name: this.user_data.last_name,
	  				role_id: this.user_data.role.id,
	  				home_phone: this.user_data.home_phone,
	  				identity_card: this.user_data.identity_card,
	  				next_update_time: this.user_data.next_update_time,
	  				email: this.user_data.email,
	  				cell_phone: this.user_data.cell_phone,
	  				direction: this.user_data.direction,
	  				password: this.user_data.password,
	  				active: this.user_data.active
	  			}
	  			});
	  		}
	  	}
  	},
  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	  }
  	}
  	
const Loan = {
	template: '#loanDetails',
	data: function () {
		return {
			loan: null,
			init: initLoanPage(this)
		}
	},
	methods: {
		moment: function (data) {
  			return moment(data);
  		},
	}
}
  	
  	/***/
const AudiovisualMaterialManagment= { 
	template: "#audiovisualMaterialManagementTemplate",
	data: function () {
         return {
			pageIndex: this.$route.params.pages,
			page: {},
			audiovisual_material_management: audiovisualMaterialsLoad(this)
		}
	},
  	methods:{
	  	loading: function() {
	  		audiovisualMaterialsLoad(this);
	  	  }
	  	},
	  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	  }
  	}
  	
const AudiovisualMaterialPanel= { 
	template: "#audiovisualMaterialPanelTemplate",
	data: function () {
		return {
			editorials: [],
			audiovisual_formats: [],
			audiovisual_types: [],
			audiovisual_material_data:{},
			audiovisual_material_id: this.$route.params.id,
			audiovisual_material_panel: audiovisualMaterialPanelLoad(this)
		}
	},
  	methods:{
	  	loading: function() {
	  		audiovisualMaterialPanelLoad(this);
	  	  }
	  	},

	  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	  }
  	}
  	
const ThreeDimensionalObjectManagement = {
	template: "#threeDimensionalObjectManagementTemplate",
	data: function () {
		return {
			pageIndex: this.$route.params.pages,
			page:{},
			three_dimensional_management: threeDimensionalLoad(this)
		}
	},
	methods:{
	  	loading: function() {
			threeDimensionalLoad(this);
	  	}
  	},
  	watch: {
  		$route: function () {
  			this.loading()
  		}
  	}
}

const ThreeDimensionalObjectPanel= { 
	template: "#singleThreeDimensionalTemplate",
	data: function () {
		return {
			bibliographic_materials: [],
			editorials: [],
			keyWords: [],
			three_dimensional_data:{},
			three_dimensional_id: this.$route.params.id,
			three_dimensional_panel: threeDimensionalObjectPanelLoad(this)
		}
	},
  	methods:{
	  	loading: function() {
	  		threeDimensionalObjectPanelLoad(this)
	  	  }
	  	},

	  	watch: {
  		$route: function () {
  			this.loading()     
  		}
  	  }
  	}
  	
const DayPendingLoans = {
	template:"#dayPendingsLoansTemplate",
	data: function () {
		return {
			loan_data:{}
			
		}
	},
	methods:{ 
	},
	watch: {
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

	  { path: '/login', alias: '/', component: Login, meta: { requiresLogout: true } },
	  { path: '/generalConfig', component: ConfigManager, meta: { requiresAuth: true } },
	  { path: '/prestamos', component: LoanPanel, meta: { requiresAuth: true } },
	  { path: '/estadisticas', name: 'estadisticas', component: Statistics, meta: {requiresAuth: true}},
	  { path: '/gestion/:page', name:'gestion', component: SearchPanel, meta: {requiresAuth: true}},
	  { path: '/personas/:page', name: 'personas', component: AllUsersManagement, meta: {requiresAuth: true}},
	  { path: '/usuario/:id', name: 'usuario', component: SingleUser, meta: {requiresAuth: true}},
	  { path: '/objeto-tridimensional/:page', name: 'objeto-tridimensional', component: ThreeDimensionalObjectManagement, meta: { requiresAuth: true } },
	  { path: '/objeto-tridimensional-panel/:id', name: 'objeto-tridimensional-panel', component: ThreeDimensionalObjectPanel, meta: { requiresAuth: true } },
	  { path: '/material-audiovisual-panel/:id', name: 'material-audiovisual-panel', component: AudiovisualMaterialPanel, meta: {requiresAuth: true}},
	  { path: '/material-audiovisual/:page', name: 'material-audiovisual', component: AudiovisualMaterialManagment, meta: { requiresAuth: true } },
	  { path: '/administrador', name: 'administrador', component: Dashboard, meta: { requiresAuth: true } },
	  { path: '/prestamo/:id', name: 'prestamo', component: Loan, meta: { requiresAuth: true } },
	  { path: '/activo/:id', name: 'activo', component: LoanablePanel, meta: { requiresAuth: true } },
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
  components: {
      vSelect: VueStrap.select
    },
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
  		logout();
  	}
  }
}).$mount('#app');

function logout() {
		var xhr = $.ajax({
			method: "POST",
			dataType: 'json',
			url: wss + "logout",
			data: {
				token: sessionStorage.getItem('token')
			}
		});

		xhr.done(function () {
			sessionStorage.removeItem('searchIdentification');
			sessionStorage.removeItem('token');
			sessionStorage.removeItem('user');
			sessionStorage.removeItem('expire'); 
			user.clear();
			toastr['success']('Sesión cerrada con exito :)');
			router.push('login');
			
		});

		xhr.fail(function () {
			toastr['error']('Ha ocurrido un error, la sesión continúa abierta');
		});
}

function getLoansByDate(parent) { //se llama desde el const
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "get-loans-by-date",
		data: { //datos que se envian
			type: parent.statistics_data,
			date1_stats: parent.date1_stats,
			date2_stats: parent.date2_stats,
			//today: new Date("d-m-Y"),
			token: sessionStorage.getItem('token')
		},
		context:parent
	});
	xhr.done(function( msg ) {
		console.log(msg);
		if(msg != null && msg != ''){
			//message('Cantidad por año: ' + msg.amountYear)
			parent.yearAmountLoans=msg.amountYear;
			parent.monthAmountLoans=msg.amountMonth;
			parent.dayAmountLoans=msg.amountDay;
			parent.cant_prestv=msg.cant_prestv;
		}else{
			message('No hay datos de estadísticas')
		}
	});
	xhr.fail(function (msg) {
		console.log(msg);
		//$("#identification").focus();
		message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg) {
		//parent.searchUser.disabled = false;
	});
}

function getPendingsByDate(parent) { //se llama desde el const
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "get-pendings-by-date",
		data: { //datos que se envian
			type: parent.statistics_data,
			date1_stats: parent.date1_stats,
			date2_stats: parent.date2_stats,
			//today: new Date("d-m-Y"),
			token: sessionStorage.getItem('token')
		},
		context:parent
	});
	xhr.done(function( msg ) {
		console.log(msg);
		if(msg != null && msg != ''){
			//message('Cantidad por año: ' + msg.amountYear)
			parent.yearAmountPendings=msg.amountYear;
			parent.monthAmountPendings=msg.amountMonth;
			parent.dayAmountPendings=msg.amountDay;
			parent.cant_pendv=msg.cant_pendv;
			
		}else{
			message('No hay datos de estadísticas')
		}
	});
	xhr.fail(function (msg) {
		console.log(msg);
		//$("#identification").focus();
		message("Existe un error de comunicación con el servidor, por favor reintente la ultima acción. Si el problema persiste solicite soporte técnico", "¡Ha ocurrido un inconveniente!");
	});
	xhr.always(function (msg) {
		//parent.searchUser.disabled = false;
	});
}

function datepicker_init(parent) {
	console.log('datepicker_init')
	$('#datePicker').datepicker({
	    language: "es",
		maxViewMode: 2,
	    todayHighlight: true,
	    startDate: "yesterdays",
    	daysOfWeekDisabled: "0",
    	autoclose: true,
    	todayBtn: "linked",
	});
	
	$('#datePickerStats').datepicker({
		format:'yyyy-mm-dd',
	    language: "es",
		maxViewMode: 2,
	    todayHighlight: true,
    	daysOfWeekDisabled: "0",
    	autoclose: true
	});
	
	$('#datePicker').on('change focusout', function (evn) {
		console.log('datePicker -> change focusout,  $(this).val() = ',  $(this).val());
		if(parent != null){
			parent.return_time = $(this).val();
			parent.return_hour = (date.getDay() == 6)?parent.saReturn():parent.weReturn();
		}
	});
	
}

$(document).ready(function () {

	datepicker_init();
	
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-bottom-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	$('#modal').on('hidden.bs.modal', function () {
	    app.modal.isOpen = false;
	});

	$('#modal').on('show.bs.modal', function () {
	    app.modal.isOpen = true;
	});
	
	if(sessionStorage.getItem('expire') != null){
		var t = sessionStorage.getItem('expire').split(/[- :]/);
		var d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
		setTimeout(function () {
			logout();
		}, (4*59*60*1000));
	}
	moment.locale('es');
	moment.locale('es', {
	    calendar : {
	        lastDay : '[Ayer a las] h:mm a',
	        sameDay : '[Hoy a las] h:mm a',
	        nextDay : '[Mañana a las] h:mm a',
	        lastWeek : '[el] dddd [pasado a la] h:mm a',
	        nextWeek : 'dddd [a la] h:mm a',
	        sameElse : 'L'
	    }
	});
});

function getHours(config, day) {
	var hours = [];
	
	if(day != null && day.trim() != '' && config.saturday_hour_opening != null){
		var d = day.split('/'); //Example 28/12/2016
		var date = new Date(d[2], (d[1]-1), d[0]); //Need year month day
		var today = new Date();
		
		if(date.getDay() == 6){//Saturday
			var initHour = config.saturday_hour_opening.split(':')[0];
			var initMinute = config.saturday_hour_opening.split(':')[1];
			
			var endHour = config.saturday_hour_closing.split(':')[0];
			var endMinute = config.saturday_hour_closing.split(':')[1];
		}else{
			var initHour = config.opening_hour_week.split(':')[0];
			var initMinute = config.opening_hour_week.split(':')[1];
			
			var endHour = config.closing_hour_week.split(':')[0];
			var endMinute = config.closing_hour_week.split(':')[1];
		}
		
		
		var isToday = (date.getFullYear() == today.getFullYear()) && (date.getMonth() == today.getMonth()) && (date.getDate() == today.getDate());
		
		if(isToday && today.getHours() > initHour){
			initHour = today.getHours();
			initMinute = today.getMinutes();
		}
		
		for(var i = initHour; i <= endHour; i++){
			for(var j = ((isToday && i == initHour)?(initMinute-(initMinute%15))+15:0); j<60; j+=15){
				hours.push({
					militar: i + ':' + ((j==0)?'00':j),
					civil: ((i>12)?i-12:i) + ':' + ((j==0)?'00':j) + ((i>11)?' pm':" am"),
				});
			}
		}
	}
	
	return hours;
}

function getUserData(identification, parent) {
	if(identification != null && identification.trim() != ''){
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
			sessionStorage.setItem('searchIdentification', identification);
			console.log(msg);
			if(msg != null && msg != '' && typeof msg.id == "number"){
				parent.havePenalty = "El usuario se encuentra multado";
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
					message("Antes de hacer un prestamo al usuario " + parent.user.identification + " - " + msg.name + " " + msg.last_name + ", debe hacer una actualzación de datos", "Actulizar usuario", "Actualizar", function() {
						closeModal();
						router.push('usuario/' + msg.id);
					});
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
	}else{
		parent.searchUser.state = 'default';
		parent.searchUser.disabled = false;
		$("#identification").focus();
	}
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
	$(document).unbind( "keypress" );
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	        element.click();
	    }
	});
}

function getCurrentLoans(parent) {
	parent.currentLoans = [];
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
	  		email: email,
	  		password: password
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
	parent.barcode = parent.barcode.trim();
	if(parent.barcode != ""){
		parent.loan.disabled = true;
		var xhr = $.ajax({
		  	method: "POST",
	        dataType: 'json',
		  	url: wss + "automatic-loan",
		  	data: { 
		  		user_id: parent.user.id,
		  		return_time: dateToSQL(parent.return_time)  + " " + parent.return_hour + ':00',
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
		    }else  if(msg.response != null && msg.response == "not available for penalty"){
		    	message("No se puede realizar este prestamo porque el usuario posee una multa temporal");
		    }else  if(msg.response != null && msg.response == "incorrect user"){
		    	message("El artículo que está tratando de prestar, se encuentr en prestamo y no corresponde al usuario seleccionado");
		    }else  if(msg.response != null && msg.response == "available loanable empty user"){
		    	message("El artículo se encuentra disponible para prestamo, pero debe especificar un usuario", "Mensaje", "Ok", function () {
		    		closeModal();
		    		$("#identification").focus();
		    	});
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
			   	parent.user.penality = msg.penality.penalty_time_finish.date.split(" ")[0];
		    }
		    parent.barcode = '';
		    $( "#barcode" ).focus();
	
		 /*  	if(parent.user.id == null){
		   		getUserDataById(msg.user_id, this);
		   	}else if(parent.user.id != msg.user_id){
		   		getUserDataById(msg.user_id, this);
		   		toastr["info"]("Se ha cambiado de usuario para realizar la operación")
		   	}
	    */
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
}

function User(json) {
	this.id = (json && json.id)?json.id:null;
	this.name = (json && json.name)?json.name:null;
	this.last_name = (json && json.last_name)?json.last_name:null;
	this.email = (json && json.email)?json.email:null;
	this.identity_card = (json && json.identity_card)?json.identity_card:null;
	this.home_phone = (json && json.home_phone)?json.home_phone:null;
	this.cell_phone = (json && json.cell_phone)?json.cell_phone:null;
	this.next_update_time = (json && json.next_update_time)?json.next_update_time:null;
	this.active = (json && json.active)?json.active:null;
	this.role_id = (json && json.role_id)?json.role_id:null;
	this.student = (json && json.student)?json.student:null;
	this.identification = (json && json.identification)?json.identification:null;
	this.role = (json && json.role)?json.role:null;
	this.student = (json && json.student)?json.student:{};
	this.penality = (json && json.penality)?json.student:{};
	this.district_id = (json && json.district_id)?json.district_id:null;
	this.district = (json && json.district)?json.district:null;	

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
			if(identification != null && identification != ''){
				var xhr = $.ajax({
					method: "POST",
					dataType: 'json',
					url: wss + "search-by-identification",
					data: { 
						identification: identification.trim()
					},
					context: this.parent
				});
	
				xhr.done(function (response) {
					this.autoFill(response);
				});
			}
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
		parent.page = msg;
	});

	xhr.fail(function () {
		toastr['error']('Ha ocurrido un error, no se han cargado los equipos');
	});
}

function cartographicLoad(parent){
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "cartographic-material",
		data: {
			page: parent.$route.params.page,
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	xhr.done(function (msg) {
		parent.page = msg;
	});
	
	xhr.fail(function(){
		toastr['error']('Ha ocurrido un error, no se han cargado los cartográficos');
	});
}

function threeDimensionalLoad(parent) {
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "three-dimensional-object",
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

function usersLoad(parent) {
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "users",
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

function audiovisualMaterialsLoad(parent) {
	var xhr = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-material",
		data: {
			page: parent.$route.params.page,
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	xhr.done(function (msg) {
		console.log(msg);
		parent.page = msg;
		//message(parent.page);
		
	});

	xhr.fail(function () {
		toastr['error']('Ha ocurrido un error al cargar la lista de materiales');
	});
}

function cartographicPanelLoad(parent){
	var bibliographic_material = $.ajax({
		method: "GET",
		dataType: "json",
		url: wss + "bibliographic-material",
		data:{
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	bibliographic_material.done(function (msg){
		console.log(msg);
		this.bibliographic_material = msg;
	});
	
	bibliographic_material.fail(function() {
		toarstr['error']('Al cargar los datos del material cartográfico', 'Ha ocurrido un error');
	});
	
	var editorial = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "editorial",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	editorial.done(function (msg) {
		console.log(msg);
		this.editorial = msg;
	});

	editorial.fail(function () {
		toastr['error']('Al cargar los nombres de las editoriales', 'Ha ocurrido un error');
	});
	
	var cartographic_format = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "cartographic-format",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	cartographic_format.done(function (msg) {
		console.log(msg);
		this.cartographic_formats = msg;
	});

	cartographic_format.fail(function () {
		toastr['error']('Al cargar los nombres del material cartográfico', 'Ha ocurrido un error');
	});

	var cartographic = $.ajax({
	method: "GET",
	dataType: 'json',
	url: wss + "cartographic-material",
	data:{
		token: sessionStorage.getItem('token'),
		page: parent.$route.params.id
	},
	context: parent
	});
	
	cartographic.done(function (msg) {
		console.log(msg);
		this.cartographic_data = msg;
	});
	
	cartographic.fail(function () {
		toastr['error']('Al cargar datos del material cartográfico', 'Ha ocurrido un error');
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

function audiovisualMaterialPanelLoad(parent) {
	var formats = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-format",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	formats.done(function (msg) {
		console.log(msg);
		parent.format = msg;
	});

	formats.fail(function () {
		toastr['error']('Al cargar los formatos del material', 'Ha ocurrido un error');
	});
	
	var audiovisualTypes = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-type",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	audiovisualTypes.done(function (msg) {
		console.log(msg);
		parent.audiovisualType = msg;
	});

	audiovisualTypes.fail(function () {
		toastr['error']('Al cargar los formatos del material', 'Ha ocurrido un error');
	});
		
	var audiovisualMaterial = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "audiovisual-material/" + parent.$route.params.id,
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	audiovisualMaterial.done(function (msg) {
		console.log('msg', msg);
		this.audiovisual_material_data = msg;
		
	});

	audiovisualMaterial.fail(function () {
		toastr['error']('Al cargar los datos de los materiales', 'Ha ocurrido un error');
	});
	
	var keyWord = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "key-word",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	keyWord.done(function (msg) {
		console.log(msg);
		parent.keyWords = msg;
	});
	keyWord.fail(function () {
		toastr['error']('Al cargar las palabras claves del objeto tridimensional', 'Ha ocurrido un error');
	});
}

function singleUserPanelLoad(parent) {
	var role = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "role",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	role.done(function (msg) {
		console.log(msg);
		parent.roles = msg;
	});

	role.fail(function () {
		toastr['error']('Al cargar los roles de usuario', 'Ha ocurrido un error');
	});
	
	var user_data = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "users/"+ parent.$route.params.id,
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	user_data.done(function (msg) {
		console.log(msg);
		parent.user_data = msg;
	});
	
	user_data.fail(function () {
		if(parent.$route.params.id == "new"){
			parent.user_data= { "id": '', "name": "", "email": "", "created_at": "", "updated_at": "", "identity_card": '', "last_name": "", "birthdate": "", "home_phone": "", "cell_phone": "", "direction": "", "next_update_time": "", "active": 0, "role_id": '3', "role": { "id": 3, "type": "Usuario"}, "student": {}, "penalties": [] } ;
		}else{
			parent.user_data = {};
			toastr['error']('Al cargar datos del usuario', 'Ha ocurrido un error');
		}
		
	});
}

function initLoanPanel(parent) {
	console.log("initLoanPanel");
	setTimeout(function () {
		datepicker_init(parent);
		var searchIdentification = sessionStorage.getItem('searchIdentification');
		if(searchIdentification != null && searchIdentification != ''){
			getUserData(searchIdentification, parent);
		}
	},200);
	
	
	
	var general_cofiguration = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "configuration",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	general_cofiguration.done(function (msg) {
		console.log(msg);
		parent.general_cofiguration = msg;
		
  				console.log("/************ return_hour - 3 **********************/");
		if((new Date()).getDay() == 6){
			var array = msg.saturday_hour_closing.split(":");
			array.pop();
			parent.return_hour = array.join(":");
		}else{
			var array = msg.closing_hour_week.split(":");
			array.pop();
			parent.return_hour = array.join(":");
		}
		
	});
	
	general_cofiguration.fail(function () {
		toastr['error']('Al cargar la configuracion general', 'Ha ocurrido un error');
		parent.user_data=[];
	});
	
	parent.return_time = (new Date()).visualFormat();
}

function statisticsTypes(parent) {
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
}

function threeDimensionalObjectPanelLoad(parent) {
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
	
	var keyWord = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "key-word",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	keyWord.done(function (msg) {
		console.log(msg);
		parent.keyWords = msg;
	});
	keyWord.fail(function () {
		toastr['error']('Al cargar las palabras claves del objeto tridimensional', 'Ha ocurrido un error');
	});
	
	var editorial = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "editorial",
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	editorial.done(function (msg) {
		console.log(msg);
		parent.editorials = msg;
	});
	editorial.fail(function () {
		toastr['error']('Al cargar las editoriales', 'Ha ocurrido un error');
	});

		console.log('parent',parent);
	var threeDimensional_data = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "three-dimensional-object/" + parent.$route.params.id,
		data: {
			token: sessionStorage.getItem('token')
		},
		context: parent
	});

	threeDimensional_data.done(function (msg) {
		console.log('msg', msg);
		this.three_dimensional_data = msg;
	});

	threeDimensional_data.fail(function () {
		toastr['error']('Al cargar los datos del tridimensional', 'Ha ocurrido un error');
	});

}

function initSearchPanel(parent) {
	setTimeout(function () {
		var types = [];
		for (var i = 0; i < parent.types.length; i++) {
			var item = parent.types[i];
			if(item.include){
				types.push(item.asParameter);
			}
		}
		var promise = $.ajax({
			method: "POST",
			dataType: 'json',
			url: wss + "search-loanable",
			data: {
				pageLength: parent.resultsPerPage,
				types: types,
				page:parent.$route.params.page,
				token: sessionStorage.getItem('token')
			},
			context: parent
		});
		
		promise.done(function (msg) {
			console.log(parent.resultsPerPage);
			console.log(msg);
			this.paginate = msg
		});
		promise.fail(function () {
			toastr['error']('Al cargar los estados de los equipos', 'Ha ocurrido un error');
		});
	},1);
	
}

function pendingLoansDay() {
	var loan = $.ajax({
		method: "GET",
		dataType: "json",
		url: wss + "pendings-by-day",
		data:{
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
	
	loan.done(function (msg){
		console.log(msg);
		this.loan = msg;
	});
	
	loan.fail(function() {
		toarstr['error']('Al cargar los prestamos', 'Ha ocurrido un error');
	});
}

function showHelp() {
	//toarstr['error']('Al cargar los prestamos', 'Ha ocurrido un error');
		    alert("Informacion de Ayuda");
}

function initLoanablePanel(parent){
	
	if(!isNumeric(parent.$route.params.id)){
		var params = parent.$route.params.id.split('.');
		if(params[0] == 'nuevo'){
			setTimeout(function () {
				parent.type = params[1];
				parent.loanable.state_id = 1;
				parent.loanable.state = { "id": 1, "description": "Disponible" };
			}, 100);
		}
	}else{
		var loanableAjax = $.ajax({
				method: "GET",
				dataType: 'json',
				url: wss + "loanable-panel-resource",
				data:{
					token: sessionStorage.getItem('token'),
					loanable: parent.$route.params.id
				},
				context: parent
			});
			
		loanableAjax.done(function (resource) {
			console.log(resource);
			parent.models = resource.models;
			parent.brands = resource.brands;
			parent.types = resource.types;
			parent.states = resource.states;
			parent.loanable = resource.loanable;
			parent.loans = resource.loans;
			switch (parent.loanable.specification_type) {
				case 'App\\AudiovisualEquipment':
					parent.type = 'equipo';
					break;
				case 'App\\CopyPeriodicPublication':
					parent.type = 'publicacion';
					break;
				case 'App\\BibliographicMaterial':
					switch (parent.loanable.specific.material_type) {
						case 'App\\CartographicMaterial':
							parent.type = 'cartografico';
							break;
						case 'App\\ThreeDimensionalObject':
							parent.type = 'tridimensional';
							break;
						case 'App\\Book':
							parent.type = 'libro';
							break;
						case 'App\\AudiovisualMaterial':
							parent.type = 'aduiovisual';
							break;
					}
					break;
			}
		});
		loanableAjax.fail(function () {
			parent.loanable = {};
			toastr['error']('Al cargar la información', 'Ha ocurrido un error');
		});
	}
}

function intiDashboard(parent) {
	var dashdoardAjax = $.ajax({
		method: "POST",
		dataType: 'json',
		url: wss + "dashboard-panel-resource",
		data:{
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
			
	dashdoardAjax.done(function (resource) {
		console.log(resource);
	});
	dashdoardAjax.fail(function () {
		toastr['error']('Al cargar la información', 'Ha ocurrido un error');
	});
}

function deleteLoanable(id, parent) {
	var loanableAjax = $.ajax({
		method: "DELETE",
		dataType: 'json',
		url: wss + "loanable/" + id,
		data:{
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
		
	loanableAjax.done(function (response) {
		parent.loanableDeleteSuccess(response);
	});
	loanableAjax.fail(function (response) {
		parent.loanableDeleteError(response);
	});
}

function initLoanPage(parent){
	var loanAjax = $.ajax({
		method: "GET",
		dataType: 'json',
		url: wss + "loan/" + parent.$route.params.id,
		data:{
			token: sessionStorage.getItem('token')
		},
		context: parent
	});
			
	loanAjax.done(function (resource) {
		console.log(resource);
		this.loan = resource;
	});
	loanAjax.fail(function () {
		toastr['error']('Al cargar la información', 'Ha ocurrido un error');
	});
}