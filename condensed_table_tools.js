// Depends on book_search.js, book.js

Event.observe(window, 'load', function () {
	BookExtension();
});

function BookExtension() {

	// 'condensed_book_table' corresponds to a condensed book information table where
	// the user does not have delete functionality. In such a table, for each row, the first data 
	// is isbn, the second data is title and the third data is author. This isbn is examined and used
	// to expand the table row.
	var f = $$(".condensed_book_table tr");
	for(var i = 1; i < f.length; i++) {
		if(i % 2 == 1) {
			f[i].addClassName("even");
		} else {
			f[i].addClassName("odd");
		}
		f[i].addClassName("condensed");
		// Add expanding functionality to first three data entries.
		f[i].children[0].observe("click", bookExpand);
		f[i].children[1].observe("click", bookExpand);
		f[i].children[2].observe("click", bookExpand);		
	}
	
	// 'condensed_user_book_table' corresponds to a condensed book information table
	// where the user has delete functionality. In such a table, for each row, the first data is isbn,
	// the second data is title, the third is author, and the fourth is empty until this procedure
	// is called. This procedure fills the fourth entry with a delete image which can be clicked
	// by the user to delete the book from his collection.
	var t = $$(".condensed_user_book_table tr");
	for(var i = 1; i < t.length; i++) {
		if(i % 2 == 1) {
			t[i].addClassName("even");
		} else {
			t[i].addClassName("odd");
		}
		t[i].addClassName("condensed");
		// Add expanding functionality to first three data entries.
		t[i].children[0].observe("click", bookExpand);
		t[i].children[1].observe("click", bookExpand);
		t[i].children[2].observe("click", bookExpand);		
		
		// Add the clickable image to the fourth data entry.
		if(t[i].children[3].childElementCount == 0) {
			var img_remove = document.createElement("img");
			img_remove.setAttribute('src', '../txscholar/images/remove.gif');
			t[i].children[3].appendChild(img_remove);
			img_remove.observe("click", deleteClick);
		}
	}
}

// Attaches to remove image in the condensed user table to
// add delete functionality.
function deleteClick() {
	var isbn = this.parentNode.parentNode.children[0].innerHTML;
	deleteBook(isbn, this);
}

// Attaches to three main table rows in the condensed user table to
// add expanding functionality.
function bookExpand() {
	var isbn = this.parentNode.children[0].innerHTML;
	toggleBookInfo(isbn, this.parentNode);
}

// Allows the user to delete books from their collection.
function deleteBook(isbn, element) {
	var parent = element.parentNode.parentNode;
	new Ajax.Request('../txscholar/web_services/delete_book.php', {
			method : 'post', 
			asynchronous : true, 
			parameters : {
				isbn : isbn,
				userid : userid
			}, 
			onSuccess : function () {
				parent.remove();
			}, 
			onFailure : ajaxFailure, 
			onExcepion : ajaxFailure
		});
}

// Allows user to click on an entry to display more information about the book in the condensed table. 
function toggleBookInfo(isbn, element) {
	new Ajax.Request('../txscholar/web_services/query_books_by_isbn.php', {
			method : 'get', 
			asynchronous : true, 
			parameters : {
				isbn : isbn
			}, 
			onSuccess : function (ajax_one) {
				var result = ajax_one.responseXML;
				if (result.childNodes[0].textContent != "Invalid ISBN!") {
					if (result.childNodes[0].childElementCount == 0) { // No book data found.
						alert("No book data found");
					} else {
						a_book = new Book(result);
						if(!element.classList.contains("condensed")) {
							element.removeClassName("expanded");
							element.addClassName("condensed");
							element.children[1].innerHTML = a_book.getTitle();
						} else {
							element.removeClassName("condensed");
							element.addClassName("expanded");
							
							// Format amount of information to display within an expanded condensed table row. 
							element.children[1].innerHTML = "<h2>"+a_book.getTitle()+"</h2><br/>" + a_book.getImageTag();
							//element.children[1].appendChild(button);
						}
					}
				}
			}, 
			onFailure : ajaxFailure, 
			onExcepion : ajaxFailure
		});
}

