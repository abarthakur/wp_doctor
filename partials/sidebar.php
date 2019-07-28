<?php
require_once get_template_directory() . "/includes/utils.php";
global $wp_query;
if (is_page() && $wp_query->post_count>0){
	$args = array('is_mobile' => false );
	doc_get_template_part('partials/card-page-contents',$args);
}
get_template_part('partials/card-categories');
get_template_part('partials/card-book-appointment');
// get_template_part('partials/card-testimonial');