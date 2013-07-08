<?php get_header() ?>

	<div id="container">
	
<div id="content">
			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>
		
<?php $my_query = new WP_Query('showposts=1');
  while ($my_query->have_posts()) : $my_query->the_post();
  $do_not_duplicate = $post->ID; ?>

<div class="featured <?php sandbox_post_class() ?>" >
<?php include (TEMPLATEPATH . '/post-image.php'); ?>
<div class="bigdate"><?php the_time('d M'); ?></div>
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-content"><?php the_title() ?><span class="post-content-excerpt"><?php the_excerpt(); ?></span></a>
</div><!-- .featured -->
<?php endwhile; ?>

<div class="recent">			
<?php query_posts('showposts=7'); ?>
<?php while (have_posts()) : the_post(); 
  if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>
<div id="post-<?php the_ID() ?>" class="<?php sandbox_post_class() ?>">

<?php include (TEMPLATEPATH . '/post-image.php'); ?>

<div class="bigdate"><?php the_time('d M'); ?></div>
<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="post-content"><?php the_title() ?><span class="post-content-excerpt"><?php the_excerpt(); ?></span></a>
</div><!-- .post -->
<?php endwhile ?>
</div><!-- .recent -->

			<div id="nav-below" class="navigation">
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'sandbox')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'sandbox')) ?></div>
			</div>

		</div><!-- #content -->
	</div><!-- #container -->

<?php get_sidebar() ?>
<?php get_footer() ?>