<?php
 /*
   Plugin Name: Branderati MCR Voting Receiver
   Plugin URI: http://branderati.com
   Description: Receive votes for the MCR Photo Contest
   Version: 0.1
   Author: Jared Alessandroni
   Author URI: http://branderati.com
   License: Private
 */

//number of seconds until posts can no longer be voted on. Set to 24 hrs (86400 seconds)  by default.
define("POST_EXPIRE_TIME", 86400 );

add_action('the_post','mcrResults');

function mcrResults($content) {

	wp_register_style( 'vote-style', plugins_url('vote.css', __FILE__) );
	wp_enqueue_style( 'vote-style' );

	//page must be named 'Vote'
	if (!is_admin() && $content->post_title == 'Vote')
	{
		$votes_table = "wp_mcr_votes";
		$files_table = "wp_mcr_files";
		global $wpdb;
		//get user name or use ip address if username is not available
		$user = $_GET["u"] ?: $_SERVER["REMOTE_ADDR"];
		$image = $_GET["i"];
		if (isset($user) && isset($image)){

			$user_count = $wpdb->get_var("SELECT COUNT(*) FROM $votes_table where user = '$user' AND image_id = '$image'");
			if ($user_count <= 0 )
			{
				$current_time = time();
				$wpdb->insert($votes_table, array('time' => $current_time, 'user' => $user ,'image_id' => $image));
				print 'Congratulations - your vote has been counted.';
			}
			else{
				print 'One vote per item please';
			}

		}
		$results = array();
		$current_time = time();
		$vote_page = get_page_by_title( 'Vote' );
		$stamp = substr($vote_page->post_name, 0, 10);
		//just in case something went wrong with the post to tumblr, we'll ignore anything that dosen't have a tumblr URL
		$pic_arrays = $wpdb->get_results("SELECT id,url FROM $files_table WHERE time = '$stamp'");


		foreach ($pic_arrays as $pics) {
			$id = $pics->id;
 			$results[$id] = $wpdb->get_var("SELECT COUNT(*) FROM $votes_table where image_id = '$id'");
 		}

		$most = 0;
		foreach ($results as $r) {
			if ($r > $most)
				$most = $r;
		}
		$multiplier = (500 * (1 / $most));

		?>
		<br /><br />
		<div id="results"><?php foreach ($pic_arrays as $pics) {
			$id = $pics->id;
			$url = $pics->url;
		?>
			<div class='vote-row'>
				<div class="left"><img src="<?php echo $url; ?>" /></div>
				<div class="right">
					<div class="fill" style="width:<?php echo ($results[$id] * $multiplier); ?>px;<?php echo (($results[$id]!=0 && $results[$id] == $most)?'background:#F63641':'');?>">
					</div>
					<div class="count">
						<?=$results[$id].($results[$id] == 1 ? ' Vote' : ' Votes')?>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
				<?php } ?>

		</div>

<?php
	}

}


?>