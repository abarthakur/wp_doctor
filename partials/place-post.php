 <?php
require_once get_stylesheet_directory() . "/includes/utils.php";

$classes = "";
if (array_key_exists('classes',$args) && trim($args['classes'])){
	$classes = $args['classes'];
}
if (array_key_exists('reverse_order',$args) && $args['reverse_order']){
	$classes .=' reverse';
}
$office_hours=get_field("office_hours");
if ($office_hours && trim($office_hours)){
	$office_hours=implode(" , ",explode("\n",$office_hours));
}
else{
	$office_hours=array();
}
$office_address=get_field("office_address");
$office_phones=get_field("office_telephones");
if ($office_phones && trim($office_phones)){
	$office_phones=explode("\n",$office_phones);
}
else{
	$office_phones=array();
}
$rand_suffix=strval(rand(0,100));
?>
<article class="place-post <?php echo $classes;?>">
	<div class="place-image-container">
		<?php print_image("square_image",array("medium"=>"1x","large"=>"2x"),"fluid-image",false);?>
	</div>
	<div class="place-tabbed-pane">
		<header class="place-header">
			<div class="place-title">
				<h3><?php the_title(); ?></h3>
			</div>
			<div role="tablist" class="place-tabs">
				<button role="tab" aria-selected="true" 
					aria-controls="about-panel-<?php echo $rand_suffix;?>"
					id="about-tab-<?php echo $rand_suffix;?>">
					<i class="fas fa-pen-fancy">About</i>
				</button>
				<button role="tab" aria-selected="false" 
					aria-controls="map-panel-<?php echo $rand_suffix;?>"
					id="map-tab-<?php echo $rand_suffix;?>">
					<i class="fas fa-map-marked-alt">Map</i>
				</button>
				<button role="tab" aria-selected="false"
					aria-controls="contact-panel-<?php echo $rand_suffix;?>"
					id="contact-tab-<?php echo $rand_suffix;?>">
					<i class="fas fa-phone">Contact</i>
				</button>
			</div>
		</header>
		<div class="place-tabcontent">
			<div role="tabpanel" id="about-panel-<?php echo $rand_suffix;?>" 
			aria-labelledby="about-tab-<?php echo $rand_suffix;?>" class="place-about-container active">
				<div class="place-description">
					<div class="clamped-text-container">
						<?php the_content();?>
					</div>
				</div>
			</div>
			<div role="tabpanel" id="map-panel-<?php echo $rand_suffix;?>" 
			aria-labelledby="map-tab-<?php echo $rand_suffix;?>" class="place-map-container">
				<?php
				$google_map_embed_html=get_field("google_map_embed_html");
				// $google_map_embed_html.="?wmode=transparent";
				echo $google_map_embed_html;
				?>
			</div>
			<div role="tabpanel"id="contact-panel-<?php echo $rand_suffix;?>"
			aria-labelledby="contact-tab-<?php echo $rand_suffix;?>" class="place-contact-container">
				<address>
					<div class="hours">
						<span class="label">Office hours</span>
						<span class="value"><?php echo $office_hours;?></span>
					</div>
					<div class="address">
						<span>Address</span>
						<p><?php echo $office_address;?></p>
					</div>
					<div class="phones">
					<?php
					$i=0;
					while($i<2 && $i < count($office_phones)){
						$phn=$office_phones[$i];
					?>
						<a class="call-button" href="tel:<?php echo $phn;?>">
							<i class="fas fa-phone"><?php echo $phn;?></i>
						</a>
					<?php
						$i++;
					}
					?>
					</div>
				</address>
			</div>
		</div>
	</div>
</article>

