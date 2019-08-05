<?php
//TODO : DOC STRING
get_header();
require_once get_stylesheet_directory() . '/includes/utils.php';

/*********************************************/

// get featured posts
$featured_post_id=get_option( 'blog-featured-post-id' );
$featured_post_id=(int)$featured_post_id;	
$args = array(
	'posts_per_page'   => 1,
	'p'	=> $featured_post_id,
	'post_status'    => 'publish'
);
$feat_post_query = new WP_Query( $args );
$first_posts=array();
$first_posts_query=null;
if ($feat_post_query->post_count>0){
	//get 1 extra post
	$args = array(
		'posts_per_page'   => 1,
		'post_type'        => 'post',
		'post__not_in'     => array($featured_post_id),
		'post_status'    => 'publish'
	);
	$second_card_query = new WP_Query( $args );
	if ($second_card_query->post_count>0){
		$first_card_id=$second_card_query->posts[0]->ID;
		array_push($first_posts,$featured_post_id);
		array_push($first_posts,$first_card_id);
		$args=array(
			'posts_per_page' => 3,
			'post_type'=>'post',
			'post__in'=>$first_posts,
			'post_status'    => 'publish'
		);
		$first_posts_query=new WP_Query( $args);
	}
}

/*********************************************/

//get rest of the posts
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args = array(
	'posts_per_page'   => 5,
	'post_type'        => 'post',
	'post__not_in'     => $first_posts,
	'paged'            => $paged,
	'orderby'        => 'date',
    'order'          => 'ASC',
    'post_status'    => 'publish'
);
$posts_query = new WP_Query( $args );

/*********************************************/

// get video posts
$args = array(
	'posts_per_page'   => 1,
	'post_type'        => 'video_post',
	'paged'            => $paged,
	'post_status'    => 'publish'
);
$videos_query = new WP_Query( $args );


?>

<div class="container page-container">
	<header class="page-section">
		<div class="page-header">
			<h1><?php echo get_the_title();?></h1>
		</div>
		<?php
			//pagination
			$pagination_args=array("query"=>$posts_query,"url_page_num"=>$paged,"is_query_var"=>False);
			doc_get_template_part('partials/page-pagination-links',$pagination_args); 
		?>
	</header>
	<section class="page-section">
	<?php
		$args=array();
		$args["container_classes"]="blog-card-grid";
		$args["max_post_count"]=2;
		$args["col_classes"]=array("blog-card-col feat-card-col col-12 col-sm-12 col-md-6 col-lg-8 col-xl-8",
									"blog-card-col feat-card-col col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4");
		if ($paged==1 && $first_posts_query && $first_posts_query->post_count==2){
			print_responsive_card_grid($first_posts_query,$args);
		}
		$args["max_post_count"]=3;
		$args["col_classes"]="blog-card-col col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4";
		$still_left=print_responsive_card_grid($posts_query,$args);
	?>
	</section>
	<section class="page-section">
	<?php
		get_template_part('partials/video-posts-banner');
		get_template_part('partials/video-post');
	?>
	</section>
	<section class="page-section">
	<?php
		if($still_left){
			print_responsive_card_grid($posts_query,$args);
		}
	?>
	<footer class="page-section">
		<?php
		doc_get_template_part('partials/page-pagination-links',$pagination_args);
		?>
	</footer>
</div>

<?php
get_footer();