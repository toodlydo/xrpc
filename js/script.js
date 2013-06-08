/*
	File: script.js
*/
var i = 0;
var showid = 0;
var rurl=0;
var totaltv=0;

$( document ).ready(function() {
	/*
		space for jquery actions if needed
	*/
	//$('.active').toggleClass("active");
	//$("#mremote").addClass("active");
	//$("#mremote").parent().toggleClass("active");
	$("#cssmenu").on('click', "#mtv", function(){
		//alert("mtv");
		$('.container').load('tvshows.php');
		$('.active').toggleClass("active");
		$("#mtv").parent().toggleClass("active");
	});
	$("#cssmenu").on('click', "#mremote", function(){
		//$('.container').load('remote.php');
		//$('.active').toggleClass("active");
		//$("#mremote").parent().toggleClass("active");
		$('.remote').animate({left:Math.abs($('.remote').css("left").split("px")[0])-320}, 700);
	});
	$("#cssmenu").on('click', "#msystem", function(){
		$('.container').load('system.php');
		$('.active').toggleClass("active");
		$("#msystem").parent().toggleClass("active");
	});
	$("#cssmenu").on('click', "#mstream", function(){
		$('.container').load('stream.php');
		$('.active').toggleClass("active");
		$("#mstream").parent().toggleClass("active");
	});
	$(".container").on('click', "#fanart", function(){
		$("#browse").slideToggle("slow");
		$("#browse").scrollTop(0);
		$('#browse').load('browse.php?id='+window.showid+'&action=seasons');
	});
	$(".container").on('click',".season", function(){
		$("#browse").scrollTop(0);
		$('#browse').load('browse.php?id='+window.showid+'&action=episodes&season='+$(this).attr("id"));
	});
	$(".container").on('click',".episode", function(){
		$("#browse").scrollTop(0);
		$('#browse').load('browse.php?id='+window.showid+'&action=epdetails&episode='+$(this).attr("id"));
	});
	$(".container").on('click',"#up", function(){
		if($(".season")[0]==null && $(".episode")[0]!=null){
			$('#browse').load('browse.php?id='+window.showid+'&action=seasons');
		} else if($(".epd")[0]!=null){
			$('#browse').load('browse.php?id='+window.showid+'&action=episodes&season='+$(this).attr("class"));
		} else { //if($(".season")[0]!=null)
			$("#browse").slideToggle("slow");
		}
	});	
});

function loadpn(response, pn, x){
	$("#browse").hide();
	if(pn==0){
		window.i = x - 1;
		if(i==-1){
			window.i=0;
		}
	} else{
		window.i = x + 1;
		if(i >= totaltv - 1){
			window.i = totaltv - 1;
		}
	}
	console.log(x + ' -- '+ i);
	if(i < totaltv) {
		// Replace all bad chars. Could be more efficient.
		var obj = $.parseJSON((response.replace(/\\\",/g, "\",")).replace(/\r\n/g,"").replace(/\/\"/g, "\"").replace(/\\/g, "\\\\").replace(/ \"/g, " \\\"").replace(/\" /g, "\\\" ").replace(/. \\\",/g, ".\",").replace(/\", /g, "\\\", ").replace(/\(\"/g, "\(\\\", ").replace(/\"\)/g, "\\\"\)").replace(/\.\"\"/g, "\.\\\"\""));

		window.showid = obj.result.tvshows[i].tvshowid;
		
		//check whether there is any art before displaying them
		count = 0;
		for (var a in obj.result.tvshows[i].art) {
			if (obj.result.tvshows[i].art.hasOwnProperty(a)) {
				count++;
			}
		}
		console.log(count);
		if(count != 0){
			$("#banner").fadeOut(500, function(){$("#banner").attr("src", rurl + "image/image://" + encodeURIComponent(decodeURIComponent((obj.result.tvshows[i].art.banner).split("://")[1])).replace(/%/g, "%25"));}).fadeIn(500);
			$("#poster").fadeOut(500, function(){$("#poster").attr("src", rurl + "image/image://" + encodeURIComponent(decodeURIComponent((obj.result.tvshows[i].art.poster).split("://")[1])).replace(/%/g, "%25"));}).fadeIn(500);
			$("#fanart").fadeOut(500, function(){$("#fanart").attr("src", rurl + "image/image://" + encodeURIComponent((decodeURIComponent((obj.result.tvshows[i].art.fanart).split("://")[1])).replace("://","://www.")).replace(/%/g, "%25"));}).fadeIn(500);
		} else {
			console.log("no image")
			$("#banner").attr("src","img/noimage.png");
			$("#poster").attr("src","img/noimage.png");
			$("#fanart").attr("src","img/noimage.png");
		}
		$("#details #title").html("<p>" + obj.result.tvshows[i].label + "</p>");
		$("#year").html("<p>Year: " + obj.result.tvshows[i].year + "</p>");
		$("#rating").html("<p>Rating: " + obj.result.tvshows[i].rating.toFixed(1) + " </p>\n<div style=\"z-index: 1;\"><img style=\"z-index: 1;\" src=\"img/stars_empty.png\" /></div>\n<div style=\"z-index: 2; width:"+(obj.result.tvshows[x].rating.toFixed(1))*16+"px; overflow:hidden;\"> <img src=\"img/stars_full.png\" /></div>");
		$("#plot").html("<h3>Plot: </h3><p>" + obj.result.tvshows[i].plot + "</p>");
		$("#notv").html((i+1) + " /" + $("#notv").html().split("/")[1]);
		$("#stitle").html(obj.result.tvshows[i].label);
		$("#sgenre").html((obj.result.tvshows[i].genre).join(" / "));
		$("#sepno").html(obj.result.tvshows[i].episode + " epsiodes");
	}
}