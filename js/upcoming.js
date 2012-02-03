 $(function(){
	
	var user = $(".login span").text();
	
	$("#workout_table").jqGrid({
		url:'functions/show.php?object=workout&username='+user,
		datatype: 'json',
		mtype: 'GET',
		colNames:['Date', 'Location','Duration','Owner'],
		colModel :[ 
		  {name:'date', index:'date', width:120}, 
		  {name:'location', index:'location', width:140},
		  {name:'duration', index:'duration', width:80},
		  {name:'user', index:'user',width:80},
		],
		pager: '#workout_pager',
		rowNum:5,
		rowList:[5,10,20],
		sortname: 'date',
		sortorder: 'asc',
		viewrecords: true,
		gridview: true,
		caption: 'Workouts',
		recordtext: "{0}-{1}/{2}",
		emptyrecords: "No workouts planned.",
		onSelectRow: function(id) {
			$.loadGrid("workoutExercise","workout",id);			
		} 
	 });
	 	  
	$("#workoutExercise_table").jqGrid({
		url:'functions/show.php?object=workoutExercise&filterType=workout',
		datatype: 'local',
		mtype: 'GET',
		colNames:['#','Exercise','Muscle Group'],
		colModel :[ 
		  {name:'rank', index:'rank', width:60}, 
		  {name:'exercise', index:'exercise', width:210},
		  {name:'group', index:'group', width:130} 		  
		],
		pager: '#workoutExercise_pager',
		rowNum:5,
		rowList:[5,10,15],
		sortname: 'rank',
		sortorder: 'asc',
		viewrecords: true,
		gridview: true,
		caption: 'Exercises',
		recordtext: "{0}-{1}/{2}",
		emptyrecords: "No exercises planned.",
		onSelectRow: function(id) {
			$.loadGrid("setPlanned","planned",id);
			$.loadGrid("setActual","actual",id);				
		} 
	}); 

	$("#setPlanned_table").jqGrid({
		url:'functions/show.php?object=setPlanned&filterType=planned',
		datatype: 'local',
		mtype: 'GET',
		colNames:['#','Repetitions','Weight'],
		colModel :[ 
		  {name:'rank', index:'rank', width:60}, 
		  {name:'reps', index:'reps', width:180},
		  {name:'weight', index:'weight', width:120} 		  
		],
		sortname: 'rank',
		sortorder: 'asc',
		gridview: true,
		caption: 'Planned Sets'
	}); 
	
	$("#setActual_table").jqGrid({
		url:'functions/show.php?object=setActual&filterType=actual',
		datatype: 'local',
		mtype: 'GET',
		colNames:['#','Repetitions','Weight'],
		colModel :[ 
		  {name:'rank', index:'rank', width:60}, 
		  {name:'reps', index:'reps', width:180},
		  {name:'weight', index:'weight', width:120} 	 		  
		],
		sortname: 'rank',
		sortorder: 'asc',
		gridview: true,
		caption: 'Actual Sets'
	}); 
	
}); 
  
		
$.loadGrid = function(object, filterType, objId){
	//Common
	var dGrid = $("#"+object+"_table");
	dGrid.clearGridData();
	dGrid.setGridParam({url:"functions/show.php?objId="+objId+"&object="+object+"&filterType="+filterType,page:1,datatype:"json"}).trigger("reloadGrid");
};