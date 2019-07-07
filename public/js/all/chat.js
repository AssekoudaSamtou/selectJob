function loadDiscussions(exp, dest) {
	$("#___you___").val(dest);
	console.log("loading...");

	$.ajax({
		method : "get",
		url    : "http://127.0.0.1:8000/__discussions",
		data   : {
					'expediteur'   : exp,
					'destinataire' : dest,
				 },
		success : function ( response ) {
			// console.log(response);
			$("#chat_ul").html(response);
		},

		error : function (status) {
			console.log(status);
		}
	})
}
$(document).ready(function(){

	var me = {};
	var you = {};
	if ($("#___utilisateur___").val() == "P"){
		me.avatar = "/img/user.png";
		you.avatar = "/img/building.png";
	}else{
		me.avatar = "/img/building.png";
		you.avatar = "/img/user.png";
	}

	function formatAMPM(date) {
		var hours = date.getHours();
		var minutes = date.getMinutes();
		var ampm = hours >= 12 ? 'PM' : 'AM';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0'+minutes : minutes;
		var strTime = hours + ':' + minutes + ' ' + ampm;
		return strTime;
	}            

	//-- No use time. It is a javaScript effect.
	function insertChat(who, text, time){
		if (time === undefined){
			time = 0;
		}
		var control = "";
		var date = formatAMPM(new Date());
		
		if (who == "me"){
			control = '<li style="width:100%">' +
							'<div class="msj macro">' +
							'<div class="avatar"><img class="img-circle" style="width:100%;" src="'+ me.avatar +'" /></div>' +
								'<div class="text text-l">' +
									'<p>'+ text +'</p>' +
									'<p><small>'+date+'</small></p>' +
								'</div>' +
							'</div>' +
						'</li>';                    
		}else{
			control = '<li style="width:100%;">' +
							'<div class="msj-rta macro">' +
								'<div class="text text-r">' +
									'<p>'+text+'</p>' +
									'<p><small>'+date+'</small></p>' +
								'</div>' +
							'<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="'+you.avatar+'" /></div>' +                                
					  '</li>';
		}
		setTimeout(
			function(){                        
				$("#chat_ul").append(control).scrollTop($("#chat_ul").prop('scrollHeight'));
			}, time);
	}

	function resetChat(){
		$("#chat_ul").empty();
	}


	$(".mytext").on("keydown", function(e){
		if (e.which == 13){
			var text = $(this).val();
			if (text !== ""){
				$.ajax({
					method : "post",
					url    : "http://127.0.0.1:8000/__discussions/new_msg",
					data   : {
								'expediteur'   : $("#___me___").val(),
								'destinataire' : $("#___you___").val(),
								'msg'          : text,
							 },
					success : function ( response ) {
						console.log(response);
						$("#chat_ul").html(response);
					},

					error : function (status) {
						console.log(status);
					}
				})
				// insertChat("me", text);
				$(this).val('');
			}
		}
	});

	$("#msg_init").on("click", function(e){
		$("#msg_container").toggle();
		console.log(e);
	});

	$('#send__btn').click(function(){
		$(".mytext").trigger({type: 'keydown', which: 13, keyCode: 13});
	})

	//-- Clear Chat
	// resetChat();

	//-- Print Messages
	// insertChat("me", "Hello Tom...", 0);
	// insertChat("you", "Hi, Pablo", 1500);
});