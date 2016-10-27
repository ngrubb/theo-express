
		</div><!-- .col-full -->
   
	</div><!-- #content -->
	<div class="top__footer">
    <div class="col-full">
    	<div class="top__footer-left">
        	<p>But grow in the grace and knowledge of our lord and savior jesus christ. To him be the glory both now and to the day or eternity. Amen. <b>2 Peter 3:18</b></p>
        </div>
        <div class="top__footer-right">
        	<a class="btn btn--secondary" href="/product/subscription/">Start The Process</a>
        </div>
        </div>
    </div>
	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit - 20
			 */
			do_action( 'storefront_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
