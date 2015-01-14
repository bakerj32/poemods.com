<?php
	function get_input_name($input_img){
		return '[[File: '.$input_img->attr['alt'].']] ';
	}

	function format_name($name){
		foreach($name->find('img') as $img){
			return '[[File: '.$img->attr['alt'].']]';
		}
	}
	$strip_tags = array('<p>', '</p>', '<br />', '<div>', '</div>', '<b>', '</b>');
	$url = $_GET['url'];

	include('includes/simple_html_dom.php');
	$html = file_get_html($url);

	echo ('<form action="scrapeijw.php">
		      <input type="text" name="url" id="url" />
		      <input type="submit" value="Submit" />
		   </form><br /><br />');

	$table_count = 0;
	foreach($html->find('table') as $table){
		if($table_count == 1){
			print "=== Basic Attacks ===<br />";
			$type = 'move'; 
		}
		else if($table_count == 3){
			print '&lt;div style="clear: both;"&gt;&lt;/div&gt;<br />=== Specials ===<br />';
			$type = 'special'; 
		}
		else if($table_count == 4){
			print '&lt;div style="clear: both;"&gt;&lt;/div&gt;<br />=== Character Power ===<br />';
			$type = 'character_power'; 
		}

		else if($table_count == 5){
			print '&lt;div style="clear: both;"&gt;&lt;/div&gt;<br />=== Super ===<br />';
			$type = 'super'; 
		}

		else if($table_count == 6){
			print '&lt;div style="clear: both;"&gt;&lt;/div&gt;<br />=== Combo Attacks ===<br />';
			$type = 'combo'; 
		}
		foreach($table->find('tr') as $row){
			$count = 0;
			$inputs = '';

			foreach($row->find('td') as $col){
				if($count == 0){ 
					format_name($col);
					$name = str_replace($strip_tags, '', $col->innertext);
					$name = preg_replace('/\<img .*? \/\>/', '', $name);
					$name .= format_name($col);
				}
				else if($count == 1){
					foreach($col->find('img') as $img){ $inputs .= get_input_name($img); }
				}
				else if($count == 2){ $damage = str_replace($strip_tags, '', $col->innertext); }
				else if($count == 3){ $hit_level = str_replace($strip_tags, '', $col->innertext); }
				else if($count == 4){ $startup = str_replace($strip_tags, '', $col->innertext); }
				else if($count == 5){ $recovery = str_replace($strip_tags, '', $col->innertext); }
				else if($count == 6){ $hit_advantage = str_replace($strip_tags, '', $col->innertext); }
				else if($count == 7){ $block_advantage = str_replace($strip_tags, '', $col->innertext); }
				$count++;
			}
			if($name != $last_name){
				echo('{{'.$type.'|
						name='.$name.'<br />|
						input='.$inputs.'<br />|
						damage='.$damage.'<br />|
						hit_level='.$hit_level.'<br />|
						startup='.$startup.'<br />|
						recovery='.$recovery.'<br />|
						hit_advantage='.$hit_advantage.'<br />|
						block_advantage='.$block_advantage.'}}');
				print '<br /><br />';
			}
			$last_name = $name;
		}
		$table_count++;
	}
?>