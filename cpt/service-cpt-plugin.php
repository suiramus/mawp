<?php
/*
Plugin Name: XIVM Services CPT and taxonomies
Description: A plugin to register custom post type "services" and custom taxonomy "service-category", along with rewrite rules for custom permalinks.
Version: 1.0
Author: XIVM
*/

// Register custom post type
function custom_post_type_services() {
	$labels = array(
		'name'               => 'Services',
		'singular_name'      => 'Service',
		'menu_name'          => 'Services',
		'name_admin_bar'     => 'Service',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Service',
		'new_item'           => 'New Service',
		'edit_item'          => 'Edit Service',
		'view_item'          => 'View Service',
		'all_items'          => 'All Services',
		'search_items'       => 'Search Services',
		'parent_item_colon'  => 'Parent Services:',
		'not_found'          => 'No services found.',
		'not_found_in_trash' => 'No services found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'services', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' )
	);

	register_post_type( 'services', $args );
}
add_action( 'init', 'custom_post_type_services' );

// Register custom taxonomy
function custom_taxonomy_service_category() {
	$labels = array(
		'name'                       => 'Service Categories',
		'singular_name'              => 'Service Category',
		'menu_name'                  => 'Service Categories',
		'all_items'                  => 'All Categories',
		'new_item_name'              => 'New Service Category',
		'add_new_item'               => 'Add New Service Category',
		'edit_item'                  => 'Edit Service Category',
		'update_item'                => 'Update Service Category',
		'view_item'                  => 'View Service Category',
		'separate_items_with_commas' => 'Separate categories with commas',
		'add_or_remove_items'        => 'Add or remove categories',
		'choose_from_most_used'      => 'Choose from the most used',
		'popular_items'              => 'Popular Categories',
		'search_items'               => 'Search Categories',
		'not_found'                  => 'No categories found',
		'no_terms'                   => 'No categories',
		'items_list'                 => 'Categories list',
		'items_list_navigation'      => 'Categories list navigation',
	);

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);

	register_taxonomy( 'service-category', array( 'services' ), $args );
}
add_action( 'init', 'custom_taxonomy_service_category', 0 );


/* Services Customization */

// Add featured image column

function add_featured_image_column($columns) {
	// Adaugă o nouă coloană numită "img"
	$columns['img'] = 'Featured Image';
	return $columns;
}

function customize_featured_image_column($column_name, $post_id) {
	if ($column_name == 'img') {
		// Obține URL-ul imaginii reprezentative
		$thumbnail_url = get_the_post_thumbnail_url($post_id, 'thumbnail');

		if ($thumbnail_url) {
			// Obține URL-ul original al imaginii și dimensiunile acesteia
			$original_url = get_the_post_thumbnail_url($post_id, 'full');
			list($original_width, $original_height) = getimagesize($original_url);

			// Obține titlul real al postării
			$actual_title = get_the_title($post_id);

			// Definește atributul title pentru imagine
			$image_title = $actual_title . ' (' . $original_width . 'px by ' . $original_height . 'px)';

			// Afișează imaginea thumbnail
			echo '<img src="' . esc_url($thumbnail_url) . '" style="max-height: 80px;" title="' . $image_title . '" />';
		} else {
			echo 'No image';
		}
	}
	return $column_name;
}

function add_featured_image_to_services($post_type) {
	// Aplică modificările doar pentru custom post type-ul "services"
	if ($post_type === 'services') {
		add_filter('manage_services_posts_columns', 'add_featured_image_column');
		add_action('manage_services_posts_custom_column', 'customize_featured_image_column', 10, 2);
	}
}
add_action('current_screen', function() {
	$screen = get_current_screen();
	add_featured_image_to_services($screen->post_type);
});


// Sort featuread image column

function add_featured_image_filter($post_type) {
	if ($post_type === 'services') {
		$selected = isset($_GET['has_thumbnail']) ? $_GET['has_thumbnail'] : '';
		?>
		<select name="has_thumbnail">
			<option value=""><?php esc_html_e('All Posts', 'textdomain'); ?></option>
			<option value="1" <?php selected($selected, '1'); ?>><?php esc_html_e('With Featured Image', 'textdomain'); ?></option>
			<option value="0" <?php selected($selected, '0'); ?>><?php esc_html_e('Without Featured Image', 'textdomain'); ?></option>
		</select>
		<?php
	}
}
add_action('restrict_manage_posts', 'add_featured_image_filter');

function filter_services_by_thumbnail($query) {
	global $pagenow;

	// Verificăm dacă suntem pe pagina listării și dacă avem parametru pentru filtrare
	if ($pagenow === 'edit.php' && isset($_GET['has_thumbnail']) && $_GET['post_type'] === 'services') {
		$has_thumbnail = $_GET['has_thumbnail'];

		if ($has_thumbnail === '1') {
			$query->set('meta_query', [
				[
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				]
			]);
		} elseif ($has_thumbnail === '0') {
			$query->set('meta_query', [
				[
					'key'     => '_thumbnail_id',
					'compare' => 'NOT EXISTS',
				]
			]);
		}
	}
}
add_action('pre_get_posts', 'filter_services_by_thumbnail');


/* Add ID in columns in Admin */

// Adăugăm o coloană personalizată pentru ID-ul postării
function add_services_id_column($columns) {
	$columns['service_id'] = 'ID';
	return $columns;
}
add_filter('manage_services_posts_columns', 'add_services_id_column');

// Afișăm ID-ul în coloana personalizată
function display_services_id_column($column, $post_id) {
	if ($column === 'service_id') {
		echo $post_id;
	}
}
add_action('manage_services_posts_custom_column', 'display_services_id_column', 10, 2);

// Setăm ca ID să fie ultima coloană
function reorder_services_columns($columns) {
	$columns = array_merge(
		array_diff_key($columns, ['service_id' => '']), // Eliminăm temporar coloana ID
		['service_id' => 'ID'],  // Adăugăm ID la sfârșit
	);
	return $columns;
}
add_filter('manage_services_posts_columns', 'reorder_services_columns', 11);
