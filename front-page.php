<?php
//TODO : DOC STRING
get_header();
require_once get_stylesheet_directory() . '/includes/utils.php';

//get about-section post
$args = array(
	'posts_per_page'   => 1,
	'post_type'		 =>'page',
	'pagename'		=> 'about-section',
);
$about_query = new WP_Query( $args );

//get service cards
$SC_COUNT=8;
$args = array(
	'posts_per_page'   => $SC_COUNT,
	'post_type'        => 'service_card',
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'meta_query'	=> array(
		'relation'		=> 'OR',
		array(
			'key'	 	=> 'pin_on_home_page',
			'value'	  	=> '1',
			'compare' 	=> '='
		)
	)
);
$service_cards_query = new WP_Query( $args );

// get video posts
$args = array(
	'posts_per_page'   => 1,
	'post_type'        => 'video_post',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish'
);
$videos_query = new WP_Query( $args );

// get places of work
$args= array(
	'posts_per_page'	=> 2,
	'post_type'        => 'place_of_work',
	'orderby'        => 'date',
	'order'          => 'DESC'
);
$pow_query = new WP_Query( $args );

//get preview posts
$PP_COUNT=4;
$args = array(
	'posts_per_page'   => $PP_COUNT,
	'post_type'        => 'post',
	'orderby'        => 'date',
	'order'          => 'DESC',
	'post_status'    => 'publish'
);
$posts_query = new WP_Query( $args );

//get tags
$args = array (
	'orderby'        => 'count',
	'order'          => 'DESC',
	'number'		=> 4
);
$tags=get_tags($args);
$preview_base_url= get_stylesheet_directory_uri();
$preview_base_url .= "/get-post-previews/?count=" . strval($PP_COUNT);
$preview_base_url .= "&count_768=" .strval($PP_COUNT*1.5);//for tabs
$preview_base_url .= "&count_1024=" .strval($PP_COUNT*1.5);//for large screens
$tag_args= array("all"=>$preview_base_url);
foreach ($tags as $t){
	$tag_args[$t->slug]=$preview_base_url . '&tag=' . $t->slug;
}
//construct post preview wall args
$ppargs=array("max_post_count"=>8,"wall_heading"=>"Popular tags");
$ppargs["taglist"]=$tag_args;
$ppargs["col_classes"]="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6";
$ppargs["query"]=$posts_query;
$ppargs["post_args"]=array("word_count"=>40);

//placeholders for options
$services_title="Services";
$places_title="Locations";
$videos_title="Step into the operating theater...";
$blog_title="Blog";
$appform_title="Request an appointment now";
$appform_subtext="Dr Ayona is a specialist in IVF";
?>


<div class="page-container front-page-container">
	<header class="page-section about-section">
		<div class="about-container">
			<?php $about_query->the_post();?>
			<h2 class="about-title"><?php echo get_the_title(); ?></h2>
			<div class="about-text">
				<div class="clamped-text-container">
					<?php the_content();?>
				</div>
			</div>
		</div>
	</header>

	<section class="page-section services-section">
		<div class="section-header">
			<h2 class="section-title"><?php echo $services_title; ?></h2>
		</div>
	<?php
		$args=array('max_post_count'=>8);
		$args['container_classes']="service-card-grid";
		$args["col_classes"]="service-card-col col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3";
		$args["card_classes"]="";
		print_responsive_card_grid($service_cards_query,$args);
	?>
	</section>

	<section class="page-section places-section">
		<div class="section-header">
			<h2 class="section-title"><?php echo $places_title;?></h2>
		</div>
	<?php
		while( $pow_query->have_posts()){
			$pow_query->the_post();
			$args= array("classes"=>"","reverse_order"=>true);
			echo '<div class="place-post-container">';
			doc_get_template_part('partials/place-post',$args);
			echo '</div>';
		}
	?>
	</section>

	<section class="page-section video-section">
		<div class="section-header">
			<h2 class="section-title"><?php echo $videos_title;?></h2>
			<a href="/videos" class="more-videos-link">More videos</a>
		</div>
	<?php
		$videos_query->the_post();
		get_template_part('partials/video-post');
	?>
	</section>

	<section class="page-section blog-section">
		<div class="section-header">
			<h2 class="section-title"><?php echo $blog_title;?></h2>
		</div>
	<?php
		doc_get_template_part('partials/widget-post-wall',$ppargs);
	?>
	</section>

	<section class="page-section form-section">
		<div class="appform-header">
			<h1 class="appform-header-title"><?php echo $appform_title;?></h1>
			<?php if (trim($appform_subtext)){?>
			<p class="appform-header-subtext"><?php echo $appform_subtext;?></p> 
			<?php } ?>
		</div>
		<div class="form-container">
		<?php
			$args=array();
			doc_get_template_part('partials/form-appointment',$args);
		?>
		</div>
	</section>
</div>

<?php
get_footer();