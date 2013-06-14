/*
	File: script.js
*/
var i = 0;
var showid = 0;
var rurl = 0;
var totalv = 0;
var oldvalues = [];
var sendarray = [];

$(document).ready(function () {
    $("#cssmenu").on('click', "#mtv", function () {
        $('.container').load('tvshows.php?i=0');
        $('.active').toggleClass("active");
        $("#mtv").parent().toggleClass("active");
    });
    $("#cssmenu").on('click', "#mmovie", function () {
        $('.container').load('movies.php?i=0');
        showid = 1;
        i = 0;
        $('.active').toggleClass("active");
        $("#mmovie").parent().toggleClass("active");
    });
    $("#cssmenu").on('click', "#mremote", function () {
        $('.remote').animate({
                left: Math.abs($('.remote').css("left").split("px")[0]) - 320
            }, 500);
    });
    $("#cssmenu").on('click', "#msystem", function () {
        $('.container').load('system.php');
        $('.active').toggleClass("active");
        $("#msystem").parent().toggleClass("active");
    });
    $("#cssmenu").on('click', "#mstream", function () {
        $('.container').load('stream.php');
        $('.active').toggleClass("active");
        $("#mstream").parent().toggleClass("active");
    });
    $(".container").on('click', "#fanart", function () {
        if ($("#fanart").attr("class") == "ftvshow") {
            if ($(".epd")[0] == null && $(".episode")[0] == null) {
                $('#browse').load('browse.php?id=' + window.showid + '&action=seasons');
            }
            $("#browse").slideToggle("slow");
            $("#browse").scrollTop(0);
        } else if ($("#fanart").attr("class") == "fmovie") {
            $('#browse').load('browse.php?id=' + window.showid + '&action=movie');
            $("#browse").slideToggle("slow");
            $("#browse").scrollTop(0);
        }
    });
    $(".container").on('click', ".season", function () {
        $("#browse").scrollTop(0);
        $('#browse').load('browse.php?id=' + window.showid + '&action=episodes&season=' + $(this).attr("id"));
    });
    $(".container").on('click', ".episode", function () {
        $("#browse").scrollTop(0);
        $('#browse').load('browse.php?id=' + window.showid + '&action=epdetails&episode=' + $(this).attr("id"));
    });
    $(".container").on('click', "#up", function () {
        if ($(this).parent().parent().parent().attr("class") == "vedit") {
            $("#edit").slideToggle("slow");
        } else {
            if ($(".season")[0] == null && $(".episode")[0] != null) {
                $('#browse').load('browse.php?id=' + window.showid + '&action=seasons');
            } else if ($(".epd")[0] != null) {
                $('#browse').load('browse.php?id=' + window.showid + '&action=episodes&season=' + $(this).attr("class"));
            } else {
                $("#browse").slideToggle("slow");
            }
        }
    });
    $(".container").on('click', "#vedit", function () {
        $('#edit').load("edit.php?id="+showid);
        $('#edit').slideToggle("slow");
    });
    $('.container').on('click', '.editcheck', function () {
        if (!$(this).is(':checked')) {
            for (var i = 0; i < oldvalues.length; i++) {
                if (oldvalues[i]["id"] == $(this).attr("name")) {
                    console.log(oldvalues[i]["value"]);
                    $(this).next().html(oldvalues[i]["value"]);
                    continue;
                }
            }
        } else {
            var found = false;
            for (var i = 0; i < oldvalues.length; i++) {
                if (oldvalues[i]["id"] == $(this).attr("name")) {
                    console.log(oldvalues[i]["value"]);
                    $(this).next().html(oldvalues[i]["value"]);
                    found = true;
                    continue;
                }
            }
            if (!found) {
                oldvalues.push({
					id: $(this).attr("name"),
					value: $(this).next('p').text()
				});
            }
            if ($(this).attr("name") == "plot") {
                $(this).next().html("<textarea id=\"" + $(this).attr("name") + "\" type=\"text\" rows=\"4\" cols=\"20\" style=\"width:90%;\">" + $(this).next('p').text() + "</textarea>");
            } else {
                $(this).next().html("<input id=\"" + $(this).attr("name") + "\" type=\"text\" value=\"" + $(this).next('p').text() + "\" style=\"width:90%;\" >");
            }
        }
    });
    $('.container').on('click', '#confirmedit', function () {
        if (confirm('Are you sure you want to save? It cannot be undone!')) {
			$('.editcheck').each(function(index){
				if($(this).is(':checked')){
					//alert($(this).attr("name"));
					//alert($(this).next('p').children().val());
					sendarray.push({
						id: $(this).attr("name"),
						value: $(this).next('p').children().val()
					});
				}
			});
			var objecta = {
				param1:JSON.stringify(sendarray)
			};
			var recursiveEncoded = $.param(objecta);

			$('#edit').load("inputExecuteAction.php?action=editmeta&id="+showid+"&"+decodeURIComponent(recursiveEncoded));
			alert("Click on Movies to refresh the content.")
            $('.container').load('movies.php?i=' + i);
        } else {
            alert("Cancelled");
        }
    });
});

