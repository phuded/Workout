 $(function(){ 
	//Exercises page
	
	$("#exercise_table").jqGrid({
		url:'functions/show.php?object=exercise',
		datatype: 'json',
		mtype: 'GET',
		colNames:['Name','Muscle Group'],
		colModel :[ 
		  {name:'name', index:'name', width:200}, 
		  {name:'type', index:'type', width:180},	  
		],
		pager: '#exercise_pager',
		rowNum:20,
		rowList:[20,50,100],
		sortname: 'name',
		sortorder: 'asc',
		viewrecords: true,
		gridview: true,
		caption: 'Exercises',
		recordtext: "{0}-{1}/{2}",
		emptyrecords: "No exercise available.",
		height:450,
		onSelectRow: function(id) {
			$.loadGrid("workoutExercise","exercise",id);			
		} 
	 });
	 
	 $("#workoutExercise_table").jqGrid({
		url:'functions/show.php?object=workoutExercise&filterType=exercise',
		datatype: 'local',
		mtype: 'GET',
		colNames:['Date','Location','Exercise'],
		colModel :[ 
		  {name:'date', index:'date', width:140}, 
		  {name:'location', index:'location', width:160},
		  {name:'exercise', index:'exercise', width:200} 		  
		],
		pager: '#workoutExercise_pager',
		rowNum:5,
		rowList:[5,10,15],
		sortname: 'rank',
		sortorder: 'asc',
		viewrecords: true,
		gridview: true,
		caption: 'Next Scheduled',
		recordtext: "{0}-{1}/{2}",
		emptyrecords: "Exercise not planned."
	}); 
	
  }); 
  
		
$.loadGrid = function(object, filterType, objId){
	//Common
	var dGrid = $("#"+object+"_table");
	dGrid.clearGridData();
	dGrid.setGridParam({url:"functions/show.php?objId="+objId+"&object="+object+"&filterType="+filterType,page:1,datatype:"json"}).trigger("reloadGrid");
};