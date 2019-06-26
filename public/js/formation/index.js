$(document).ready(function () {

	$(".periodeBox").on("click", function () {
		var id = "#periodeBox" + $(this).attr("id");
		// console.log($(this).css("right"));
		if ( $(this).css("right") > "0px" ){
			$(this).css("right", "0px");
		}
		else{
			$(this).css("right", "80%");
		}
	});
});