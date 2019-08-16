<?php
$yt_link=get_field("video_link");
$yt_id=array_slice(explode('?v=',$yt_link),-1)[0];
$yt_embed_link= "https://www.youtube.com/embed/" . $yt_id;
?>
<article class="video-post">
	<div class="video-container">
		<iframe src="<?php echo $yt_embed_link; ?>"
		frameborder="0" allowfullscreen></iframe>
	</div class="video">
	<div class="video-post-and-social">
		<div class="video-post-body">
			<a href="<?php get_the_permalink();?>" class="video-post-title">
				<h3><?php the_title(); ?></h3>
			</a>
			<div class="video-post-content">
				<div class="clamped-text-container">
					<?php the_content();?>
				</div>
			</div>
		</div>
		<footer>
			<?php get_template_part('partials/post-social'); ?>
		</footer>
	</div>
</article>
