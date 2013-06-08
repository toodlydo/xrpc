$( document ).ready(function() {
	$(".remote").on('click', ".lruds", function(){
		$.getJSON('inputExecuteAction.php?action='+$(this).attr("id")
		).done(function(data) {
			console.log( "success" );
			var obj = $.parseJSON(JSON.stringify(data));
		}).fail(function() {
			console.log( "error" );
		});
	});

	var cid = "";
	$(".remote").on('click', ".playeraction", function(){
		cid = $(this);
		$.getJSON('inputExecuteAction.php?id=1&action='+cid.attr("id")
		).done(function(data) {
			console.log( "success "  + cid.attr("id"));

			var obj = $.parseJSON(JSON.stringify(data));
			if(cid.attr("id")=="play")
			{
				console.log(obj.result.speed);
				if(obj.result.speed == 1){
					$("#play").attr("src","img/pause.png");
					$("#play").attr("id", "pause");
					$("#rewind").attr("src", "img/rw.png");
					$("#fastforward").attr("src", "img/ff.png");
				}
			} else if(cid.attr("id")=="pause")
			{
				console.log(obj.result.speed);
				if(obj.result.speed == 0){
					$("#pause").attr("src","img/play.png");
					$("#pause").attr("id", "play");
				}
			}
			if(cid.attr("id")=="rewind" || cid.attr("id")=="fastforward"){
				console.log("rewind");
				if(cid.attr("id")=="rewind"){
					cid.attr("src", "img/rwred.png");
				} else if(cid.attr("id")=="fastforward"){
					cid.attr("src", "img/ffred.png");
				}
				$("#play").attr("src","img/play.png");
				$("#pause").attr("src","img/play.png");
				$("#play").attr("id", "play");
				$("#pause").attr("id", "play");
			}
		}).fail(function() {
			console.log( "error" );
		});
	});
});