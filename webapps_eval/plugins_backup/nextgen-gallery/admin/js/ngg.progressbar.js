/*
 * Progress bar Plugin for NextGEN gallery
 * Version:  1.0.0
 * Author : Alex Rabe
 */ 
(function($) {
	nggProgressBar = {
	
		settings: {
				id:	'progressbar',
				maxStep: 100,
				wait: false,
				header: '' 
		},
		
		init: function( s ) {
			
			s = this.settings = $.extend( {}, this.settings, {}, s || {} );
			
			div = $('#' + s.id + '_container');
			width = Math.round( ( 100 / s.maxStep ) * 100 ) /100;			
			
			if ( div.find("#" + s.id).length == 0) {
				if (s.header.length > 0)
					div.append('<h2>'+ s.header +'</h2>');
				div.append('<div id="' + s.id + '" class="progressborder"><div class="' + s.id + '"><span>0%</span></div></div>');
			}
		},
		
		addMessage: function( message ) {
			s = this.settings;
			if ( div.find("#" + s.id + "_message").length == 0)
				div.append('<div class="' + s.id + '_message"><span style="display:block" id="' + s.id + '_message">' + message + '</span></div>');
			else	
				$("#" + s.id + "_message").html( message );
		},

		addNote: function( note, detail ) {
			s = this.settings;
			s.wait = true;
			if ( div.find("#" + s.id + "_note").length == 0)
				div.append('<ul id="' + s.id + '_note">&nbsp;</ul>');

			if (detail)
				$("#" + s.id + "_note").append("<li>" + note + "<div class='show_details'><span>[more]</span><br />" + detail + "</div></li>");
			else
				$("#" + s.id + "_note").append("<li>" + note + "</li>");
		},
		
		increase: function( step ) {
			s = this.settings;
			var value = step * width + "%";
			var rvalue = Math.round (step * width) + "%" ;
			$("#" + s.id + " div").width( value );
			$("#" + s.id + " span").html( rvalue );
		},

		finished: function() {
			s = this.settings;
			$("#" + s.id + " div").width( '100%' );
			$("#" + s.id + " span").html( '100%' );
			// in the case we add a note , we should wait for a click
			if (s.wait) {
				setTimeout(function() {
					$("#" + s.id).hide("slow");
				}, 2000); 
				div.click(function () {
					jQuery('.nggform').prepend("<input type=\"hidden\" name=\"ajax_callback\" value=\"0\">");
	      			jQuery('.nggform').submit();
	    		});
	    	} else {
	    		//div.hide("slow");
	    		jQuery("#" + s.id).hide("slow");
				jQuery("#" + s.id + "_container h2").hide("slow");
				jQuery('.nggform').prepend("<input type=\"hidden\" name=\"ajax_callback\" value=\"1\">");
	    		jQuery('.nggform').submit();
	    	}
		}
	};
})(jQuery);