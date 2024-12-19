<?php

/* 
	Wordpress Image info
 */

// 1. URL-ul imaginii
$image_id = 123; // ID-ul imaginii
$image_url = wp_get_attachment_url($image_id);
// Output: $image_url contine URL-ul imaginii, ex: "https://example.com/wp-content/uploads/2023/12/image.jpg"

// 2. Dimensiunile imaginii (thumbnail sau altă dimensiune definită)
$image_sizes = wp_get_attachment_image_src($image_id, 'thumbnail');
$image_url_thumbnail = $image_sizes[0]; // URL-ul imaginii
$image_width_thumbnail = $image_sizes[1]; // Lățimea imaginii thumbnail
$image_height_thumbnail = $image_sizes[2]; // Înălțimea imaginii thumbnail
// Output: Array ce conține URL-ul, lățimea și înălțimea, ex: ["https://example.com/wp-content/uploads/2023/12/image-thumbnail.jpg", 150, 150]

// 3. Meta informații despre imagine
$metadata = wp_get_attachment_metadata($image_id);
// Output: Array asociativ cu informații despre imagine, ex: 
// [
//   'width' => 1920,
//   'height' => 1080,
//   'file' => '2023/12/image.jpg',
//   'sizes' => [
//     'thumbnail' => ['file' => 'image-thumbnail.jpg', 'width' => 150, 'height' => 150],
//     'medium' => ['file' => 'image-medium.jpg', 'width' => 300, 'height' => 300],
//   ],
//   'image_meta' => ['aperture' => '5.6', 'camera' => 'Canon EOS', ...]
// ]

// 4. Titlu, descriere, legendă, alt text
$image_post = get_post($image_id);
$image_title = $image_post->post_title; // Titlul imaginii
$image_caption = $image_post->post_excerpt; // Legenda imaginii
$image_description = $image_post->post_content; // Descrierea imaginii
$alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true); // Textul alternativ
// Output:
// $image_title: "Exemplu Titlu"
// $image_caption: "Exemplu Legenda"
// $image_description: "Exemplu Descriere"
// $alt_text: "Text Alternativ"

// 5. Tipul fișierului și calea către fișier
$file_path = get_attached_file($image_id); // Calea completă a fișierului pe server
$file_type = wp_check_filetype($file_path); // Tipul fișierului (mime type și extensie)
// Output:
// $file_path: "/var/www/html/wp-content/uploads/2023/12/image.jpg"
// $file_type: ['ext' => 'jpg', 'type' => 'image/jpeg']

// 6. Informații despre dimensiunile suplimentare
$sizes = get_intermediate_image_sizes();
$all_sizes = [];
foreach ($sizes as $size) {
	$image_data = wp_get_attachment_image_src($image_id, $size);
	$all_sizes[$size] = [
		'url' => $image_data[0],
		'width' => $image_data[1],
		'height' => $image_data[2],
	];
}
// Output: Array asociativ cu toate dimensiunile disponibile
// [
//   'thumbnail' => ['url' => '...', 'width' => 150, 'height' => 150],
//   'medium' => ['url' => '...', 'width' => 300, 'height' => 300],
//   'large' => ['url' => '...', 'width' => 1024, 'height' => 1024],
// ]

/* 
	======================================================
	Functie care returneaza informatii despre imagine
	
	======================================================
 */

function get_image_details($image_id) {
	if (!wp_attachment_is_image($image_id)) {
		return false; // ID-ul nu corespunde unei imagini
	}

	$image_details = [];

	// URL-ul imaginii
	$image_details['url'] = wp_get_attachment_url($image_id);

	// Dimensiunile imaginii (thumbnail sau altă dimensiune definită)
	$image_details['sizes'] = [];
	$sizes = get_intermediate_image_sizes();
	foreach ($sizes as $size) {
		$image_data = wp_get_attachment_image_src($image_id, $size);
		$image_details['sizes'][$size] = [
			'url' => $image_data[0],
			'width' => $image_data[1],
			'height' => $image_data[2],
		];
	}

	// Meta informații despre imagine
	$image_details['metadata'] = wp_get_attachment_metadata($image_id);

	// Titlu, descriere, legendă, alt text
	$image_post = get_post($image_id);
	$image_details['title'] = $image_post->post_title;
	$image_details['caption'] = $image_post->post_excerpt;
	$image_details['description'] = $image_post->post_content;
	$image_details['alt'] = get_post_meta($image_id, '_wp_attachment_image_alt', true);

	// Tipul fișierului și calea către fișier
	$file_path = get_attached_file($image_id);
	$file_type = wp_check_filetype($file_path);
	$image_details['file_path'] = $file_path;
	$image_details['file_type'] = $file_type;

	return $image_details;
}

/* 
	// Exemplu de utilizare
	$image_id = 123; // ID-ul imaginii
	$image_info = get_image_details($image_id);
	if ($image_info) {
		echo '<pre>';
			var_dump($image_info);
		echo '</pre>';
	} else {
		echo "ID-ul nu corespunde unei imagini valide.";
	}
*/
