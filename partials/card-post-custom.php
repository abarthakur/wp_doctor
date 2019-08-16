<?php
require_once get_stylesheet_directory() . "/includes/utils.php";

$card_classes="";
if ($args && array_key_exists("card_classes",$args) && $args["card_classes"]){
	$card_classes=trim($args["card_classes"]);
}

$permalink=get_permalink();
if (!$permalink){
	$permalink="#";
}

$card_src=get_field("card_content_source");
if (!$card_src || ($card_src!="use_main_content" 
	&& $card_src!="custom_card_content")){
		return;
}

$content="";
if ($card_src=="use_main_content"){
	ob_start( );
	the_content();
	$content=ob_get_clean();
}
elseif($card_src=="custom_card_content"){
	$content=get_field("custom_card_content");
}
?>

<article class="custom-blog-card<?php echo ' '.$card_classes;?>">
	<header>
		<a href="<?php echo $permalink;?>" class="blog-card-title">
			<h3> <?php the_title(); ?> </h3>
		</a>
		<?php get_template_part('partials/post-metadata');?>
	</header>
	<div class="custom-blog-card-body">
		<div class="clamped-text-container">
		<?php 
			$num_words=100;
			// $content=wp_trim_words($content,$num_words,'');
			echo $content;
		?>
		</div>
	</div>
	<footer>
		<?php get_template_part('partials/post-social'); ?>
	</footer>
</article>