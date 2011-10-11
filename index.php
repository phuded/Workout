<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<script>
			$(document).ready(function() {
			  // Handler for .ready() called.
			});
			
			$.showChildTable = function(id, tableId, orderby, dir){
				$('#'+tableId+' .tableHolder').html('<img class="spinner" src="images/loading.gif"/>');
				$.ajax({
					type: "GET",
					url: "show"+tableId+".php",
					data: "id="+id+(orderby?"&orderby="+orderby+"&dir="+dir:""),
					success: function(msg){							
						$('#'+tableId+' .tableHolder').html($.trim(msg));
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						// Error!
					}
				});
			};
			
		</script>
		<?php
			//Connect To Database
			include 'config.php';
			date_default_timezone_set('GMT');
		?>
		
	</head>
<body>
	<div class="container">
		<div class="header">
			<div class="innerHeader">
				<div class="logo">
					<h1>Workout Planner</h1>
				</div>
				<div class="menuPanel">
					<ul id="menu" class="menu">
						<li class="menu-item">
							<a href="." class="selected">upcoming</a>
						</li>
						<li class="menu-item">
							<a href="#">add workout</a>
						</li>
						<li class="menu-item">
							<a href="exercises.php">exercises</a>
						</li>
					</ul>
				</div>
			</div>	
		</div>
		<div class="content">
			<div class="page-content">
				<div class="left-content half-height">
					<h2>Workouts</h2>
					<div class="tableHolder">
						<?php
						
							$sql = 'select * from workout';
							
							//Default
							$defaultDir = 'asc';
							$dtDir = $defaultDir;
							$lDir = $defaultDir;
							$dDir = $defaultDir;
													
							if(isset($_GET[orderby])){						
								//Flip direction for link
								if($_GET[dir] == 'asc'){
									$direction = 'desc';
								}
								else{
									$direction = 'asc';
								}					
								
								switch ($_GET[orderby]) {
									case 'date':
										$dtDir = $direction;
										break;
									case 'location':
										$lDir = $direction;
										break;
									case 'duration':
										$dDir = $direction;
										break;
								}
														
								$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
							};
							
							$sql .= ' limit 5';	
							
							$result = mysql_query($sql);

							echo '<table class="weights">'
								 . '<tr>'
									. '<th><a href="?orderby=date&dir='.$dtDir.'">Date</a></th>'
									. '<th><a href="?orderby=location&dir='.$lDir.'">Location</a></th>'
									. '<th><a href="?orderby=duration&dir='.$dDir.'">Duration</a></th>'
									. '<th></th>'
								 . '</tr>';

							if($result) {
								while($row = mysql_fetch_array($result)){
									$date = new DateTime($row['date']);
									echo '<tr>'
										. '<td>' . $date->format('d-m-Y H:i:s') . '</td>'
										. '<td>' . $row['location'] . '</td>'
										. '<td>' . $row['duration'] . ' mins </td>'
										. '<td><a href="javascript:$.showChildTable('.$row['id'].',&quot;WorkoutExercises&quot;)">View</a></td>'
										. '</tr>';
								}
							}

							echo '</table>';
						?>
					</div>
				</div>
				<div id="WorkoutExercises" class="right-content half-height">
					<h2>Exercises</h2>
					<div class="tableHolder">
						<p>Please click 'View' to load.</p>
					</div>
				</div>
				<div class="clear"></div>
				<div class="separator"></div>
				<div id="WeightsSet">
					<h2>Sets</h2>	
					<div class="tableHolder">
						<p>Please click 'View Set' to load.</p>
					</div>
				</div>
			</div>				
		</div>
		<div class="footerGap"></div>
	</div>
	<div class="footer">
		<div class="footerTop">
		</div> 
		<br/>
		<p>&copy; Workout Planner</p>
	</div>
	
</body>
</html>
