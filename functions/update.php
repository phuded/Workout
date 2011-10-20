
<?php
	include "config.php";
	
	switch($_REQUEST["object"]){
		case "workout":
			updateWorkout ($_REQUEST[id],$_REQUEST[location],$_REQUEST[dateTime],$_REQUEST[duration]); 
			break;
	}
	
	function updateWorkout ($id,$location,$dateTime,$duration) {
		//existing
		if(!empty($id)){
			$sql = "update workout set ".
					"location = '$location',".
					"date = '$dateTime',".
					"duration = $duration".
					" where id = $id";
					
			$result = mysql_query($sql);
			$res = array ("success"=>$result);
		}
		else{
			$sql = "insert into workout (location,date,duration)".
				   " values ('$location','$dateTime',$duration)";
					
			$result = mysql_query($sql);
			$res = array ("success"=>$result);
		}
		
		echo json_encode($res);
	}
?>