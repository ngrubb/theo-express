<?php

function testimonials_shortcode($attrs)
{
    $attrs = shortcode_atts( array(

        'limit'   => -1
        ,'orderby' => 'date'
        ,'order' => 'DESC'
    ), $attrs );


    $testimonials = new WP_Query(array(
        'post_type' => 'testimonial'
        ,'orderby'  => $attrs['orderby']
        ,'order'    => $attrs['order']
    ));


    if(!$testimonials->have_posts()) return '';
    ob_start();

?>

    <div id="testimonials">

<?php

    while($testimonials->have_posts()): $testimonials->the_post();
    ?>


    <?php // echo get_post_meta( $testimonial->ID, 'client_name', true ); ?>
    <?php // echo get_post_meta( $testimonial->ID, 'company_name', true ); ?>
    <?php // echo get_post_meta( $testimonial->ID, 'position', true ); ?>
    <?php // echo get_post_meta( $testimonial->ID, 'email', true ); ?>



    
    <?php
          // We'll disply two testimonials to start, and hide the rest
          // Then we'll begin rotating through them all
          if ($testimonials->current_post < 2) {
               $style = "";
          } else {
               $style = 'style="display: none;"';
          }
     ?>

    <div class="slide" <?php echo $style; ?>>
    <blockquote class="testimonial-page__testimonial push-half--bottom push--top flush--sides" itemscope itemtype="http://schema.org/Review">
        <div class="cta-block__icon">
            <span class="icon-social"></span>
        </div>
        <h4>
            <cite itemprop="author" class="author"><?php echo get_post_meta( get_the_id(), 'client_name', true ); ?></cite><br>
            Company: <?php echo get_post_meta( get_the_id(), 'company_name', true ); ?>&nbsp;&nbsp;
            <!-- Link to Company URL -->
            <br>
            <?php if (get_post_meta( get_the_id(), 'company_url', true )): ?>
            Company URL: <a href="<?php echo get_post_meta( get_the_id(), 'company_url', true ); ?>" class="">
                 <?php echo get_post_meta( get_the_id(), 'company_url', true ); ?>
            </a>
            <?php endif; ?>
        </h4>
        <span itemprop="reviewBody">
            <?php the_content(); ?>
        </span>

    </blockquote>
    </div>

    <?php
    endwhile; wp_reset_postdata();
    ?>
    
    </div>
<script language="javascript">
(function( $ ) {

    $(function () {

        // Get a count of the slides
        var slides =  $('#testimonials .slide');

        // Set our index
        var current_index = 0;

        // Loop through each testimonial, fading out the currently visible slides
        // and fading in 2 others.
        setInterval(function(){

            $('#testimonials .slide').filter(':visible').fadeOut(1000,function(){
                $('#testimonials .slide').eq((current_index+2) % slides.length).fadeIn(1000);

                current_index = (current_index+1) % slides.length;
            });

        },8000);
    });
})(jQuery);
</script>

    <?php
    return ob_get_clean();
}

add_shortcode('testimonials', 'testimonials_shortcode');
