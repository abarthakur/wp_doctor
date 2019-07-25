<?php
$args = array(
	'posts_per_page'   => 1,
	'post_type'		 =>'testimonial',
	'order_by' => 'date',
	'orderby' => 'rand'
);
$testimonials_query = new WP_Query( $args );

if ($testimonials_query->have_posts()){
	$testimonials_query->the_post();
}
else{
	return;
}

$highlight = get_field('highlight');
$testimonial = get_field('testimonial');
$fb_name = get_field('user_fb_name');
$fb_id = get_field('user_fb_id');
$fb_img_link='https://graph.facebook.com/' . strval($fb_id) . '/picture?type=large';
?>
<div class="card sidebar-card shadow-hover sidebar-testimonial">
	<div class="testimonial-img-container">
		<img src="<?php echo $fb_img_link?>" class="sidebar-testimonial-image" onload="testimonialImageLoad(this);">
	</div>
	<h4><?php echo $fb_name; ?></h4>
	<div class="quote-container">
		<div class="d-flex flex-row">
			<i class="fa fa-quote-left testimonial-quote-left" aria-hidden="true"></i>
		</div>
		<blockquote class="testimonial-text"><?php echo $highlight; ?></blockquote>
		<div class="d-flex flex-row-reverse">
			<i class="fa fa-quote-right testimonial-quote-right" aria-hidden="true"></i>
		</div>
	</div>
</div>
<?php;
