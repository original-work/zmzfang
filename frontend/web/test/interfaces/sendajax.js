function sendajax(url,params){ 
	$.ajax({type: "post",
					url: url,
					dataType: "json",
					data: params,
					success: function(jsonStr){
							var backdata = JSON.stringify(jsonStr); 
							$("#retcontent").html(backdata);
							$("#retcontent").css({color: "green"});
							},
					error: function(request, statuss, error){			  
							$("#retcontent").html(statuss+error);
							$("#retcontent").css({color: "green"});
							}
				});
};