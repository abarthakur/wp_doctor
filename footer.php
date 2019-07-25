<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "wrapper" div and all content after.
 *
 */
//TODO Docstring
require_once 'includes/utils.php';
?>
	</main>		
	<footer>
		<div class="container footer-container">
			<div class="row footer-row">
				<!-- bootstrap order-xs- classes don't seem to work correctly, forcing me to use a mobile-first approach -->
				<div class="col-lg footer-left order-2 order-lg-1">
					<?php print_footer_menu('footer-menu-1');?>
				</div>
				<div class="col-lg footer-center order-1 order-lg-2">
					<?php get_template_part('partials/footer-social');?>
				</div>
				<div class="col-lg footer-right order-3 order-lg-3">
					<?php print_footer_menu('footer-menu-2');?>
				</div>
			</div>
			<div class="row copyright-row">
				<div class="col-lg">
					<?php get_template_part('partials/footer-banner');?>
				</div>
			</div>
		</div>
	</footer>

	<?php wp_footer(); ?>
	<a id="back-to-top" title="Back to top" href="#">
		<i class="fas fa-arrow-circle-up fa-3x"></i>
	</a>	
	</body>
</html>