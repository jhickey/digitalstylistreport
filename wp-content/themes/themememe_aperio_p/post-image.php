<?php 

if (get_post_meta($post->ID, 'post-image', true) != null) {

print '<a href="';
the_permalink();
print '" title="';
the_title_attribute();
print '"><img src="';
$key="post-image";
echo get_post_meta($post->ID, $key, true);
print '" alt="" /></a>';

} else {

}
?>