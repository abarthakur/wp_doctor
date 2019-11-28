<?php include_once get_template_directory() . '/includes/utils.php' ?>
<div class="post-container shadow-hover">
	<h1 id="post-title"><?php echo the_title();?></h1>
	<hr class="my-3">
	
	<?php print_image("wide_image",array("medium"=>"1x","large"=>"2x"),"featured-img fluid-img",false);?>
	<hr class="my-3">

	<div class="date-bar d-flex flex-row-reverse">
	<div class="fb-like" data-href="<?php echo $permalink;?>" data-layout="button_count" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
		<div class="vrule">
		</div>
		<div>
			<small class="text-muted date-text"> <?php echo get_the_date(); ?> </small>
		</div>
	</div>
	<hr class="my-3">	
	<div class="container post-content-container">
		<?php echo the_content();?>
	</div>
</div>