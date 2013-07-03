fileOrder = [];
fileOrderData={};

function submitForm(){
	jQuery('#the_form').submit();
}

jQuery(document).ready(function(){
	jQuery.get('http://localhost:8888/digitalstylistreport/wp-content/plugins/mcrTumblr/upload/index.php?delete=true');
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
			jQuery.get('http://localhost:8888/digitalstylistreport/wp-content/plugins/mcrTumblr/upload/index.php?delete=true');
		}
	});

	var myDropzone = new Dropzone(document.body, {
		url: url_prefix + 'index.php',
		previewsContainer: "#fileDropTarget",
		autoProcessQueue: false,
		parallelUploads: 1000,
		sending: function (file, xhr, formData)
		{
			formData.append("json", JSON.stringify(fileOrderData));
		}
	});

	myDropzone.on("addedfile", function(file) {
		fileOrder.push(file.name);
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
			for (var i=0; i < fileOrder.length; i++)
			{
				fileOrderData[i] = fileOrder[i];
			}
			console.log(fileOrderData);
			//submitForm();
			myDropzone.processQueue();
		}
		return false;
	});
});

