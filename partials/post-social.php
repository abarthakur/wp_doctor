<?php 
$post_link = get_the_permalink();
//the quote/ share text
$quote="Check out this interesting post about " . get_the_title() . " on www.doctorayona.com!";
//construct fb share link
$fb_link ='https://www.facebook.com/dialog/share?app_id=';
$fb_link .= get_option('fb-app-id');
$fb_link .= '&display=popup&href=' .esc_url($post_link);
$fb_link .= '&quote=' . $quote . '&redirect_uri=' . get_home_url();
$fb_link = esc_url($fb_link);
//construct tweet link
$tweet_link = "https://twitter.com/intent/tweet?";
$tweet_link .= 'text=' . $quote . '&url=' . $post_link;
//construct linkedin link
$linkedin_link='http://www.linkedin.com/shareArticle?mini=true&url=';
// $linkedin_link .= esc_url($post_link);
$linkedin_link .= 'https://www.stackoverflow.com/';
$linkedin_link .='&title=' . get_the_title();
$linkedin_link .= '&source=' .  home_url();

$social_icons=array(
   "Facebook"=>array("cname"=>"fab fa-facebook-f","link"=>$fb_link),
   "LinkedIn"=>array("cname"=>"fab fa-linkedin-in","link"=>$linkedin_link),
   "Twitter"=>array("cname"=>"fab fa-twitter","link"=>$tweet_link)
);
if (wp_is_mobile()){
	$social_icons["Whatsapp"]=array("cname"=>"fab fa-whatsapp");
	$whatsapp_link='whatsapp://send?text=' . $quote;
	$whatsapp_link .=' (' . $post_link . ')';
	$social_icons["Whatsapp"]["link"]=$whatsapp_link;
}
?>
<div class="post-social">
   <?php 
	foreach($social_icons as $name => $attrs){
	?>	
		<a class="share-link" href="<?php echo $attrs["link"]?>" target="_blank">
			<i class="<?php echo $attrs["cname"];?>"></i>
		</a>
	<?php
	}
?>
</div>

