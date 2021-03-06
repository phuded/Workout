
<?php
	include "config.php";
	
	switch($_REQUEST["action"]){
		case "updateworkout":
			updateWorkout ($_REQUEST[id],$_REQUEST[location],$_REQUEST[dateTime],$_REQUEST[duration],$_REQUEST[username]); 
			break;
		case "delworkout":
			delWorkout ($_REQUEST[id]); 
			break;
		case "addexercise":
			addExercise ($_REQUEST[exerciseId],$_REQUEST[workoutId],$_REQUEST[rank]); 
			break;
		case "delexercise":
			delExercise ($_REQUEST[workoutExerciseId],$_REQUEST[workoutId],$_REQUEST[rank],$_REQUEST[total]); 
			break;
		case "moveexercise":
			moveExercise ($_REQUEST[workoutExerciseId],$_REQUEST[workoutId],$_REQUEST[rank],$_REQUEST[change]); 
			break;
		case "addset":
			addSet($_REQUEST[reps],$_REQUEST[weight],$_REQUEST[type],$_REQUEST[workoutExerciseId],$_REQUEST[rank],$_REQUEST[total]); 
			break;
		case "delset":
			delSet($_REQUEST[setId],$_REQUEST[workoutExerciseId],$_REQUEST[type],$_REQUEST[rank],$_REQUEST[total]); 
			break;
	}
	
	function updateWorkout ($id,$location,$dateTime,$duration,$user) {
		//existing
		if(!empty($id)){
			$sql = "update workout set ".
					"location = '$location',".
					"date = '$dateTime',".
					"duration = $duration, ".
					"user_id = (select id from user where username ='$user')".
					" where id = $id";
					
			$result = mysql_query($sql);
			$res = array ("success"=>$result);
		}
		else{
			$sql = "insert into workout (location,date,duration,user_id)".
				   " values ('$location','$dateTime',$duration,(select id from user where username='$user'))";
			
			$result = mysql_query($sql);
			$res = array ("success"=>$result);
		}
		
		echo json_encode($res);	
	}
	
	function delWorkout ($id) {
		
		$sql = "select id from workout_exercise where workout_id = $id";	
		$result = mysql_query($sql);
		
		if($result){
		
			while($row = mysql_fetch_array($result)){
				$weId = $row[id];
				
				$sql = "delete from weights_set where " .
				   "workout_exercise_id = $weId";
				mysql_query($sql);

				$sql = "delete from workout_exercise where id = $weId";
				mysql_query($sql);		
			}
			
			$sql = "delete from workout where id = $id";	
			$result = mysql_query($sql);
		
		}

		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}
	
	function addExercise ($exerciseId,$workoutId,$rank) {
		$sql = "insert into workout_exercise (rank,workout_id,exercise_id)".
				   " values ($rank,$workoutId,$exerciseId)";

		$result = mysql_query($sql);
		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}
	
	function delExercise ($workoutExerciseId,$workoutId,$rank,$total) {
	
		$sql = "delete from weights_set where " .
			   "workout_exercise_id = $workoutExerciseId";
		mysql_query($sql);
		
		$sql = "delete from workout_exercise where " .
			   "id = $workoutExerciseId";
		$result = mysql_query($sql);
		
		if($result){
			for ($it = $rank;$it<$total;$it++){	
				$nxRank = $it+1;
				$sqlUpdate = "update workout_exercise set ".
					"rank = $it".
					" where workout_id = $workoutId".
					" and rank = $nxRank";
				mysql_query($sqlUpdate);	
			}	
		}
		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}
	
	function moveExercise ($workoutExerciseId,$workoutId,$rank,$change){
			
		$nxRank = $rank+$change;
	
		$sqlUpdate = "update workout_exercise set rank = $rank where workout_id = $workoutId and rank = $nxRank";
		mysql_query($sqlUpdate);
		
		$sqlUpdate = "update workout_exercise set rank = $nxRank where id = $workoutExerciseId";
		$result = mysql_query($sqlUpdate);	

		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}

	function addSet ($reps,$weight,$type,$workoutExerciseId,$rank,$total) {
		
		for ($it = $total;$it>=$rank;$it--){	
			$nxRank = $it+1;
			$sqlUpdate = "update weights_set set ".
						"rank = $nxRank".
						" where workout_exercise_id = $workoutExerciseId".
						" and type = '$type'".
						" and rank = $it";
			mysql_query($sqlUpdate);	
		}	
		
		$sql = "insert into weights_set (rank,workout_exercise_id,type,reps,weight)" .
			   " values ($rank,$workoutExerciseId,'$type',$reps,$weight)";
			   
		$result = mysql_query($sql);
		
		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}
	
	function delSet ($setId,$workoutExerciseId,$type,$rank,$total) {
	
		$sql = "delete from weights_set where " .
			   "id = $setId";
		$result = mysql_query($sql);
		
		if($result){
			for ($it = $rank;$it<$total;$it++){	
				$nxRank = $it+1;
				$sqlUpdate = "update weights_set set ".
							"rank = $it".
							" where workout_exercise_id = $workoutExerciseId".
							" and type = '$type'".
							" and rank = $nxRank";

				mysql_query($sqlUpdate);	
			}	
		}
		$res = array ("success"=>$result);
		
		echo json_encode($res);
	}
?>