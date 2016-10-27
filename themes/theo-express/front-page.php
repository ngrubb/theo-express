<?php
/**
 * The front page template
 */
get_header(); ?>

	<div id="primary" >
		<main id="main" class="site-main" role="main">
			<div class="bg--yellow">
            <section class="page-content col-full">

				<?php the_content(); ?>

			</section>
            </div>
<div class="bg--black soft--ends clearfix">
            <section class="featured-testimonials col-full text-center">
                <?php 
                $testimonials = new WP_Query( array(
                    'post_type'      => 'testimonial',
                    'posts_per_page' => 4,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'meta_key'       => 'featured',
                    'meta_value'     => 1
                ));
                if( $testimonials->have_posts() ): ?>
                	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/white-logo.png" />
                    <hr />
                    
                        <h2>What Are Others Saying?</h2>
                        <?php while( $testimonials->have_posts() ):
                            $testimonials->the_post(); 
                            $testimonial = get_post( get_the_ID() );
                            $t_content = $testimonial->post_content;?>
                            
                            <div class="col-xxs-12 col-sm-4 single-testimonial">
                                <p>"<?php echo $t_content; ?>"</p>
                                <span><?php the_title(); ?></span>
                            </div>

                        <?php endwhile; ?>
                        <div class="col-xxs-12 text--center">
                        <a class="btn btn--primary" href="/product/subscription/">Sign up!</a>
                        </div>
                    </div>
                <?php endif; wp_reset_postdata(); ?>

            </section>

			<?php
            $recent = new WP_Query( array(
                'post_type'      => 'product',
                'posts_per_page' => 8,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'tax_query'      => array(
			        array(
			            'taxonomy'      => 'product_cat',
			            'terms'         => 10,
			            'operator'      => 'NOT IN' 
			        )
			    )
            ));
        	?>
        	<?php if( $recent->have_posts() ): ?>
        	
        	

           <div class="recent-titles col-full">

                <h2>New to the Library:</h2>
          
    		    <div class="recent-slider2">
                    
                    <?php while( $recent->have_posts() ):
                        $recent->the_post(); 
                        $product = wc_get_product( get_the_ID() ); ?>
                        <div class="slide">
                        
                            <?php echo $product->get_image('medium'); ?>
                            <div class="slide-content">
                            	<h5 class="recent__name"><?php the_title(); ?></h5>
                                <a class="btn btn--primary" href="<?php the_permalink(); ?>">View Details</a>
                            </div>

                        </div>
                    <?php endwhile;  ?>

                </div>

           </div>

        <?php endif; wp_reset_postdata(); ?>
        
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>