<a href="index.php"><img src="includes/images/logo.png" /></a>
<div id="top-bar">
				<!--
				<div id="search">
					<form action="index.php" method="GET">
						<input class="searchbox" type="text" name="query" id="query" />
						<input style="padding: 5px;" type="submit" value="Search" />
					</form>
					<p style="font-size: 10pt;">Search for <a class="unique-link" href="uniques.php">uniques</a>. eg: 'kaoms heart'</p>
				</div>
				-->
				<div id="item-types">
					<table>
						<tr class="normal">
							<td><b>Weapons</td>
							<td><a href="/index.php?item_type=dagger">Dagger</a></td>
							<td><a href="/index.php?item_type=bow">Bow</a></td>
							<td><a href="/index.php?item_type=wand">Wand</a></td>
							<td><a href="/index.php?item_type=scepter">Scepter</a></td>
							<td><a href="/index.php?item_type=claw">Claw</a></td>
							<td><a href="/index.php?item_type=staff">Staff</a></td>
							<td><a href="/index.php?item_type=1h_sword_axe">1h Sword/Axe</a></td>
							<td><a href="/index.php?item_type=2h_sword_axe">2h Sword/Axe</a></td>
							<td><a href="/index.php?item_type=1h_mace">1h Mace</a></td>
							<td><a href="/index.php?item_type=2h_mace">2h Mace</a></td>
							
						</tr>
						<tr class="normal">
							<td><b>Armor</b></td>
							<td><a href="/index.php?item_type=ring">Ring</a></td>
							<td><a href="/index.php?item_type=amulet">Amulet</a></td>
							<td><a href="/index.php?item_type=gloves">Gloves</a></td>
							<td><a href="/index.php?item_type=boots">Boots</a></td>
							<td><a href="/index.php?item_type=helmet">Helm</a></td>
							<td><a href="/index.php?item_type=chest">Chest</a></td>
							<td><a href="/index.php?item_type=shield">Shield</a></td>
							<td><a href="/index.php?item_type=belt">Belt</a></td>
							<td><a href="/index.php?item_type=quiver">Quiver</a></td>
						</tr>
					</table>
				</div>
				<br />
				<div id="show-query">
					<?php if($item_type){ echo '<h3>Showing results for: <span class="blue">'.get_item_type_label($item_type).'</span></h3>'; } ?>
				</div>

			</div>