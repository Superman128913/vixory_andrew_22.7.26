import Vue from 'vue';
import fKV from './modelsToKV'

Vue.mixin({
	methods: {
		jumpToErrors() {
			setTimeout(function(){
				let errors = document.getElementsByClassName("error-message");
				if(errors.length > 0) {
					
					let x_value = errors[0].offsetTop;
					window.scrollTo(0,x_value);
				}
			}, 300);
		},
		pendingApproval() {
			var isRejected = this.$store.getters.isRejected;
			var isPending = this.$store.getters.isPendingApproval;

			if((isPending && this.$route.name !== "pending-approval") || isRejected) {
				this.$router.push({name:"pending-approval"});
			}
			else if(!isPending && this.$route.name === "pending-approval") {
				this.$router.push({name:"profile"});
			}
			return isPending;
		},
		checkDeactivation() {
			var user = this.$store.getters.user;
			var deactivationPass = localStorage.getItem('deactivationPass');
			if(user && (user.is_deactivated && !deactivationPass)) {
				this.$router.push({path:"/deactivated"});
			}
		},
		removeMaskFormatting(value) {
            //Remove any masking from the end value.
            return value.replace(/\D/g,'');
        },
		filterUpdate(filter_name, value) {
            let payload = {
                filter_name:filter_name,
                value:value
            };
            this.$store.commit("updateFilter", payload);
        },
		animateCSS(element, animationName, callback) {
			const node = document.querySelector(element)
			node.classList.add('animated', animationName)
		
			function handleAnimationEnd() {
				node.classList.remove('animated', animationName)
				node.removeEventListener('animationend', handleAnimationEnd)
		
				if (typeof callback === 'function') callback()
			}
		
			node.addEventListener('animationend', handleAnimationEnd)
		},
		getBaseUrl() {
			return process.env.VUE_APP_URL;
		},
		getAssetUrl() {
			return process.env.VUE_APP_ASSET_URL;
		},
		formatTimeSince: function(timestamp) {
			var date = new Date(timestamp + "+00:00");
			var seconds = Math.floor((Date.now() - date) / 1000);

			//Return just the years if it's been over a year.
			var interval = Math.floor(seconds / 31536000);
			if (interval > 1) {
			  return interval + " years ago";
			}

			//Return just the months if it's been over a month.
			interval = Math.floor(seconds / 2592000);
			if (interval > 1) {
			  return interval + " months ago";
			}

			//Return just the days if it's been over a day
			interval = Math.floor(seconds / 86400);
			if (interval > 1) {
			  return interval + " days ago";
			}

			//Return hours
			interval = Math.floor(seconds / 3600);
			if (interval > 1) {
			  return interval + " hours ago";
			}

			//Return minutes
			interval = Math.floor(seconds / 60);
			if (interval > 1) {
			  return interval + " minutes ago";
			}

			//Return seconds
			return "Just Now";
		},
		formatTimestamp: function(timestamp) {
			var date = new Date(timestamp);
			return date.toLocaleString('en-US', { dateStyle: "medium" });
		},
		formatUnixAsReadable: function(timestamp) {
			var date = new Date(timestamp * 1000);

			//Calculate the timestamp.
			return date.toLocaleString('en-US', { dateStyle: "medium" });
		},
		formatAsMoney: function(number) {
			if(! isNaN(number)) {
				var number = (number / 100).toFixed(2);
				return '$' + number.replace(/\d(?=(\d{3})+\.)/g, '$&,');
			}
			return number;
		},
		isAthleticRecruiter: function() {
			return this.hasRole("coach,pro_scout");
		},
		userCan: function(permission_name) {
			var user = this.$store.getters.user;
			if(user)
			{
				let permissions = user.all_permissions;
				for(var i = 0; i < permissions.length; i++) {
					if(permissions[i] == permission_name) {
						return true;
					}
				}
				return false;
			}
			return false;
		},
		userHasRole: function(payload) {
			var specifiedRoles = payload.specifiedRoles.split(",");
			var roles = payload.user.roles;

			for(var i = 0; i < roles.length; i++) {
				for(var j = 0; j < specifiedRoles.length; j++) {
					if(roles[i].name === specifiedRoles[j]) {
						return true;
					}
				}
			}
			return false;
		},
		hasRole: function(specifiedRoles) {
			var user = this.$store.getters.user;
			if(user)
			{
				var roles = user.role_names;
				var specifiedRoles = specifiedRoles.split(",");
				for(var i = 0; i < roles.length; i++) {
					for(var j = 0; j < specifiedRoles.length; j++) {
						if(roles[i] === specifiedRoles[j]) {
							return true;
						}
					}
				}
				return false;
			}
			return false;
		},
		/**
		 * There is a duplicate php version of this function in Helpers.php. The
		 * purpose of these functions is to allow us to transfer eloquent collections
		 * into key-value pairs that can be easily used by form inputs.
		 */
		modelsToKV: fKV,
		/**
		 * Accepts a field and returns the related component name.
		 */
		getFieldsComponentName: function(field) {
			return this.getComponentName(field.type);
		},
		getFieldsFilterComponentName: function(field) {
			return this.getComponentName(field.filter_type);
		},
		getComponentName(type_value) {
			switch(type_value) {
				case 0:
					return "TextInput";
				case 1:
					return "TextareaInput";
				case 2:
					return "NumberInput";
				case 3:
					return "BooleanInput";	
				case 4:
					return "RadioInput";
				case 5:
					return "SelectInput";
				case 6:
					return "TextInput"; // This one used to be LinkInput
				case 7:
					return "CheckboxInput";
				case 8:
					return "DateInput";
				case 9:
					return "PhoneInput";
				case 10:
					return "PlacesInput";
				case 11:
					return "RangeFilter";
				case 12:
					return "EnumRepeater";
				default:
					return "TextInput";
			}
		},
		sexOptions() {
			return [
                {
                    value:0,
                    key:"Male"
                },
                {
                    value:1,
                    key:"Female"
                }
            ]
		},
		signout() {
			let self = this;
            axios.get("logout").then(res => {
                self.$store.dispatch("logoutUser");
                self.$router.push("/");
            });
		},
		stateNameToCode(input, to) {
			var states = [
				['Arizona', 'AZ'],
				['Alabama', 'AL'],
				['Alaska', 'AK'],
				['Arkansas', 'AR'],
				['California', 'CA'],
				['Colorado', 'CO'],
				['Connecticut', 'CT'],
				['Delaware', 'DE'],
				['Florida', 'FL'],
				['Georgia', 'GA'],
				['Hawaii', 'HI'],
				['Idaho', 'ID'],
				['Illinois', 'IL'],
				['Indiana', 'IN'],
				['Iowa', 'IA'],
				['Kansas', 'KS'],
				['Kentucky', 'KY'],
				['Louisiana', 'LA'],
				['Maine', 'ME'],
				['Maryland', 'MD'],
				['Massachusetts', 'MA'],
				['Michigan', 'MI'],
				['Minnesota', 'MN'],
				['Mississippi', 'MS'],
				['Missouri', 'MO'],
				['Montana', 'MT'],
				['Nebraska', 'NE'],
				['Nevada', 'NV'],
				['New Hampshire', 'NH'],
				['New Jersey', 'NJ'],
				['New Mexico', 'NM'],
				['New York', 'NY'],
				['North Carolina', 'NC'],
				['North Dakota', 'ND'],
				['Ohio', 'OH'],
				['Oklahoma', 'OK'],
				['Oregon', 'OR'],
				['Pennsylvania', 'PA'],
				['Rhode Island', 'RI'],
				['South Carolina', 'SC'],
				['South Dakota', 'SD'],
				['Tennessee', 'TN'],
				['Texas', 'TX'],
				['Utah', 'UT'],
				['Vermont', 'VT'],
				['Virginia', 'VA'],
				['Washington', 'WA'],
				['West Virginia', 'WV'],
				['Wisconsin', 'WI'],
				['Wyoming', 'WY'],
			];
		
			if (to == 'abbr'){
				input = input.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
				for(var i = 0; i < states.length; i++){
					if(states[i][0] == input){
						return(states[i][1]);
					}
				}    
			} else if (to == 'name'){
				input = input.toUpperCase();
				for(var i = 0; i < states.length; i++){
					if(states[i][1] == input){
						return(states[i][0]);
					}
				}    
			}
		},
	}
})