<?php
get_header();
?>
<?php
$cat=get_queried_object();
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : null;
$page_qvar = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : null;
$paged = ($paged==null) ? ($page_qvar==null ? 1 : $page_qvar): $paged;
global $wp_query;
?>



<div class="page-section-wrap">
	<header class="page-section-inner page-header">
		<div class="page-header">
			<h1><?php echo $cat->name;?></h1>
		</div>
		<?php
			//pagination
			$pagination_args=array("query"=>$wp_query,"url_page_num"=>$paged,"is_query_var"=>False);
			doc_get_template_part('partials/page-pagination-links',$pagination_args); 
		?>
	</header>
	<section class="page-section-inner">
	<?php
		$args=array();
		$args["container_classes"]="blog-card-grid";
		$args["max_post_count"]=doc_const_categories_per_page();
		$args["col_classes"]="blog-card-col col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4";
		print_responsive_card_grid($wp_query,$args);
	?>
	</section>
	<footer class="page-section-inner">
		<?php
		doc_get_template_part('partials/page-pagination-links',$pagination_args);
		?>
	</footer>
</div>

<?php
get_footer();
?>
