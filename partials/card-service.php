<?php
require_once get_stylesheet_directory() . "/includes/utils.php";
$card_classes="";
if ($args && array_key_exists("card_classes",$args) && $args["card_classes"]){
	$card_classes=trim($args["card_classes"]);
}
$card_src=get_field("card_content_source");
$service_link=get_field("service_link");
if (!$service_link || !trim($service_link)){
	$service_link="#";
}
$body_class="";
if ($card_src=="only_text"){
	$body_class="full-height";
}
?>
<article class="service-card <?php echo trim($card_classes);?>">
	<?php 
	if ($card_src=="image_and_text")
	{?>
		<header class="service-card-image">
			<?php print_image("square_image",array("thumbnail"=>"1x","medium"=>"2x"),"fluid-image",false);?>
		</header>
	<?php
	}?>
	<div class="service-card-body <?php echo $body_class;?>">
		<div class="clamped-text-container">
			<a class="service-card-title" href="<?php echo $service_link;?>">
				<h4 class="service-card-title"><?php echo get_the_title();?></h4>
			</a>
			<div class="service-card-text">
				<?php the_content();?>
			</div>
		</div>
	</div>
</article>