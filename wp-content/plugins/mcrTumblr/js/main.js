jQuery(document).ready(function(){
	
	jQuery('#loading-div').hide();
	jQuery('#done-div').hide();
	
	jQuery('button').click(function (){
		myDropzone.processQueue();
	});
	
	var myDropzone = new Dropzone(document.body, { 
    	url: url_prefix + 'index.php', 
	    previewsContainer: "#fileDropTarget", 
    	enqueueForUpload: false
	});	
	
	myDropzone.on("addedfile", function(file) {
		myDropzone.filesQueue.push(file);
	});
	
	myDropzone.on("sending", function(file) {
		jQuery('#loading-div').show()
		jQuery('button').attr('disabled','disabled');
	});
	myDropzone.on("success", function(file) {
		jQuery('#loading-div').hide()
        jQuery('button').removeAttr('disabled');
        jQuery('#fileDropTarget').html('');
        jQuery('#done-div').show();
        setInterval(function(){jQuery('#done-div').fadeOut('fast');},1000);
    });
    myDropzone.on("error", function(file) {
			alert('error!');
    });	
});

