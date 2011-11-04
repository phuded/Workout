
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
		$sql = "select * from workout where date > current_date";
		
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
		}
		else{
			$sql .= " order by date asc";
		}
		
		$sql .= " limit 5";	
		
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){
			$output = "<table class=\"weights\">"
					 . "<tr>"
						. "<th><a href=\"?orderby=date&dir=$dtDir\">Date</a></th>"
						. "<th><a href=\"?orderby=location&dir=$lDir\">Location</a></th>"
						. "<th><a href=\"?orderby=duration&dir=$dDir\">Duration</a></th>"
						. "<th></th>"
					 . "</tr>";

			while($row = mysql_fetch_array($result)){
				$date = new DateTime($row["date"]);
				$date = $date->format("d-m-Y H:i");
				$output .= "<tr id=\"workout_$row[id]\">"
						. "<td>$date</td>"
						. "<td>$row[location]</td>"
						. "<td>$row[duration] mins </td>"
						. "<td><a href=\"javascript:$.showChildTable('workoutExercise',$row[id],'workout');$.setSelected('workout_$row[id]')\"><img src=\"images/arrow_right_fat.png\" title=\"Select Workout\"/></a></td>"
						. "</tr>";
			}
			
			$output .= '</table>';
		}
		else{
			$output = "<h3>There are no workouts planned!</h3>";
		}
		
		echo $output;
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
		}
		else{
			$sql .= " order by name asc";
		}
						
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){

			$output .=  "<table class=\"weights\">".
						 "<tr>".
							"<th><a href=\"?orderby=name&dir=$nDir\">Name</a></th>".
							"<th><a href=\"?orderby=type&dir=$tDir\">Muscle Group</a></th>".
							"<th><a>Next</a></th>".
						 "</tr>";

	
			while($row = mysql_fetch_array($result)){
				$output .=  "<tr id=\"exercise_$row[id]\">"
							. "<td>$row[name]</td>"
							. "<td>$row[type]</td>"
							. "<td class=\"centre\"><a href=\"javascript:$.showChildTable('workoutExercise',$row[id],'exercise');$.setSelected('exercise_$row[id]')\"><img src=\"images/arrow_right_fat.png\" title=\"Select Exercise\"/></a></td>"
							. "</tr>";
			}
			
			$output .=  '</table>';
		}
		else{
			$output = "<h3>There are no exercises!</h3>";
		}
		
		echo $output;
	}
	
	function showWorkoutExercises ($id,$filterType,$orderBy,$dir) {		
		$sql = "select we.id as id, we.rank as rank, e.name as exercise, e.type as type, w.date as date, w.location as location from workout_exercise we, exercise e, workout w"
				. " where we.exercise_id = e.id and we.workout_id=w.id and";
		
		if($filterType == "workout"){
			$sql .= " we.workout_id = $id";
		}
		else if($filterType == "exercise"){
			$sql .= " we.exercise_id = $id";
		}
		
			
		//Default
		$defaultDir = "asc";
		$rDir = $defaultDir;
		$dDir = $defaultDir;
		$lDir = $defaultDir;
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
				case "date":
					$dDir = $direction;
					break;
				case "location":
					$lDir = $direction;
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
		else{
			$sql .= " order by rank asc";
		}
							
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){

			$output = "<table class=\"weights\">".
					"<tr>";
					
			if($filterType == "workout"){
				$output .= "<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','rank','$rDir')\">#</a></th>";
			}
			else if($filterType == "exercise"){
				$output .= "<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','date','$dDir')\">Date</a></th>"
						. "<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','type','$lDir')\">Location</a></th>";
			}
			
			$output .= "<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','exercise','$eDir')\">Exercise</a></th>";
			
			if($filterType == "workout"){
				$output .= "<th><a href=\"javascript:$.showChildTable('workoutExercise',$id,'$filterType','type','$tDir')\">Muscle Group</a></th>"
						. "<th></th>";
			}
			
			$output .= "</tr>";
		
			while($row = mysql_fetch_array($result)){
				$output .= "<tr id=\"workoutExercise_$row[id]\">";
				
				if($filterType == "workout"){
					$output .= "<td>$row[rank]</td>";
				}
				else if($filterType == "exercise"){
					$date = new DateTime($row["date"]);
					$date = $date->format("d-m-Y H:i");
					
					$output .= "<td>$date</td>"
							. "<td>$row[location]</td>";
				}
				
				$output .= "<td>$row[exercise]</td>";						

				if($filterType == "workout"){
					$output .= "<td>$row[type]</td>"
							. "<td><a href=\"javascript:$.showChildTable('weightsSet_Planned',$row[id],'Planned');$.showChildTable('weightsSet_Actual',$row[id],'Actual');$.setSelected('workoutExercise_$row[id]')\"><img src=\"images/arrow_right.png\" title=\"Select Exercise\"/></a></td>";
				}
				$output .= "</tr>";
			}
			
			$output .= "</table>";
		
		}
		else{
			if($filterType == "workout"){
				$output = "<h3>There are no exercises planned for this workout!</h3>";
			}
			else if($filterType == "exercise"){
				$output = "<h3>This exercise is not scheduled in any workout!</h3>";
			}
		}
		
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
		else{
			$sql .= " order by rank asc";
		}

		$result = mysql_query($sql);
		
		if(mysql_num_rows($result) > 0){

			$output = "<table class=\"weights\">"
					 ."<tr>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','rank','$rDir')\">#</a></th>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','reps','$rDir')\">Repetitions</a></th>"
						."<th><a href=\"javascript:$.showChildTable('weightsSet_$filterType',$id,'$filterType','weight','$wDir')\">Weight</a></th>"
					 ."</tr>";

			while($row = mysql_fetch_array($result)){
				$output .= "<tr>"
						. "<td>$row[rank]</td>"
						. "<td>$row[reps]</td>"
						. "<td>$row[weight] KG</td>"
						. "</tr>";
			}
			
			$output .= "</table>";
		
		
			if($filterType=="Planned"){
				$output .= "<br/><a href=\"javascript:$.showGraph(true,$id)\">Show Graph</a>";
			}
		}
		else{
			$output = "<h3>There are no $filterType sets for this workout!</h3>";
		}

		echo $output;
	};

?>