<?php
	include('includes/simple_html_dom.php');

	$html = file_get_html('http://www.pathofexile.com/item-data/armour');

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
	$item_count = 0;
	$last_good_count = 0;
	foreach($html->find('div[class=layoutBox1 layoutBoxFull defaultTheme]') as $table) {
		$item_type = $table->find('h1');
		
		foreach($table->find('tr') as $row){
			$count = 0;
			foreach($row->find('td') as $col){

				if($col->innertext != ''){
					if($row->class=='even_mod' || $row->class=='odd_mod'){
						if ($col->colspan==4){ $items[$last_good_count]['implicit_label'] = str_replace('<br />', '', strtolower($col->innertext)); }
						else{ $items[$last_good_count]['implicit_value'] = str_replace('<br />', '', $col->innertext); }
					}
					else{
						if($count == 0){ $image = $col->find('img')->src; }
						else if ($count == 1) { $name = strtolower($col->innertext); }
						else if ($count == 2) { $level = $col->innertext; }
						else if ($count == 3) { $damage = $col->innertext; }
						else if ($count == 4) { $attacks_per_second = $col->innertext; }
						else if ($count == 5) { $dps = $col->innertext; }
						else if ($count == 6) { $req_str = $col->innertext; }
						else if ($count == 7) { $req_dex = $col->innertext; }
						else if ($count == 8) { 
							$req_int = $col->innertext;
							$item_count -= 8;
							$last_good_count = $item_count + 1;
						}
						$count++;
						$item_count++;
					}
				}
				else{ break; }
			}
			
			//print $name.', '.$image.', '.$level.', '.$damage.', '.$attacks_per_second.', '.$dps.', '.$req_str.', '.$req_dex.', '.$req_int;
			//print '<br />';
			$items[$item_count]['type'] = strtolower($item_type[0]->innertext);
			$items[$item_count]['name'] = str_replace('<br >', '', $name);
			$items[$item_count]['image'] = $image;
			$items[$item_count]['level'] = $level;
			$items[$item_count]['damage'] = $damage;
			$items[$item_count]['attacks_per_second'] = $attacks_per_second;
			$items[$item_count]['dps'] = $dps;
			$items[$item_count]['req_str'] = $req_str;
			$items[$item_count]['req_dex'] = $req_dex;
			$items[$item_count]['req_int'] = $req_int;
			
		}
	}
	$count = 268;
	foreach ($items as $item){
		print $count.','.$item['name'].','.$item['type'].','.$item['level'].','.$item['damage'].','.$item['attacks_per_second'].','.$item['dps'].','.$item['req_str'].','.$item['req_dex'].','.$item['req_int'].','.$item['implicit_label'].','.$item['implicit_value'].',';
		print '<br >';
		$count++;
	}
?>