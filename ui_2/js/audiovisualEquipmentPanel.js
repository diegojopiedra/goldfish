const AudiovisualEquipmentPanel = {
	template: "#audiovisualEquipmentPanel",
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