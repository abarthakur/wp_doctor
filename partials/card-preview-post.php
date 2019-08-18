<?php
require_once get_stylesheet_directory() . "/includes/utils.php";

$num_words=100;
if (array_key_exists("word_count",$args) && $args["word_count"] < $num_words){
	$num_words=$args["word_count"];
}

$excerpt=get_the_excerpt();
if (!$excerpt || !trim($excerpt)){
	$excerpt=get_the_content();
	$excerpt=strip_tags($excerpt);
}
$excerpt=wp_trim_words($excerpt,$num_words,null);
?>
<article class="post-preview-card">
	<div class="preview-card-text">
		<div class="clamped-text-container">
			<a class="preview-title-link" href="<?php echo get_the_permalink();?>">
				<h4> <?php the_title(); ?> </h4>
			</a>
			<p> <?php echo $excerpt;?></p>
		</div>
	</div>
	<a href="<?php echo get_the_permalink();?>" style="display:contents;">
		<div class="preview-image-container"> 
			<?php print_image("square_image",array("thumbnail"=>"1x","medium"=>"2x"),"fluid-image",false)?>
		</div>
	</a>
</article>