function submitForm(){
	jQuery('#the_form').submit();
}
jQuery(document).ready(function(){

	jQuery('#loading-div').hide();
	jQuery('#done-div').hide();

	// jQuery('#btn-publish').click(function (){
	// 	myDropzone.processQueue();
	// });
	jQuery('#btn-clear').click(function (){
		var r = confirm("Are you sure you want to remove all photos?");
		if (r === true)
		{
			myDropzone.removeAllFiles();
		}
	});

	var myDropzone = new Dropzone(document.body, {
		url: url_prefix + 'index.php',
		previewsContainer: "#fileDropTarget",
		enqueueForUpload: true
	});

	myDropzone.on("addedfile", function(file) {
		//myDropzone.filesQueue.push(file);
		jQuery(file.previewElement).append('<input type="text" name="sub_'+ file.name +'"/>');
		jQuery(file.previewElement).append('<br><textarea name="body_'+ file.name +'"/></textarea>');
	});

	myDropzone.on("sending", function(file) {
		jQuery('#loading-div').show();
		jQuery('button').attr('disabled','disabled');
	});
	myDropzone.on("success", function(file) {
		jQuery('#loading-div').hide();
        jQuery('button').removeAttr('disabled');
        //jQuery('#fileDropTarget').html('');
        jQuery('#done-div').show();
        setInterval(function(){jQuery('#done-div').fadeOut('fast');},1000);
    });
    myDropzone.on("error", function(file) {
			alert('error!');
    });
    jQuery('#submit_button').click(function() {
		var r = confirm("Are you sure you're ready to publish?");
		if (r === true)
		{
			submitForm();
		}
		return false;
	});
});

