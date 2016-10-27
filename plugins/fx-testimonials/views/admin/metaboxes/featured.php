<?php
/*
Title: Featured
Post Type: testimonial
Context: side
Priority: default
*/

global $post;
$is_featured = ($v = get_post_meta( $post->ID, 'featured', true)) ? $v : 0;
?>

<input id="post_meta_featured_yes" name="post_meta[featured]" type="radio" value="1" <?php checked($is_featured, 1); ?>>
<label for="post_meta_featured_yes">Yes</label>

<input id="post_meta_featured_no" name="post_meta[featured]" type="radio" value="0" <?php checked($is_featured, 0); ?>>
<label for="post_meta_featured_no">No</label>