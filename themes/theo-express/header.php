<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php storefront_html_tag_schema(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='https://fonts.googleapis.com/css?family=Cinzel:400,700,900|Open+Sans+Condensed:300|Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php
	// do_action( 'storefront_before_header' ); ?>
	<div class="site__navigation">

		<div id="site-logo" >
			<a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.png" width="110" height="80" /></a>
		</div>

		<?php
            // Output the main Menu
            wp_nav_menu( array(
                'theme_location' => 'primary'
                ,'container'       => 'nav'
                ,'depth' => 3
            ));
        ?>

        <?php do_action( 'theoexpress_header' ); ?>

    </div>

	<?php
	/**
	 * @hooked storefront_header_widget_region - 10
	 */
	do_action( 'storefront_before_content' ); ?>

	<?php if ( is_front_page() ) : ?>

		<div class="masthead--slideshow">
            <?php echo do_shortcode('[fx-slideshow]'); ?> 
        </div><!-- masthead end -->

	<?php endif; ?>

	<div id="content" class="site-content" tabindex="-1">
		<div >

		<?php
		/**
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'storefront_content_top' ); ?>

