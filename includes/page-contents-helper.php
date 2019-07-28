<?php
function print_pages_list(){
	global $post; 
	$args = array(
		'sort_order' => 'asc',
		'sort_column' => 'menu_order',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish',
		'child_of'=> $post->ID
	); 
	$child_pages = get_pages($args); 
	if (!$child_pages || count($child_pages)<1){
		//no child pages
		return;
	}			
	$parent=$post->ID;
	echo '<ul>';
	$ending = '';
	echo get_page_list_item($post->post_name,get_the_title($parent),"parent-page-menu-item");
	echo '<ul>';
	foreach ($child_pages as $cpage){
		$string = get_page_list_item($cpage->post_name,get_the_title($cpage),"child-page-menu-item");
		$string .='</li>';
		echo $string;
	}
	echo '</ul>';
	echo '</ul>';
}


function get_page_list_item($page_slug,$page_title,$classes)
{
	$string='<li class="' . $classes .'">';
	$string .='<a href="#' . $page_slug . '">';
	$string .=$page_title;
	$string .='</a>';
	return $string;
}
?>