<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
				
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Workout Planner</title>
		<script>
		
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
					<span>Workout Planner</span>
				</div>
				<div class="menuPanel">
					<ul id="menu" class="menu">
						<li class="menu-item">
							<a href=".">Upcoming workouts</a>
						</li>
						<li class="menu-item">
							<a href="exercises.php" class="selected">exercises</a>
						</li>
						<li class="menu-item">
							<a href="#">schedule</a>
						</li>
					</ul>
				</div>
			</div>	
		</div>
		<div class="content">
			<div class="page-content">
				<div class="left-content">
				<h2>Exercises</h2>
				<?php
					$sql = 'select * from exercise';
					
					//Default
					$defaultDir = 'asc';
					$nDir = $defaultDir;
					$tDir = $defaultDir;
											
					if(isset($_GET[orderby])){						
						//Flip direction for link
						if($_GET[dir] == 'asc'){
							$direction = 'desc';
						}
						else{
							$direction = 'asc';
						}
						
						if($_GET[orderby] == 'name'){
							$nDir = $direction;
						}
						else{
							$tDir = $direction;
						}
						
						$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
					};								
									
					$result = mysql_query($sql);

					echo '<table class="weights">'.
						 '<tr>'.
							'<th><a href="?orderby=name&dir='.$nDir.'">Name</a></th>'.
							'<th><a href="?orderby=type&dir='.$tDir.'">Muscle Group</a></th>'.
						 '</tr>';

					if($result) {
						while($row = mysql_fetch_array($result)){
							echo '<tr>'
								. '<td>' . $row['name'] . '</td>'
								. '<td>' . $row['type'] . '</td>'
								. '</tr>';
						}
					}

					echo '</table>';

				?>
				</div>
				<div class="right-content">
					<h2>Add new</h2>
					<div class="form">
						<form action="addExercise.php" method="post">
							Name: <input type="text" name="name" />
							Type: <select type="text" name="type">
										<option value="Biceps">Biceps</option>
										<option value="Triceps">Triceps</option>
										<option value="Deltoids">Deltoids</option>
										<option value="Shoulders">Shoulders</option>
										<option value="Chest">Chest</option>
										<option value="Abs">Abs</option>
										<option value="Back">Back</option>
										<option value="Legs">Legs</option>
									</select>
							<input type="submit"/>
						</form>
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
