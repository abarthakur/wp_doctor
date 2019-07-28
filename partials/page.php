<?php
global $post;
$target = $post->post_name;
?>
<div class="post-container shadow-hover <?php echo trim($args["classes"])?>" id="<?php echo $target;?>">
	<h1 id="post-title"><?php echo get_the_title();?></h1>
	<?php
	if ($args["is_parent_page"]){
		echo '<a id="go-to-mobile-page-menu" href="#mobile-page-menu">&raquo; Go to page contents</a> ';
	}
	?>
	<hr class="my-3">
	<div class="container post-content-container">
		<?php the_content();?>
	</div>
</div>
