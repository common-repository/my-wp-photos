<?php
/*
Plugin Name: My WP Photos
Plugin URI: https://mburnette.com/my-wp-photos
Description: Add your WordPress Photo Directory photos to your website as a gallery.
Version: 0.0.1
Author: Marcus Burnette
Author URI: https://mburnette.com
License: GPL2
*/

//* Don't access this file directly
defined( 'ABSPATH' ) or die();


include("includes/helper-functions.php");


// Register the shortcode
add_shortcode('wp_photo_directory', 'my_wp_photos_display_photos_by_author');

// Function to handle the shortcode
function my_wp_photos_display_photos_by_author($atts) {

	// Extract the author ID or username from the shortcode attributes
    $username = isset($atts['username']) ? sanitize_text_field($atts['username']) : ''; // wordpress.org username
    $count = isset($atts['count']) ? sanitize_text_field($atts['count']) : 12; // 1-100, default 12
	$aspect = isset($atts['aspect']) ? sanitize_text_field($atts['aspect']) : 'landscape'; // square, landscape, portrait
	$size = isset($atts['size']) ? sanitize_text_field($atts['size']) : 'large'; // medium, large, thumbnail, medium_large, 1536x1536, 2048x2048, full

    // Check if either author ID or username is provided
    if (!$username) {
        return 'Attribute "username" is required!';
    }

    // If username is provided, fetch the corresponding author ID
	$user_id = my_wp_photos_get_photo_directory_user_ID($username);
	if (!$user_id) {
		return 'Invalid username!';
	}
	$author_id = $user_id;

    // URL for the REST API endpoint
    $url = 'https://wordpress.org/photos/wp-json/wp/v2/photos?author=' . $author_id . '&per_page=' . $count . '&_embed';

    // Make a request to the REST API
    $response = wp_remote_get($url);

    // Check for errors
    if (is_wp_error($response)) {
        return 'Failed to fetch photos!';
    }

    // Decode the JSON response
    $photos = json_decode(wp_remote_retrieve_body($response));

    // Check if photos are available
    if (empty($photos)) {
        return 'No photos found for the given username!';
    }

    // Generate the HTML for displaying the images
    $output = '<div class="wp-photo-directory-photos">';
    foreach ($photos as $photo) {
        $output .= '<p class="wp-photo-directory-photo"><a href="' . esc_url($photo->link) . '"><img src="' . esc_url($photo->_embedded->{"wp:featuredmedia"}[0]->media_details->sizes->{$size}->source_url) . '" alt="' . esc_attr($photo->title->rendered) . '"></a></p>';
    }
    $output .= '</div>';
	$output .= '<p><a href="https://wordpress.org/photos/author/' . $username . '/">See all photos for ' . $username . '</a></p>';
	$output .= '<style>
	.wp-photo-directory-photos {
		line-height: 1;
	}
	.wp-photo-directory-photos a {
		display: inline-block;
	}
	.wp-photo-directory-photo {
		display: inline-block;
		width: 25%;
		margin: 0;
	}
	.wp-photo-directory-photo img {
		display: inline-block;
		width: 100%;
		aspect-ratio: 5 / 4;
		object-fit: cover;
	}
	</style>';
	if( $aspect == 'square' ){
		$output .= '<style>
			.wp-photo-directory-photo img {
				aspect-ratio: 1;
			}
		</style>';
	}
	if( $aspect == 'portrait' ){
		$output .= '<style>
			.wp-photo-directory-photo img {
				aspect-ratio: 4 / 5;
			}
		</style>';
	}

    return $output;
}