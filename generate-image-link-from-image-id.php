<?php

// Dec 2024

/**
 * Generate a gallery item HTML for a given WordPress media attachment.
 *
 * @param int $attachment_id The ID of the media attachment.
 * @param string $big_img_size The image size for the main image (default: 'large').
 * @param string $thumb The image size for the placeholder thumbnail (default: 'thumbnail').
 * @return string The HTML markup for the gallery item.
 */
function mawp_generate_gallery_item($attachment_id, $big_img_size = 'large', $thumb = "thumbnail") {
	// Get the full-size image URL.
	$full_image_url = wp_get_attachment_image_url($attachment_id, 'full');

	// Retrieve the metadata of the image to extract dimensions.
	$image_metadata = wp_get_attachment_metadata($attachment_id);
	$width = isset($image_metadata['width']) ? $image_metadata['width'] : 0;
	$height = isset($image_metadata['height']) ? $image_metadata['height'] : 0;

	// Retrieve the alt text with a fallback hierarchy.
	$alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true) 
		?: get_the_title($attachment_id) 
		?: wp_get_attachment_caption($attachment_id) 
		?: 'Default image'; // Custom fallback text.

	// Retrieve the title text with a fallback hierarchy.
	$link_text = get_the_title($attachment_id) 
		?: get_post_meta($attachment_id, '_wp_attachment_image_alt', true) 
		?: wp_get_attachment_caption($attachment_id) 
		?: 'Image title'; // Custom fallback text.

	// Retrieve the placeholder image URL based on the provided size.
	$placeholder = wp_get_attachment_image_url($attachment_id, $thumb);

	// Generate and return the gallery item HTML.
	return sprintf(
		'<a class="gal-item" title="%s" href="%s" data-pswp-width="%d" data-pswp-height="%d">' .
		'<img class="lazyload" src="%s" srcset="%s" data-src="%s" data-srcset="%s" alt="%s">' .
		'</a>',
		esc_attr($link_text), // Title attribute for the anchor tag.
		esc_url($full_image_url), // Full image URL for the link.
		esc_attr($width), // Image width for PhotoSwipe.
		esc_attr($height), // Image height for PhotoSwipe.
		esc_url($placeholder), // Placeholder image URL.
		esc_attr(wp_get_attachment_image_srcset($attachment_id, 'thumbnail')), // Srcset for the thumbnail.
		esc_url(wp_get_attachment_image_url($attachment_id, $big_img_size)), // Main image URL.
		esc_attr(wp_get_attachment_image_srcset($attachment_id, $big_img_size)), // Srcset for the main image.
		esc_attr($alt_text) // Alt attribute for the image.
	);
}

/* How to use */
/* 

// ========================== 
// For multiple images in gallery

// Get an array with id of images (from CarbonFields, CMB2, etc)
// $gallery_ids = carbon_get_theme_option( 'crb_media_gallery2' );
// Or set the array id-s manually
// $gallery_ids = [108, 109, 118, 119];


if (!empty($gallery_ids)) {
	echo '<div class="gallery-items">';
	foreach ($gallery_ids as $gallery_id) {
		echo mawp_generate_gallery_item($gallery_id, 'large', 'gallery-thumb');
	}
	echo '</div> <!-- .gallery-items -->';
} else {
	// echo 'Nu există imagini în galerie.';
} 

// ==========================

// For single item:

// Example: Generate a gallery item for attachment ID 123 with custom sizes.
$gallery_item_html = mawp_generate_gallery_item(123, 'medium', 'small');
echo $gallery_item_html;

// Output: The function will return an <a> tag containing an <img> element with lazy loading,
// alt text, title, and data attributes for PhotoSwipe dimensions.

*/