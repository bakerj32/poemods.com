<?php

	include('includes/preferences.php');
	header('Content-Type: text/html; charset=utf-8');
	
	function get_item_type_label($item_type){
		if($item_type == '1h_sword_axe'){ return '1h Swords & Axes'; }
		else if($item_type == '2h_sword_axe'){ return '2h Swords & Axes'; }
		else if($item_type == '1h_mace'){ return '1h Mace'; }
		else if($item_type == '2h_mace'){ return '2h Mace'; }
		else { return $item_type; }
	}

	function is_cat_armor($item_type){
		$cat_armors = array('helmet', 'gloves', 'boots', 'chest', 'shield', 'helmet');
		$result = array_search($item_type, $cat_armors);
		if($result){ return True;}
		// ATTN
		else if($item_type == 'helmet'){ return True; }
		else{return False;}

	}

	function get_cat_armors($item_type, $query_result){
		$prefix_types = array('any' => [], 'ar' => [], 'ev' => [], 'es' => [], 'ar_ev' => [], 'ar_es' => [], 'ev_es' => []);
		$suffix_types = array('any' => [], 'ar' => [], 'ev' => [], 'es' => [], 'ar_ev' => [], 'ar_es' => [], 'ev_es' => []);
		$implicit_types = array('any' => [], 'ar' => [], 'ev' => [], 'es' => [], 'ar_ev' => [], 'ar_es' => [], 'ev_es' => []);

		//$prefix_result = mysqli_query($conn, "SELECT level, description, value, name, mods FROM mods WHERE ". $item_type ." LIKE '%Yes%' AND mod_type = 'Prefix'");
		while($item = mysqli_fetch_assoc($query_result)){
			if($item[$item_type] == 'Yes' && $item['mod_type'] == 'Prefix'){
				array_push($prefix_types['any'], $item);
				array_push($prefix_types['ar'], $item);
				array_push($prefix_types['ev'], $item);
				array_push($prefix_types['es'], $item);
				array_push($prefix_types['ar_ev'], $item);
				array_push($prefix_types['ar_es'], $item);
				array_push($prefix_types['ev_es'], $item);
			}
			else if($item[$item_type] == 'Yes' && $item['mod_type'] == 'Suffix'){ 
				array_push($suffix_types['any'], $item);
				array_push($suffix_types['ar'], $item);
				array_push($suffix_types['ev'], $item);
				array_push($suffix_types['es'], $item);
				array_push($suffix_types['ar_ev'], $item);
				array_push($suffix_types['ar_es'], $item);
				array_push($suffix_types['ev_es'], $item);
			}
			else if($item[$item_type] == 'Yes' && $item['mod_type'] == 'Implicit'){ 
				array_push($implicit_types['any'], $item);
				array_push($implicit_types['ar'], $item);
				array_push($implicit_types['ev'], $item);
				array_push($implicit_types['es'], $item);
				array_push($implicit_types['ar_ev'], $item);
				array_push($implicit_types['ar_es'], $item);
				array_push($implicit_types['ev_es'], $item);
			}
			if($item['mod_type'] == "Prefix"){
				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (str-only)') && $item['mod_type'] = 'Prefix'){ array_push($prefix_types['ar'], $item); }
				if(($item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-only)') && $item['mod_type'] = 'Prefix'){ array_push($prefix_types['ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (int-only)') && $item['mod_type'] = 'Prefix'){ array_push($prefix_types['es'], $item); }
				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-str)') && $item['mod_type'] == 'Prefix'){ array_push($prefix_types['ar_ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (int-str)') && $item['mod_type'] == 'Prefix'){ array_push($prefix_types['ar_es'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (int-dex)') && $item['mod_type'] == 'Prefix'){ 
					array_push($prefix_types['ev_es'], $item); }
			}
			else if($item['mod_type'] == "Suffix"){

				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (str-only)') && $item['mod_type'] = 'Suffix'){ array_push($suffix_types['ar'], $item); }
				if(($item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-only)') && $item['mod_type'] = 'Suffix'){ array_push($suffix_types['ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (int-only)') && $item['mod_type'] = 'Suffix'){ array_push($suffix_types['es'], $item); }
				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-str)') && $item['mod_type'] == 'Suffix'){ array_push($suffix_types['ar_ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (int-str)') && $item['mod_type'] == 'Suffix'){ array_push($suffix_types['ar_es'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (int-dex)') && $item['mod_type'] == 'Suffix'){ array_push($suffix_types['ev_es'], $item); }
			}
			else if($item['mod_type'] == "Implicit"){
				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (str-only)') && $item['mod_type'] = 'Implicit'){ array_push($implicit_types['ar'], $item); }
				if(($item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-only)') && $item['mod_type'] = 'Implicit'){ array_push($implicit_types['ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (int-only)') && $item['mod_type'] = 'Implicit'){ array_push($implicit_types['es'], $item); }
				if(($item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (dex-str)') && $item['mod_type'] == 'Implicit'){ array_push($implicit_types['ar_ev'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (str)' || $item[$item_type] == 'Yes (int-str)') && $item['mod_type'] == 'Implicit'){ array_push($implicit_types['ar_es'], $item); }
				if(($item[$item_type] == 'Yes (int)' || $item[$item_type] == 'Yes (dex)' || $item[$item_type] == 'Yes (int-dex)') && $item['mod_type'] == 'Implicit'){ array_push($implicit_types['ev_es'], $item); }
			}
		}


		$armor_types = array('prefixes' => $prefix_types, 'suffixes' => $suffix_types, 'implicits' => $implicit_types);
		return $armor_types;
	}

	function get_cat_items($query_result){
		$prefixes = array();
		$suffixes = array();
		$implicits = array();

		while($item = mysqli_fetch_assoc($query_result)){
			if($item['mod_type'] == 'Prefix'){  array_push($prefixes , $item); }
			else if($item['mod_type'] == 'Suffix'){  array_push($suffixes, $item); }
			else if($item['mod_type'] == 'Implicit'){  array_push($implicits, $item); }
		}

		return array('prefixes' => $prefixes, 'suffixes' => $suffixes, 'implicits', $implicits);

	}

	function get_row_html($items){
		$html = '<tr class="nest-accordion"><td><b>'.$items[0]['mod_type'].'</b></td></tr>';
		$item_desc = '';
		$nested = false;
		foreach($items as $item){
			// Item is nested <ul>
			if($item_desc == $item['description']){ 
				// Normal <li>
				$html .= '<li><b>iLvl: '.$item['level'].'</b> - '.$item['value'].' (<b>'.$item['name'].')</b></li>'; 
				// First item in UL.
			}
			// First Mod description, accordion.
			else{
				if($nested){
					$html .= "</ul></td></tr>";
					$nested = false;
				}
				$html .= '<tr class="nest-accordion" name="collapsed">
							<td>'.$item['description'].'</td>
							<td class="nest">
								<ul>
									<li><b>iLvl: '.$item['level'].'</b> - '.$item['value'].'<b> ('.$item['name'].')</b></li>';
				$nested = true;
			} 
			$item_desc = $item['description'];
		}
		return $html;
	}

	function print_inner_unique_table($item){
		echo ('
		<tr class="accordion unique-hover" name="collapsed">
									<td class="level1"><b><span class="unique-text" style="text-shadow: 1px 1px #CCC">'.ucwords($item['name']).'</span> - '.ucwords($item['base_item']).'</b></td>
									<tr class="inner-row" name="collapsed">
										<td style="background-color: #FFF; cursor: pointer;">
											<table class="inner-table">
												<tr class="normal">');

												$keys = array_keys($item);
												foreach($keys as $key){
													if($item[$key] != '' && trim($item[$key]) != 'N/A'){
														if($key == 'level'){ $th = 'iLvl'; }
														else if($key == 'name'){ $th = 'Name'; }
														else if($key == 'base_item'){ $th = 'Item'; }
														else if($key == 'req_str'){ $th = 'Req. Str'; }
														else if($key == 'req_dex'){ $th = 'Req. Dex'; }
														else if($key == 'req_int'){ $th = 'Req. Int'; }
														else if($key == 'block'){ $th = 'Block'; }
														else if($key == 'ar'){ $th = 'AR'; }
														else if($key == 'ev'){ $th = 'EV'; }
														else if($key == 'es'){ $th = 'ES'; }
														else if($key == 'dps'){ $th = 'DPS'; }
														else if($key == 'physical_damage'){ $th = 'Dmg'; }
														else if($key == 'lightning_damage'){ $th = 'L. Dmg'; }
														else if($key == 'fire_damage'){ $th = 'F. Dmg'; }
														else if($key == 'cold_damage'){ $th = 'C. Dmg'; }
														else if($key == 'crit'){ $th = 'Crit'; }
														else if($key == 'attacks_per_second'){ $th = 'APS'; }
														else if($key == 'mods'){ $th = 'Mods'; }

														echo '<th>'.$th.'</th>';
														
													}

													
												}
		echo('

												</tr>
												<tr class="nest-show">');
													
												$keys = array_keys($item);
												foreach($keys as $key){
													if($item[$key] != '' && trim($item[$key]) != 'N/A'){
														if($key == 'mods'){
															print "<td>";
															foreach(unserialize($item['mods']) as $mod){
																print $mod.'<br />';
															}
															print "</td>";
														}
														else{ echo '<td>'.ucwords($item[$key]).'</td>'; } 
													}
												}
													
		echo('
												</tr>
											</table>
										</td>
									</tr>
								</tr>');

	}

	function print_weapon_mods($item_types){
		echo ('<table style="background-color: #DDD;" name="mods">
						<tbody id="weapon-mods">
							<tr class="normal">
								<td style="padding: 5px 0 5px 10px; background-color: #8FBCDD; margin-left: 0;"><b>Prefix</b></td>
							</tr>');
							
								$item_desc = '';
								foreach($item_types['prefixes'] as $item){
									if($item_desc == $item['description']){ 
										print '<tr class="inner-row"><td><b>iLvl: '.$item['level'].'</b>: '.$item['value'].'<b> ('.$item['name'].')</b></td></tr>';
									}
									else{
										print '<tr class="accordion" name="collapsed"><td> '.$item['description'].'</td></tr>
												<tr class="inner-row"><td><b>iLvl: '.$item['level'].'</b>: '.$item['value'].'<b> ('.$item['name'].')</b></td></tr>';
									}
									$item_desc = $item['description'];
								}
		echo('							
							<tr class="accordion">
								<td style="padding: 5px 0 5px 10px; background-color: #8FBCDD; margin-left: 0;"><b>Suffix</b></td>
							</tr>');

								$item_desc = '';
								foreach($item_types['suffixes'] as $item){
									if($item_desc == $item['description']){ 
										print '<tr class="inner-row"><td><b>iLvl: '.$item['level'].'</b> : '.$item['value'].'<b> ('.$item['name'].')</b></td></tr>';
									}
									else{
										print '<tr class="accordion" name="collapsed"><td>'.$item['description'].'</td></tr><tr class="inner-row">
												<tr class="inner-row"><td> <b>iLvl: '.$item['level'].'</b>: '.$item['value'].'<b> ('.$item['name'].')</b></td></tr>';
									}
									$item_desc = $item['description'];
								}
		echo('
						</tbody>
					</table>');
	}

	
	$conn = mysqli_connect($server, $dbUsername, $dbPassword, $db);
	if (mysqli_connect_errno($con)){ echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

	if(isset($_GET['item_type'])){ $item_type = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['item_type']); }
	if(isset($_GET['query'])){ $query = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['query']); }

	if($query){
		$unique_sql = "SELECT level, name, base_item, req_str, req_dex, req_int, block, ar, ev, es, dps, physical_damage, lightning_damage, fire_damage, cold_damage, crit, attacks_per_second, mods FROM unique_items WHERE name LIKE '%".$query."%'";
		$query_sql = "SELECT level, description, value, name, mod_type, ".$query.", mod_type FROM mods WHERE ". $query ." LIKE '%Yes%'";
	}
	else if($item_type){
		$query_sql = "SELECT level, description, value, name, mod_type, ".$item_type.", mod_type FROM mods WHERE ". $item_type ." LIKE '%Yes%'";
		$unique_sql = "SELECT level, name, base_item, req_str, req_dex, req_int, block, ar, ev, es, dps, physical_damage, lightning_damage, fire_damage, cold_damage, crit, attacks_per_second, mods FROM unique_items WHERE base_type LIKE '%".$item_type."%'";
	}
	
	else{
		$prefix_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE mod_type = 'Prefix'");
		$suffix_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE mod_type = 'Suffix'");
		$implicit_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE mod_type = 'Implicit'");
	}

	

	



?>

<html>
	<head>
		<script type="text/javascript" src="includes/js/jquery.js"></script>
		<link rel="stylesheet" href="includes/css/styles.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

		<script src="includes/js/poemods.js">
			  
		</script>
	</head>
	<body>
		<div id="wrapper">
			<?php 
				include('includes/header.php');
			/*******************************************************
			/ Prep Mods
			/******************************************************/
				if( $query_result = @mysqli_query($conn, $query_sql)){
					$displaying_results = true;
					if(!$item_type){ $item_type = $query; }
					if(is_cat_armor($item_type)){ $armor_types = get_cat_armors($item_type, $query_result); }
					else{ $item_types = get_cat_items($query_result);}

			/*******************************************************
			/ Armor Mods
			/******************************************************/
					if(is_cat_armor($item_type)){ ?>
						<h3 class="blue-header-shadow"><?php print ucfirst($item_type); ?> Types</h3>
						<div id="mod-results">
							<table>
								<tbody id="armor-mods">
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Armor</b></td>
										<?php echo get_row_html($armor_types['prefixes']['ar']); ?>
										<?php echo get_row_html($armor_types['suffixes']['ar']); ?>
										<?php echo get_row_html($armor_types['implicits']['ar']); ?>
									</tr>
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Evasion</b></td>
										<?php echo get_row_html($armor_types['prefixes']['ev']); ?>
										<?php echo get_row_html($armor_types['suffixes']['ev']); ?>
										<?php echo get_row_html($armor_types['implicits']['ev']); ?>
									</tr>
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Energy Shield</b></td>
										<?php echo get_row_html($armor_types['prefixes']['es']); ?>
										<?php echo get_row_html($armor_types['suffixes']['es']); ?>
										<?php echo get_row_html($armor_types['implicits']['es']); ?>

									</tr>
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Armor / Evasion</b></td>
										<?php echo get_row_html($armor_types['prefixes']['ar_ev']); ?>
										<?php echo get_row_html($armor_types['suffixes']['ar_ev']); ?>
										<?php echo get_row_html($armor_types['implicits']['ar_ev']); ?>
									</tr>
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Armor / Energy Shield</b></td>
										<?php echo get_row_html($armor_types['prefixes']['ar_es']); ?>
										<?php echo get_row_html($armor_types['suffixes']['ar_es']); ?>
										<?php echo get_row_html($armor_types['implicits']['ar_es']); ?>
									</tr>
									<tr class="accordion" name="collapsed">
										<td colspan="2" class="level1"><b>Evasion / Energy Shield</b></td>
										<?php echo get_row_html($armor_types['prefixes']['ev_es']); ?>
										<?php echo get_row_html($armor_types['suffixes']['ev_es']); ?>
										<?php echo get_row_html($armor_types['implicits']['ev_es']); ?>
									</tr>
								</tbody>
							</table>
						</div>
						

			<?php 
				}
			/*******************************************************
			/ WEAPON MODS
			/******************************************************/
				else { ?>
					<div id="mod-results">
						<h3 class="blue-header-shadow"><?php print(ucfirst(get_item_type_label($item_type))); ?> Mods</h3>
						<?php print_weapon_mods($item_types); ?>
					</div>
			<?php } 
			}
			/*******************************************************
			/ UNIQUES
			/******************************************************/
			/**
			if($unique_result = @mysqli_query($conn, $unique_sql)){
				if($unique_result->num_rows > 0){
					$displaying_results = true; 
			?>
					<div id="unique-results" style="clear: both;">
						<h3 class="unique-header">Uniques</h3>
						<table>
							<tbody id="uniques">
								<?php while($item = mysqli_fetch_assoc($unique_result)) {
									print_inner_unique_table($item);
								 } ?>
							</tbody>
						</table>
					</div>

		  <?php }
			**/
			
			/*******************************************************
			/ GREETING
			/******************************************************/
			if(!$displaying_results){
				print ('<center><div id="greeting">
							<h1>Click on an item type above!</h1>
							<!--
							<form id="greeting-search" action="index.php" method="get">
								<input class="searchbox" type="text" name="query" id="query" />
								<input style="padding: 5px;" type="submit" value="Search" />
							</form>
							<small>Search for <a class="unique-link" href="uniques.php">uniques</a> or items types. eg: \'kaoms heart\'</small>
							-->
						</div></center>');
			}
		?>
		</div>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-40247017-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
	</body>
</html>

<?php mysqli_close($conn); ?>
