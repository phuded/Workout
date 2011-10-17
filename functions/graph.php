<?php
	//Connect To Database
	include "config.php";

	$id = $_GET[id];
	
	$sql = "select * from weights_set where workout_exercise_id = $id order by rank asc";
	$result = mysql_query($sql);
	
	if($result) {
		while($row = mysql_fetch_array($result)){
			if($row[type]=='Planned'){
				$plannedRes[] = array(intval($row[rank]),intval($row[weight]));
			}
			else{
				$actualRes[] = array(intval($row[rank]),intval($row[weight]));
			}
		}
	}

	$output[] = $plannedRes;
	if(isset($actualRes)){
		$output[] = $actualRes;
	}

	echo json_encode($output);
?>
