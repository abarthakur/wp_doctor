<?php 
//TODO : DOC STRING
//Redirect child page (direct access) to parent page
if (is_page() && $post->post_parent){
	//wordpress still associates the original permalink of the child page
	//maybe later change the "set permalink" hook?
	//hence still need to redirect
	$permalink=get_permalink($post);
	wp_redirect($permalink, 301);
	exit;
}
get_header();
require_once get_stylesheet_directory() . "/includes/utils.php";
?>

<?php 
//TODO : script to fix scrolling for parent links?
?>

<div class="page-section-wrap">
	<div class="page-section-inner">
		<div class="two-col-container">
			<div class="main-col">
			<?php
			$children_query=null;
			if (have_posts()){
				while (have_posts()){
					the_post();
					//print the parent page
					$args = array(	'classes' => 'parent-page-container',
									'is_parent_page'=> true
								);
					doc_get_template_part('partials/page',$args);
				}
				
				//print page contents card
				$args = array('is_mobile' => true );
				doc_get_template_part('partials/card-page-contents',$args);
				
				//query child pages
				$args = array(
					'post_parent' => $post->ID,
					'post_type'   => 'page', 
					'orderby'	=> 'menu_order',
					'order' => 'asc'
				);
				$children_query = new WP_Query( $args );
				
				//print child pages
				if ($children_query){
					while($children_query->have_posts()){
						$children_query->the_post();
						$args = array('classes' => '',
									'is_parent_page'=> false
							);
						doc_get_template_part('partials/page',$args);
					}
				}
				//reset post vars to global query
				wp_reset_postdata();
			}
			?>
			</div>
			<div class="side-col">
				<div class="sidebar-wrapper">
					<?php get_template_part('partials/sidebar'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
?>