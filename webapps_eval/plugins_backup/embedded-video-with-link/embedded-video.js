function embeddedvideo_insert() {
	if(window.tinyMCE) {
		var postnumber = document.getElementById('post_ID').value;		

		tinyMCE.activeEditor.windowManager.open( {
				url : tinyMCE.activeEditor.documentBaseURI + '../../../wp-content/plugins/embedded-video-with-link/embedded-video-popup.php?post='+postnumber,
				width : 440,
				height : 220,
				resizable : 'no',
				scrollbars : 'no',
				inline : 'yes'
			}, { /* custom parameter space */ }
		);
		return true;
	} else {
		window.alert('This function is only available in the WYSIWYG editor');
		return true;
	}
}

function ev_insertVideoCode(portal, vid, linktext) {
	var text = (linktext == '') ? ('['+ portal + ' ' + vid + ']') : ('['+ portal + ' ' + vid + ' ' + linktext + ']');
	if(window.tinyMCE) {
		var ed = tinyMCE.activeEditor;
		ed.execCommand('mceInsertContent', false, '<p>' + text + '</p>');
		ed.execCommand('mceCleanup');
	}
	return true;
}

function ev_checkData(formObj) {	
	if (formObj.vid.value != '') ev_insertCode(formObj);
}

function ev_insertCode(formObj) {
	var portal = formObj.portal.value;
	var vid = formObj.vid.value;
	var linktext = (formObj.nolink.checked) ? 'nolink' : formObj.linktext.value;

	ev_insertVideoCode(portal, vid, linktext);
	tinyMCEPopup.close();
}

function disable_enable(objCheckbox, objTextfield) {
	objTextfield.disabled = (objCheckbox.checked) ? true : false;
	objTextfield.value = '';
	objTextfield.style.backgroundColor = (objTextfield.disabled) ? '#ccc' : '#fff';
}

function dailymotion(objSelectBox, objTextfield, objCheckbox) {
	if (objSelectBox.value=='dailymotion' || objSelectBox.value=='garagetv') {
		objCheckbox.checked = true;
		objTextfield.disabled = true;
		objTextfield.style.backgroundColor = '#ccc';
		objTextfield.value = '';
	}
	objCheckbox.disabled = (objSelectBox.value=='dailymotion' || objSelectBox.value=='garagetv') ? true : false;
}

function init() {
	tinyMCEPopup.resizeToInnerSize();
}
