						<?php
								//Connect To Database
								include 'config.php';
								date_default_timezone_set('GMT');
							
								$wsId = $_GET[id];
								
								$sql = 'select * from weights_set'
										. ' where'
										. ' workout_exercise_id = '.$wsId;
								
								//Default
								$defaultDir = 'asc';
								$rDir = $defaultDir;
								$rDir = $defaultDir;
								$wDir = $defaultDir;
								$tDir = $defaultDir;
														
								if(isset($_GET[orderby])){						
									//Flip direction for link
									if($_GET[dir] == 'asc'){
										$direction = 'desc';
									}
									else{
										$direction = 'asc';
									}					
									
									switch ($_GET[orderby]) {
										case 'rank':
											$rDir = $direction;
											break;
										case 'reps':
											$rDir = $direction;
											break;
										case 'weight':
											$wDir = $direction;
											break;
										case 'type':
											$tDir = $direction;
											break;
									}
															
									$sql .= ' order by ' . $_GET[orderby] . ' ' . $_GET[dir];
								};
			
								$result = mysql_query($sql);

								echo '<table class="weights">'.
									 '<tr>'.
										'<th><a href="javascript:$.showChildTable('.$wsId.',&quot;WeightsSet&quot;,&quot;rank&quot;,&quot;'.$rDir.'&quot;)">#</a></th>'.
										'<th><a href="javascript:$.showChildTable('.$wsId.',&quot;WeightsSet&quot;,&quot;reps&quot;,&quot;'.$rDir.'&quot;)">Repetitions</a></th>'.
										'<th><a href="javascript:$.showChildTable('.$wsId.',&quot;WeightsSet&quot;,&quot;weight&quot;,&quot;'.$wDir.'&quot;)">Weight</a></th>'.
										'<th><a href="javascript:$.showChildTable('.$wsId.',&quot;WeightsSet&quot;,&quot;type&quot;,&quot;'.$tDir.'&quot;)">Planned/Actual</a></th>'.
									 '</tr>';

								if($result) {
									while($row = mysql_fetch_array($result)){
										echo '<tr>'
											. '<td>' . $row['rank'] . '</td>'
											. '<td>' . $row['reps'] . '</td>'
											. '<td>' . $row['weight'] . ' KG </td>'
											. '<td>' . $row['type'] . '</td>'
											. '</tr>';
									}
								}

								echo '</table>';
					?>
	