<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php if (have_posts()) : ?>
<div class="comment-count">
		<h2 class="page-title"><?php _e('Search Results for:', 'sandbox') ?> <span id="search-terms"><?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></span></h2>
</div>
			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
			<div class="preview <?php sandbox_post_class() ?>" >
<?php include (TEMPLATEPATH . '/post-image.php'); ?><div class="bigdate"><?php the_time('d M'); ?></div>
</div>


<div class="preview-content">

<div class="entry-meta">
				
				<ul>
					<li class="author vcard"><?php printf(__('By %s', 'sandbox'), '<a class="url fn n" href="'.get_author_link(false, $authordata->ID, $authordata->user_nicename).'" title="' . sprintf(__('View all posts by %s', 'sandbox'), $authordata->display_name) . '">'.get_the_author().'</a>') ?></li>
					<li class="cat-links"><?php printf(__(' Filed under: %s', 'sandbox'), get_the_category_list(', ')) ?></li>
					
					<li><?php the_tags(__('<span class="tag-links">Tags: ', 'sandbox'), ", ", "</span>\n\t\t\t\t\t\n") ?>
<?php edit_post_link(__('Edit', 'sandbox'), "\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n"); ?></li>
					<li class="comments-link">Comments: <?php comments_popup_link(__('Add a Comment', 'sandbox'), __('1', 'sandbox'), __('%', 'sandbox')) ?></li>
					</ul>
				</div>
			</div><!-- .post -->


							
				<div class="entry-content">
				<h3 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'sandbox'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h3>

<?php the_excerpt(''.__('Read More <span class="meta-nav">&raquo;</span>', 'sandbox').'') ?>

				</div>
			</div><!-- .post -->

<?php endwhile ?>

				
			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>

<?php else : ?>

			<div id="post-0" class="post noresults">
				<h2 class="entry-title"><?php _e('Nothing Found', 'sandbox') ?></h2>
				<div class="entry-content">
					<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'sandbox') ?></p>
				</div>
				<form id="noresults-searchform" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="noresults-s" name="s" type="text" value="<?php echo wp_specialchars(stripslashes($_GET['s']), true) ?>" size="40" />
						<input id="noresults-searchsubmit" name="searchsubmit" type="submit" value="<?php _e('Find', 'sandbox') ?>" />
					</div>
				</form>
			</div><!-- .post -->

<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>