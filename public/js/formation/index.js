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

	$(".btn-inscrire").on("click", function () {
		var id = $(this).val();
		$("#btn-confirmer").val(id);
	});

	$("#btn-confirmer").on("click", function () {
		window.formation_id = $(this).val();

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/formations/suscribe",
			data   : {
						'formation'   : window.formation_id,
						'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				console.log(response);
				$("#formation_state" + window.formation_id).children('.btn-inscrire').css("display", "none");
				$("#formation_state" + window.formation_id).children('.btn-desinscrire').show();
			},

			error : function (status) {
				console.log(status);
				// $("#response_text").html(status.responseText);
			}
		})
	});

	$(".btn-desinscrire").on("click", function () {
		window.formation_id = $(this).val();

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/formations/unsuscribe",
			data   : {
						'formation'   : window.formation_id,
						'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				console.log(response);
				$("#formation_state" + window.formation_id).children('.btn-inscrire').show();
				$("#formation_state" + window.formation_id).children('.btn-desinscrire').css("display", "none");
			},

			error : function (status) {
				console.log(status);
				// $("#response_text").html(status.responseText);
			}
		})
	});
	
});