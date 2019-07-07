$(document).ready(function () {
	window.new_prerequis_compter = 1;

	function update_prerequis() {
		var selected_option = $("#prerequis option"),
			new_val = "";
		
		for (var opt of selected_option) {
			if ( $(opt).val().includes("new") ){
				new_val += ("___" + $(opt).text());
			}else{
				new_val += ("___" + $(opt).val());
			}
		}
		$("input[name='prerequis']").val(new_val);
	}

	$("#btn__autre").on("click", function () {
		$("#input_autre").show();
		$("#btn_new_add").show();
	});

	$("#btn__add").on("click", function () {
		var comp_val = $("#prerequis_choice").val();
		var comp_text = $("#prerequis_choice option[value='" + comp_val + "']").text();


		var selected_option = $("#prerequis option"),
			selected_array = [];
		
		for (var opt of selected_option) {
			selected_array.push($(opt).val());
		}

		if ( selected_array.includes(comp_val) ){

		}else{
			$("input[name='prerequis']").val($("input[name='prerequis']").val() + "___" + comp_val);

			$("#prerequis").append("<option value='"+ comp_val +"'>" + comp_text + "</option>");
		}
	});

	$("#btn_new_add").on("click", function () {
		var comp_text = $("#input_autre").val();
		var comp_val = "new_" + window.new_prerequis_compter;
		window.new_prerequis_compter += 1;

		if (comp_text != "") {
			$("input[name='prerequis']").val($("input[name='prerequis']").val() + "___" + comp_text);
			$("#prerequis").append("<option value='"+comp_val+"'>" +comp_text+ "</option>");

			$("#input_autre").val("");
		}else{
			$("#input_autre").css("outline", "2px solid red");
		}
	});

	$("#btn__remove").on("click", function () {
		var selected_options = $("#prerequis").val();
		for (var value of selected_options) {
			$("#prerequis").children('option[value="' + value + '"]').remove();
			update_prerequis();
		}
	});
});