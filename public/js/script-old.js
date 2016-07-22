var offset = $('#button').val();
$("#button").click(function() {
	console.log(offset);
	$.get("/loadalarmmore?offset="+offset, function(result) {
	  	console.log(result);
	  	offset = parseInt(offset)+result.length;
	  	$(".alarm").append("<p>");
	  	var i=0;
	  	for (i=0;i<result.length;i++) {
	  		$(".alarm").append("alarm id = "+result[i]["alarm_id"]+"<br>");
	  	}
	  	$(".alarm").append("</p>");
	})
});

var last_id = $('.alarm')[0].id;
console.log(last_id);
function loadalarm() {
	$.get("/loadnewalarm?last_id="+last_id, function(result) {
		console.log(result);
		$(".alarm").prepend("</p>");
		var i=0;
		for (i=0;i<result.length;i++) {
			$(".alarm").append("alarm id = "+result[i]["alarm_id"]+"<br>");
		}
		$(".alarm").prepend("<p>");
		if (result.length != 0) {
			last_id = result[result.length-1]['alarm_id'];
		}
	})
}

setInterval(function() {
	loadalarm();
}, 5000);