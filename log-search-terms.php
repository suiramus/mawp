<?php

/* 
Salveaza un fisier cu termenii de cautare de pe site
search-terms.log

Data 					Ip 					Termen de cautare
[2023-11-02 19:32:00] - [ 179.100.95.71 ] - [ term1 ]
[2023-11-02 19:33:11] - [ 179.100.95.71 ] - [ term 2]
[2023-11-03 12:40:57] - [ 80.96.90.100 ] - [ another term ]
 */

// Adaugă funcția log_search_terms() în acțiunea 'init'
add_action('init', 'log_search_terms');

// Funcție pentru a salva termenii de căutare și adresa IP într-un fișier de log
function log_search_terms() {
	// Obține termenul de căutare din parametrul GET 's' (query string)
	$search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

	// Obține adresa IP a utilizatorului
	$ip_address = $_SERVER['REMOTE_ADDR'];

	// Dacă există un termen de căutare, salvează-l în fișierul de log împreună cu adresa IP
	if (!empty($search_term)) {
		// Calea către fișierul de log (poți specifica altă cale dacă dorești)
		$log_file = get_template_directory() . '/search-terms.log';

		// Formatează data, adresa IP și termenul de căutare pentru înregistrare
		$log_entry = date('[Y-m-d H:i:s]') . ' - [ ' . $ip_address . ' ] - [ ' . $search_term . ' ]' . PHP_EOL;

		// Salvează termenul de căutare și adresa IP în fișierul de log (cu opțiunea FILE_APPEND pentru a adăuga la sfârșitul fișierului)
		file_put_contents($log_file, $log_entry, FILE_APPEND);
	}
}