function loadpn(response, pn, x) {
    var v = "t";
    $("#browse").hide();
    $('#browse').html("");
    if (pn == 0) {
        window.i = x - 1;
        if (i == -1) {
            window.i = 0;
        }
    } else {
        window.i = x + 1;
        if (i >= totalv - 1) {
            window.i = totalv - 1;
        }
    }
    console.log(x + ' -- ' + i);
    if (i < totalv) {
        // Replace all bad chars. Could be more efficient.
        var obj = $.parseJSON((response.replace(/\\\",/g, "\",")).replace(/\r\n/g, "").replace(/\/\"/g, "\"").replace(/\\/g, "\\\\").replace(/ \"/g, " \\\"").replace(/\" /g, "\\\" ").replace(/. \\\",/g, ".\",").replace(/\", /g, "\\\", ").replace(/\(\"/g, "\(\\\", ").replace(/\"\)/g, "\\\"\)").replace(/\.\"\"/g, "\.\\\"\""));
        var video = "";
        if (obj.result.tvshows != null) {
            v = "t";
            video = obj.result.tvshows;
            window.showid = video[i].tvshowid;
            $("#fanart").attr("class", "ftvshow");
        } else {
            v = "m";
            video = obj.result.movies;
            window.showid = video[i].movieid;
            $("#fanart").attr("class", "fmovie");
        }

        //check whether there is any art before displaying them
        count = 0;
        for (var a in video[i].art) {
            if (video[i].art.hasOwnProperty(a)) {
                count++;
            }
        }
        console.log(count);
        if (count != 0) {
            if (v == "t") {
                if (typeof (video[i].art.banner) != 'undefined') {
                    $("#banner").fadeOut(500, function () {
                        $("#banner").attr("src", rurl + "image/image://" + encodeURIComponent(decodeURIComponent((video[i].art.banner).split("://")[1])).replace(/%/g, "%25"));
                    }).fadeIn(500);
                } else {
                    $("#banner").attr("src", "img/banner.jpg");
                }
            }
            if (typeof (video[i].art.poster) != 'undefined') {
                $("#poster").fadeOut(500, function () {
                    $("#poster").attr("src", rurl + "image/image://" + encodeURIComponent(decodeURIComponent((video[i].art.poster).split("://")[1])).replace(/%/g, "%25"));
                }).fadeIn(500);
            } else {
                $("#poster").attr("src", "img/poster.jpg");
            }
            if (typeof (video[i].art.fanart) != 'undefined') {
                $("#fanart").fadeOut(500, function () {
                    $("#fanart").attr("src", rurl + "image/image://" + encodeURIComponent((decodeURIComponent((video[i].art.fanart).split("://")[1])).replace("://", "://www.")).replace(/%/g, "%25").replace(/www./g, ""));
                }).fadeIn(500);
            } else {
                $("#fanart").attr("src", "img/fanart.jpg");
            }
        } else {
            console.log("no image")
            if (v == "t") {
                $("#banner").attr("src", "img/noimage.png");
            }
            $("#poster").attr("src", "img/noimage.png");
            $("#fanart").attr("src", "img/noimage.png");
        }
        $("#details #title").html("<p>" + video[i].label + "</p>");
        $("#year").html("<p>Year: " + video[i].year + "</p>");
        $("#rating").html("<p>Rating: " + video[i].rating.toFixed(1) + " </p>\n<div style=\"z-index: 1;\"><img style=\"z-index: 1;\" src=\"img/stars_empty.png\" /></div>\n<div style=\"z-index: 2; width:" + (video[i].rating.toFixed(1)) * 16 + "px; overflow:hidden;\"> <img src=\"img/stars_full.png\" /></div>");
        $("#plot").html("<h3>Plot: </h3><p>" + video[i].plot + "</p>");
        $("#notv").html((i + 1) + " /" + $("#notv").html().split("/")[1]);
        $("#stitle").html(video[i].label);
        $("#sgenre").html((video[i].genre).join(" / "));
        $("#sepno").html(video[i].episode + " epsiodes");
    }
}