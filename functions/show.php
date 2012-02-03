
<?php
	include "config.php";

	switch($_REQUEST["object"]){
		case "workout":
			showWorkouts ($_REQUEST[sidx],$_REQUEST[sord],$_REQUEST[page],$_REQUEST[rows],$_REQUEST[username]); 
			break;
		case "exercise":
			showExercises ($_REQUEST[sidx],$_REQUEST[sord],$_REQUEST[page],$_REQUEST[rows]); 
			break;
		case "workoutExercise":
			showWorkoutExercises ($_REQUEST[objId],$_REQUEST[filterType],$_REQUEST[sidx],$_REQUEST[sord],$_REQUEST[page],$_REQUEST[rows]); 
			break;
		case "setPlanned":
			showSets ($_REQUEST[objId],$_REQUEST[filterType],$_REQUEST[sidx],$_REQUEST[sord]); 
			break;
		case "setActual":
			showSets ($_REQUEST[objId],$_REQUEST[filterType],$_REQUEST[sidx],$_REQUEST[sord]); 
			break;
	}
	
	function showWorkouts ($orderBy,$dir,$page,$limit,$user) {
		$start = $limit*$page - $limit;
		//Count SQL
		$countSql = "SELECT COUNT(*) as count from workout where date > current_date and (user_id=0 or user_id=(select id from user where username='$user'))";

		$countResult = mysql_fetch_array(mysql_query($countSql),MYSQL_ASSOC); 
		$count = $countResult[count];

		if($count >0 ){ 
			$totalPages = ceil($count/$limit);
		}
		else {
			$totalPages = 0;
		}

		//Query 
		$sql = "select w.id, w.date, w.location, w.duration, u.username from workout w, user u where w.user_id=u.id and w.date > current_date and (u.id = 0 or u.username = '$user') order by $orderBy $dir LIMIT $start, $limit";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result)){
				$date = new DateTime($row["date"]);
				$date = $date->format("d-m-Y H:i");
				
				$res[] = array(id=>$row[id],cell=>array($date,$row[location],$row[duration]." mins", $row[username]));
		}
		
		$response = array(total=>$totalPages,page=>$page,records=>$count,rows=>$res);
		
		echo json_encode($response);
	}
	
	function showExercises ($orderBy,$dir,$page,$limit) {
		$start = $limit*$page - $limit;
		//Count SQL
		$countSql = "SELECT COUNT(*) as count from exercise";
		$countResult = mysql_fetch_array(mysql_query($countSql),MYSQL_ASSOC); 
		$count = $countResult[count];
		
		if($count >0 ){ 
			$totalPages = ceil($count/$limit);
		}
		else {
			$totalPages = 0;
		}

		//Query
		$sql = "select * from exercise order by $orderBy $dir LIMIT $start, $limit";
		
		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result)){
				$res[] = array(id=>$row[id],cell=>array($row[name],$row[type]));
		}
		
		$response = array(total=>$totalPages,page=>$page,records=>$count,rows=>$res);
		
		echo json_encode($response);
	}
	
	function showWorkoutExercises ($objId,$filterType,$orderBy,$dir,$page,$limit) {
		$start = $limit*$page - $limit;
		
		if($filterType == "workout"){
			$filter = " we.workout_id = $objId";
		}
		else if($filterType == "exercise"){
			$filter = " we.exercise_id = $objId";
		}
		
		//Count SQL
		$countSql = "SELECT COUNT(*) as count from workout_exercise we, exercise e, workout w where we.exercise_id = e.id and we.workout_id=w.id and $filter";
			
		$countResult = mysql_fetch_array(mysql_query($countSql),MYSQL_ASSOC); 
		$count = $countResult[count];

		if($count >0 ){ 
			$totalPages = ceil($count/$limit);
		}
		else {
			$totalPages = 0;
		}
		
		//Query
		$sql = "select we.id as id, we.rank as rank, e.name as exercise, e.type as type, w.date as date, w.location as location from workout_exercise we, exercise e, workout w"
				. " where we.exercise_id = e.id and we.workout_id=w.id and $filter order by $orderBy $dir LIMIT $start, $limit";
	
		
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)){
			if($filterType == "workout"){
				$res[] = array(id=>$row[id],cell=>array($row[rank],$row[exercise],$row[type]));
			}
			else if($filterType == "exercise"){
				$date = new DateTime($row["date"]);
				$date = $date->format("d-m-Y H:i");
				$res[] = array(id=>$row[id],cell=>array($row[date],$row[location],$row[exercise]));
			}
		}
		
		$response = array(total=>$totalPages,page=>$page,records=>$count,rows=>$res);
		
		echo json_encode($response);
	}
	
	function showSets ($objId,$filterType,$orderBy,$dir) {		
		$sql = "select * from weights_set where workout_exercise_id = $objId and type='$filterType' order by $orderBy $dir";	

		$result = mysql_query($sql);
		
		while($row = mysql_fetch_array($result)){
			$res[] = array(id=>$row[id],cell=>array($row[rank],$row[reps],$row[weight]." kg"));
		}
		
		$response = array(rows=>$res);
		
		echo json_encode($response);
	}
?>