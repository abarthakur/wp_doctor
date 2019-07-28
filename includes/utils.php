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