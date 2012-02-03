
<?php
	include "config.php";
	
	switch($_REQUEST["object"]){
		case "workout":
			editWorkouts ($_REQUEST[id],$_REQUEST[filterType],$_REQUEST[username]); 
			break;
		case "exercise":
			editExercises ($_REQUEST[id],$_REQUEST[filterType]);
			break;
		case "workoutExercise":
			editWorkoutExercises ($_REQUEST[id],$_REQUEST[filterType]); 
			break;
		case "weightsSet":
			editWeightsSet ($_REQUEST[id],$_REQUEST[filterType]);
			break;
	}
	
	function editWorkouts ($id,$filterType,$user) {
		if(isset($id)){
	
			$sql = "select w.id, w.date, w.location, w.duration, u.username from workout w, user u where w.user_id=u.id and w.id = $id";
			$result = mysql_query($sql);
			
			if($result) {
				$row = mysql_fetch_assoc($result);
				$date = strtotime($row[date]);
				
				if($row[username] == "Shared"){
					$shared = "shared";
				}
				else{
					$shared = "personal";
				}
				
				$output = array(id=>$row[id],location=>$row[location],date=>$date,duration=>$row[duration],shared=>$shared);
			}

			echo json_encode($output);
		}
		else{
			$sql = "select w.id, w.date, w.location, w.duration, u.username from workout w, user u where w.user_id=u.id and (u.id=0 or u.username='$user') order by date asc";

			$result = mysql_query($sql);
			
			if(mysql_num_rows($result) > 0){
				$output =  "<table class=\"weights\">"
						 . "<tr>"
							. "<th>Date</th>"
							. "<th>Location</th>"
							. "<th>Duration</th>"
							. "<th>Owner</th>"
							. "<th></th>"
						 . "</tr>";

				while($row = mysql_fetch_array($result)){
					$date = new DateTime($row["date"]);
					$date = $date->format("d-m-Y H:i");
					
					$output .= "<tr id=\"workout_$row[id]\">"
							. "<td>$date</td>"
							. "<td>$row[location]</td>"
							. "<td>$row[duration] mins </td>"
							. "<td>$row[username]</td>"
							. "<td><a href=\"javascript:$.selectWorkout($row[id])\"><img src=\"images/arrow_right_fat.png\" title=\"Select Workout\"/></a></td>"
							. "</tr>";
				}

				$output .= '</table>';
			}
			else{
				$output = "<h3>There are not workouts planned!</h3>";
			}
			
			echo $output;
		}
	}
	
	function editExercises ($id,$filterType) {
		$sql = "select * from exercise"
				." where id not in (select exercise_id from workout_exercise where workout_id=$id)"
				." order by type asc";
						
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){

			$output = "<table class=\"weights\">".
					 "<tr>".
						"<th>Name</th>".
						"<th>Muscle Group</th>".
						"<th></th>".
					 "</tr>";


			while($row = mysql_fetch_array($result)){
				$output .= "<tr id=\"exercise_$row[id]\">"
							. "<td>$row[name]</td>"
							. "<td>$row[type]</td>"
							. "<td><a href=\"javascript:$.addExercise($row[id])\"><img src=\"images/add.png\" title=\"Add to workout\"/></a></td>"
							. "</tr>";
			}
		
			$output .= '</table>';
		}
		else{
			$output = "<h3>There are no exercises!</h3>";
		}
		
		echo $output;
	}
	
	function editWorkoutExercises ($id,$filterType) {		
		$sql = "select we.id as id, we.rank as rank, e.name as exercise from workout_exercise we, exercise e"
				. " where we.exercise_id = e.id and we.workout_id = $id order by rank asc";
				
		$result = mysql_query($sql);
		$numRows = mysql_num_rows($result);
		
		if($numRows > 0){
		
			$output = "<table class=\"weights\">".
					"<tr>".
						"<th>#</th>".
						"<th>Exercise</th>".
						"<th></th>".
						"<th></th>".
						"<th></th>".
					"</tr>";
			
			$cnt = 1;
			while($row = mysql_fetch_array($result)){
				$output .= "<tr id=\"workoutExercise_$row[id]\">"
							. "<td>$row[rank]</td>"
							. "<td>$row[exercise]</td>"
							. "<td><a href=\"javascript:$.delExercise($row[id],$row[rank])\"><img src=\"images/delete.png\" title=\"Delete Exercise\"/></a></td>";
							
				if($cnt>1){
					$output .= "<td><a href=\"javascript:$.moveExercise($row[id],$row[rank],-1)\"><img src=\"images/arrow_up.png\" title=\"Move up\"/></a>";
					$margin = "7px";
				}
				else{
					$output .= "<td>";
					$margin = "18px";
				}
				
				if($cnt<$numRows){
					$output .= "<a style=\"margin-left:$margin\" href=\"javascript:$.moveExercise($row[id],$row[rank],1)\"><img src=\"images/arrow_down.png\" title=\"Move down\"/></a></td>";
				}
				else{
					$output .= "</td>";
				}
				
				$output .= "<td><a href=\"javascript:$.selectWorkoutExercise($row[id])\"><img src=\"images/arrow_right_fat_blue.png\" title=\"View Sets\"/></a></td>"
				."</tr>";
				$cnt++;			
			}

			$output .= "</table>";
		}
		else{
			$output = "<h3>There are no exercises planned for this workout!</h3>";
		}
		
		echo $output;
	}
	
	function editWeightsSet ($id,$filterType) {	
		
		$sql = "select * from weights_set where workout_exercise_id = $id and type='$filterType' order by rank asc";

		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){
			$output = "<table class=\"weights\">"
						 ."<tr>"
							."<th>#</th>"
							."<th>Repetitions</th>"
							."<th>Weight</th>"
							."<th></th>"
						 ."</tr>";

			while($row = mysql_fetch_array($result)){
				$output .= "<tr>"
						. "<td>$row[rank]</td>"
						. "<td>$row[reps]</td>"
						. "<td>$row[weight] KG</td>"
						. "<td><a href=\"javascript:$.delSet($row[id],$row[rank],'$filterType')\"><img src=\"images/delete.png\" title=\"Delete Set\"/></a></td>"
						. "</tr>";
			}
			
			$output .= "</table>";
		}
		else{
			$output = "<h3>There are no $filterType sets for this workout!</h3>";
		}
		
		echo $output;
	};

?>