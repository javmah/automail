//  Check & Balance || if #automailNewVue Div is Present do the rest
if ( document.getElementById("automailNewVue") ) {

	var automailNew = new Vue({
		el: '#automailNewVue',
		data: {
			eventsAndTitles:"",
			selectedEvent:"",
			selectedEventsAndTitles:""
		},
		methods: {
			eventSelected: function(event){
				if( typeof this.eventsAndTitles[event.target.value] !== 'undefined'  &&  typeof event.target.value !== 'undefined' ) {
					console.log( event.target.value );
					console.log( this.eventsAndTitles[event.target.value] );
					// Inserting Selected Event 
					this.selectedEvent = event.target.value;
					this.selectedEventsAndTitles = this.eventsAndTitles[event.target.value];

				} else {
					console.log( "error:Selected event is undefined in eventsAndTitles OR event.target.value is undefined !" ); 
				}
			},
			copyTheTag: function(index){
				// Coping the data to Clipboard 
				var text  =  '['+ index +']' ;
				navigator.clipboard.writeText( text ).then(function() {
					console.log('Async: Copying to clipboard was successful!');
				}, function(err) {
					console.error('Async: Could not copy text: ', err);
				});
			}

		}, beforeMount() {
			// Inserting data to the data.eventsAndTitles element
			this.eventsAndTitles = automailJsData;
			console.log( automailJsData ); 
		}
	})
}


// Check & Balance if #automailEditVue Div is Present do the rest
if ( document.getElementById("automailEditVue") ) {

	var automailEdit = new Vue({
		el: '#automailEditVue',
		data: {
			eventsAndTitles:"",
			selectedEvent:"",
			selectedEventsAndTitles:""
		},
		methods: {
			eventSelected: function(event){
				if( typeof this.eventsAndTitles[event.target.value] !== 'undefined'  &&  typeof event.target.value !== 'undefined' ) {
					console.log( event.target.value );
					console.log( this.eventsAndTitles[event.target.value] );
				} else {
					console.log( "error:Selected event is undefined in eventsAndTitles OR event.target.value is undefined !" ); 
				}
			}

		}, beforeMount() {
			// Inserting data to the data.eventsAndTitles element
			this.eventsAndTitles = automailJsData;
			console.log( automailJsData ); 
		}
	})

}


