<?php
function register_theme_settings() {
    //Register all settings
    register_setting( 'general-site-settings-group', 'primary-phone-number',
                    array('sanitize_callback'=>'validate_phone_number'));
    register_setting( 'general-site-settings-group', 'blog-featured-post-id',
                    array('sanitize_callback'=>'validate_blog_featured_post_id'));
    //Appearance Section
    add_settings_section( 'featured-section', 'Featured Posts', 'featured_settings_callback', 'general-site-settings-page' );
    add_settings_field('blog-featured-post-id-field','Featured Post on Blog','text_input_callback','general-site-settings-page',
    'featured-section',array('option'=>'blog-featured-post-id'));
    //Contact & Social Media Section
    add_settings_section( 'contact-section', 'Contact & Social Media', 'contact_settings_callback', 'general-site-settings-page' );
    add_settings_field( 'primary-phone-number-field', 'Primary Phone Number', 
    'text_input_callback', 'general-site-settings-page', 'contact-section',array("option"=>"primary-phone-number"));
}
?>

<?php
function print_general_theme_settings_page() 
{?>
    <div class="wrap">
        <h2>General Theme Settings</h2>
        <form action="options.php" method="POST">
            <?php settings_fields( 'general-site-settings-group' ); ?>
            <?php do_settings_sections( 'general-site-settings-page' ); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

function contact_settings_callback() {
    echo 'Contact related settings like phone, numbers, email etc.';
}

function featured_settings_callback(){
    echo 'Select featured posts for the blog page & front page.</br>';
    echo 'All inputs must be numerical ids of the post, not the title, not the url.';
    // echo 'Use the "Search by Title" widget below to find the numeric id(entifier) of the post if you know the title.';
    //TODO
}

function validate_blog_featured_post_id($input){
    $output = get_option( 'blog-featured-post-id' );
    $args = array(
        'post_type'        => 'post',
        'p'               => (int)$input
    );
    $post_query = new WP_Query( $args );
    if ($post_query->post_count==0||$post_query->post_count>1){
        $error_string=$input . " is an invalid post id!";
        add_settings_error( 'blog-featured-post-id', 'invalid-post',$error_string);
    }
    else{
        $output=(int)$input;
    }
    return (int)$output;
}

function text_input_callback($args) {
    $setting = esc_attr( get_option( $args['option'] ) );
    echo '<input type="text" name="'. $args['option'] .'" value="'. $setting . '"/>';
}

function validate_phone_number($input){
    $output = get_option( 'primary-phone-number' );
    $mob_regex="/\A([+]91)?[1-9]{1}[0-9]{9}\z/";
    $landline_regex="/\A[0-9]{11}\z/";
    if(preg_match($mob_regex, $input)|| preg_match($landline_regex, $input)) {
        //phone is valid
        $output=$input;
    }
    else{
        $error_string='You have entered an invalid phone number!';
        $error_string.="Format : +919123491234 or  9123491234 for mobile,";
        $error_string.=" or 03612545126 (11 digits) for landlines.";
        add_settings_error( 'primary-phone-number', 'invalid-phone-number',$error_string);
    }
    return $output;
}