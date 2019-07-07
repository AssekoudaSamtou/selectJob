$(document).ready(function () {
	window.new_prerequis_compter = 1;

	function level_index(value) {
		index = 0;
		var	children = $("#competences").children('option');
		console.log("VALUE " + value);

		for(var child of children) {
			if ( $(child).val() == value ) {
				console.log("INDEX " + index);
				break;
			}else {
				index += 1;
			}
		}

		return index;
	}

	function update_competences() {
		var selected_option = $("#competences option"),
			new_val = "";
		
		for (var opt of selected_option) {
			if ( $(opt).val().includes("new") ){
				new_val += ("___" + $(opt).text());
			}else{
				new_val += ("___" + $(opt).val());
			}
		}
		$("input[name='competences']").val(new_val);
	}

	function update_niveaux() {
		var selected_option = $("#niveaux option"),
			new_val = "";
		
		for (var opt of selected_option) {
			new_val += "___" + $(opt).val();
		}
		$("input[name='niveaux']").val(new_val);
	}

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
		var comp_val = "new_" + window.new_prerequis_compter;
		window.new_prerequis_compter += 1;

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

	$("#btn__remove").on("click", function () {
		var index, selected_options = $("#competences").val();
		for (var value of selected_options) {
			index = level_index(value);
			console.log(index);
			$("#niveaux").children('option').eq(index).remove();
			$("#competences").children('option[value="' + value + '"]').remove();
			update_competences();
			update_niveaux();
		}
	});
});