
$(document).ready(function() {   

	$(".fi-icon-btn").click(function() {
		var name = $(".fi-input").val();

		 $.ajax({
		        url: "/chat",
		        dataType: 'json',
		        async: true,
		        type : "POST",
				data: {
				        "_token": "{{ csrf_token() }}",
				        "content": name,
				        "description": 'meta',
				        "model": "gpt-4"
				        },
		        success: function(result){
		        	$("#title").val(result.title);
		        	$("#slug").val(result.slug);
		        	$("textarea.fi-fo-textarea").val(result.choices[0].message.content);
		        },
		        error : function(error){

		        }
		  });

		 $.ajax({
		        url: "/chat",
		        dataType: 'json',
		        async: true,
		        type : "POST",
				data: {
				        "_token": "{{ csrf_token() }}",
				        "content": name,
				        "description": 'full',
				        "model": "gpt-4"
				        },
		        success: function(result){
		        	$(".CodeMirror").text(result.choices[0].message.content);
		        },
		        error : function(error){

		        }
		  });		 

	});  
})
