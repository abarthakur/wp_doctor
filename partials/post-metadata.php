<?php
global $post;
//query for categories
$categories=get_the_terms( $post->id, 'category' );
//query for tags
$tags=get_the_tags($post->id);
//get primary category
$primary_cat_id=get_field("primary_category");
?>
<div class="post-metadata-bar">
	<div class="post-metadata">
		<div class="metadata-categories">
		<?php
			foreach ($categories as $cat)
			{
				if ($cat->slug=="uncategorized"){
					continue;
				}
				$classes="";
				if ($cat->id==$primary_cat_id){
					$classes .= "primary-cat"; 
				}
				$link=get_category_link($cat->term_id);
				$string = '<a href="' . $link . '"';
				$string .= ' class="' . $classes . '"';
				$string .= '>';
				$string .= $cat->name;
				$string .= '</a>';
				echo $string;
			}
		?>
		</div>
		<?php
		if ($tags && count($tags)>0)
		{?>
			<div class="metadata-tags">	
			<?php 
				foreach($tags as $t){
					//TODO
					$link="";
					$string = '<a href="' . $link . '">';
					$string .= $t->name;
					$string .= '</a>';
					echo $string;
				}
			?>
			</div>
		<?php 
		}?>
	</div>
	<div class="post-date">
		<span> <?php echo get_the_date(); ?> </span>
	</div>
</div>