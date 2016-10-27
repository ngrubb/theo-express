<?php
/*
Title: Client Information
Post Type: testimonial
Context: normal
Priority: default
*/


global $post, $wpdb;
?>

<!--
<p>
    <label for="post_meta_client_name"><?php _e( "Client Name", 'fx-testimonials' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[client_name]" id="post_meta_client_name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'client_name', true ) ); ?>">
</p>
-->

<p>
    <label for="post_meta_company_name"><?php _e( "Company Name", 'fx-testimonials' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[company_name]" id="post_meta_company_name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'company_name', true ) ); ?>">
</p>

<!--
<p>
    <label for="post_meta_company_url"><?php _e( "Company URL", 'fx-testimonials' ); ?></label>
    <br />
    <input class="widefat" type="text" name="post_meta[company_url]" id="post_meta_company_url" value="<?php echo esc_attr( get_post_meta( $post->ID, 'company_url', true ) ); ?>">
</p>
-->

<p>
    <label for="post_meta_position"><?php _e( "Position", 'fx-testimonials' ); ?></label>
    <br />
    <input class="widefat" type="position" name="post_meta[position]" id="post_meta_position" value="<?php echo esc_attr( get_post_meta( $post->ID, 'position', true ) ); ?>">
</p>

<p>
    <label for="post_meta_email"><?php _e( "Email", 'fx-testimonials' ); ?></label>
    <br />
    <input class="widefat" type="email" name="post_meta[email]" id="post_meta_email" value="<?php echo esc_attr( get_post_meta( $post->ID, 'email', true ) ); ?>">
</p>


