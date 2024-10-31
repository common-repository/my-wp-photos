=== My WP Photos ===
Contributors: mdburnette
Tags: photos, photography, wordpress, gallery, directory
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 0.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add your WordPress Photo Directory photos to your website as a gallery.

== Description ==
Add your WordPress Photo Directory photos to your website as a gallery.

Includes a shortcode that displays your photos. The following attributes can be added:
- username: wordpress.org username (required)
- count: number of photos to display from 1-100, default 12
- aspect: aspect ratio for your images. options include "square", "landscape", "portrait"
- size: photo gallery size from the directory. options include "medium", "large", "thumbnail", "medium_large", "1536x1536", "2048x2048", "full"

== WordPress Photo Directory ==
This plugin uses the REST API freely provided by the WordPress Photo Directory to determine the author ID from the username and to load the corresponding list of photos. The directory can also be visited at https://wordpress.org/photos.

All photos are CC0 licensed. No rights are reserved, so you are free to use the photos anywhere, for any purpose, without the need for attribution.

Learn more at https://wordpress.org/photos/faq/

== Installation ==
1. Upload the my-wp-photos plugin to your site and activate it!
3. Add the [wp_photo_directory] shortode to any post/page where you'd like the gallery to appear.
4. Be sure to include your wordpress.org username as an attribute.

Ex: [wp_photo_directory username="mdburnette"]

== Screenshots ==
1. Coming soon.

== Changelog ==
= 0.0.1 (November 8, 2023) =
* Initial plugin release