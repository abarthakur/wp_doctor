<?php 
function doc_get_head_title(){
	if (is_page()||is_single()){
		return get_the_title();
	}
}
?>
<?php
function print_image($field_name,$size_pixel_density_map,$image_classes,$print_caption)
{	
	$image_src=null;
	$attachment_id = get_field($field_name);
	$title=get_the_title($attachment_id);
	$alt_text=get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	$caption=wp_get_attachment_caption($attachment_id);
	if(!$alt_text && $caption){
		$alt_text=$caption;
	}
	else if(!$caption && $alt_text){
		$caption=$alt_text;
	}
	$valid_sizes = array('thumbnail','medium','large');
	$srcset="";
	$primary_src="";
	foreach ($size_pixel_density_map as $size => $pix_density){
		if(!$attachment_id){
			break;
		}
		$src=null;
		if (trim($size) && in_array(trim($size),$valid_sizes)){
			$src=wp_get_attachment_image_src( $attachment_id, $size )[0];
		}
		if (!$primary_src){
			//first size as primary
			$primary_src=$src;
		}
		$srcset .= $src . " " . $pix_density;
		$srcset .=",";
	}
	if ($srcset){
		$srcset=substr($srcset,0,strlen($srcset)-1);
	}
	if ($primary_src){
		echo '<figure style="display:contents">';
		$img_string = '<img class="'. $image_classes . '"';
		$img_string .= ' src="' . $primary_src. '"';
		if ($srcset){
			$img_string .= ' srcset="' . $srcset . '"';
		}
		$img_string .= ' alt="' . $alt_text . '"';
		$img_string .= ' title="' . $title . '"';
		$img_string .= '/>';
		echo $img_string;
		if ($print_caption){
			echo '<figcaption>' . $caption . '</figcaption>';
		}
		echo '</figure>';
	}
	else{
		echo '<figure style="display:contents">';
		$img_string = '<img class="'. $image_classes . '"';
		$img_string .= ' src="' . get_stylesheet_directory_uri() ;
		$img_string .= '/images/placeholder-' .explode('_',$field_name)[0] . '"';
		$img_string .= ' alt="This picture is coming soon..."';
		$img_string .= '.jpg">';
		echo $img_string;
		echo '</figure>';
	}
}	
?>

<?php 
function doc_get_template_part($slug,$args){
	include locate_template($slug . ".php", false);
}
?>


<?php
function print_responsive_card_grid($query, $args)
{	
	foreach (array('row_classes','col_classes','card_classes') as $params){
		if (!array_key_exists($params,$args) || !$args[$params]){
			$args[$params]='';
		}
	}
?>
	<div class="container <?php echo $args["container_classes"];?>">
		<div class="row <?php echo $args["row_classes"];?>">
		<?php
			$col_classes=$args['col_classes'];
			if (!is_array($col_classes) && is_string($col_classes)){
				$col_classes=array($col_classes);
			}
			$post_count=0;
			while($post_count < $args['max_post_count'] && $query->current_post+1 < $query->post_count)
			{	
				$col_cls_ptr=($post_count)%count($col_classes);
				echo '<div class="col '. $col_classes[$col_cls_ptr] .'">';
				$query->the_post();
				global $post;
				$card_src=get_field("card_content_source");
				if($post->post_type=="post"){
					if ($card_src=="use_main_content" || $card_src =="custom_card_content"){
						doc_get_template_part('partials/card-post-custom',$args);
					}
					else {
						doc_get_template_part('partials/card-post',$args);
					}
				}
				elseif($post->post_type=="service_card"){
					doc_get_template_part('partials/card-service',$args);
				}
				
				$post_count+=1;
				echo "</div>";
			}
		?>
		</div>
	<?php
	if ($query->current_post +2 == $query->post_count){
		return False;//this query is consumed
	}
	else{
		return True;
	}
}
?>


<?php 
function print_checkbox_group($header,$options)
{?>	
	<div class="options-container">
		<span class="options-label"> <?php echo trim($header);?> </span>
		<div class="checkbox-wrapper">
		<?php foreach($options as $option)
		{?>
			<div class="checkbox">
				<label>
					<input type="checkbox" value="true" 
					name="<?php echo $option["input_name"];?>">
					<?php echo $option["label"];?>
				</label>
			</div>
		<?php
		}?>
		</div>
	</div>
<?php
}
?>

<?php
function print_footer_menu($menu_location){
	$locations = get_nav_menu_locations();
	$menu_id = $locations[ $menu_location ] ;
	$menu= wp_get_nav_menu_object($menu_id);
	echo '<h3 class="footer-menu-title">' . $menu->name . "</h3>";
	echo '<hr class="my-2">';
	wp_nav_menu( array(
	'theme_location'  => $menu_location,
	'depth'	          => 1, // 1 = no dropdowns, 2 = with dropdowns.
	'container'       => '',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'footer-menu'
	));
}?>