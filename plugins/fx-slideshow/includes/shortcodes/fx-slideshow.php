<?php
/* -- custom fx slider shortcode -- */

function fx_slideshow(){
 
    $slides = new WP_Query(array(
        'post_type' => 'slideshow',
        'orderby' => 'menu_order title', 
        'posts_per_page' => -1,
        'order' => 'ASC'
    ));
    ?>
    
    <div class="slick-slider" id="slick-slider">
    
        <?php
         if($slides->have_posts()): while($slides->have_posts()): $slides->the_post();
        
            $post_id             = get_the_ID();
            $primary_image       = get_post_meta($post_id, '_thumbnail_id',true);
            $image               = wp_get_attachment_image_src( $primary_image, 'banner-image' );

            $banner_button_label = get_post_meta( $post_id, 'slide_button_text', true );
            $banner_button_link  = get_post_meta( $post_id, 'slide_link', true );
            $target = get_post_meta( $post_id, 'slide_link_window', true ) ? 'target="_blank"' : '';

            $title  = get_post_meta( $post_id, 'white_title', true );
            $title2 = get_post_meta( $post_id, 'white_title2', true );
            $desc   = get_post_meta( $post_id, 'yellow_title', true );
        ?>

            <div class="item">
    
                <div class="item__image"> 

                    <?php if ( has_post_thumbnail($post_id) ) : // check if the post has a Post Thumbnail assigned to it.   ?>                      
                            
                      <?php echo get_the_post_thumbnail( $post_id, 'banner-image', array( 'class' => 'img-responsive' ) ); ?>   
                        <!--<img src="<?php echo $image[0]; ?>" class="img-responsive" alt=""  />-->    
                    
                    <?php endif; ?>
                    
                </div>
    
                <div class="item__info"> 
                
                    <div class="item__info--title">
                        
                        <hgroup>
                            <h2> <?php echo $title;?> </h2>
                            <?php if ( !empty($title2) ) echo '<h3>'. $title2 . '</h3>'; ?>
                        </hgroup>

                        <p><?php echo $desc;?>  </p>                         
                
                    </div><!-- banner info title end -->
                    
                    <a href="<?php echo $banner_button_link; ?>" class="button button--primary"> <?php echo $banner_button_label; ?> </a>
                
                </div><!-- slider info end -->
    
    
            </div><!-- item end -->
              
        <?php endwhile; endif; wp_reset_postdata(); ?>
    
    </div><!-- slick slider end -->

<?php

}
add_shortcode('fx-slideshow','fx_slideshow');