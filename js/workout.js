$.showEditTable = function(object,id,filterType,selectAfter){
	var username = $(".login span").text();
	$('#'+object+' .inner-content').html('<img class="spinner" src="images/loading.gif"/>');
	
	obj = object.split("_")[0];
	
	$.ajax({
		type: "GET",
		url: "functions/edit_tables.php",
		data: "object="+obj+"&username="+username+(id?"&id="+id+"&filterType="+filterType:""),
		success: function(msg){
			//Add content
			$('#'+object+' .inner-content').html($.trim(msg));
			//Stay selected after reload
			if(selectAfter){
				$.setSelected(object+"_"+selectAfter);
			}
			
			if(obj=="weightsSet"){
				$.populateWSPos(filterType);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});
};

/* Workout */

//When user clicks on one
$.selectWorkout = function(id){
	//Load form
	$.loadWorkout(id);
	//Load child tables
	$.showEditTable("workoutExercise",id,"workout");
	$.showEditTable("exercise",id,"workout");
	//Select it visually
	$.setSelected("workout_"+id);
	
	//Clear set tables
	$.resetSubPanels(true);
};

//Load details into form
$.loadWorkout = function(id){
	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/edit_tables.php",
		data: "object=workout&id="+id,
		success: function(json){
			$("#workoutId").val(json.id);
			var date = new Date(json.date*1000);
			$("#datepicker").val(pad(date.getDate()) + "-" + pad(date.getMonth()+1) + "-" + date.getFullYear());
			$("#timehr").val(pad(date.getHours()));
			$("#timemn").val(pad(date.getMinutes()));
			$("#location").val(json.location);
			$("#duration").val(json.duration);
			
			var shared = $("#shared");
			
			shared.val(json.shared);
			
			if(json.shared == "shared"){
				shared.attr('disabled',true);
			}
			else{
				shared.attr('disabled',false);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

//When user resets the form - do this also
$.unselectWorkout = function(){
	$("#workout .inner-content table tr td").removeAttr("style");
	$("#shared").attr('disabled',false);
	$.resetSubPanels(false);
};

//When user clicks on delete workout
$.delWorkout = function(){
	
	var workout = $("#workoutId").val();
	if(workout){
		$.ajax({
			type: "GET",
			dataType:"json",
			url: "functions/update.php",
			data: "action=delworkout&id="+workout,
			success: function(json){
				//Reset workout form
				document.workoutForm.reset();
				//Once complete reload workouts (do not remember selection)
				$.showEditTable("workout");
				$.resetSubPanels(false);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				// Error!
			}
		});
	}
};

//When user clicks on update workout
$.updateWorkout = function(){
	var dt = $("#datepicker").val();
	var dateString = dt.substring(6,10) + "-" + dt.substring(3,5) + "-" + dt.substring(0,2) + " " + $("#timehr").val() + ":" + $("#timemn").val() + ":00";

	var data = {
				action:"updateworkout",
				id:$("#workoutId").val(),
				dateTime:dateString,
				location:$("#location").val(),
				duration:$("#duration").val(),
				username:$("#shared").val()=="shared"?"Shared":$(".login span").text()
			};
			
	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: data,
		success: function(json){
			if($("#workoutId").val()){
				//Once complete reload workouts (remember selection)
				$.showEditTable("workout",null,null,$("#workoutId").val());
			}
			else{
				//New workout
				//Reset workout form
				document.workoutForm.reset();
				$.showEditTable("workout");
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};


/* Exercises */

$.addExercise = function(id){
	
	var rank = $("#workoutExercise .inner-content table tr").size();
	rank = rank?rank:1;
	var workoutId = $("#workoutId").val();

	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: "action=addexercise&exerciseId="+id+"&workoutId="+workoutId+"&rank="+rank,
		success: function(json){
			$.showEditTable("workoutExercise",workoutId,"workout");
			$.showEditTable("exercise",workoutId,"workout");
			$.resetSubPanels(true);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

$.delExercise = function(id,rank){
	
	var total = $("#workoutExercise .inner-content table tr").size()-1;
	var workoutId = $("#workoutId").val();

	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: "action=delexercise&workoutExerciseId="+id+"&workoutId="+workoutId+"&rank="+rank+"&total="+total,
		success: function(json){
			$.showEditTable("workoutExercise",workoutId,"workout");
			$.showEditTable("exercise",workoutId,"workout");
			$.resetSubPanels(true);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

$.moveExercise = function(id,rank,change){
	
	var total = $("#workoutExercise .inner-content table tr").size()-1;
	var workoutId = $("#workoutId").val();
	
	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: "action=moveexercise&workoutExerciseId="+id+"&workoutId="+workoutId+"&rank="+rank+"&change="+change,
		success: function(json){
			$.showEditTable("workoutExercise",workoutId,"workout");
			$.resetSubPanels(true);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};


/* Sets*/

$.selectWorkoutExercise = function(id){
	//Set selected
	$.setSelected("workoutExercise_"+id);
	$("#workoutExercise").data("selected",id);

	// New exercise - clear form
	$.clearSetForms();
	
	$.showEditTable("weightsSet_Planned",id,"Planned");
	$.showEditTable("weightsSet_Actual",id,"Actual");
	
};

$.addSet = function(type){
	var workoutExerciseId = $("#workoutExercise").data("selected");
	
	if(workoutExerciseId){
		var total = $("#weightsSet_"+type+" table tr").size();
		total = total?(total-1):0;
		
		var data = {
			action:"addset",
			type:type,
			rank:$("#position_"+type).val(),
			reps:$("#numReps_"+type).val(),
			weight:$("#weight_"+type).val(),
			workoutExerciseId:workoutExerciseId,
			total:total
		};

		$.ajax({
			type: "GET",
			dataType:"json",
			url: "functions/update.php",
			data: data,
			success: function(json){
				$.showEditTable("weightsSet_"+type,workoutExerciseId,type);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				// Error!
			}
		});
	}

};

$.delSet = function(setId,rank,type){
	
	var total = $("#weightsSet_"+type+" .inner-content table tr").size()-1;
	var workoutExerciseId = $("#workoutExercise").data("selected");

	$.ajax({
		type: "GET",
		dataType:"json",
		url: "functions/update.php",
		data: "action=delset&setId="+setId+"&workoutExerciseId="+workoutExerciseId+"&type="+type+"&rank="+rank+"&total="+total,
		success: function(json){
			$.showEditTable("weightsSet_"+type,workoutExerciseId,type);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});

};

$.populateWSPos = function(filterType){
	var numRows = $("#weightsSet_"+filterType+" table tr").size();
	numRows = numRows?numRows:1;
	var options = "";
	for(var i=1;i<=numRows;i++){
		if(i==numRows){
			options += "<option value=\""+i+"\" SELECTED>"+i+"</option>";
		}
		else{
			options += "<option value=\""+i+"\">"+i+"</option>";
		}
	}
	$("#position_"+filterType).html(options);
};


/* Common */
$.resetSubPanels = function(setsOnly){
	//Remove selected workout_exercise id
	$("#workoutExercise").removeData("selected");
	//Clear the set forms
	$.clearSetForms();

	if(!setsOnly){
		$("#workoutExercise .inner-content,#exercise .inner-content").html("<p>Please select a workout to load.</p>");
	}
	$("#weightsSet_Planned .inner-content,#weightsSet_Actual .inner-content").html("<p>Please select an exercise to load.</p>");
};

$.clearSetForms = function(){
	$(".set_form").val("");
	$("#position_Planned *").remove();
	$("#position_Actual *").remove();
};

$.setSelected = function(id){
	var parent = id.split("_")[0];
	$('#'+parent + ' .inner-content table tr td').css('background-color','white');
	$('#'+id+' td').css('background-color','#ECDDDD');
};

function pad(val){
	if(val<10){
		val = "0"+val;
	}
	return val;
}