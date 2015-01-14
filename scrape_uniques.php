<?php
	include('includes/simple_html_dom.php');
	include('includes/preferences.php');

	$conn = mysqli_connect($server, $dbUsername, $dbPassword, $db);
	if (mysqli_connect_errno($con)){ echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

	header('Content-Type: text/html; charset=utf-8');

	function get_damages($data){
		$damages = array('dps' => '',
							'physical' => '',
							'lightning' => '',
							'cold' => '',
							'fire' => '');
		if (strpos($data,'HoverFire') !== false) {
	    	preg_match('/\<span class="HoverFire"\>(.*?)\<\/span\>/', $data, $result);
	    	$damages['fire'] = str_replace('<span class="HoverFire">', '', $result[0]);
		}
		if (strpos($data,'HoverLightning') !== false) {
	    	preg_match('/\<span class="HoverLightning"\>(.*)\<\/span\>/', $data, $result);
	    	$damages['lightning'] = $result[0];
		}
		if (strpos($data,'HoverCold') !== false) {
	    	preg_match('/<span class="HoverCold"\>(.*)<\/span\>/', $data, $result);
	    	$damages['cold'] = $result[0];
		}

		$damage = preg_replace("/<.*?>/", "", $data);
		$parts = explode(' ', $damage);
		$damages['dps'] = $parts[1];
		$damages['physical'] = $parts[3];
		return $damages;
	}

	$html = file_get_html('http://en.pathofexilewiki.com/wiki/Full_Unique_Index');

	$strip_tags = array('<p>', '</p>', '<br />', '<div>', '</div>');

	$items = array(	array('name' => '',
							'image' => '',
							'level' => '',
							'damage' => '',
							'attacks_per_second' => '',
							'dps' => '',
							'req_str' => '',
							'req_dex' => '',
							'req_int' => '',
							'implicit_label',
							'implicit_value'
							));

	$mod_list = array();

	$item_count = 0;
	$table_count = 0;
	$insert_count = 0;
	$last_item_name = '';

	foreach($html->find('table[class=wikitable sortable]') as $table){
		foreach($table->find('tr') as $row){
			$col_count = 0;
			foreach($row->find('td') as $col){
				// Accessory Tables
				if($table_count <= 3){
					$category = 'accessory';

					if($col_count == 0){ $name = $col->find('a'); }
					else if($col_count == 1) { $base_item = $col->find('a'); }
					else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}

					else if($col_count == 3) { 
						$mods = explode('<br />', str_replace('<span class="HoverMod">', '<br />', $col->innertext));
					}
					else if($col_count == 4) { $flavor_text = str_replace($strip_tags, '', $col->innertext); }
					

					if($table_count == 0){ $base_type = 'amulet'; }
					else if($table_count == 1){ $base_type = 'belt'; }
					else if($table_count == 2){ $base_type = 'ring'; }
					else if($table_count == 3){ $base_type = 'quiver'; }

				}
				// Armor Tables
				else if($table_count <= 8){
					// Special case for shields to include the block column.
					$category = 'armor';
					if ($table_count == 8){
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_dex = $col->innertext; }
						else if($col_count == 5) { $req_int = $col->innertext; }
						else if($col_count == 6) { $block = $col->innertext; }
						else if($col_count == 7) { $ar = str_replace('&#8211', '', $col->innertext); }
						else if($col_count == 8) { $ev = $col->innertext; }
						else if($col_count == 9) { $es = $col->innertext; }
						else if($col_count == 10) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 11) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					else{
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_dex = $col->innertext; }
						else if($col_count == 5) { $req_int = $col->innertext; }
						else if($col_count == 6) { $ar = html_entity_decode($col->innertext); }
						else if($col_count == 7) { $ev = html_entity_decode($col->innertext); }
						else if($col_count == 8) { $es = html_entity_decode($col->innertext); }
						else if($col_count == 9) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 10) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}

					}

					if($table_count == 4){ $base_type = 'chest'; }
					else if($table_count == 5){ $base_type = 'boots'; }
					else if($table_count == 6){ $base_type = 'gloves'; }
					else if($table_count == 7){ $base_type = 'helmets'; }
					else if($table_count == 8){ $base_type = 'shield'; }


				}
				// Weapons
				else{
					$category = 'weapon';
					unset($ar);
					unset($ev);
					unset($es);
					unset($block);
					// Special case for each item type: 
					// Two-Handed Axes
					if($table_count == 9){
						$base_type = 'two-handed axe';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_dex = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Bows
					else if($table_count == 10){
						$base_type = 'bow';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_dex = $col->innertext; }
						else if($col_count == 4) { $damages = get_damages($col->innertext); }
						else if($col_count == 5) { $crit = $col->innertext; }
						else if($col_count == 6) { $attacks_per_second = $col->innertext; }
						else if($col_count == 7) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 8) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Claws
					else if($table_count == 11){
						$base_type = 'claw';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_dex = $col->innertext; }
						else if($col_count == 4) { $req_int = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Dagger
					else if($table_count == 12){
						$base_type = 'dagger';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_dex = $col->innertext; }
						else if($col_count == 4) { $req_int = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// 1h mace
					else if($table_count == 13){
						$base_type = 'one-handed mace';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_int = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// 2h mace
					else if($table_count == 14){
						$base_type = 'two-handed mace';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $damages = get_damages($col->innertext); }
						else if($col_count == 5) { $crit = $col->innertext; }
						else if($col_count == 6) { $attacks_per_second = $col->innertext; }
						else if($col_count == 7) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 8) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// 1h sword
					else if($table_count == 15){
						$base_type = 'one-handed sword';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_dex = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// 2h sword
					else if($table_count == 16){
						$base_type = 'one-handed sword';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_dex = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Staff
					else if($table_count == 17){
						$base_type = 'staff';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_str = $col->innertext; }
						else if($col_count == 4) { $req_int = $col->innertext; }
						else if($col_count == 5) { $damages = get_damages($col->innertext); }
						else if($col_count == 6) { $crit = $col->innertext; }
						else if($col_count == 7) { $attacks_per_second = $col->innertext; }
						else if($col_count == 8) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 9) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Wand
					else if($table_count == 18){
						$base_type = 'wand';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_int = $col->innertext; }
						else if($col_count == 4) { $damages = get_damages($col->innertext); }
						else if($col_count == 5) { $crit = $col->innertext; }
						else if($col_count == 6) { $attacks_per_second = $col->innertext; }
						else if($col_count == 7) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 8) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
					// Maps
					else if($table_count == 18){
						$base_type = 'map';
						if($col_count == 0){ $name = $col->find('a'); }
						else if($col_count == 1) { $base_item = $col->find('a'); }
						else if($col_count == 2) { $level = str_replace($strip_tags, '', $col->innertext);}
						else if($col_count == 3) { $req_int = $col->innertext; }
						else if($col_count == 4) { $damages = get_damages($col->innertext); }
						else if($col_count == 5) { $crit = $col->innertext; }
						else if($col_count == 6) { $attacks_per_second = $col->innertext; }
						else if($col_count == 7) { $mods = explode('<br />', $col->innertext); }
						else if($col_count == 8) { $flavor_text = str_replace($strip_tags, '', $col->innertext);}
					}
				}
				$col_count++;
			}


			
			//$last_item_name = $name[0]->innertext;
			if($last_item_name != $name[0]->innertext){
				
				$level = preg_replace("/<.*?>/", "", $level);
				// Ewww...
				$name = str_replace("'", "", strtolower(preg_replace("/\<.*?>/", "", $name[0]->innertext)));
				$base_item = strtolower(preg_replace("/<.*?>/", "", $base_item[0]->innertext));
				$req_str = preg_replace("/<.*?>/", "", $req_str);
				$req_dex = preg_replace("/<.*?>/", "", $req_dex);
				$req_int = preg_replace("/<.*?>/", "", $req_int);
				$block = preg_replace("/<.*?>/", "", $block);
				$ar = preg_replace("/<.*?>/", "", $ar);
				$ev = preg_replace("/<.*?>/", "", $ev);
				$es = preg_replace("/<.*?>/", "", $es);
				$crit = preg_replace("/<.*?>/", "", $crit);
				$attacks_per_second = preg_replace("/<.*?>/", "", $attacks_per_second);
				$flavor_text = preg_replace("/<.*?>/", "", $flavor_text);
				$mods = serialize(preg_replace('/<.*?\>/', '', $mods));


				
				if($stmt = mysqli_prepare($conn, "INSERT INTO unique_items VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)")){
					$stmt->bind_param('isssssssssssssssssssss',
											$item_count,
											$category,
											$base_type,
											$level,
											$name,
											$base_item,
											$req_str,
											$req_dex,
											$req_int,
											$block,
											$ar,
											$ev,
											$es,
											$damages['dps'],
											$damages['physical'],
											$damages['lightning'],
											$damages['fire'],
											$damages['cold'],
											$crit,
											$attacks_per_second,
											$flavor_text,
											$mods);
					$stmt->execute();
				}
				else{
					print $conn-> errno.' - '.$conn->error;
				}
				$insert_count++;

			}
			//$last_mod = array_search($mods, $mod_list);
			$last_item_name = $name[0]->innertext;
			$item_count++;
		}
		$table_count++;
	}

	print($insert_count);

	/*
	print "<h1>MODS</h1>";

	$item_count = 1;
	$last = 0;
	foreach($mod_list as $mods){
		$line = '';
		if(is_array($mods)){
			if($last != array_search($mods, $mod_list)){
				print '"'.array_search($mods, $mod_list),serialize($mods).'"<br />';
				//if($stmt = mysqli_prepare($conn, "INSERT INTO unique_item_mods VALUES ('".array_search($mods, $mod_list)."', ?)")){
				//	$stmt->bind_param("s", serialize($mods));
				//	$stmt->execute();
				}
			}
			$last = array_search($mods, $mod_list);
		}
		$item_count++;
		//print $line.'<br />';
	}
	*/

	mysqli_close($conn);
?>