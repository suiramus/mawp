<?php

/*
Plugin Name: MAWP Portfolio CPT and taxonomies
Plugin URI: https://wordpress.org/
Description: CPT: portfolio-cpt | Taxonomy: portfolio-category
Version: 0.1.1224
Author: MAWP Team
Author URI: https://wordpress.org/
Text Domain: mapw
*/


/* 
	Portfolio CPT: portfolio-cpt
	Taxonomy: portfolio-category
 */


// Register "portfolio-category" for "portfolio-cpt" CPT
// Tax name: portfolio-category
// Tax slug: galleries
// Tax associated to CPT: portfolio-cpt
add_action( 'init', 'mawp_portfolio_category_register_taxonomy' );
function mawp_portfolio_category_register_taxonomy() {
	$domain = "mawp";
	$labels = [
		'name'                       => esc_html__( 'Portfolio Categories', $domain ),
		'singular_name'              => esc_html__( 'Portfolio Category', $domain ),
		'menu_name'                  => esc_html__( 'Portfolio Categories', $domain ),
		'search_items'               => esc_html__( 'Search Portfolio Categories', $domain ),
		'popular_items'              => esc_html__( 'Popular Portfolio Categories', $domain ),
		'all_items'                  => esc_html__( 'All Portfolio Categories', $domain ),
		'parent_item'                => esc_html__( 'Parent Portfolio Category', $domain ),
		'parent_item_colon'          => esc_html__( 'Parent Portfolio Category', $domain ),
		'edit_item'                  => esc_html__( 'Edit Portfolio Category', $domain ),
		'view_item'                  => esc_html__( 'View Portfolio Category', $domain ),
		'update_item'                => esc_html__( 'Update Portfolio Category', $domain ),
		'add_new_item'               => esc_html__( 'Add new portfolio category', $domain ),
		'new_item_name'              => esc_html__( 'New portfolio category name', $domain ),
		'separate_items_with_commas' => esc_html__( 'Separate portfolio categories with commas', $domain ),
		'add_or_remove_items'        => esc_html__( 'Add or remove portfolio categories', $domain ),
		'choose_from_most_used'      => esc_html__( 'Choose most used portfolio categories', $domain ),
		'not_found'                  => esc_html__( 'No portfolio categories found', $domain ),
		'no_terms'                   => esc_html__( 'No portfolio categories found', $domain ),
		'items_list_navigation'      => esc_html__( 'Portfolio categories list pagination', $domain ),
		'items_list'                 => esc_html__( 'Portfolio Categories list', $domain ),
		'most_used'                  => esc_html__( 'Most Used', $domain ),
		'back_to_items'              => esc_html__( 'Back to portfolio categories', $domain ),
		'text_domain'                => esc_html__( $domain, $domain ),
	];
	$args = [
		'label'              => esc_html__( 'Portfolio Categories', 'mawp' ),
		'labels'             => $labels,
		'description'        => 'Categories for portfolio galleries.',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		// 'meta_box_cb'        => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => false,
		'show_in_quick_edit' => true,
		'show_admin_column'  => true,
		'query_var'          => true,
		'sort'               => null,
		'rest_base'          => '',
		'rewrite'            => [
			// 'slug'         => 'galleries',
			'slug'         => 'portfolio-category',
			'with_front'   => false,
			'hierarchical' => true,
		],
	];
	register_taxonomy( 'portfolio-category', 'portfolio-cpt', $args );
}


