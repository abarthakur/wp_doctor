<?php
//TODO : DOC STRING
get_header();
?>

<div class="top-container">
	<div class="row top-page-row">
		<div class="col-lg-8 col-md col-sm content-col">
		<?php
			if (have_posts()){
				while(have_posts()){
					the_post();
					get_template_part('partials/post');
				}
			}
		?>
		</div>
		<div class="col-lg-4 col-md col-dm sidebar-col">
			<div class="sidebar-wrapper">
				<?php get_template_part('partials/sidebar'); ?>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();