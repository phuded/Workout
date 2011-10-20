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