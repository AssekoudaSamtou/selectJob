$(document).ready(function () {
	window.new_comptence = 1;

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
	});

	$("#btn__autre").on("click", function () {
		$("#input_autre").show();
		$("#btn_new_add").show();
	});

	$("#btn__add").on("click", function () {
		var comp_val = $("#experiences_choice").val();
		var comp_text = $("#experiences_choice option[value='" + comp_val + "']").text();


		var selected_option = $("#experiences option"),
			selected_array = [];
		
		for (var opt of selected_option) {
			selected_array.push($(opt).val());
		}

		if ( selected_array.includes(comp_val) ){

		}else{
			$("input[name='experiences']").val($("input[name='experiences']").val() + "___" + comp_val);

			$("#experiences").append("<option value='"+comp_val+"'>" +comp_text+ "</option>");
		}
	});

	$("#btn_new_add").on("click", function () {
		var comp_text = $("#input_autre").val();
		var comp_val = "new_" + window.new_comptence;
		window.new_comptence += 1;

		var added_options = $("#experiences option"),
			added_array = [];
		
		for (var opt of added_options) {
			added_array.push($(opt).text());
		}
		console.log("added_array");
		console.log(added_array);

		if (comp_text != "") {
			if (added_array.includes(comp_text)) {
				console.log("doublons");
			}else{
				$("input[name='experiences']").val($("input[name='experiences']").val() + "___" + comp_text);
				$("#experiences").append("<option value='"+comp_val+"'>" +comp_text+ "</option>");
				$("#input_autre").val("");
			}

		}else{
			$("#input_autre").css("outline", "2px solid red");
		}
	});

	$("#langues_choice").on("click", function () {
		// console.log($("#langues_choice").val());
		$('input[name="langues"]').val($("#langues_choice").val().join("___"));
	});
});