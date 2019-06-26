$(document).ready(function () {

	$("#next_step").on("click", function () {
		var current_step = parseInt($("#current_step").val()),
			next_step = current_step + 1;
			console.log('inner');
		
		if (current_step < 3) {
			$("#etape" + next_step).css("display", "block");
			$("#etape" + current_step).css("display", "none");
			$("#current_step").val(next_step);

			if (current_step == 2) {
				console.log("end");
				$("#next_step").css("display", "none");
				$('button[type="submit"]').css("display", "block");

				if ($('input:checked').val() == 'E') {
					
					$("#type_compte").val("E");

					$("#entreprise").css("display", "block");
					$("#particulier").css("display", "none");

					$("#particulier_nom").attr("required", false)
					$("#particulier_prenom").attr("required", false)
					$("#entreprise_nom").attr("required", true)

				}else if($('input:checked').val() == 'P') {

					$("#type_compte").val("P");
					
					$("#entreprise").css("display", "none");
					$("#particulier").css("display", "block");

					$("#particulier_nom").attr("required", true)
					$("#particulier_prenom").attr("required", true)
					$("#entreprise_nom").attr("required", false)
				}
			}
		}
	});

	$("#previous_step").on("click", function () {
		var current_step = parseInt($("#current_step").val()),
			previous_step = current_step - 1;
		
			console.log('inner');
		if (current_step > 1) {
			$("#etape" + previous_step).css("display", "block");
			$("#etape" + current_step).css("display", "none");
			$("#current_step").val(previous_step);
			$("#next_step").css("display", "block");
			$('button[type="submit"]').css("display", "none");
		}
	});

	$("#contactus-btn").on("click", function () {
		$.ajax({
			method : "post",
			url    : "",
			data   : {
						// 'nom' : nom,
					 },
			success : function ( response ) {

			},

			error : function (status) {
				
			}
		})
	})
});