<?php

function testimonial_shortcode($attrs)
{
    $attrs = shortcode_atts( array(
        'id' => ''
    ), $attrs );

    if(empty($attrs['id'])) return '';

    $testimonial = get_post( $attrs['id'] );

    ob_start();
    ?>

    <div class="testimonial">
        <?php echo apply_filters( 'the_content', $testimonial->post_content ); ?>

        <?php echo get_post_meta( $testimonial->ID, 'client_name', true ); ?>
        <?php echo get_post_meta( $testimonial->ID, 'company_name', true ); ?>
        <?php echo get_post_meta( $testimonial->ID, 'position', true ); ?>
        <?php echo get_post_meta( $testimonial->ID, 'email', true ); ?>
    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('testimonial', 'testimonial_shortcode');