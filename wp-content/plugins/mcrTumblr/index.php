<?
 /*
   Plugin Name: Branderati MCR Tumblr Uploader
   Plugin URI: http://branderati.com
   Description: Upload to Tumblr
   Version: 0.1
   Author: Jimmy Hickey
   Author URI: http://branderati.com
   License: Private
 */
 
add_action( 'admin_menu', 'tumblr_upload' );
 
function tumblr_upload (){ 
	add_options_page( 'Tumblr Upload Options', 'Tumblr Upload', 'manage_options', 'tumblr-upload-plugin', 'render_plugin' );
	
}

function render_plugin(){
	wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js');
	wp_enqueue_script('dropzone',  plugins_url('js/vendor/dropzone.js', __FILE__));
	wp_enqueue_script('main', plugins_url('js/main.js', __FILE__));
	
	wp_register_style( 'main-style', plugins_url('css/main.css', __FILE__) );
	wp_enqueue_style('main-style');
	
	global $wpdb;
	
	echo '<script>var url_prefix ="'.plugins_url('mcrTumblr/upload/').'"</script>';
	echo '<div class="container">
            	<div class="span6">
            		<h3 class="drop-text">Drag photos here to upload to tumblr.</h3>
					<div id="fileDropTarget" class="dropzone-previews">
					</div>
					<button class="btn">Publish To Tumblr</button><br />

					<div id="loading-div">Uploading, please wait. <img src="'.plugins_url('mcrTumblr/img/ajax-loader.gif').'" /></div>
					<div id="done-div">Upload is complete!</div>
            	</div>
            </div>';
}