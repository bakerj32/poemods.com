<?php
	
	function print_inner_unique_table($item){
		echo ('<table class="inner-table">
												<tr class="normal">');

												$keys = array_keys($item);
												foreach($keys as $key){
													if($item[$key] != '' && trim($item[$key]) != 'N/A' && $key != 'name' && $key != 'base_type' ){
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
													if($item[$key] != '' && trim($item[$key]) != 'N/A' && $key != 'name' && $key != 'base_type'){
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
											</table>');
	}

	function get_unique_items($conn, $sql){
		$accessories = array('amulet' => array(), 'belt' => array(), 'ring' => array(), 'quiver'=> array(), 'map' => array());
		$weapons = array('two-handed axe' => array(), 'bow' => array(), 'claw' => array(), 'dagger' => array(), 'one-handed mace' => array(), 'two-handed mace' => array(), 'one-handed sword' => array(), 'staff' => array(), 'wand' => array());
		$armor = array('chest' => array(), 'boots' => array(),'gloves' => array(), 'helmets' => array(), 'shield' => array());

		if ($unique_result = mysqli_query($conn, $sql)){
			while($item = mysqli_fetch_assoc($unique_result)){
				// Accessories
				if($item['base_type'] == 'amulet'){ array_push($accessories['amulet'], $item); }
				else if($item['base_type'] == 'belt'){ array_push($accessories['belt'], $item); }
				else if($item['base_type'] == 'ring'){ array_push($accessories['ring'], $item); }
				else if($item['base_type'] == 'quiver'){ array_push($accessories['quiver'], $item); }
				else if($item['base_type'] == 'map'){ array_push($accessories['map'], $item); }
				//Armor
				else if($item['base_type'] == 'chest'){ array_push($armor['chest'], $item); }
				else if($item['base_type'] == 'boots'){ array_push($armor['boots'], $item); }
				else if($item['base_type'] == 'gloves'){ array_push($armor['gloves'], $item); }
				else if($item['base_type'] == 'shield'){ array_push($armor['shield'], $item); }
				else if($item['base_type'] == 'helmet'){ array_push($armor['helmet'], $item); }
				//Weapons
				else if($item['base_type'] == 'two-handed axe'){ array_push($weapons['two-handed axe'], $item); }
				else if($item['base_type'] == 'bow'){ array_push($weapons['bow'], $item); }
				else if($item['base_type'] == 'claw'){ array_push($weapons['claw'], $item); }
				else if($item['base_type'] == 'dagger'){ array_push($weapons['dagger'], $item); }
				else if($item['base_type'] == 'one-handed mace'){ array_push($weapons['one-handed mace'], $item); }
				else if($item['base_type'] == 'two-handed mace'){ array_push($weapons['two-handed mace'], $item); }
				else if($item['base_type'] == 'one-handed sword'){ array_push($weapons['one-handed sword'], $item); }
				else if($item['base_type'] == 'staff'){ array_push($weapons['staff'], $item); }
				else if($item['base_type'] == 'wand'){ array_push($weapons['wand'], $item); }	
			}
		}
		$unique_items = array('weapons' => $weapons, 'armor' => $armor, 'accessories' => $accessories);
		return $unique_items;
	}

	function print_unique_table($items, $conn, $cat_sql){
		$cat_result = mysqli_query($conn, $cat_sql);
		echo ('<table id="unique-'.$items[0]['category'].'">
					<tbody id="uniques">');
					while($cat = mysqli_fetch_assoc($cat_result)){
						echo('<tr class="accordion level1" name="collapsed">
								<td>'.$cat['name'].'</td>');
								foreach($items[$cat['name']] as $item){
									echo ('<tr class="nest-accordion yellow" name="collapsed"><td>'.$item['name'].'</td>
									<td class="nest inner" style="cursor: pointer;">');
									print_inner_unique_table($item);
									echo ('</td></tr>');
								}
						echo '</tr>';
					}
		echo '</table>';
	}

	include('includes/preferences.php');
	$conn = mysqli_connect($server, $dbUsername, $dbPassword, $db);
	if (mysqli_connect_errno($con)){ echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

	if(isset($_GET['item_type'])){ $item_type = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['item_type']); }
	if(isset($_GET['item_name'])){ $item_name = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['item_name']); }

	$accessory_type_sql = "SELECT distinct(base_type) as name FROM unique_items WHERE category = 'accessory'";
	$armor_type_sql = "SELECT distinct(base_type) as name FROM unique_items WHERE category = 'armor'";
	$weapon_type_sql = "SELECT distinct(base_type) as name FROM unique_items WHERE category = 'weapon'";
	$all_item_sql = "SELECT base_type, level, name, base_item, req_str, req_dex, req_int, block, ar, ev, es, dps, physical_damage, lightning_damage, fire_damage, cold_damage, crit, attacks_per_second, mods FROM unique_items";

	$items = get_unique_items($conn, $all_item_sql);
	
?>

<html>
	<head>
		<script type="text/javascript" src="includes/js/jquery.js"></script>
		<link rel="stylesheet" href="includes/css/styles.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

		<script src="includes/js/poemods.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<?php include('includes/header.php'); ?>
			<div id="uniques">
				<div id="unique-weapons">
					<h3 class="unique-header">Unique Weapons</h3>
					<?php print_unique_table($items['weapons'], $conn, $weapon_type_sql); ?>
				</div>

				<div id="unique-armor">
					<h3 class="unique-header">Unique Armor</h3>
					<?php print_unique_table($items['armor'], $conn, $armor_type_sql); ?>
				</div>

				<div id="unique-accessories">
					<h3 class="unique-header">Unique Accessories</h3>
					<?php print_unique_table($items['accessories'], $conn, $accessory_type_sql); ?>
				</div>
			</div>
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