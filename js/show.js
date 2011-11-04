
$.showChildTable = function(object,id,filterType, orderby, dir){

	$('#'+object+' .inner-content').html('<img class="spinner" src="images/loading.gif"/>');
	
	var obj = object.split("_")[0];
	
	if(obj == "workoutExercise"){
		$.resetSubPanels(); 
	}
	
	$.ajax({
		type: "GET",
		url: "functions/show_tables.php",
		data: "object="+obj+"&id="+id+"&filterType="+filterType+(orderby?"&orderby="+orderby+"&dir="+dir:""),
		success: function(msg){	
			$("#"+object+" .inner-content").html($.trim(msg));
		},
		error: function(XMLHttpRequest, textStatus, errorThrown) {
			// Error!
		}
	});
};

$.resetSubPanels = function(){
	$("#weightsSet_Planned .inner-content,#weightsSet_Actual .inner-content").html("<p>Please click 'View Set' to load.</p>");
};

$.showGraph = function(show,id){
	if(show){
		$("#graph").html("");
		$("#weightsSet_Graph").show();
		$(".weights_set").hide();
		
		var ajaxDataRenderer = function(url, plot, options) {
			var ret = null;
			$.ajax({
				async: false,
				url: url,
				dataType:"json",
				success: function(data) {
					ret = data;
				 }
			});
			return ret;
		};
		 
	  // The url for our json data
	  var jsonurl = "functions/graph.php?id="+id;
	 
	  // passing in the url string as the jqPlot data argument is a handy
	  // shortcut for our renderer.  You could also have used the
	  // "dataRendererOptions" option to pass in the url.
	  var plot = $.jqplot('graph', jsonurl,{
		title: "Planned vs Actual Comparison",
		dataRenderer: ajaxDataRenderer,
		dataRendererOptions: {
		  unusedOptionalUrl: jsonurl
		},
		axes: {
			// options for each axis are specified in seperate option objects.
			xaxis: {
			  label: "Set #",
			  tickInterval: 1,
			  min:0,
			  tickOptions: {
				formatString: '%.0f', 
			  }
			},
			yaxis: {
			  label: "Weight (KG)",
			  tickInterval: 2,
			  min:0,
			  tickOptions: {
				formatString: '%.0f', 
			  }
			}
		},
		series:[{label:'Planned',color:'red'},{label:'Actual',color:'black'}],
		legend: {show: true,placement: 'outsideGrid'}
	  });
		
	}
	else{
		$("#weightsSet_Graph").hide();
		$(".weights_set").show();
	}
};