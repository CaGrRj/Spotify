<?php
	
	/* Sends an PAUSE request to the currently playing device
	 *
	 * Required REQUEST params:
	 *  ---
	 */
	
	require_once(__DIR__ . '/../access.php');
	
	spotify_pause();
	
?>