<?php
/*
Title: Slide Options
Post Type: slideshow
Context: normal
Priority: default
*/


global $post, $wpdb;
?>

<p>
    <label for="post_meta_slide_link"><?php _e( "Title Text", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[white_title]" id="post_meta_white_title" value="<?php echo esc_attr( get_post_meta( $post->ID, 'white_title', true ) ); ?>" size="30" />
</p>

<p>
    <label for="post_meta_slide_link"><?php _e( "Title Text (line 2)", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[white_title2]" id="post_meta_white_title2" value="<?php echo esc_attr( get_post_meta( $post->ID, 'white_title2', true ) ); ?>" size="30" />
</p>

<p>
    <label for="post_meta_slide_link"><?php _e( "Description Text", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[yellow_title]" id="post_meta_yellow_title" value="<?php echo esc_attr( get_post_meta( $post->ID, 'yellow_title', true ) ); ?>" size="30" />
</p>


<p>
    <label for="post_meta_slide_link"><?php _e( "Caption", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[caption]" id="post_meta_caption" value="<?php echo esc_attr( get_post_meta( $post->ID, 'caption', true ) ); ?>" size="30" />
</p>


<p>
    <label for="post_meta_slide_link"><?php _e( "Slide Link URL", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[slide_link]" id="post_meta_slide_link" value="<?php echo esc_attr( get_post_meta( $post->ID, 'slide_link', true ) ); ?>" size="30" />
</p>
<p>
    <input type="checkbox" name="post_meta[slide_link_window]" id="post_meta_slide_link_window" value="1" <?php checked( get_post_meta( $post->ID, 'slide_link_window', true ), 1 ); ?> /> <label for="post_meta_slide_link_window">Open in new window</label>
</p>

<p>
    <label for="post_meta_slide_button_text"><?php _e( "Button Text", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[slide_button_text]" id="post_meta_slide_button_text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'slide_button_text', true ) ); ?>" size="30" />
</p>

<p>
    <label for="post_meta_slide_video"><?php _e( "Slide Video URL", 'wpfx' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[slide_video]" id="post_meta_slide_video" value="<?php echo esc_attr( get_post_meta( $post->ID, 'slide_video', true ) ); ?>" size="30" />
</p>