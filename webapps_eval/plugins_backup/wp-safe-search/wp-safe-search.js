// Ajax cookie checks and sets
// URI: http://www.editeurjavascript.com/trucs/voir.php?truc=35&debut=20
// Author: unknown
function writediv(texte)
{
    document.getElementById('wpssbox').innerHTML = texte;
}

function has_qs()
{
	return location.search.indexOf('?')>=0;
}

function clean_qs(str)
{
	var queryString=location.search;
	var qs = '';
	var params=queryString.substring(1).split('&');
	for(var i=0; i<params.length; i++){
		var pair=params[i].split('=');
		if(decodeURIComponent(pair[0])!=str && pair[1])
			if (pair[0] != 'safesearch') qs += (i>0 ? '&' : '?') + pair[0] + '=' + pair[1];
	}
	return qs;
}

function has_param(str)
{
	var queryString=location.search;
	var params=queryString.substring(1).split('&');
	for(var i=0; i<params.length; i++){
		var pair=params[i].split('=');
		if(decodeURIComponent(pair[0])==str && pair[1])
			return true;
	}
	return false;
}

// checkCookie() is only used the first time page is loaded, and then replaced by switchCookie()
function checkCookie(path,label_enable,label_enabled,label_disable,label_disabled)
{
	var ccheck = file(path + '/wp-safe-search-jx.php?v0='+path+'&v1='+label_enable+'&v2='+label_enabled+'&v3='+label_disable+'&v4='+label_disabled+'&set=0');
	writediv(ccheck);
}

function switchCookie(path,label_enable,label_enabled,label_disable,label_disabled)
{
	var cvalue = wpss_getcookie('safesearch') ? 'false' : 'true';
	//alert(cvalue);
	var cswitch = file(path + '/wp-safe-search-jx.php?v0='+path+'&v1='+label_enable+'&v2='+label_enabled+'&v3='+label_disable+'&v4='+label_disabled+'&set=1');
	//window.location.reload();
	var cvalue = wpss_getcookie('safesearch') ? 'false' : 'true';
	if (has_qs() && has_param('safesearch'))
	{
		this.location.href = location.href.substring(0,location.href.indexOf("?")) + clean_qs('safesearch');
	}
	else
	{
		var css = '';
		if (cvalue=='false') { css = (has_qs() ? '&' : '?') + 'safesearch=false'; }
		this.location.href = document.URL + css;
	}
}

function file(fichier)
{
	if (window.XMLHttpRequest) // FIREFOX
		xhr_object = new XMLHttpRequest();
	else if (window.ActiveXObject) // IE
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
	else
		return(false);
	xhr_object.open("GET", fichier, false);
	xhr_object.send(null);
	if (xhr_object.readyState == 4)
		return(xhr_object.responseText);
	else
		return(false);
}
     

// Javascript Cookie Script
// URI: http://techpatterns.com/downloads/javascript_cookies.php
// Author: unknown

function wpss_getcookie( check_name ) {
	// first we'll split this cookie up into name/value pairs
	// note: document.cookie only returns name=value, not the other components
	var a_all_cookies = document.cookie.split( ';' );
	var a_temp_cookie = '';
	var cookie_name = '';
	var cookie_value = '';
	var b_cookie_found = false; // set boolean t/f default f

	for ( i = 0; i < a_all_cookies.length; i++ )
	{
		// now we'll split apart each name=value pair
		a_temp_cookie = a_all_cookies[i].split( '=' );


		// and trim left/right whitespace while we're at it
		cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

		// if the extracted name matches passed check_name
		if ( cookie_name == check_name )
		{
			b_cookie_found = true;
			// we need to handle case where cookie has no value but exists (no = sign, that is):
			if ( a_temp_cookie.length > 1 )
			{
				cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
			}
			// note that in cases where cookie is initialized but no value, null is returned
			return cookie_value;
			break;
		}
		a_temp_cookie = null;
		cookie_name = '';
	}
	if ( !b_cookie_found )
	{
		return null;
	}
}

// this deletes the cookie when called
function wpss_deletecookie( name, path, domain ) {
	if ( wpss_getcookie( name ) ) document.cookie = name + "=" +
	( ( path ) ? ";path=" + path : "") +
	( ( domain ) ? ";domain=" + domain : "" ) +
	";expires=Thu, 01-Jan-1970 00:00:01 GMT";
}

function wpss_setcookie( name, value, expires, path, domain, secure )
{
	// set time, it's in milliseconds
	var today = new Date();
	today.setTime( today.getTime() );
	if ( expires )
	{
	expires = expires * 1000 * 60 * 60 * 24;
	}
	var expires_date = new Date( today.getTime() + (expires) );

	document.cookie = name + "=" +escape( value ) +
	( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
	( ( path ) ? ";path=" + path : "" ) +
	( ( domain ) ? ";domain=" + domain : "" ) +
	( ( secure ) ? ";secure" : "" );
}
