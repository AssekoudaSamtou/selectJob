$(document).ready(function () {

	$(".btn-desinscrire-formation").on("click", function () {
		window.formation_id = $(this).val();
		console.log("not deleted");

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/formations/unsuscribe",
			data   : {
						'formation'   : window.formation_id,
						'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				$("#formation_row" + window.formation_id).remove();
				console.log("deleted");
			},

			error : function (status) {
				console.log(status);
			}
		})
	});
	
	$(".btn-desinscrire-offre").on("click", function () {
		window.offre_id = $(this).val();
		console.log("not deleted");

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/offres/unsuscribe",
			data   : {
						'offre'   : window.offre_id,
						'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				$("#offre_row" + window.offre_id).remove();
				console.log("deleted");
			},

			error : function (status) {
				console.log(status);
			}
		})
	});

	$(".btn-delete-formation").on("click", function () {
		window.formation_id = $(this).val();
		console.log("not deleted");

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/formations/delete",
			data   : {
						'formation'   : window.formation_id,
						// 'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				$("#formation_row" + window.formation_id).remove();
				console.log("deleted");
			},

			error : function (status) {
				console.log(status);
			}
		})
	});

	$(".btn-delete-offre").on("click", function () {
		window.offre_id = $(this).val();
		console.log("not deleted");

		$.ajax({
			method : "post",
			url    : "http://127.0.0.1:8000/offres/delete",
			data   : {
						'offre'   : window.offre_id,
						// 'particulier' : $("#particulier").val(),
					 },
			success : function ( response ) {
				$("#offre_row" + window.offre_id).remove();
				console.log("deleted");
			},

			error : function (status) {
				console.log(status);
			}
		})
	});

	
});