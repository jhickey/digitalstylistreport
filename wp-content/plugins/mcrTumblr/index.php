<?php
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
		$html = "<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>Mark Curtis Project</title>
</head>
<body>
<singleline></singleline>
    <table width='800' border='0' cellspacing='0' cellpadding='0' style='padding: 25px; margin:0 auto;'>
        <tr id='header'>
            <td>&nbsp;</td>
      </tr>
        <tr>
            <td>
                <p style='font-family:'Helvetica'; font-weight:bold; font-size: 14px; line-height: 16px;'>
                    </p>
                              </td>
        </tr>
        <tr>
            <td>
				<img src='http://localhost:8888/digitalstylistreport/wp-content/uploads/1372362969/mcr_jpg' alt='Image 1' width='800' height='78' style='clear:both; display:block;' />
                <div class='image-container' style='font-family:'Helvetica'; font-weight:bold; font-size:14px; line-height:22px; margin-bottom: 25px;'> It's Friday everybody. Here are some things to look for in today's MCR. The 3D skirt on 8, 'awesome' on 13, shoes on 15, the skirt on 20, the eyebrows on 21, eye shadow on 22 and back of the dress on 26. My prediction are that Ryan Hohman's favorites are going to be 1, 3, 4, 12, and 14. And yes, you need to buy the mint green suit in 23.
Have a great weekend!</div>";
		$i = 1;
		foreach ($the_files as $value) {
			$url = $upload_dir['baseurl'].'/'.$the_time.'/'.$value;
			$wpdb->query("INSERT INTO wp_mcr_files (url, time) VALUES ('$url', '$the_time')");
			$my_post = array(
				'post_title'    => $the_post["sub_".$value],
				'post_content'  => '<img src="'.$url.'" width="800" style="clear:both; display:block;"/><br>'.$the_post["body_".$value].'<br><a href="'.home_url().'?page_id='.$vote_id.'&i='.$wpdb->insert_id.'&u=-name-" target="_blank">Vote for this!</a>',
				'post_status'   => 'publish',
				'post_author'   => 1,
			);
			$html.="<div class='image-container' style='font family:'Helvetica'; font-weight:bold; font-size:14px; line-height:22px;'>
                    <p class='title' style='width:100%; float:left; border-bottom:4px solid #292929;'>
                        <span class='count' style='font-size:20px;'>".$i.".</span> ".$my_post['post_title']."</p>
                    ".$my_post['post_content']."</div>";
			wp_insert_post($my_post);
			$i++;
    	}
    		$old_vote_page = get_page_by_title( 'Vote' );
			$my_vote_page = array(
				'ID'    => $vote_id,
				'post_name' => $the_time
			);
			wp_update_post($my_vote_page);

			$html.="</td>
        </tr>
    </table>
    <p>unsubscribe</p>
</body>
</html>
";
	postEmailTemplate(array('html'=>$html));
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

function postEmailTemplate($template){
	$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, 'http://127.0.0.1:8888/mail/public/template/1');
curl_setopt($ch,CURLOPT_POST, 1);
curl_setopt($ch,CURLOPT_POSTFIELDS, $template);
//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);
}