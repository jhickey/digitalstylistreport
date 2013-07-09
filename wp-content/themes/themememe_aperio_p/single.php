<?php get_header(); ?>

	<div id="container">
		<div id="content">
		
<?php the_post(); ?>
			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">&laquo;</span> %title') ?></div>
				<div class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">&raquo;</span>') ?></div>
			</div>
			<div class="category">
					<h2><?php the_category('<span>'); ?></h2>
					</div>


<div class="preview <?php sandbox_post_class() ?>" style="background: #999 url('<?php $key="post-image"; echo get_post_meta($post->ID, $key, true); ?>') no-repeat;" >
<div class="bigdate"><?php the_time('d M'); ?></div>
<div class="preview-content">
<div class="entry-meta">

					<?php printf(__('By %1$s. Posted <abbr class="published" title="%2$sT%3$s">%4$s at %5$s</abbr>. Filed under %6$s%7$s. <a href="%8$s" title="Permalink to %9$s" rel="bookmark">Permalink</a>. <a href="%10$s" title="Comments RSS to %9$s" rel="alternate" type="application/rss+xml">Subscribe</a> to this post&rsquo;s comments.', 'sandbox'),
						'<span class="author vcard"><a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a></span>',
						get_the_time('Y-m-d'),
						get_the_time('H:i:sO'),
						the_date('', '', '', false),
						get_the_time(),
						get_the_category_list(', '),
						get_the_tag_list(' '.__('and tagged').' ', ', ', ''),
						get_permalink(),
						wp_specialchars(get_the_title(), 'double'),
						comments_rss() ) ?>

<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Comments and trackbacks open ?>
					<?php printf(__('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">leave a trackback</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Only trackbacks open ?>
					<?php printf(__('Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'sandbox'), get_trackback_url()) ?>
<?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Only comments open ?>
					<?php printf(__('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'sandbox')) ?>
<?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Comments and trackbacks closed ?>
					<?php _e('Both comments and trackbacks are currently closed.') ?>
<?php endif; ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>"); ?>

				</div>

</div>
</div>



			<div id="post-<?php the_ID(); ?>" class="<?php sandbox_post_class(); ?>">
<h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" ><?php the_title() ?></a></h2>
				<div class="entry-content">
<?php the_content(''.__('Read More <span class="meta-nav">&raquo;</span>', 'sandbox').''); ?>

					<?php wp_link_pages('before=<div class="page-link">' .__('Pages:', 'sandbox') . '&after=</div>') ?>
				</div>
							</div><!-- .post -->
														


			<div id="nav-below" class="navigation">
				
			
			
<div class="browse"><h3>Browse</h3></div>

		<?php 
			$previouspost = get_previous_post($in_same_cat, $excluded_categories);
			
			if ($previouspost != null) {
			
			echo '<div class="nav-previous">';
			previous_post_link('Previous: %link');
			echo '</div><div class="nav-excerpt">';
			previous_post_excerpt();
			echo '</div>';
			 } ?>
			 

				
				
				<?php 
			$nextpost = get_next_post($in_same_cat, $excluded_categories);
			
			if ($nextpost != null) {
			
			echo '<div class="nav-next">';
			next_post_link('Next: %link');
			echo '</div><div class="nav-excerpt">';
			next_post_excerpt();
			echo '</div>';
			 } ?>

			</div><!-- #nav-below -->
			
		

<?php comments_template(); ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>