$.post( $("#myForm").attr("action"),
        $("#myForm :input").serializeArray(),
		function(data){
		$("div#ack").html(data);
		});
		$("myForm".submit(function(){
		return false;
		});