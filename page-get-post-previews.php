<?php
$params=array("tag","cat","count","order","orderby");
$args=array();
foreach ($params as $par){
	$args[$par]="";
	if (array_key_exists($par,$_GET) && !empty($_GET[$par]) 
		&& strlen(trim($_GET[$par]))>0){
			$args[$par]=trim($_GET[$par]);
	}
}
if ((int)$args["count"] >0 && (int)$args["count"]<=10){
	$args["count"]=(int)$args["count"];
}
else {
	$args["count"]=10;
}
//TODO : Sanitize inputs more

if (!trim($args["order"])||!trim($args["orderby"])){
	$args["order"]="DESC";
	$args["orderby"]="date";
}
$qargs= array(
	'posts_per_page'   => $args["count"],
	'post_type'		 =>'post',
	'tag' =>$args["tag"],
	'category_name'=>$args["cat"],
	'order_by' => $args["orderby"],
	'order' => $args["order"]
);
$query = new WP_Query($qargs);

require_once get_stylesheet_directory() . "/includes/utils.php";
$post_args=array('word_count'=>50);
echo '<div class="preview-posts-container">';
while($query->have_posts()){
	$query->the_post();
	doc_get_template_part('partials/card-preview-post',$post_args);
}
echo '</div>';