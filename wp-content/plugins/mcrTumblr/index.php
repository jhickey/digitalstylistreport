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
			<form method="post" id="the_form">
            	<div class="span6">
            		<h3 class="drop-text">Drag photos here to upload to tumblr.</h3>
					<div id="fileDropTarget" class="dropzone-previews">
					</div>
					<button class="btn" id="btn-preview">Preview</button><br />

						<button id="submit_button">Publish</button>
						<input type="hidden" name="publish", value="true"/>
					<button class="btn" id="btn-clear">Clear</button><br />

					<div id="loading-div">Uploading, please wait. <img src="'.plugins_url('mcrTumblr/img/ajax-loader.gif').'" /></div>
					<div id="done-div">Upload is complete!</div>
            	</div>
            </form>
          </div>';
    if( isset($_POST['publish']))
    {
    	global $wpdb;
    	$the_post = $_POST;
    	$upload_dir = wp_upload_dir();
    	$the_time = time();
    	$the_base = $upload_dir['basedir'];
    	$old_vote_page = get_page_by_title( 'Vote' );
		$vote_id = $old_vote_page->ID;
		$the_files = directoryToArray('current', $the_time, $the_base);
		foreach ($the_files as $value) {
			$url = $upload_dir['baseurl'].'/'.$the_time.'/'.$value;
			$wpdb->query("INSERT INTO wp_mcr_files (url, time) VALUES ('$url', '$the_time')");
			$my_post = array(
				'post_title'    => $the_post["sub_".$value],
				'post_content'  => '<img src="'.$url.'"/><br>'.$the_post["body_".$value].'<br><a href="'.home_url().'?page_id='.$vote_id.'&i='.$wpdb->insert_id.'" target="_blank">Vote for this!</a>',
				'post_status'   => 'publish',
				'post_author'   => 1,
			);
			wp_insert_post($my_post);
    	}
    		$old_vote_page = get_page_by_title( 'Vote' );
			$my_vote_page = array(
				'ID'    => $vote_id,
				'post_name' => $the_time
			);
			wp_update_post($my_vote_page);
    }
}

function directoryToArray($directory, $time, $base) {
	$full_dir = $base.'/'.$directory.'/';
	$timePath = $base.'/'.$time.'/';
	if (!file_exists($timePath)) {
    	mkdir($timePath);
	}
	$array_items = array();

	if ($handle = opendir($full_dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (!is_dir($full_dir. "/" . $file)) {
					$no_dot = str_replace('.', '_', $file);
					rename($full_dir. "/" . $file, $timePath.$no_dot);
					$array_items[] = preg_replace("/\/\//si", "/", $no_dot);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}