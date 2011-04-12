/*
 * Ajax Plugin for NextGEN gallery
 * Version:  1.4.0
 * Author : Alex Rabe
 */ 
(function($) {
nggAjax = {
		settings: {
			url: nggAjaxSetup.url, 
			type: "POST",
			action: nggAjaxSetup.action,
			operation : nggAjaxSetup.operation,
			nonce: nggAjaxSetup.nonce,
			ids: nggAjaxSetup.ids,
			permission: nggAjaxSetup.permission,
			error: nggAjaxSetup.error,
			failure: nggAjaxSetup.failure,
			timeout: 10000
		},
	
		run: function( index ) {
			s = this.settings;
			var req = $.ajax({
				type: "POST",
			   	url: s.url,
			   	data:"action=" + s.action + "&operation=" + s.operation + "&_wpnonce=" + s.nonce + "&image=" + s.ids[index],
			   	cache: false,
			   	timeout: 10000,
			   	success: function(msg){
			   		switch ( parseInt(msg) ) {
			   			case -1:
					   		nggProgressBar.addNote( nggAjax.settings.permission );
						break;
			   			case 0:
					   		nggProgressBar.addNote( nggAjax.settings.error );
						break;
			   			case 1:
					   		// show nothing, its better
						break;
						default:
							// Return the message
							nggProgressBar.addNote( "<strong>ID " + nggAjax.settings.ids[index] + ":</strong> " + nggAjax.settings.failure, msg );
						break; 			   			
			   		}

			    },
			    error: function (msg) {
					nggProgressBar.addNote( "<strong>ID " + nggAjax.settings.ids[index] + ":</strong> " + nggAjax.settings.failure, msg.responseText );
				},
				complete: function () {
					index++;
					nggProgressBar.increase( index );
					// parse the whole array
					if (index < nggAjax.settings.ids.length)
						nggAjax.run( index );
					else 
						nggProgressBar.finished();
				} 
			});
		},

		readIDs: function( index ) {
			s = this.settings;
			var req = $.ajax({
				type: "POST",
			   	url: s.url,
			   	data:"action=" + s.action + "&operation=" + s.operation + "&_wpnonce=" + s.nonce + "&image=" + s.ids[index],
			   	dataType: "json",
	   			cache: false,
			   	timeout: 10000,
			   	success: function(msg){
  					// join the array
			 		imageIDS = imageIDS.concat(msg);
				},
			    error: function (msg) {
					nggProgressBar.addNote( "<strong>ID " + nggAjax.settings.ids[index] + ":</strong> " + nggAjax.settings.failure, msg.responseText );
				},
				complete: function () {
					index++;
					nggProgressBar.increase( index );
					// parse the whole array
					if (index < nggAjax.settings.ids.length)
						nggAjax.readIDs( index );
					else {
						// and now run the image operation
						index  = 0;
						nggAjax.settings.ids = imageIDS;
						nggAjax.settings.operation = nextOperation;
						nggAjax.settings.maxStep = imageIDS.length;
						nggProgressBar.init( nggAjax.settings );
						nggAjax.run( index );
					}
				} 
			});
		},
	
		init: function( s ) {

			var index  = 0;
								
			// get the settings
			this.settings = $.extend( {}, this.settings, {}, s || {} );
			
			// a gallery operation need first all image ids via ajax
			if ( this.settings.operation.substring(0, 8) == 'gallery_' ) {
				nextOperation = this.settings.operation.substring(8);
				//first run, get all the ids
				this.settings.operation = 'get_image_ids';
				imageIDS = new Array();
				this.readIDs( index );
			} else {
				// start the ajax process
				this.run( index );				
			}
		}
	}
}(jQuery));