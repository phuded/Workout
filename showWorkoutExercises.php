						<?php						
								//Connect To Database
								include 'config.php';
								date_default_timezone_set('GMT');
								
								//If by ID - tidy up
								if(isset($_GET[id])){	
									$weId = $_GET[id];
									
									$sql = 'select we.id as id, e.name as exercise, we.date as date from workout_exercise we, exercise e'
											. ' where'
											. ' we.exercise_id = e.id and'
											. ' we.workout_id = '.$weId;
									
									//Default
									$defaultDir = 'asc';
									$eDir = $defaultDir;
									$dDir = $defaultDir;
															
									if(isset($_GET[orderby])){						
										//Flip direction for link
										if($_GET[dir] == 'asc'){
											$direction = 'desc';
										}
										else{
											$direction = 'asc';
										}					
										
										switch ($_GET[orderby]) {
											case 'exercise':
												$eDir = $direction;
												break;
											case 'date':
												$dDir = $direction;
												break;
										}
																
										$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
									};
														
									$result = mysql_query($sql);

									echo '<table class="weights">'.
										 '<tr>'.
											'<th><a href="javascript:$.showChildTable('.$weId.',&quot;WorkoutExercises&quot;,&quot;exercise&quot;,&quot;'.$eDir.'&quot;)">Exercise</a></th>'.
											'<th><a href="javascript:$.showChildTable('.$weId.',&quot;WorkoutExercises&quot;,&quot;date&quot;,&quot;'.$dDir.'&quot;)">Time</a></th>'.
											'<th></th>'.
										 '</tr>';

									if($result) {
										while($row = mysql_fetch_array($result)){
											$date = new DateTime($row['date']);
											echo '<tr>'
												. '<td>' . $row['exercise'] . '</td>'
												. '<td>' . $date->format('d-m-Y H:i:s') . '</td>'
												. '<td><a href="javascript:$.showChildTable('.$row['id'].',&quot;WeightsSet&quot;)">View Set</a></td>'
												. '</tr>';
										}
									}

									echo '</table>';
								}
								//Else by Exercise ID
								else{						
									$weId = $_GET[exerciseId];
									
									$sql = 'select we.id as id, e.name as exercise, we.date as date from workout_exercise we, exercise e'
											. ' where'
											. ' we.exercise_id = e.id and'
											. ' we.exercise_id = '.$weId;
											
									//Default
									$defaultDir = 'asc';
									$eDir = $defaultDir;
									$dDir = $defaultDir;
															
									if(isset($_GET[orderby])){						
										//Flip direction for link
										if($_GET[dir] == 'asc'){
											$direction = 'desc';
										}
										else{
											$direction = 'asc';
										}					
										
										switch ($_GET[orderby]) {
											case 'exercise':
												$eDir = $direction;
												break;
											case 'date':
												$dDir = $direction;
												break;
										}
																
										$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
									};
														
									$result = mysql_query($sql);

									echo '<table class="weights">'.
										 '<tr>'.
											'<th><a href="javascript:$.showChildTable('.$weId.',&quot;WorkoutExercises&quot;,&quot;exercise&quot;,&quot;'.$eDir.'&quot;)">Exercise</a></th>'.
											'<th><a href="javascript:$.showChildTable('.$weId.',&quot;WorkoutExercises&quot;,&quot;date&quot;,&quot;'.$dDir.'&quot;)">Time</a></th>'.
										 '</tr>';

									if($result) {
										while($row = mysql_fetch_array($result)){
											$date = new DateTime($row['date']);
											echo '<tr>'
												. '<td>' . $row['exercise'] . '</td>'
												. '<td>' . $date->format('d-m-Y H:i:s') . '</td>'
												. '</tr>';
										}
									}

									echo '</table>';
								}
						?>
