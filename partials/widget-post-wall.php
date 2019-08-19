<?php
require_once get_stylesheet_directory() . "/includes/utils.php";

if ($args["max_post_count"]<0 || $args["query"]->post_count<=0 || strlen($args["col_classes"])<=0){
	return; 
}
$post_args=array();
if (array_key_exists("post_args",$args) && count($args["post_args"])>0){
	$post_args=$args["post_args"];
}

$default_tag="all";
if (array_key_exists("default_tag",$args) && count($args["default_tag"])>0){
	$default_tag=$args["default_tag"];
}

$container_classes="";
if (array_key_exists("container_classes",$args) && strlen($args["container_classes"])>0){
	$container_classes=$args["container_classes"];
}

?>
<div class="preview-post-wall <?php echo $container_classes;?>">
	<div class="taglist-container">
		<?php
			if (array_key_exists("wall_heading",$args) && strlen($args["wall_heading"])>0){
				echo '<h4>' . $args['wall_heading']. '</h4>';
			}
			if (array_key_exists("wall_heading",$args) && count($args["taglist"])>0){
				echo '<div class="taglist">';
				foreach ($args["taglist"] as $tag=>$url){
					$link_classes="";
					if ($tag==$default_tag){
						$link_classes .= " default active";
					}
				?>
				<a class="pwall-tag-link<?php echo $link_classes;?>" href="<?php echo $url;?>">
					<?php echo $tag;?>
				</a>
			<?php } 
				echo '</div>';
			}
		?>
	</div>
	<div class="horizontal-align">
		<div class="posts-container container">
			<div class="row">
				<?php 
				$count=0;
				while($count < $args["max_post_count"] && $args["query"]->have_posts()){
					$count+=1;
					$args["query"]->the_post();
				?>
					<div class="post-col <?php echo $args["col_classes"];?>">
						<?php doc_get_template_part('partials/card-preview-post',$post_args);?>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
