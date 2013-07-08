<div id="comments">

<?php
	$req = get_option('require_name_email'); // Checks if fields are required. Thanks, Adam. ;-)
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
				<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'sandbox') ?></div>
			</div><!-- .nopassword -->
<?php
		return;
	endif;
endif;
?>

<?php $i = 0; ?>
<?php if ( $comments ) : ?>
<?php global $sandbox_comment_alt ?>

<?php /* numbers of pings and comments */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>
<?php if ( $comment_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

				<div id="comments-list" class="comments">
				<div class="comment-count">
					<h3><?php printf($comment_count > 1 ? __('<span>%d</span> Comments', 'sandbox') : __('<span>One</span> Comment', 'sandbox'), $comment_count) ?></h3>
					</div>

					<ol>
<?php foreach ($comments as $comment) : ?>
<?php $i++; ?>
<?php if ( get_comment_type() == "comment" ) : ?>
						<li id="comment-<?php comment_ID() ?>" class="<?php sandbox_comment_class() ?>">
							
							<div class="comment-meta">
							<span class="count">
<?php echo $i; ?>
</span>
			<?php if (function_exists('get_avatar')) {
 	echo get_avatar( get_comment_author_email(), '60' );
 } else {
 	 if (function_exists('gravatar')) {
  	print "<img src=\"";
  	gravatar('R', 60);
  	print "alt=\"";
  	comment_author();
  	print "\" />";  
	}
 }
?>		
														<div class="comment-author vcard"><span class="fn n"><?php comment_author_link() ?></span></div><?php printf(__('%1$s at %2$s <span class="meta-sep"><br/></span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'sandbox'),
										get_comment_date(),
										get_comment_time(),
										'#comment-' . get_comment_ID() );
										edit_comment_link(__('Edit', 'sandbox'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'sandbox') ?>
							<div class="comment-text"><?php comment_text() ?></div>
						</li>
<?php endif; /* if ( get_comment_type() == "comment" ) */ ?>
<?php endforeach; ?>

					</ol>
				</div><!-- #comments-list .comments -->

			
<?php endif; /* if ( $comment_count ) */ ?>
<?php if ( $ping_count ) : ?>
<?php $sandbox_comment_alt = 0 ?>

<div id="trackbacks-list" class="comments">
<div class="comment-count">
					<h3><?php printf($ping_count > 1 ? __('<span>%d</span> Trackbacks', 'sandbox') : __('<span>One</span> Trackback', 'sandbox'), $ping_count) ?></h3>
</div>

					<ol>
<?php foreach ( $comments as $comment ) : ?>
<?php if ( get_comment_type() != "comment" ) : ?>

						<li id="comment-<?php comment_ID() ?>" class="<?php sandbox_comment_class() ?>">
						<div class="comment-meta">
							<div class="comment-author"><span class="comment-stamp"><?php printf(__('%1$s</span></div>%2$s at %3$s', 'sandbox'),
									get_comment_author_link(),
									get_comment_date(),
									get_comment_time() );
									edit_comment_link(__('Edit', 'sandbox'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
<?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'sandbox') ?>
							<div class="comment-text"><?php comment_text() ?></div>
						</li>
<?php endif /* if ( get_comment_type() != "comment" ) */ ?>
<?php endforeach; ?>

					</ol>
				</div><!-- #trackbacks-list .comments -->

				
<?php endif /* if ( $ping_count ) */ ?>
<?php endif /* if ( $comments ) */ ?>
<?php if ( 'open' == $post->comment_status ) : ?>
				<div id="respond">
				<div id="commentform-subhead">
					<h3><?php _e('Add Comment', 'sandbox') ?></h3>
</div>

<div class="respond-info">
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
				<div class="trackback-meta">
					<p id="login-req"><?php printf(__('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'sandbox'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>	
					</div>	
					</div>

<?php else : ?>					

<?php if ( $user_ID ) : ?>
<div class="comment-meta">
  	<p id="login"><?php printf(__('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'sandbox'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								get_option('siteurl') . '/wp-login.php?action=logout&amp;redirect_to=' . get_permalink() ) ?></p>
								</div>
</div><!-- #respond-info -->
<?php else : ?>
<div class="trackback-meta">
<p id="comment-notes"><?php _e('Your email is <em>never</em> published nor shared.', 'sandbox') ?> <?php if ($req) _e('Required fields are marked <span class="required">*</span>', 'sandbox') ?></p>
</div>

</div><!-- #respond-info -->

						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
							<div class="form-label"><label for="author"><?php _e('Name', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>

							<div class="form-label"><label for="email"><?php _e('Email', 'sandbox') ?></label> <?php if ($req) _e('<span class="required">*</span>', 'sandbox') ?></div>
							<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>

							<div class="form-label"><label for="url"><?php _e('Website', 'sandbox') ?></label></div>
							<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>

<?php endif /* if ( $user_ID ) */ ?>



<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
							<div class="form-label"><label for="comment"><?php _e('Comment', 'sandbox') ?></label></div>
							<div class="form-textarea"><textarea id="comment" name="comment" tabindex="6"></textarea></div>

							<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Post Comment', 'sandbox') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>

							<?php do_action('comment_form', $post->ID); ?>

						</form><!-- #commentform -->
			
<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>

				</div><!-- #respond -->
<?php endif /* if ( 'open' == $post->comment_status ) */ ?>

			</div><!-- #comments -->