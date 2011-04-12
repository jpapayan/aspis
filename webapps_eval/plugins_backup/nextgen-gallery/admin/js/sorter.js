	/************************************************************************************************************
	(C) www.dhtmlgoodies.com, September 2005
	
	This is a script from www.dhtmlgoodies.com. You will find this and a lot of other scripts at our website.	
	
	Terms of use:
	LGPL: See web page for more info.
	
	Thank you!
	
	www.dhtmlgoodies.com
	Alf Magne Kalleland
	
	************************************************************************************************************/	
	var operaBrowser = navigator.userAgent.indexOf('Opera') >=0 ? 1 : false;
	var safariBrowser = navigator.userAgent.indexOf('Safari') >=0 ? true : false;
	var MSIE = navigator.userAgent.indexOf('MSIE')>= 0 ? true : false;
	var navigatorVersion = navigator.appVersion.replace(/.*?MSIE (\d\.\d).*/g,'$1')/1;
	
	function cancelEvent()
	{
		return false;
	}
	var activeImage = false;
	var readyToMove = false;
	var moveTimer = -1;
	var dragDropDiv;
	var insertionMarker;
	
	var offsetX_marker = -3;	// offset X - element that indicates destinaton of drop
	var offsetY_marker = 0;		// offset Y - element that indicates destinaton of drop
	
	var firefoxOffsetX_marker = -3;
	var firefoxOffsetY_marker = -2;
	
	if(navigatorVersion<6 && MSIE){	/* IE 5.5 fix */
		offsetX_marker-=23;
		offsetY_marker-=10;		
	}
	
	var destinationObject = false;
	
	var divXPositions = new Array();
	var divYPositions = new Array();
	var divWidth = new Array();
	var divHeight = new Array();
		
	var tmpLeft = 0;
	var tmpTop = 0;
	
	var eventDiff_x = 0;
	var eventDiff_y = 0;
		
	function getTopPos(inputObj)
	{		
	  var returnValue = inputObj.offsetTop;
	  while((inputObj = inputObj.offsetParent) != null){
	  	if(inputObj.tagName!='HTML'){
	  		returnValue += (inputObj.offsetTop - inputObj.scrollTop);
	  		if(document.all)returnValue+=inputObj.clientTop;
	  	}
	  } 
	  return returnValue;
	}
	
	function getLeftPos(inputObj)
	{	  
	  var returnValue = inputObj.offsetLeft;
	  while((inputObj = inputObj.offsetParent) != null){
	  	if(inputObj.tagName!='HTML'){
	  		returnValue += inputObj.offsetLeft;
	  		if(document.all)returnValue+=inputObj.clientLeft;
	  	}
	  }
	  return returnValue;
	}
		
	function selectImage(e)
	{
		if(document.all && !operaBrowser)e = event;
		var obj = this.parentNode;
		if(activeImage)activeImage.className='imageBox';
		obj.className = 'imageBoxHighlighted';
		activeImage = obj;
		readyToMove = true;
		moveTimer=0;
		
		tmpLeft = e.clientX + Math.max(document.body.scrollLeft,document.documentElement.scrollLeft);
		tmpTop = e.clientY + Math.max(document.body.scrollTop,document.documentElement.scrollTop);

		startMoveTimer();	
		
		return false;	
	}
	
	function startMoveTimer(){
		if(moveTimer>=0 && moveTimer<10){
			moveTimer++;
			setTimeout('startMoveTimer()',15);
		}
		if(moveTimer==10){
			getDivCoordinates();
			var subElements = dragDropDiv.getElementsByTagName('DIV');
			if(subElements.length>0){
				dragDropDiv.removeChild(subElements[0]);
			}
			
			jQuery("#dragDropContent").show();
			// dragDropDiv.style.display='block';
			var newDiv = activeImage.cloneNode(true);
			newDiv.className='imageBox';	
			newDiv.id='';
			jQuery("#dragDropContent").append(newDiv);
			//dragDropDiv.appendChild(newDiv);	
			
			jQuery("#dragDropContent").css("top" , tmpTop + 'px');
			jQuery("#dragDropContent").css("left" , tmpLeft + 'px');
			// dragDropDiv.style.top = tmpTop + 'px';
			// dragDropDiv.style.left = tmpLeft + 'px';
							
		}
		return false;
	}
	
	function dragDropEnd()
	{
		readyToMove = false;
		moveTimer = -1;
		
		jQuery("#dragDropContent").hide();
		//dragDropDiv.style.display='none';
		jQuery("#insertionMarker").hide();
		//insertionMarker.style.display='none';
		
		if(destinationObject && destinationObject!=activeImage){
			var parentObj = destinationObject.parentNode;
			parentObj.insertBefore(activeImage,destinationObject);
			activeImage.className='imageBox';
			activeImage = false;
			destinationObject=false;
			getDivCoordinates();
		}
		return false;
	}
	
	function dragDropMove(e)
	{
		if(moveTimer==-1)
			return;
		if(document.all && !operaBrowser)
			e = event;
			
		if (safariBrowser) {
			var leftPos = e.pageX - eventDiff_x;
			var topPos = e.pageY - eventDiff_y;
		} else {
			var leftPos = e.clientX + document.documentElement.scrollLeft - eventDiff_x;
			var topPos = e.clientY + document.documentElement.scrollTop - eventDiff_y;
		}
		
		// message =  " topPos: <strong>" + topPos + "</strong> e.pageY: <strong>" + e.pageY + "</strong> e.clientY: <strong>" + e.clientY + "</strong> scrollTop: <strong>" + document.documentElement.scrollTop + "</strong>";
		// message += "<br /> leftPos: <strong>" + leftPos + "</strong> e.pageX: <strong>" + e.pageX + "</strong> e.clientX: <strong>" + e.clientX + "</strong> scrollLeft: <strong>" + document.documentElement.scrollLeft + "</strong>";
		//debug( message );
		
		dragDropDiv.style.top = topPos + 'px';
		dragDropDiv.style.left = leftPos + 'px';
		
		leftPos = leftPos + eventDiff_x;
		topPos = topPos + eventDiff_y;
		
		if(e.button!=1 && document.all &&  !operaBrowser)dragDropEnd();
		var elementFound = false;

		for(var prop in divXPositions){
			// message  = (divXPositions[prop]/1) + " < " + leftPos/1 + " && " + (divXPositions[prop]/1 + divWidth[prop]*0.7) + " > " + (leftPos/1);
			// message += "<br />" + (divYPositions[prop]/1) + " < " + topPos/1 + " && " + (divYPositions[prop]/1 + divWidth[prop]) + " > " + (topPos/1);
			// debug( message );
			if( (divXPositions[prop]/1 < leftPos/1) && ( (divXPositions[prop]/1 + divWidth[prop]*0.7) > leftPos/1) && ( (divYPositions[prop]/1) < topPos/1) && (( (divYPositions[prop]/1) + divWidth[prop]) > topPos/1)) {
				
				// check for IE who support document.all
				if( document.all && !safariBrowser ){
					offsetX = offsetX_marker;
					offsetY = offsetY_marker;
				}else{
					offsetX = firefoxOffsetX_marker;
					offsetY = firefoxOffsetY_marker;
				} 
				jQuery("#insertionMarker").css("top", divYPositions[prop] + offsetY + 'px');
				//insertionMarker.style.top = divYPositions[prop] + offsetY + 'px';
				jQuery("#insertionMarker").css("left", divXPositions[prop] + offsetX + 'px');
				//insertionMarker.style.left = divXPositions[prop] + offsetX + 'px';
				jQuery("#insertionMarker").show();
				//insertionMarker.style.display='block';	
				destinationObject = document.getElementById(prop);
				elementFound = true;	
				break;	
			}				
		}
		
		if(!elementFound){
			jQuery("#insertionMarker").hide();
			//insertionMarker.style.display='none';
			destinationObject = false;
		}
		
		return false;
		
	}

	// brackets are not recognize by jQuery
	// see http://groups.google.com/group/jquery-en/browse_thread/thread/29438736a4369d7b
	function $$(selector, context){ 
		return jQuery(selector.replace(/(\[|\])/g, '\\$1'),context) 
	} 
	
	function getDivCoordinates()
	{
		var divs = document.getElementsByTagName('DIV');
		for(var no=0;no<divs.length;no++){	
			if(divs[no].className=='imageBox' || divs[no].className=='imageBoxHighlighted' && divs[no].id){
				divXPositions[divs[no].id] = getLeftPos(divs[no]);
				divYPositions[divs[no].id] = getTopPos(divs[no]);			
				divWidth[divs[no].id] = divs[no].offsetWidth;			
				divHeight[divs[no].id] = divs[no].offsetHeight;	
				// show coordinates
				// $$('#' + divs[no].id + ' span').html("X: " + getLeftPos(divs[no])+ " Y: " + getTopPos(divs[no]));		
			}		
		}
	}
	
	// seralize the ImageOrder
	function saveImageOrder()
	{
		var serial = "";
		var objects = document.getElementsByTagName('DIV');
		for(var no=0;no<objects.length;no++){
			if(objects[no].className=='imageBox' || objects[no].className=='imageBoxHighlighted'){
				if (serial.length > 0)	serial = serial + '&'
				serial = serial + "sortArray[]=" + objects[no].id;
			}			
		}
		jQuery('input[name=sortorder]').val(serial);
		// debug( 'This is the new order of the images(IDs) : <br>' + orderString );
		
	}
	
	function initGallery()
	{
		var divs = document.getElementsByTagName('DIV');
		for(var no=0;no<divs.length;no++){
			if(divs[no].className=='imageBox_theImage' || divs[no].className=='imageBox_label'){
				divs[no].onmousedown = selectImage;	

			}
		}
		
		var insObj = document.getElementById('insertionMarker');
		var images = insObj.getElementsByTagName('IMG');
		document.body.onselectstart = cancelEvent;
		document.body.ondragstart = cancelEvent;
		document.body.onmouseup = dragDropEnd;
		document.body.onmousemove = dragDropMove;

		
		window.onresize = getDivCoordinates;
		
		dragDropDiv = document.getElementById('dragDropContent');
		// insertionMarker = document.getElementById('insertionMarker');
		jQuery("#insertionMarker").hide();
		getDivCoordinates();
	}
	
	function debug(value) {
		document.getElementById('debug').innerHTML = value;
	}
	
	window.onload = initGallery;