$(document).ready(function() {
	var str = window.location.href;
	var n = str.lastIndexOf('/');
	var result = str.substring(n + 1);
	$("#results").load("pager", {"url":result});
	$("#results").on("click", ".page a", function (e){
		console.log('here');
		e.preventDefault();
		$("#loading-div").show();
		var page = $(this).attr("data-page");
		$("#results").load("pager",{"page":page, "url":result}, function(){
			$("#loading-div").hide();
		});
	});
});