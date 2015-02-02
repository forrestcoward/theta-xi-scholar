
Event.observe(window, 'load', function () {
	$("department").observe("change", selectClassNum);
	selectClassNum();
});

function selectClassNum() {
	var did = $("department").value;
	
	new Ajax.Request('../txscholar/web_services/select_course_nums.php', {
		method : 'get', 
		asynchronous : true, 
		parameters : {
			did : did, 
		}, 
		onSuccess : function (ajax_one) {
			x = $("course_num");
			if(x.hasChildNodes()) {
				while(x.childNodes.length >= 1) {
					x.removeChild(x.firstChild);
				}
			}
			
			// Append results to course number drop box.
			items = ajax_one.responseText;
			var lines = items.split("-");
			for(var i = 0; i < lines.length - 1; i++) {
				var option = document.createElement('option');
				option.value = lines[i];
				option.innerHTML = lines[i];
				$("course_num").appendChild(option);
			}

		}, 
		onException : function () {
			alert("Ajax Exception. Wtf? See Forrest.");
		}, 
		onFailure : function () {
			alert("Ajax failure. Wtf? See Forrest.");
		}
	});
}