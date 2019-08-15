<?php
require_once get_stylesheet_directory() . "/includes/utils.php";
// Blog Posts (Cards) -----------------------------------------------

$card_classes="";
if ($args && array_key_exists("card_classes",$args) && $args["card_classes"]){
	$card_classes=trim($args["card_classes"]);
}

$permalink=get_permalink();
if (!$permalink){
	$permalink="#";
}
?>

<article class="blog-card<?php echo ' '.$card_classes;?>">  
	<header>
		<a href="<?php echo $permalink;?>" class="blog-card-image-container">
			<?php print_image("square_image",array("medium"=>"1x","large"=>"2x"),"fluid-image",false)?>
		</a>
		<?php get_template_part('partials/post-metadata');?>
	</header>

	<div class="blog-card-body">
		<div class="clamped-text-container">
			<a href="<?php echo $permalink;?>" class="blog-card-title">
				<h3> <?php the_title(); ?> </h3>
			</a>
			<div class="blog-card-excerpt">
				<p>
				<?php 
					$excerpt=get_the_excerpt();
					$num_words=50;
					$excerpt=wp_trim_words($excerpt,$num_words,'');
					echo $excerpt;
				?>
				</p>
			</div>
		</div>
	</div>
	<footer>
		<?php get_template_part('partials/post-social'); ?>
	</footer>
</article>







