<div class="navbar-container">
	<div class="navbar-row d-flex flex-row align-items-center justify-content-between">
		<nav class="navbar navbar-expand-lg" id="myTopNavBar">
			<div class="collapse navbar-collapse" id="daNavBarCollapse">
			<?php
				da_print_nav_menu();
				da_print_search_button();
			?>
			</div>
		</nav>
	</div>
</div>


<?php 
function da_print_nav_menu()
{
	wp_nav_menu( array(
		'theme_location'  => 'header-menu',
		'depth'	          => 2, // 1 = no dropdowns, 2 = with dropdowns.
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'navbar-nav',
		'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
		'walker'          => new WP_Bootstrap_Navwalker(),
	) );
}
?>

<?php 
function da_print_search_button()
{?>
	<a href="<?php echo get_home_url(null,"/search",null); ?>" id="searchButton">
		<i class='fas fa-search nav-search'></i>	
	</a>
<?php
}
?>


<?php 
function da_print_fb_login()
{?>
	<div class="fb-login-button" data-size="large" data-button-type="login_with" data-auto-logout-link="true" data-use-continue-as="true"></div>
<?php
}
?>