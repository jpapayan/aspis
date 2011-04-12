/**
 * NextGEN Gallery - SWFUpload Handler 
 *   http://alexrabe.boelinger.com/
 *
 * Built on top of the swfupload library
 *   http://swfupload.org version 2.2.0
 *
 *  version 1.0.2
 */

// on load change the upload to swfupload
function initSWFUpload() { 
	jQuery(function() {
		jQuery("#uploadimage_btn").after("<input class='button-primary' type='button' name='uploadimage' id='swfupload_btn' value='" + ngg_swf_upload.customSettings.upload + "' />")
								  .remove();
		jQuery("#swfupload_btn").click( function() { submitFiles(); } );
		jQuery("#imagefiles")
			.after("<div id='uploadQueue'></div>")
			.after("<input id='imagefiles' type='button' class='button-secondary uploadform' value='" + ngg_swf_upload.customSettings.browse + "' />")
			.after("<input type='text' id='txtFileName' readonly='readonly' />")				
			.remove();
		jQuery("#imagefiles").click( function() { fileBrowse(); } );
		jQuery("#progressbar-wrap").hide();
	});
}
 
// call the upload dialog
function fileBrowse() {
	jQuery("#txtFileName").val("");
	ngg_swf_upload.cancelUpload();
	ngg_swf_upload.selectFiles();
}

// called when a file is added
function fileQueued(fileObj) {
	filesize = " (" + Math.round(fileObj.size/1024) + " kB) ";;
	jQuery("#txtFileName").val(fileObj.name);
	jQuery("#uploadQueue")
		.append("<div id='" + fileObj.id + "' class='nggUploadItem'> [<a href='javascript:removeFile(\"" + fileObj.id + "\");'>" + ngg_swf_upload.customSettings.remove + "</a>] " + fileObj.name + filesize + "</div>")
		.children("div:last").slideDown("slow")
		.end();
}

// start the upload
function submitFiles() {
	// check if a gallery is selected
	if (jQuery('#galleryselect').val() > "0") {
		jQuery("#progressbar-wrap").show();
		// get old post_params
		post_params = ngg_swf_upload.getSetting("post_params");
		// update the selected gallery in the post_params 
		post_params['galleryselect'] = jQuery('#galleryselect').val();
		ngg_swf_upload.setPostParams(post_params);
		ngg_swf_upload.startUpload();
	} else {
		jQuery('#uploadimage_form').prepend("<input type=\"hidden\" name=\"swf_callback\" value=\"-1\">");
		jQuery("#uploadimage_form").submit();
	}
}

// called when a file will be removed
function removeFile(fileID) {
	ngg_swf_upload.cancelUpload(fileID);
	jQuery("#" + fileID).hide("slow");
	jQuery("#" + fileID).remove();
}

// called before the uploads start
function uploadStart(fileObj) {
	jQuery("#progressbar span").text("0% - " + fileObj.name);	
	return true;
}

// called during the upload progress
function uploadProgress(fileObj, bytesLoaded) {
	var percent = Math.ceil((bytesLoaded / fileObj.size) * 100);
	jQuery("#progressbar").css("width", percent + "%");
	jQuery("#progressbar span").text(percent + "% - " + fileObj.name);
}

// called when the file is uploaded
function uploadComplete(fileObj) {
	jQuery("#" + fileObj.id).hide("slow");
	jQuery("#" + fileObj.id).remove();
	if ( ngg_swf_upload.getStats().files_queued == 0) {
		jQuery("#progressbar-wrap").hide()
		jQuery("#uploadimage_form").submit();
	}
}

// called when all files are uploaded
function uploadSuccess(fileObj, server_data) {
	// Show any error message
	if (server_data != 0){
		jQuery("#progressbar-wrap").append("<div><strong>ERROR</strong>: " + fileObj.name + " : " + server_data + "</div>");
	}
	// Upload the next file until queue is empty
	if ( ngg_swf_upload.getStats().files_queued > 0) {
		ngg_swf_upload.startUpload();
	} else {
		// server_data could be add as hidden field
		jQuery('#uploadimage_form').prepend("<input type=\"hidden\" name=\"swf_callback\" value=\"" + server_data + "\">");				 
	}		
}
		
// called on error
function uploadError(fileObj, error_code, message) {
	var error_name = "";
	switch(error_code) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			error_name = "HTTP ERROR";
		break;
		case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
			error_name = "MISSING UPLOAD URL";
		break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			error_name = "IO FAILURE";
		break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			error_name = "SECURITY ERROR";
		break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			error_name = "UPLOAD LIMIT EXCEEDED";
		break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			error_name = "UPLOAD FAILED";
		break;
		case SWFUpload.UPLOAD_ERROR.SPECIFIED_FILE_ID_NOT_FOUND:
			error_name = "SPECIFIED FILE ID NOT FOUND";
		break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			error_name = "FILE VALIDATION FAILED";
		break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			error_name = "FILE CANCELLED";
			return;
		break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			error_name = "FILE STOPPED";
		break;
		default:
			error_name = "UNKNOWN";
		break;
	}
	jQuery("#progressbar-wrap").append("<div><strong>ERROR " + error_name + " </strong>: " + fileObj.name + " : " + message + "</div>");
	jQuery("#" + fileObj.id).hide("slow");
	jQuery("#" + fileObj.id).remove();
	if ( ngg_swf_upload.getStats().files_queued > 0) {
		ngg_swf_upload.startUpload();
	} else {
		jQuery("#progressbar-wrap").hide()
		jQuery('#uploadimage_form').prepend("<input type=\"hidden\" name=\"swf_callback\" value=\"" + error_name + "\">");
		jQuery("#uploadimage_form").submit();
	}
}