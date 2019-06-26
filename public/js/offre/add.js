$(document).ready(function () {
	window.new_comptence = 1;

	$("#btn__autre").on("click", function () {
		$("#input_autre").show();
		$("#btn_new_add").show();
		$("#niveaux_choice_new").show();
	});

	$("#btn__add").on("click", function () {
		var comp_val = $("#competence_choice").val();
		var comp_text = $("#competence_choice option[value='" + comp_val + "']").text();

		var level_val = $("#niveaux_choice").val();
		var level_text = $("#niveaux_choice option[value='" + level_val + "']").text();

		var selected_option = $("#competences option"),
			selected_array = [];
		
		for (var opt of selected_option) {
			selected_array.push($(opt).val());
		}

		if ( selected_array.includes(comp_val) ){

		}else{
			$("input[name='competences']").val($("input[name='competences']").val() + "___" + comp_val);
			$("input[name='niveaux']").val($("input[name='niveaux']").val() + "___" + level_val);

			$("#competences").append("<option value='"+comp_val+"'>" +comp_text+ "</option>");
			$("#niveaux").append("<option value='"+ level_val + "'>" + level_text + "</option>");
		}
	});

	$("#btn_new_add").on("click", function () {
		var comp_text = $("#input_autre").val();
		var comp_val = "new_" + window.new_comptence;

		var level_val = $("#niveaux_choice_new").val();
		var level_text = $("#niveaux_choice_new option[value='" + level_val + "']").text();

		if (comp_text != "") {
			$("input[name='competences']").val($("input[name='competences']").val() + "___" + comp_text);
			$("input[name='niveaux']").val($("input[name='niveaux']").val() + "___" + level_val);

			$("#competences").append("<option value='"+comp_val+"'>" +comp_text+ "</option>");
			$("#niveaux").append("<option value='"+ level_val + "'>" + level_text + "</option>");
		}else{
			$("#input_autre").css("outline", "2px solid red");
		}
	});
});