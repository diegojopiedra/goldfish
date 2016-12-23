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