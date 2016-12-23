const AudiovisualEquipmentManagement = {
	template: "#audiovisualEquipmentManagementTemplate",
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