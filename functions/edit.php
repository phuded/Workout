
<?php
	include "config.php";
	
	switch($_REQUEST["object"]){
		case "workout":
			editWorkouts ($_REQUEST[id],$_REQUEST[filterType]); 
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
	
	function editWorkouts ($id,$filterType) {
		if(isset($id)){
	
			$sql = "select * from workout where id = $id";
			$result = mysql_query($sql);
			
			if($result) {
				$row = mysql_fetch_assoc($result);
				$date = strtotime($row[date]);
				$output = array(id=>$row[id],location=>$row[location],date=>$date,duration=>$row[duration]);
			}

			echo json_encode($output);
		}
		else{
			$sql = "select * from workout";
			
			$result = mysql_query($sql);

			echo "<table class=\"weights\">"
				 . "<tr>"
					. "<th>Date</th>"
					. "<th>Location</th>"
					. "<th>Duration</th>"
					. "<th></th>"
				 . "</tr>";

			if($result) {
				while($row = mysql_fetch_array($result)){
					$date = new DateTime($row["date"]);
					$date = $date->format("d-m-Y H:i:s");
					echo "<tr id=\"workout_$row[id]\">"
						. "<td>$date</td>"
						. "<td>$row[location]</td>"
						. "<td>$row[duration] mins </td>"
						. "<td><a href=\"javascript:$.selectWorkout($row[id])\">Select</a></td>"
						. "</tr>";
				}
			}

			echo '</table>';
		}
	}
	
	function editExercises ($id,$filterType) {
		$sql = "select * from exercise"
				." where id not in (select exercise_id from workout_exercise where workout_id=$id)"
				." order by type asc";
						
		$result = mysql_query($sql);

		echo "<table class=\"weights\">".
			 "<tr>".
				"<th>Name</th>".
				"<th>Muscle Group</th>".
				"<th></th>".
			 "</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				echo "<tr id=\"exercise_$row[id]\">"
					. "<td>$row[name]</td>"
					. "<td>$row[type]</td>"
					. "<td><a href=\"#\">Add</a></td>"
					. "</tr>";
			}
		}

		echo '</table>';
	}
	
	function editWorkoutExercises ($id,$filterType) {		
		$sql = "select we.id as id, we.rank as rank, e.name as exercise from workout_exercise we, exercise e"
				. " where we.exercise_id = e.id and we.workout_id = $id";
				
		$result = mysql_query($sql);

		$output = "<table class=\"weights\">".
				"<tr>".
					"<th>#</th>".
					"<th>Exercise</th>".
					"<th></th>".
					"<th></th>".
				"</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				$output .= "<tr id=\"workoutExercise_$row[id]\">"
							. "<td>$row[rank]</td>"
							. "<td>$row[exercise]</td>"
							. "<td><a href=\"#\">Delete</a></td>"
							."<td><a href=\"javascript:$.showEditTable('weightsSet_Planned',$row[id],'Planned');$.showEditTable('weightsSet_Actual',$row[id],'Actual');$.setSelected('workoutExercise_$row[id]')\">View Set</a></td>"
							."</tr>";
			}
		}

		$output .= "</table>";
		
		echo $output;
	}
	
	function editWeightsSet ($id,$filterType) {	
		
		$sql = "select * from weights_set where workout_exercise_id = $id and type='$filterType'";

		$result = mysql_query($sql);

		$output = "<table class=\"weights\">"
					 ."<tr>"
						."<th>#</th>"
						."<th>Repetitions</th>"
						."<th>Weight</th>"
						."<th></th>"
					 ."</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				$output .= "<tr>"
						. "<td>$row[rank]</td>"
						. "<td>$row[reps]</td>"
						. "<td>$row[weight] KG</td>"
						. "<td><a href=\"#\">Delete</a></td>"
						. "</tr>";
			}
		}

		$output .= "</table>";
		
		echo $output;
	};

?>