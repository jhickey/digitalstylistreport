<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header() ?>
	
	<div id="container">
		<div id="content">

<?php the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">
			<div class="category">
				<h2 class="page-title"><?php the_title() ?></h2>
				</div>
				<div class="entry-content">


					<ul id="archives-page" class="xoxo">
						<li id="category-archives" class="content-column">
							<div class="comment-count">
							<h3><?php _e('By Category', 'sandbox') ?></h3></div>
							<ul>
								<?php wp_list_cats('sort_column=name&optioncount=1&feed=RSS') ?> 
							</ul>
						</li>
						<li><div class="clear"></div></li>
						<li id="monthly-archives" class="content-column">
							<div class="comment-count"><h3><?php _e('By Month', 'sandbox') ?></h3>
							</div>
							<ul>
								<?php wp_get_archives('type=monthly&show_post_count=1') ?>
							</ul>
						</li>
					</ul>
<!-- <?php edit_post_link(__('Edit', 'sandbox'),'<span class="edit-link">','</span>') ?> -->

				</div>
			</div><!-- .post -->

<?php if ( get_post_custom_values('comments') ) comments_template() // Add a key/value of "comments" to enable comments on pages! ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>