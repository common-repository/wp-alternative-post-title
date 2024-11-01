<?php
/*
Plugin Name: WP Alternative post title
Plugin URI: https://tulipemedia.com/en/wp-alternative-post-title-on-homepage/
Description: This plugin enables you to have two titles for one post. One will be displayed on the post page, while the other one will be used on the homepage, the categories, tags and archives, in order to improve your conversion rate from the homepage or archive to content via a nice call to action that attracts readers, without affecting your real post titles for SEO.
Author: Ziyad BACHALANY
Version: 0.1
Author URI: https://tulipemedia.com
*/

// add a metabox to set our alternative title
add_action('add_meta_boxes','init_alternative_title',1);
function init_alternative_title() {
	add_meta_box('alternative_title_123', 'Alternative title', 'alternative_title_display', 'post', 'normal', 'high');
}

//check if there's already a title to display
function alternative_title_display($post) {
	$title = get_post_meta($post->ID,'alternative_title',true);
	echo '<input id="alt_title" type="text" name="alt_title" value="' . $title . '" style="width:100%"/>';
}

//save the alternative title when the post is saved
add_action('save_post','alt_title_metabox_save');
function alt_title_metabox_save($post_ID) {
	//check if there is a value to save
	if(isset($_POST["alt_title"])) {
		//save the value, stripping the html tags
		update_post_meta($post_ID,'alternative_title',sanitize_text_field($_POST["alt_title"]));
	}
}

//hook to the_title
add_filter('the_title','alt_title_display',10,2);
function alt_title_display($title,$post_ID) {
	if(!is_single()) {
		$alt_title = get_post_meta($post_ID,'alternative_title',true);
		if ($alt_title != '') {
			return $alt_title;
		}
	}
	return $title;
}

?>