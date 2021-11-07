// if #automailNewVue Div is Present do the rest This  the new section 
if(document.getElementById("automailNewVue")){
	var automailNew = new Vue({
		el:'#automailNewVue',
		data:{
			ID 						: "", // useless hassle test operation && remove before deployment 
			automatonName  			: "",
			eventsAndTitles         : "",
			selectedEvent			: "",
			selectedEventsAndTitles : {},
			mailReceiver 			: [],
			freemiusStatus 			: "",
		},
		methods:{
			eventSelected:function(event){
				if(typeof this.eventsAndTitles[event.target.value] !== 'undefined' && typeof event.target.value !== 'undefined'){
					this.selectedEventsAndTitles = this.eventsAndTitles[event.target.value];
				}else{
					console.log("error:Selected event is undefined in eventsAndTitles OR event.target.value is undefined !"); 
				}
			},
			copyTheTag:function(index){
				// Coping the data to Clipboard 
				var text  =  '['+ index +']' ;
				navigator.clipboard.writeText(text).then(function(){
					console.log('Async: Copying to clipboard was successful!');
				},function(error){
					console.error('error: Async, Could not copy text: ', error);
				});
			},
			inputValidation:function(event){
				if((this.automatonName && this.selectedEvent) && (this.selectedEventsAndTitles && this.mailReceiver.length > 0)){
					return true;
				}else{
					event.preventDefault();
					alert("error:Please fill all the fields!");
				}
			}
		},beforeMount(){
			// Inserting data to the data.eventsAndTitles element
			this.eventsAndTitles = automailJsData.eventsAndTitles;
			this.freemiusStatus  = automailJsData.freemiusStatus;
			console.log(automailJsData); 
		}
	})
}

//if #automailEditVue Div is Present do the rest, This the edit section 
if(document.getElementById("automailEditVue")){
	var automailEdit = new Vue({
		el:'#automailEditVue',
		data:{
			ID 						: "",
			automatonName  			: "",
			eventsAndTitles  		: "",
			selectedEvent			: "",
			selectedEventsAndTitles	: {},
			mailReceiver 			: [],
			freemiusStatus 			: "",
		},
		methods:{
			eventSelected:function(event){
				if(typeof this.eventsAndTitles[event.target.value] !== 'undefined' && typeof event.target.value !== 'undefined'){
					this.selectedEventsAndTitles = this.eventsAndTitles[event.target.value];
				}else{
					console.log("error:Selected event is undefined in eventsAndTitles OR event.target.value is undefined !"); 
				}
			},
			copyTheTag:function(index){
				// Coping the data to Clipboard 
				var text  =  '['+ index +']';
				navigator.clipboard.writeText( text ).then(function(){
					console.log('Async: Copying to clipboard was successful!');
				},function(error){
					console.error('error:Async, Could not copy text: ', error);
				});
			},
			inputValidation:function(event){
				if((this.automatonName && this.selectedEvent) && (this.selectedEventsAndTitles && this.mailReceiver.length > 0)){
					return true;
				}else{
					event.preventDefault();
					alert("error:Please fill all the fields!");
				}
			}

		},beforeMount(){
			// Inserting data to the data.eventsAndTitles element
			this.ID 			 		 = automailJsData.ID;
			this.automatonName 	 		 = automailJsData.automatonName;
			this.selectedEvent 	 		 = automailJsData.selectedEvent;
			this.eventsAndTitles 		 = automailJsData.eventsAndTitles;
			this.mailReceiver 	 		 = JSON.parse( automailJsData.mailReceiver);
			this.selectedEventsAndTitles = this.eventsAndTitles[automailJsData.selectedEvent];
			this.freemiusStatus  		 = automailJsData.freemiusStatus;
		}
	})
}
// Note:
// (function) eventSelected func has a Room for Improvement 