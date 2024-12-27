<?php

/* 
	How To Add Masonry Layout In WordPress
	https://www.customfitwebdesign.com/how-to-add-masonry-layout-in-wordpress/
 */

// functions.php
// Will include masonry.min.js and imagesLoaded.min.js

function mawp_masonry_on_frontend() {
	wp_enqueue_script('masonry');
}
add_action('wp_enqueue_scripts', 'mawp_masonry_on_frontend');


// Add settings to footer
function MasonOnLoad() { ?>  <!-- add masonry setting to the footer -->
  <script>
	(function( $ ) {
		"use strict";
		$(function() {
				// set the container that Masonry will be inside of in a var
				// adjust to match your own wrapper/container class/id name
			var container = document.querySelector( '#ms-container' );
				//create empty var msnry
				var msnry;
			// initialize Masonry after all images have loaded
				imagesLoaded( container, function() {
					msnry = new Masonry( container, {
					// adjust to match your own block wrapper/container class/id name
					itemSelector: '.grid-item'
					});
				});
		});
	}(jQuery));
  </script>
<?php } // end function MasonOnLoad
add_action('wp_footer', 'MasonOnLoad');

// OR

// Without jQuery
/* 
function MasonOnLoad() {
	if (!is_page('gallery')) { // Înlocuiește 'gallery' cu slug-ul paginii dorite
		return;
	}
	?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var container = document.querySelector('#ms-container');
			if (!container) {
				console.warn('Masonry container not found: #ms-container');
				return;
			}

			imagesLoaded(container, function() {
				new Masonry(container, {
					itemSelector: '.grid-item',
					columnWidth: '.grid-sizer',
					percentPosition: true
				});
			});
		});
	</script>
	<?php
}
add_action('wp_footer', 'MasonOnLoad', 20);

*/

/* 
	HTML:
	<div class="row" id="ms-container">
		<div class="grid-sizer"></div> <!-- Element gol, folosit doar pentru calcul -->
		<div class="grid-item">...</div>
		<div class="grid-item">...</div>
		<div class="grid-item">...</div>
	</div>

 */

/* 
	CSS:
	#ms-container {
		display: flex;
		flex-wrap: wrap;
	}

	// Coloanele vor avea 25% din lățimea containerului
	.grid-sizer {
		width: 25%;
	}

	// Exemplu: Itemele pot avea dimensiuni diferite
	.grid-item {
		width: 50%;
		background: #ccc;
		margin-bottom: 10px;
	}

 */