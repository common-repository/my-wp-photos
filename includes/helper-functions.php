<?php
function my_wp_photos_get_photo_directory_user_ID( $username ) {

    // check if user id already exists in transients
    if( get_transient('my_wp_photos_author_id_for_'.$username) ){
        return get_transient('my_wp_photos_author_id_for_'.$username);
    }

    // Constructing the URL
    $url = 'https://wordpress.org/photos/author/' . $username . '/';

    // Using wp_remote_get to fetch the content
    $response = wp_remote_get( $url );

    // If there's an error, return null
    if (is_wp_error($response)) {
        return;
    }

    // Get the response body
    $content = wp_remote_retrieve_body($response);

    // Finding the body class that contains the author ID
    $matches = [];
    preg_match('/<body.*class=".*author-(\d+).*">/i', $content, $matches);

    // Returning the ID if found
    if (isset($matches[1])) {
        set_transient('my_wp_photos_author_id_for_'.$username, $matches[1], WEEK_IN_SECONDS);
        return $matches[1];
    }

    return;
}