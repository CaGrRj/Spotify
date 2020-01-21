<?php
	
	if (isset($_GET['send']) and ($_GET['send'] == 'true')) {
		$content = "RewriteEngine On\nRewriteBase " . $_GET['path'] . "\n";
		$content .= "\n";
		$content .= "### RESTRICTED FOLDER\n";
		$content .= "RewriteRule ^(.*)const/server(.*)$ / [R=301,L,NC]\n";
		$content .= "RewriteRule ^(.*)server/server(.*)$ / [R=301,L,NC]\n";
		$content .= "RewriteRule ^(.*)site/server(.*)$ / [R=301,L,NC]\n";
		$content .= "RewriteRule ^(.*)site/content(.*)$ / [R=301,L,NC]\n";
		$content .= "\n";
		$content .= "### CONTENT LOADER\n";
		$content .= "# Keep this subfolders untouched\n";
		$content .= "RewriteRule ^(api|display.php)($|/) - [L]\n";
		$content .= "# Check if this looks like a mobile device\n";
		$content .= "RewriteCond %{HTTP:x-wap-profile} !^$ [OR]\n";
		$content .= "RewriteCond %{HTTP:Profile}       !^$ [OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"acs|alav|alca|amoi|audi|aste|avan|benq|bird|blac|blaz|brew|cell|cldc|cmd-\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"dang|doco|eric|hipt|inno|ipaq|java|jigs|kddi|keji|leno|lg-c|lg-d|lg-g|lge-\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"maui|maxo|midp|mits|mmef|mobi|mot-|moto|mwbp|nec-|newt|noki|opwv\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"palm|pana|pant|pdxg|phil|play|pluc|port|prox|qtek|qwap|sage|sams|sany\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"sch-|sec-|send|seri|sgh-|shar|sie-|siem|smal|smar|sony|sph-|symb|t-mo\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"teli|tim-|tosh|tsm-|upg1|upsi|vk-v|voda|w3cs|wap-|wapa|wapi\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"wapp|wapr|webc|winw|winw|xda|xda-\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"up.browser|up.link|windowssce|iemobile|mini|mmp\" [NC,OR]\n";
		$content .= "RewriteCond %{HTTP_USER_AGENT} \"symbian|midp|wap|phone|pocket|mobile|pda|psp\" [NC,OR]\n";
		$content .= "# Or if cookie is set to mobile\n";
		$content .= "RewriteCond %{HTTP_COOKIE} ^.*device=m.*$ [NC]\n";
		$content .= "# And if cookie is not set to desktop\n";
		$content .= "RewriteCond %{HTTP_COOKIE} !^.*device=d.*$ [NC]\n";
		$content .= "# Then show mobile site\n";
		$content .= "RewriteRule ^([^\.]*)$ mobile.php?request=$1 [QSA]\n";
		$content .= "# Else show desktop site\n";
		$content .= "RewriteRule ^([^\.]*)$ desktop.php?request=$1 [QSA]\n";
		file_put_contents(__DIR__ . '/.htaccess', $content);
		
		$content = "<?php\n";
		$content .= "error_reporting(0);\n";
		$content .= "define('SERVER_ADDR', 'https://" . $_SERVER['SERVER_NAME'] . $_GET['path'] . "');\n";
		$content .= "define('CLIENT_ID', '$_GET[client_id]');\n";
		$content .= "define('CLIENT_SECRET', '$_GET[client_secret]');\n";
		$content .= "define('REFRESH_TOKEN', '*** PASTE YOUR REFRESH_TOKEN HERE ***');\n";
		$content .= "define('JQUERY_URL1', 'https://code.jquery.com/jquery-1.9.1.min.js');\n";
		$content .= "define('JQUERY_URL2', 'https://code.jquery.com/ui/1.10.3/jquery-ui.js');\n";
		$content .= "?>\n";
		file_put_contents(__DIR__ . '/server/server/const.php', $content);
		
		$content = "<?php\n";
		$content .= "// Party-Name und Willkommens-Text\n";
		$content .= "define('PARTY_NAME', 'Test-Party');\n";
		$content .= "define('WELCOME_TEXT', 'Herzlich Willkommen auf der ' . PARTY_NAME . '!');\n";
		$content .= "\n";
		$content .= "// Party-Codes\n";
		$content .= "define('PARTY_CODE', 'party-code');   // Nötig, um die Website als Gast zu sehen - Wünsche möglich\n";
		$content .= "define('ADMIN_CODE', 'party-admin');  // Admin Code - Kann zusätzlich die Blacklist bearbeiten und Wünsche löschen\n";
		$content .= "\n";
		$content .= "// Username\n";
		$content .= "define('SP_USERNAME', '$_GET[username]');\n";
		$content .= "\n";
		$content .= "// Playlist IDs\n";
		$content .= "define('PL_WISH',  '$_GET[pl_wish]');  // Wunschliste - hier werden die gewünschten Songs hinzugefügt\n";
		$content .= "define('PL_WDW',   '$_GET[pl_wdw]');  // Wünsch Dir Was - hier hinzugefügte Songs werden automatisch in PL_WISH verschoben\n";
		$content .= "define('PL_SAVED', '$_GET[pl_saved]');  // Alle Wünsche werden zusätzlich in diese Playlist kopiert - so lässt sich später einsehen, was gespielt wurde\n";
		$content .= "define('PL_POOL',  '$_GET[pl_pool]');  // Songpool - Sollten weniger als 3(?) Songs in PL_WISH sein, wird ein zufälliger Song aus dieser Playlist dorthin verschoben\n";
		$content .= "?>\n";
		file_put_contents(__DIR__ . '/site/server/const.php', $content);
		
		unlink(__FILE__);
	} else {
		echo '<form method="post"><table border="0">';
			echo '<tr>';
				echo '<td><b>Installation Directory:</b></td>';
				echo '<td><input type="text" name="path" value="/" /><br>';
				echo '<i>The path to your installation.</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>CLIENT_ID:</b></td>';
				echo '<td><input type="text" name="client_id" value="" /><br>';
				echo '<i></i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>CLIENT_SECRET:</b></td>';
				echo '<td><input type="text" name="client_secret" value="" /><br>';
				echo '<i></i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>Username:</b></td>';
				echo '<td><input type="text" name="username" value="" /><br>';
				echo '<i>Your spotify username</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="2"><b>Playlist IDs</b><br>The ids of your created playlists - without the "spotify:playlist:"</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>PL_WISH:</b></td>';
				echo '<td><input type="text" name="pl_wish" value="" /><br>';
				echo '<i>The wishlist - will be played by spotify</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>PL_WDW:</b></td>';
				echo '<td><input type="text" name="pl_wdw" value="" /><br>';
				echo '<i>Wish You What playlist - guests can add wishes to this playlist</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>PL_SAVED:</b></td>';
				echo '<td><input type="text" name="pl_saved" value="" /><br>';
				echo '<i>All wishes will be saved here</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><b>PL_POOL:</b></td>';
				echo '<td><input type="text" name="pl_pool" value="" /><br>';
				echo '<i>Track pool - if there are no wishes, a random song from here will be played</i></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="2"><button>Einrichten</button></td>';
			echo '</tr>';
		echo '</table></form>';
	}
	
?>