/*
	File: script.js
*/
var i = 0;

$( document ).ready(function() {
	/*
		space for jquery actions if needed
	*/
});

function loadpn(response, pn, x){
	if(pn==0){
		window.i = x - 1;
	} else{
		window.i = x + 1;
	}
	// Replace all bad chars. Could be more efficient.
	var obj = $.parseJSON((response.replace(/\\\",/g, "\",")).replace(/\r\n/g,"").replace(/\/\"/g, "\"").replace(/\\/g, "\\\\").replace(/ \"/g, " \\\"").replace(/\" /g, "\\\" ").replace(/. \\\",/g, ".\",").replace(/\", /g, "\\\", ").replace(/\(\"/g, "\(\\\", ").replace(/\"\)/g, "\\\"\)").replace(/\.\"\"/g, "\.\\\"\""));

	$("#banner").fadeOut(100, function(){$("#banner").attr("src",decodeURIComponent((obj.result.tvshows[x].art.banner).split("://")[1]));}).fadeIn(100);
	$("#poster").fadeOut(100, function(){$("#poster").attr("src",decodeURIComponent((obj.result.tvshows[x].art.poster).split("://")[1]));}).fadeIn(100);
	$("#details #title").html("<p>" + obj.result.tvshows[x].label + "</p>");
	$("#year").html("<p>" + obj.result.tvshows[x].year + "</p>");
	$("#rating").html("<p>Rating: " + obj.result.tvshows[x].rating.toFixed(1) + " </p>\n<div style=\"z-index: 1;\"><img style=\"z-index: 1;\" src=\"img/stars_empty.png\" /></div>\n<div style=\"z-index: 2; width:"+(obj.result.tvshows[x].rating.toFixed(1))*16+"px; overflow:hidden;\"> <img src=\"img/stars_full.png\" /></div>");
	$("#plot").html("<h3>Plot: </h3><p>" + obj.result.tvshows[x].plot + "</p>");
	$("#fanart").fadeOut(100, function(){$("#fanart").attr("src",(decodeURIComponent((obj.result.tvshows[x].art.fanart).split("://")[1])).replace("://","://www."));}).fadeIn(100);
	$("#stitle").html(obj.result.tvshows[x].label);
	$("#sgenre").html((obj.result.tvshows[x].genre).join(" / "));
	$("#sepno").html(obj.result.tvshows[x].episode + " epsiodes");
}