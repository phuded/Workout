$.selectWorkout = function(id){
	//Load child tables
	$.showEditTable("workoutExercise",id,"workout");
	$.showEditTable("exercise",id,"workout");
	//Load form
	$.loadWorkout(id);
	//Select it
	$.setSelected("workout_"+id);
}

$.showEditTable = function(object,id,filterType,selectAfter){

	$('#'+object+' .inner-content').html('<img class="spinner" src="images/loading.gif"/>');
	
	obj = object.split("_")[0];
	
	$.ajax({
		type: "GET",
		url: "functions/edit.php",
		data: "object="+obj+(id?"&id="+id+"&filterType="+filterType:""),
		success: function(msg){	
			$('#'+object+' .inner-content').html($.trim(msg));
			if(selectAfter){
				$.setSelected(object+"_"+selectAfter);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});
};

$.loadWorkout = function(id){
	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/edit.php",
		data: "object=workout&id="+id,
		success: function(json){
			$("#workoutId").val(json.id);
			var date = new Date(json.date*1000);
			$("#datepicker").val(pad(date.getDate()) + "-" + pad(date.getMonth()+1) + "-" + date.getFullYear());
			$("#timehr").val(pad(date.getHours()));
			$("#timemn").val(pad(date.getMinutes()));
			$("#location").val(json.location);
			$("#duration").val(json.duration);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

$.unselectWorkout = function(){
	$("#workout .inner-content table tr td").removeAttr("style");
	$.resetSubPanels();
};


$.updateWorkout = function(){
	var dt = $("#datepicker").val();
	var dateString = dt.substring(6,10) + "-" + dt.substring(3,5) + "-" + dt.substring(0,2) + " " + $("#timehr").val() + ":" + $("#timemn").val() + ":00";

	var data = {
				object:"workout",
				id:$("#workoutId").val(),
				dateTime:dateString,
				location:$("#location").val(),
				duration:$("#duration").val()
			};
			
	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: data,
		success: function(json){
			//Once complete reload workouts (remember selection)
			$.showEditTable("workout",null,null,$("#workoutId").val());
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

$.resetSubPanels = function(){
	$("#workoutExercise .inner-content,#exercise .inner-content").html("<p>Please select a workout to load.</p>");
	$("#weightsSet_Planned .inner-content,#weightsSet_Actual .inner-content").html("<p>Please select an exercise to load.</p>");
}