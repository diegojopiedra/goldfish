const LoanPanel = { 
	template: "#loanTemplate",
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
		  	hours: getHours(),
		  	
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