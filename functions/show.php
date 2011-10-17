
<?php
	include "config.php";
	
	switch($_REQUEST["object"]){
		case "workout":
			showWorkouts ($_REQUEST[orderby],$_REQUEST[dir]); 
			break;
		case "exercise":
			showExercises ($_REQUEST[orderby],$_REQUEST[dir]);
			break;
		case "workoutExercise":
			showWorkoutExercises ($_REQUEST[id],$_REQUEST[filterType],$_REQUEST[orderby],$_REQUEST[dir]); 
			break;
		case "weightsSet":
			showWeightsSet ($_REQUEST[id],$_REQUEST[filterType],$_REQUEST[orderby],$_REQUEST[dir]);
			break;
	}
	
	function showWorkouts ($orderBy,$dir) {
		$sql = "select * from workout";
		
		//Default
		$defaultDir = "asc";
		$dtDir = $defaultDir;
		$lDir = $defaultDir;
		$dDir = $defaultDir;
								
		if(isset($orderBy)){						
			//Flip direction for link
			if($dir == "asc"){
				$direction = "desc";
			}
			else{
				$direction = "asc";
			}					
			
			switch ($orderBy) {
				case "date":
					$dtDir = $direction;
					break;
				case "location":
					$lDir = $direction;
					break;
				case "duration":
					$dDir = $direction;
					break;
			}
									
			$sql .= " order by $orderBy $dir";
		};
		
		$sql .= " limit 5";	
		
		$result = mysql_query($sql);

		echo "<table class=\"weights\">"
			 . "<tr>"
				. "<th><a href=\"?orderby=date&dir=$dtDir\">Date</a></th>"
				. "<th><a href=\"?orderby=location&dir=$lDir\">Location</a></th>"
				. "<th><a href=\"?orderby=duration&dir=$dDir\">Duration</a></th>"
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
					. "<td><a href=\"javascript:$.showChildTable('workoutExercise',$row[id],'workout');$.setSelected('workout_$row[id]')\">View</a></td>"
					. "</tr>";
			}
		}

		echo '</table>';
	}
	
	function showExercises ($orderBy,$dir) {
		$sql = "select * from exercise";
		
		//Default
		$defaultDir = "asc";
		$nDir = $defaultDir;
		$tDir = $defaultDir;
								
		if(isset($orderBy)){						
			//Flip direction for link
			if($dir == "asc"){
				$direction = "desc";
			}
			else{
				$direction = "asc";
			}
			
			if($orderBy == "name"){
				$nDir = $direction;
			}
			else{
				$tDir = $direction;
			}
			
			$sql .= " order by $orderBy $dir";
		};								
						
		$result = mysql_query($sql);

		echo "<table class=\"weights\">".
			 "<tr>".
				"<th><a href=\"?orderby=name&dir=$nDir\">Name</a></th>".
				"<th><a href=\"?orderby=type&dir=$tDir\">Muscle Group</a></th>".
				"<th><a>Next</a></th>".
			 "</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				echo "<tr id=\"exercise_$row[id]\">"
					. "<td>$row[name]</td>"
					. "<td>$row[type]</td>"
					. "<td><a href=\"javascript:$.showChildTable('workoutExercise',$row[id],'exercise');$.setSelected('Exercises_$row[id]')\">View</a></td>"
					. "</tr>";
			}
		}

		echo '</table>';
	}
	
	function showWorkoutExercises ($id,$filterType,$orderBy,$dir) {		
		$sql = "select we.id as id, we.rank as rank, e.name as exercise, e.type as type from workout_exercise we, exercise e"
				. " where we.exercise_id = e.id and";
		
		if($filterType == "workout"){
			$sql .= " we.workout_id = $id";
		}
		else if($filterType == "exercise"){
			$sql .= " we.exercise_id = $id";
		}
		
			
		//Default
		$defaultDir = "asc";
		$rDir = $defaultDir;
		$eDir = $defaultDir;
		$tDir = $defaultDir;
								
		if(isset($orderBy)){						
			//Flip direction for link
			if($dir == "asc"){
				$direction = "desc";
			}
			else{
				$direction = "asc";
			}					
			
			switch ($orderBy) {
				case "rank":
					$rDir = $direction;
					break;
				case "exercise":
					$eDir = $direction;
					break;
				case "type":
					$tDir = $direction;
					break;
			}
									
			$sql .= " order by $orderBy $dir";
		}
							
		$result = mysql_query($sql);

		$output = "<table class=\"weights\">".
				"<tr>".
					"<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','rank','$rDir')\">#</a></th>".
					"<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','exercise','$eDir')\">Exercise</a></th>".
					"<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','type','$tDir')\">Muscle Group</a></th>";
		
		if($filterType == "workout"){
			$output .= "<th></th>";
		}
		
		$output .= "</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				$output .= "<tr id=\"workoutExercise_$row[id]\">"
							. "<td>$row[rank]</td>"
							. "<td>$row[exercise]</td>"
							. "<td>$row[type]</td>";

				if($filterType == "workout"){
					$output .= "<td><a href=\"javascript:$.showChildTable('weightsSet_Planned',$row[id],'Planned');$.showChildTable('weightsSet_Actual',$row[id],'Actual');$.setSelected('workoutExercise_$row[id]')\">View</a></td>";
				}
				$output .= "</tr>";
			}
		}

		$output .= "</table>";
		
		echo $output;
	}
	
	function showWeightsSet ($id,$filterType,$orderBy,$dir) {	
		
		$sql = "select * from weights_set where workout_exercise_id = $id and type='$filterType'";
		
		//Default
		$defaultDir = "asc";
		$rDir = $defaultDir;
		$rDir = $defaultDir;
		$wDir = $defaultDir;
								
		if(isset($orderBy)){						
			//Flip direction for link
			if($dir == "asc"){
				$direction = "desc";
			}
			else{
				$direction = "asc";
			}					
			
			switch ($orderBy) {
				case "rank":
					$rDir = $direction;
					break;
				case "reps":
					$rDir = $direction;
					break;
				case "weight":
					$wDir = $direction;
					break;
			}
									
			$sql .= " order by $orderBy $dir";
		}

		$result = mysql_query($sql);

		$output = "<table class=\"weights\">"
					 ."<tr>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','rank','$rDir')\">#</a></th>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','reps','$rDir')\">Repetitions</a></th>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','weight','$wDir')\">Weight</a></th>"
					 ."</tr>";

		if($result) {
			while($row = mysql_fetch_array($result)){
				$output .= "<tr>"
						. "<td>$row[rank]</td>"
						. "<td>$row[reps]</td>"
						. "<td>$row[weight] KG</td>"
						. "</tr>";
			}
		}

		$output .= "</table>";
		
		if($type=="Planned"){
			$output .= "<br/><a href=\"javascript:$.showGraph(true,$id)\">Show Graph</a>";
		}

		echo $output;
	};

?>