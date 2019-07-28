<?php
require_once(get_stylesheet_directory() . "/includes/page-contents-helper.php");
if (!is_page()){
	return;
}
if ($args["is_mobile"]){
	$classes="";
	$id="mobile-page-menu";
}
else{
	$classes="sidebar-card";
	$id="desktop-page-menu";
}
?>
<div class="card shadow-hover <?php echo $args["classes"]; ?>" id="<?php echo $id;?>">
	<h4 class="card-title">Page Contents</h4>
	<p class="card-text">
	<?php
		print_pages_list();
	?>
	</p>
</div>