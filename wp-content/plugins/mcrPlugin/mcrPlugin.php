<?
 /*
   Plugin Name: Branderati MCR Voting Receiver
   Plugin URI: http://branderati.com
   Description: Receive votes for the MCR Photo Contest
   Version: 0.1
   Author: Jared Alessandroni
   Author URI: http://branderati.com
   License: Private
 */

add_action('the_post','mcrResults');

function mcrResults($content) {
	wp_register_style( 'vote-style', plugins_url('vote.css', __FILE__) );
	wp_enqueue_style( 'vote-style' );
	if (!is_admin() && $content->post_title == 'vote')
	{
		$table = "wp_mcr_votes";
		$ra = explode("/",$_SERVER["REQUEST_URI"]);
		global $wpdb;
		$user = $_GET["u"] ?: $_SERVER["REMOTE_ADDR"];
		$image = $_GET["i"];
		if (isset($user) && isset($image)){
			$user_count = $wpdb->get_var("SELECT COUNT(*) FROM $table where user = '$user' and image_id = '$image'");
			if ($user_count == 0) {
				$wpdb->insert($table, array('user' => $user ,'image_id' => $image, 'time' => time()));
				print 'Congratulations - your vote has been counted.';
			}
			else
			{
				print 'Oh no! It looks like you\'ve already voted here.';
			}
		}		
		
		$imageArray = explode("-",$image);
		$date = $imageArray[0];	
		
		$results = array();	
		$current_time = time();
		$pic_arrays = $wpdb->get_col("SELECT id FROM wp_files WHERE time > ($current_time - 86400)");
		foreach ($pic_arrays as $pics) {
 			$results[$pics] = $wpdb->get_var("SELECT COUNT(*) FROM $table where image_id = '$pics'");
 		}

		$most = 0;
		foreach ($results as $r) {
			if ($r > $most)
				$most = $r;
		} 
		$multiplier = (200 * (1 / $most)); 
		
		?>
		<br /><br />
		<div id="results"><? foreach ($pic_arrays as $pics) { ?>
			<div class='vote-row'>
				<div class="left">Image <?=$pics?></div>
				<div class="right">
					<div class="fill" style="width:<?=($results[$pics] * $multiplier)?>px;<?=(($results[$pics]!=0 && $results[$pics] == $most)?'background:#F63641':'')?>">
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
				<? } ?>

		</div>
		
<?	
	}

} 


?>