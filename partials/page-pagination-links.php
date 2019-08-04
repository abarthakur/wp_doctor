<?php
require_once get_template_directory() . '/includes/pagination.php';

if( !array_key_exists("is_query_var",$args)){
	$args["is_query_var"]=False;
} 
$base_url=doc_get_page_link_base_url($args["is_query_var"]);
$end_size=1;
$mid_size=1;
$total=$args["query"]->max_num_pages;
$current= max( 1, $args["url_page_num"] );
$links=doc_generate_page_links($base_url,$end_size,$mid_size,$total,$current);

if ( array_key_exists("aria-label",$args) && $args["aria-label"]){
	$aria_label=$args["aria-label"];
}
else{
	$aria_label=get_the_title() ." pagination";
}
?>
<div class="container">
	<div class="row top-page-row">
		<div class="col">
			<hr class="my-3">
			<div class="d-flex justify-content-center">
			<?php doc_print_page_links($aria_label,$links);?>
			</div>
			<hr class="my-3">
		</div>
	</div>
</div>