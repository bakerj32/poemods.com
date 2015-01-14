<?php 

	function get_input_name($input_img){
		preg_match('/src=\".*?\/moves\/(.*?)\.png/', $input_img, $file_name);
		return $file_name[1];
	}

	$url = $_GET['url'];

	include('includes/simple_html_dom.php');
	$html = file_get_html($url);

	echo ('<form action="scrape_ijw.php">
		      <input type="text" name="url" id="url" />
		      <input type="submit" value="Submit" />
		   </form><br /><br />');

	foreach($html->find('div') as $move){
		if($move->class == 'guide_title'){
			echo ('==='.$move->innertext.'===<br />');
			if(trim($move->innertext) == 'Basic Attacks'){ $move_type = 'move'; }
			if(trim($move->innertext) == 'Combo Attacks'){ $move_type = 'combo'; }
			if(trim($move->innertext) == 'Special Moves'){ $move_type = 'special'; }
			if(trim($move->innertext) == 'Super Move'){ $move_type = 'super'; }
			if(trim($move->innertext) == 'Character Power'){ $move_type = 'character_power'; }
		}
		if($move->class == 'move_name'){
			$inputs = array();
			if($move_type == 'move'){
				$move_table = '';
				foreach($move->find('img') as $input_img){
					array_push($inputs, get_input_name($input_img));
				}

				preg_match('/\<br.?\/>(.*?)\<\/div\>/', $move, $name);
				$name = $name[1];
				
				$move_table .= '{{move|name='.$name.'<br />|input=';
				foreach($inputs as $input){
					$move_table .= '[[File: '.$input.'.png]] ';
				}
				$move_table .= '<br />|hit_level=<br />|damage=2%<br />|startup=<br />|recovery=<br />|hit_advantage=<br />|block_advantage=<br />|special_cancelable=[[File:check.png]]<br />|explanation=Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum }}<br />';

				echo $move_table.'<br />';
			}
			else if ($move_type == 'combo'){
				$move_table = '';
				foreach($move->find('img') as $input_img){
					array_push($inputs, get_input_name($input_img));
				}

				preg_match('/\<br.?\/>(.*?)\<\/div\>/', $move, $name);
				$name = $name[1];
				
				$move_table .= '{{combo|name='.$name.'<br />|input=';
				foreach($inputs as $input){
					$move_table .= '[[File: '.$input.'.png]] ';
				}
				$move_table .= '<br />|hit_level=<br />|damage=2%<br />|startup=<br />|recovery=<br />|hit_advantage=<br />|block_advantage=<br />|special_cancelable=[[File:check.png]]<br />|explanation=Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum }}<br />';

				echo $move_table.'<br />';
			}

			else if ($move_type == 'special'){
				$move_table = '';
				foreach($move->find('img') as $input_img){
					array_push($inputs, get_input_name($input_img));
				}

				preg_match('/\<br.?\/>(.*?)\<\/div\>/', $move, $name);
				$name = $name[1];
				
				$move_table .= '{{special|name='.$name.'<br />|input=';
				foreach($inputs as $input){
					$move_table .= '[[File: '.$input.'.png]] ';
				}
				$move_table .= '<br />|hit_level=<br />|damage=2%<br />|startup=<br />|recovery=<br />|hit_advantage=<br />|block_advantage=<br />|explanation=Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum }}<br />';

				echo $move_table.'<br />';
			}

			else if ($move_type == 'super'){
				$move_table = '';
				foreach($move->find('img') as $input_img){
					array_push($inputs, get_input_name($input_img));
				}

				preg_match('/\<br.?\/>(.*?)\<\/div\>/', $move, $name);
				$name = $name[1];
				
				$move_table .= '{{super|name='.$name.'<br />|input=';
				foreach($inputs as $input){
					$move_table .= '[[File: '.$input.'.png]] ';
				}
				$move_table .= '<br />|hit_level=<br />|damage=2%<br />|startup=<br />|recovery=<br />|hit_advantage=<br />|block_advantage=<br />|explanation=Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum }}<br />';

				echo $move_table.'<br />';
			}

			else if ($move_type == 'character_power'){
				$move_table = '';
				foreach($move->find('img') as $input_img){
					array_push($inputs, get_input_name($input_img));
				}

				preg_match('/\<br.?\/>(.*?)\<\/div\>/', $move, $name);
				$name = $name[1];
				
				$move_table .= '{{character power|name='.$name.'<br />|input=';
				foreach($inputs as $input){
					$move_table .= '[[File: '.$input.'.png]] ';
				}
				$move_table .= '<br />|hit_level=<br />|damage=2%<br />|startup=<br />|recovery=<br />|hit_advantage=<br />|block_advantage=<br />|special_cancelable=[[File:check.png]]<br />|explanation=Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum }}<br />';

				echo $move_table.'<br />';
			}
		}

	}
?>