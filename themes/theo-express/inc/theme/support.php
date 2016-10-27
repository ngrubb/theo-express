<?php
/**
 * Theology Express: Storefront child theme support functions 
 */

/* Remove storefront actions */
add_action( 'after_setup_theme', 'remove_parent_theme_actions', 0 );
function remove_parent_theme_actions() {

	remove_action( 'storefront_header', 'storefront_primary_navigation', 50 );
	remove_action( 'woocommerce_after_main_content', 'storefront_after_content', 10 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

    // remove_action( 'storefront_footer', 'storefront_credit', 20 );
}

/* Add theo-express actions */
add_action( 'after_setup_theme', 'add_child_theme_actions', 10 );
function add_child_theme_actions() {

	add_action( 'woocommerce_after_main_content', 'theoexpress_after_content', 10 );
	add_action( 'theoexpress_header', 'storefront_header_cart', 10 );

    add_filter( 'storefront_credit_link', '__return_false' );
}

function theoexpress_after_content() { ?>
		</main><!-- #main -->
	</div><!-- #primary (test) -->
<?php }


add_action( 'pre_get_posts', 'exclude_membership_products' );
function exclude_membership_products( $query )
{

	if ( !$query->is_main_query() || !is_shop() || is_admin() ) 
		return;
	

	$query->set( 'tax_query', array( array(
		'taxonomy' => 'product_cat',
		'field' => 'id',
		'terms' => array( 10 ),
		'operator' => 'NOT IN'
		))
	);

}

add_action( 'theoexpress_header', 'user_account_menu', 12 );
function user_account_menu()
{

	if ( is_user_logged_in() ) : 
		$current_user = wp_get_current_user(); ?>
		<a href="/my-account/" title="View account details" id="account_link"><?php echo $current_user->display_name; ?></a>
	<?php else : ?>
		<a href="/my-account/" id="account_link">Login</a>
	<?php endif;
}



