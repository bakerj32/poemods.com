<?php
	include('includes/preferences.php');
	$conn = mysqli_connect($server, $dbUsername, $dbPassword, $db);

	// Check connection
	if (mysqli_connect_errno($con)){ echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
	if(isset($_GET['item_type'])){ $item_type = trim($_GET['item_type'], FILTER_SANITIZE_SPECIAL_CHARS); }
	
	$prefix_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE ". $item_type ." = 'Yes' AND mod_type = 'Prefix'");
	$suffix_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE ". $item_type ." = 'Yes' AND mod_type = 'Suffix'");
	$implicit_result = mysqli_query($conn, "SELECT level, description, value, name mods FROM mods WHERE ". $item_type ." = 'Yes' AND mod_type = 'Implicit'");



	mysqli_close($conn);
?>

<html>
	<head>
		<script type="text/javascript" src="includes/js/jquery.js"></script>
		<link rel="stylesheet" href="includes/css/styles.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
 		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>

		<script>
			  $(function() {
				  $("tr:not(.accordion)").hide();
				  $("tr:first-child").show();
				  $("tr.accordion").click(function(){
				  	$(this).nextUntil(".accordion", "tr").toggle();
				  	if($(this).css('background-color')=="rgb(221, 221, 221)"){
				  		$(this).css('background-color', '#FFFF99');
				  	}
				  	else{
				  		$(this).css('background-color', '#FFFFFF');
				  	}
				    });$
				  });
					  </script>
	</head>
	<body>
		<div id="wrapper">
			<div id="search">
				<form action="results.php" method="GET">
					<input class="searchbox" type="text" name="item_type" type="item_type" />
					<input style="padding: 5px;" type="submit" name="submit" value="Search" />
				</form>
				<div style="top-links">
					<p>Weapons: 
						<a href="/results.php?item_type=sword">Swordddddddddddddddddddddddd</a> - 
						<a href="/results.php?item_type=dagger">Dagger</a> - 
						<a href="/results.php?item_type=bow">Bow</a> - 
						<a href="/results.php?item_type=mace">Mace</a> - 
						<a href="/results.php?item_type=wand">Wand</a> - 
						<a href="/results.php?item_type=scepter">Scepter</a> - 
						<a href="/results.php?item_type=claw">Claw</a> -
						<a href="/results.php?item_type=staff">Staff</a> -
						<a href="/results.php?item_type=axe">Axe</a>
					</p>
					<p>Armor: 
						<a href="/results.php?item_type=ring">Ring</a> - 
						<a href="/results.php?item_type=amulet">Amulet</a> - 
						<a href="/results.php?item_type=gloves">Gloves</a> - 
						<a href="/results.php?item_type=boots">Boots</a> - 
						<a href="/results.php?item_type=helmet">Helm</a> - 
						<a href="/results.php?item_type=chest">Chest</a> - 
						<a href="/results.php?item_type=shield">Shield</a> - 
						<a href="/results.php?item_type=belt">Belt</a> -
						<a href="/results.php?item_type=quiver">Quiver</a>
					</p>

				</div>
				<h3>You searched for "<?php echo $item_type ?>"</h3>
			</div>
			<?php if($prefix_result->num_rows) { ?>
				<div id="prefixes" style="float: left;">
					<h4>Prefixes</h4>
					<table>
						<tr>
							<th>Level</th>
							<th>Description</th>
							<th>Value</th>
							<th>Name</th>
						</tr>
						<?php 
							$row_desc = '';
							while($row = mysqli_fetch_assoc($prefix_result)){ 
								if($row_desc == $row['description']) { print '<tr class="nest">'; }
								else{ print '<tr class="accordion">';} ?>
								<td><?php echo $row['level']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['value']; ?></td>
								<td><?php echo $row['name']; ?></td>
							</tr>
						<?php $row_desc = $row['description']; ?>
						<?php } ?>
					</table>
				</div>
			<?php } ?>
			<?php if($suffix_result->num_rows) { ?>
				<div id="suffixes">
					<h4>Suffixes</h4>
					<table>
						<tr>
							<th>Level</th>
							<th>Description</th>
							<th>Value</th>
							<th>Name</th>
						</tr>
						<?php 
							$row_desc = '';
							while($row = mysqli_fetch_assoc($suffix_result)){ 
								if($row_desc == $row['description']) { print '<tr class="nest">'; }
								else{ print '<tr class="accordion">';} ?>
								<td><?php echo $row['level']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['value']; ?></td>
								<td><?php echo $row['name']; ?></td>
							</tr>
						<?php $row_desc = $row['description']; ?>
						<?php } ?>
					</table>
				</div>
			<?php } ?>
			<?php if($implicit_result->num_rows) { ?>
				<div id="implicit">
					<h4>Implicit</h4>
					<table>
						<tr>
							<th>Level</th>
							<th>Description</th>
							<th>Value</th>
							<th>Name</th>
						</tr>
						<?php 
							$row_desc = '';
							while($row = mysqli_fetch_assoc($implicit_result)){ 
								if($row_desc == $row['description']) { print '<tr class="nest">'; }
								else{ print '<tr class="accordion">';} ?>
								<td><?php echo $row['level']; ?></td>
								<td><?php echo $row['description']; ?></td>
								<td><?php echo $row['value']; ?></td>
								<td><?php echo $row['name']; ?></td>
							</tr>
						<?php $row_desc = $row['description']; ?>
						<?php } ?>
					</table>
				</div>
			<?php } ?>
			<!--
				<div id="implicit">
					<h4>Implicit</h4>
					<table>
						<tr>
							<th>Level</th>
							<th>Description</th>
							<th>Value</th>
							<th>Name</th>
						</tr>

						% for item in results['implicits']:
							% if  (results['implicits'][results['implicits'].index(item)-1][0] == item[0]):
								<tr class="nest">
							% else:
								<tr class="accordion">
							% endif
								<td>${item[3]}</td>
								<td>${item[0]}</td>
								<td>${item[1]}</td>
								<td>${item[2]}</td>
							</tr>
						% endfor
					</table>
				</div>
			% endif
		-->
		</div>
	</body>
</html>