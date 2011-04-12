function quote(id){
	var url = $F('url') + '/wp-content/plugins/forumserver/quote.php&id=' + id;
	new Ajax.Updater('forumtext', url, {onComplete:function(){new Effect.ScrollTo('forumtext')} });
}

// Surrounds the selected text with text1 and text2.
function surroundText(text1, text2, textarea)
{
	// Can a text range be created?
	if (typeof(textarea.caretPos) != "undefined" && textarea.createTextRange)
	{
		var caretPos = textarea.caretPos, temp_length = caretPos.text.length;

		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? text1 + caretPos.text + text2 + ' ' : text1 + caretPos.text + text2;

		if (temp_length == 0)
		{
			caretPos.moveStart("character", -text2.length);
			caretPos.moveEnd("character", -text2.length);
			caretPos.select();
		}
		else
			textarea.focus(caretPos);
	}
	// Mozilla text range wrap.
	else if (typeof(textarea.selectionStart) != "undefined")
	{
		var begin = textarea.value.substr(0, textarea.selectionStart);
		var selection = textarea.value.substr(textarea.selectionStart, textarea.selectionEnd - textarea.selectionStart);
		var end = textarea.value.substr(textarea.selectionEnd);
		var newCursorPos = textarea.selectionStart;
		var scrollPos = textarea.scrollTop;

		textarea.value = begin + text1 + selection + text2 + end;

		if (textarea.setSelectionRange)
		{
			if (selection.length == 0)
				textarea.setSelectionRange(newCursorPos + text1.length, newCursorPos + text1.length);
			else
				textarea.setSelectionRange(newCursorPos, newCursorPos + text1.length + selection.length + text2.length);
			textarea.focus();
		}
		textarea.scrollTop = scrollPos;
	}
	// Just put them on the end, then.
	else
	{
		textarea.value += text1 + text2;
		textarea.focus(textarea.value.length - 1);
	}
}


var current_header = true; 

function shrinkHeader(mode){

	var val = "";
	document.getElementById("upshrinkHeader").style.display = mode ? "none" : "";
	document.getElementById("upshrinkHeader2").style.display = mode ? "none" : "";
	
	if (mode) {
		document.getElementById("upshrink").setAttribute("class", 'upshrink2');
	} else {
		document.getElementById("upshrink").setAttribute("class", 'upshrink');
	}

	if(mode == true){
		val = "yes";
	}
	if(mode == false){
		val = "no";
	}
	
	setCookie("wpf_header_state", val, 0 ); 

	current_header = mode;
}


function setCookie(name, value, expires, path, domain, secure) { 
	document.cookie= name + "=" + escape(value) + 
	(expires? "; expires=" + expires.toGMTString(): "") + 
	(path? "; path=" + path: "") + 
	(domain? "; domain=" + domain: "") + 
	(secure? "; secure": ""); 
}

function fold(){
	
	var lol = getCookie("wpf_header_state");
	if(lol == "yes")
		shrinkHeader(true);
	if(lol == "no")
		shrinkHeader(false);
}

function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=");
  if (c_start!=-1)
    { 
    c_start=c_start + c_name.length+1; 
    c_end=document.cookie.indexOf(";",c_start);
    if (c_end==-1) c_end=document.cookie.length;
    return unescape(document.cookie.substring(c_start,c_end));
    } 
  }
return "";
}


function selectBoards(ids){
	var toggle = true;

	for (i = 0; i < ids.length; i++)
		toggle = toggle & document.forms.wpf_searchform["forum" + ids[i]].checked;

	for (i = 0; i < ids.length; i++)
		document.forms.wpf_searchform["forum" + ids[i]].checked = !toggle;
}

function collapseExpandGroups(group, mode){
	
}

function expandCollapseBoards(){
	var current = document.getElementById("searchBoardsExpand").style.display != "none";
	document.getElementById("search_coll").src = skinurl+"/images" + (current ? "/upshrink2.gif" : "/upshrink.gif");
	document.getElementById("searchBoardsExpand").style.display = current ? "none" : "";
}

// Invert all checkboxes at once by clicking a single checkbox.
function invertAll(headerfield, checkform, mask)
{
	for (var i = 0; i < checkform.length; i++)
	{
		if (typeof(checkform[i].name) == "undefined" || (typeof(mask) != "undefined" && checkform[i].name.substr(0, mask.length) != mask))
			continue;

		if (!checkform[i].disabled)
			checkform[i].checked = headerfield.checked;
	}
}

function uncheckglobal(headerfield, checkform){
	checkform.mod_global.checked = false;
}



