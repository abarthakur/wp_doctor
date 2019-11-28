<?php
//TODO : DOC STRING
get_header();
?>

<div class="page-section-wrap">
	<div class="page-section-inner">
		<div class="two-col-container">
			<div class="main-col">
			<?php
				if (have_posts()){
					while(have_posts()){
						the_post();
						get_template_part('partials/post');
					}
				}
			?>
			</div>
			<div class="side-col">
				<div class="sidebar-wrapper">
					<?php get_template_part('partials/sidebar'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();