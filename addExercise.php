	<META HTTP-EQUIV="refresh" content="0;URL=exercises">
	<?php 
		//Connect To Database
		include 'config.php';
		date_default_timezone_set('GMT');
	
		$sql = "insert into exercise (name,type) values('".$_POST[name]."','".$_POST[type]."')";
		$result = mysql_query($sql);
	?>
