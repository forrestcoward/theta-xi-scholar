
var count;

Event.observe(window, 'load', function () {
	count = 1;
	$("moreFiles").observe("click", addFile);
	$("submit").observe("click", validateForm);
});

function addFile() {

	if(count < 30) {
		count++;
		var name = "userfile" + count;
		var dataContent = "pdf " + count + ":";	
		var row = document.createElement("tr");
		
		var td1 = document.createElement("td");
		td1.innerHTML = dataContent;
		
		var td2 = document.createElement("td");
	    var input = document.createElement("input");
		input.setAttribute('type', 'file');
		input.setAttribute('size', 50);
		input.setAttribute('name', name);
		td2.appendChild(input);
		
		row.appendChild(td1);
		row.appendChild(td2);
		
		$("upload_table").appendChild(row);
	}

	/*
	if(count < 30) {
		count++;
		var name = "userfile" + count;
		var input = document.createElement("input");
		input.setAttribute('type', 'file');
		input.setAttribute('size', 50);
		input.setAttribute('name', name);
		$("upload").appendChild(input);
	} */
}

function validateForm() {

	var emptyFiles = true;
	var inputs = $("upload").getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++) {
		if(inputs[i].value != "") {
			emptyFiles = false;
		}
	}
	if(emptyFiles) {
		alert("You must enter in at least 1 file to continue.");
		$("file_upload").setAttribute('onsubmit', 'return false');
		return;
	}
	
	var courseNum = $("course_num").value;
	if(!is_int(courseNum) || courseNum < 1) {
		alert("The course number is not a valid integer.");
		$("file_upload").setAttribute('onsubmit', 'return false');
		return;
	}
	$("file_upload").setAttribute('onsubmit', 'return true');
}

function is_int(value){ 
   for (i = 0 ; i < value.length ; i++) { 
      if ((value.charAt(i) < '0') || (value.charAt(i) > '9')) return false 
    } 
   return true; 
}