// Register Portfolio CPT
// CPT Name: portfolio-cpt
// Slug: portfolio
// Taxonomies: portfolio-category
add_action( 'init', 'mawp_portfolio_register_post_type' );
function mawp_portfolio_register_post_type() {
	$domain = "mawp";
	$labels = [
		'name'                     => esc_html__( 'Portfolio', $domain ),
		'singular_name'            => esc_html__( 'Portfolio', $domain ),
		'add_new'                  => esc_html__( 'Add New', $domain ),
		'add_new_item'             => esc_html__( 'Add new portfolio', $domain ),
		'edit_item'                => esc_html__( 'Edit Portfolio', $domain ),
		'new_item'                 => esc_html__( 'New Portfolio', $domain ),
		'view_item'                => esc_html__( 'View Portfolio', $domain ),
		'view_items'               => esc_html__( 'View Portfolios', $domain ),
		'search_items'             => esc_html__( 'Search Portfolio', $domain ),
		'not_found'                => esc_html__( 'No portfolio found', $domain ),
		'not_found_in_trash'       => esc_html__( 'No portfolio found in Trash', $domain ),
		'parent_item_colon'        => esc_html__( 'Parent Portfolio:', $domain ),
		'all_items'                => esc_html__( 'All Portfolios', $domain ),
		'archives'                 => esc_html__( 'Portfolio Archives', $domain ),
		'attributes'               => esc_html__( 'Portfolio Attributes', $domain ),
		'insert_into_item'         => esc_html__( 'Insert into portfolio', $domain ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this portfolio', $domain ),
		'featured_image'           => esc_html__( 'Cover image', $domain ),
		'set_featured_image'       => esc_html__( 'Set Cover image', $domain ),
		'remove_featured_image'    => esc_html__( 'Remove cover image', $domain ),
		'use_featured_image'       => esc_html__( 'Use as cover image', $domain ),
		'menu_name'                => esc_html__( 'Portfolio', $domain ),
		'filter_items_list'        => esc_html__( 'Filter portfolio list', $domain ),
		'items_list_navigation'    => esc_html__( 'Portfolio list navigation', $domain ),
		'items_list'               => esc_html__( 'Portfolio list', $domain ),
		'item_published'           => esc_html__( 'Portfolio published', $domain ),
		'item_published_privately' => esc_html__( 'Portfolio published privately', $domain ),
		'item_reverted_to_draft'   => esc_html__( 'Portfolio reverted to draft', $domain ),
		'item_scheduled'           => esc_html__( 'Portfolio scheduled', $domain ),
		'item_updated'             => esc_html__( 'Portfolio updated', $domain ),
		'text_domain'              => esc_html__( $domain, $domain ),
	];
	$args = [
		'label'               => esc_html__( 'Portfolio', $domain ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'menu_position'       => null,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => true,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-star-filled',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail'],
		'taxonomies'          => ['portfolio-category'],
		'rewrite'             => [
			'slug'       => 'portfolio',
			'with_front' => false,
		],
	];

	register_post_type( 'portfolio-cpt', $args );
}


/* 
	============================================
	// Add image in Admin Column for "portfolio-cpt" CPT
	// https://www.smashingmagazine.com/2017/12/customizing-admin-columns-wordpress/
	============================================
 */

// Add filter to modify the columns displayed in the admin posts list for the custom post type "portfolio-cpt".
add_filter( 'manage_portfolio-cpt_posts_columns', 'mawp_filter_posts_columns' );
function mawp_filter_posts_columns( $columns ) {
	// Store default columns for reference.
	$default_columns = $columns;

	// Define custom columns.
	$custom_columns = array(
		'cb'                           => $default_columns['cb'], // Checkbox for bulk actions.
		'title'                        => __( 'Portfolio Title', 'mawp' ), // Post title column.
		'portfolio_id'                 => __( 'Post ID', 'mawp' ), // Custom column for displaying post IDs.
		'image'                        => __( 'Cover Image', 'mawp' ), // Custom column for displaying featured images.
		'taxonomy-portfolio-category'  => __( 'Portfolio Category', 'mawp' ), // Taxonomy column.
		// 'taxonomy-portfolio-tags'  	=>__( 'Portfolio Tags', 'mawp' ),
		'date'                         => __( 'Date', 'mawp' ), // Default date column.
	);

	// Merge custom columns with default columns.
	return array_merge( $custom_columns, $default_columns );
}

// Add action to populate custom columns with their respective data.
add_action( 'manage_portfolio-cpt_posts_custom_column', 'mawp_portfolio_custom_columns', 10, 2 );
function mawp_portfolio_custom_columns( $column, $post_id ) {
	if ( 'image' === $column ) {
		// Display the featured image thumbnail, or a fallback message if no image is set.
		$thumbnail = get_the_post_thumbnail( $post_id, array( 100, 100 ) );
		echo $thumbnail ? $thumbnail : __( 'No image', 'mawp' );
	} elseif ( 'portfolio_id' === $column ) {
		// Display the ID of the post.
		echo $post_id;
	}
}


