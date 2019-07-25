<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page header div.
 *
 * @package DoctorAyona
 * @since   1.0.0
 */


?>
<!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<!-- Important standard meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="Foo Bar">
		<meta name="description" content="This is a description of this article">

		<!-- Favicon (the image in browser tabs/bookmarks) -->
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<!--Directives for web crawlers-->
		<meta name="robots" content="index,follow" />

		<!-- Social Media Tags -->
		<?php get_template_part('partials/social-meta-tags') ?>

		<!-- Title tag also goes in the head. This is what appears on the browser tab.-->
		<title>The title of the article</title>

		<!-- Mark canonical pages-->
		<link rel="canonical" href="https://www.example.com">

		<!-- Always have wp_head() just before the closing </head> for theme compatibility -->
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php get_template_part('partials/top-skip-links') ?>
		<header>
			<?php get_template_part('partials/banner'); ?>
			<?php get_template_part('partials/navbar'); ?>
		</header>
		<main role="main">

		<?php //header.php FIN 