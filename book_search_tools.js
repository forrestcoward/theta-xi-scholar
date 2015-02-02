// A series of functions responsible for managing the books database. 
// Depends on condensed_table_tools.js, book.js

var ie;

Event.observe(window, 'load', function () {
	ie = getInternetExplorerVersion();
	if(ie == -1) {
		$("isbn_button").observe("click", getIsbn);
		$("mass_enter").observe("click", massEnter);
	} else {
		$("isbn_button").observe("click", ieError);
		$("mass_enter").observe("click", ieError);
	}
});

function ieError() {
	alert("This feature is disabled in Internet Explorer because Internet Explorer is broken. Switch to another browser!");
}

function ISBN10toISBN13(isbn10) {
	
	var sum = 38 + 3 * (parseInt(isbn10[0]) + parseInt(isbn10[2]) + parseInt(isbn10[4]) + parseInt(isbn10[6]) + parseInt(isbn10[8])) + parseInt(isbn10[1]) + parseInt(isbn10[3]) + parseInt(isbn10[5]) + parseInt(isbn10[7]);
	
	var checkDig = (10 - (sum % 10)) % 10;
	
	return "978" + isbn10.substring(0, 9) + checkDig;
}

function ISBN13toISBN10(isbn13) {
	
	var start = isbn13.substring(4, 12);
	var sum = 0;
	var mul = 10;
	var i;
	
	for(i = 0; i < 9; i++) {
		sum = sum + (mul * parseInt(start[i]);
		mul -= 1;
	}
	
	var mod = 11 - (sum % 11);
	if (mod == 10) {
		mod = "X";
	} else if (mod == 11) {
		mod = 0;
	}
	return start + mod;
}

var bookNotFoundError = "<strong>Book Not Found!</strong><br/><br/> This may be an error on my part. To check, try entering the isbn on the <a href='http://isbndb.com/'>ISBN Database</a>. If the isbn is found there, try searching for the same isbn again. If things still aren't working contact Forrest.<br/>";
var invalidISBNError = "<br><strong>Invalid ISBN Entered. Please try again.</strong><br/><br/>";
var addBookButton = '<button id="add_book">Yes, I own this book!</button>';

var book; // The current book being examined.
var runningQuery = false; // Prevent excessive requests when finding or importing a book. Default: false.
var addingBook = false; // Prevent excessive requests when adding book to library. Keep false.
var asynch = false; // Don't mess with this? Default: false.
var lock = true; // Don't mess with this?
var noLoad = false; // Determines if a book will be displayed after it is imported. Makes mass enter faster because of less ajax calls. 

// Button with id 'mass_enter' is linked to this button. 
function massEnter() {
	var items = document.getElementById("isbn_numbers");
	var lines = items.value.split("\n");
	for (var i = 0; i < lines.length; i++) {
		getIsbnSingleSite(lines[i]);
	}
}

// Button with id 'isbn_button' is linked to this button. Starts a series of ajax calls. 
function getIsbn() {
	var isbnNum = $("isbn_text").getValue();
	if(validateISBN(isbnNum)) {
		getIsbnSingleSite(isbnNum);
	} else {
		setBookQuestion(false, "", "");
		$("book_info").innerHTML = invalidISBNError;
		//$('loading').hide();
	}
}

// Displays and adds functionality to the add to library button. 
function setBookQuestion(show, title, isbn13) {
	if (show) {
		var newHtml = 'Add "<strong>' + title + '</strong>" to your library? ' + addBookButton;
		$("book_question").innerHTML = newHtml;
		$("add_to_collection").show();
		
		// Register the add book function onto the newly displayed button.
		$("add_book").observe("click", addBook);
	} else {
		$("add_to_collection").hide();
	}
}

// query_books_by_isbn.php returns xml data corresponding to a single book. This function knows how to parse such an xml result and print it into a nicely formatted html table. This is done by passing the xml to the book constructor. The result is setting the inner html of id "book_info" book.createTable().
function printBookQueryResult(result) {
	book = new Book(result);
	$("book_info").innerHTML = book.createTable();
	setBookQuestion(true, book.getTitle(), book.getIsbn13());
	$('loading').hide();
	runningQuery = false;
}

// Queries the local database for the presence of some ISBN. If the book is present, display it. Otherwise, call import the book in to the local database by calling ImportBook().
function getIsbnSingleSite(isbnNum) {
	if (!runningQuery || !lock) {
		runningQuery = true;
		new Ajax.Request('../txscholar/web_services/query_books_by_isbn.php', {
				method : 'get', 
				asynchronous : asynch, 
				parameters : {
					isbn : isbnNum
				}, 
				onCreate : function () {
					$('loading').show();
				}, 
				onSuccess : function (ajax_one) {
					var result = ajax_one.responseXML;
					if (result.childNodes[0].textContent != "Invalid ISBN!") {
						if (result.childNodes[0].childElementCount == 0) { // No book data found.
							ImportBook(isbnNum);
						} else {
							printBookQueryResult(result);
						}
					} else {
						$('loading').hide();
						$("book_info").innerHTML = invalidISBNError;
					    setBookQuestion(false, "", "");
					}
				}, 
				onFailure : ajaxFailure, 
				onExcepion : ajaxFailure, 
				onComplete : function () {
					runningQuery = false;
				}
			});
	}
}

// This function is called when a book is searched for that is not in the local database. The ajax call extracts information from www.lookupbyisbn.com and adds the book to the local database. Afterward, the book is searched for again in the local database and displayed on the page. The displaying afterward can be turned off by setting noLoad to true. This saves time during a mass load because an additional ajax call does not need to be made.

function ImportBook(isbnNum) {
	new Ajax.Request('../txscholar/web_services/extract_html_with_isbn_param.php', {
			method : 'get', 
			asynchronous : asynch, 
			parameters : {
				isbn : isbnNum, 
				remote_url : 'http://www.lookupbyisbn.com/itemDetail.aspx?type=Books&id='
			}, 
			onSuccess : function (ajax_one) {
				var myHTML = ajax_one.responseText;
				var tempDiv = document.createElement('html');
				tempDiv.innerHTML = myHTML;
				var y = tempDiv.getElementsByTagName("span");
				var title = y[1].textContent;
				var author = y[3].textContent;
				var publisher = y[4].textContent;
				var edition = y[7].textContent;
				var pubdate = y[5].textContent;
				var pages = y[10].textContent;
				var imageURL = "";
				var x = tempDiv.getElementsByTagName("img");
				if (x.length != 1) { // If x.length == 1, the image is not available. 
					imageURL = x[1].getAttribute("src"); // Otherwise retrieve the image url. 
				}
				
				new Ajax.Request('../txscholar/web_services/import_book.php', {
						method : 'post', 
						asynchronous : asynch, 
						parameters : {
							image_url : imageURL, 
							isbn : isbnNum, 
							title : title, 
							author : author, 
							publisher : publisher, 
							edition : edition, 
							pubdate : pubdate, 
							pages : pages
						}, 
						onFailure : ajaxFailure, 
						onExcepion : ajaxFailure, 
						onComplete : function () {
							if (!noLoad) {
								new Ajax.Request('../txscholar/web_services/query_books_by_isbn.php', {
										method : 'get',
										asynchronous : asynch, 
										parameters : {
											isbn : isbnNum
										}, 
										onSuccess : function (ajax_one) {
											var result = ajax_one.responseXML;
											if (result.childNodes[0].textContent != "Invalid ISBN!") {
												if (result.childNodes[0].childElementCount == 0) {
													$("book_info").innerHTML = bookNotFoundError;
													setBookQuestion(false, "", "");
												} else {
													printBookQueryResult(result);
												}
											} else {
												$("book_info").innerHTML = invalidISBNError;
												setBookQuestion(false, "", "");
											}
											if (Ajax.activeRequestCount === 1) {
												$('loading').hide();
											}
											runningQuery = false;
										}, 
										onFailure : ajaxFailure, 
										onExcepion : ajaxFailure, 
										onComplete : function () {
											$('loading').hide();
											runningQuery = false;
										}
									});
							} else {
								$('loading').hide();
								runningQuery = false;
							}
						}
					});
			}, 
			onException : function () {
				//alert("There was an error retrieving the book information.");
				$("book_info").innerHTML = bookNotFoundError;
				$('loading').hide();
				setBookQuestion(false, "", "");
			}, 
			onFailure : function () {
				//alert("There was an error retrieving the book information.");
				$("book_info").innerHTML = bookNotFoundError;
				$('loading').hide();
				setBookQuestion(false, "", "");
			}, 
		});
}

// This functions takes a string containing an ISBN (ISBN-10 or ISBN-13) and returns true if it's valid or false if it's invalid.
function validateISBN(isbn) {
	if(isbn.match(/[^0-9xX\.\-\s]/)) {
		return false;
	}

	isbn = isbn.replace(/[^0-9xX]/g,'');

	if(isbn.length != 10 && isbn.length != 13) {
		return false;
	}

		checkDigit = 0;
	if(isbn.length == 10) {
		checkDigit = 11 - ( (
								 10 * isbn.charAt(0) +
								 9  * isbn.charAt(1) +
								 8  * isbn.charAt(2) +
								 7  * isbn.charAt(3) +
								 6  * isbn.charAt(4) +
								 5  * isbn.charAt(5) +
								 4  * isbn.charAt(6) +
								 3  * isbn.charAt(7) +
								 2  * isbn.charAt(8)
								) % 11);

		if(checkDigit == 10) {
			return (isbn.charAt(9) == 'x' || isbn.charAt(9) == 'X') ? true : false;
		} else {
			return (isbn.charAt(9) == checkDigit ? true : false);
		}
	} else {
		checkDigit = 10 -  ((
								 1 * isbn.charAt(0) +
								 3 * isbn.charAt(1) +
								 1 * isbn.charAt(2) +
								 3 * isbn.charAt(3) +
								 1 * isbn.charAt(4) +
								 3 * isbn.charAt(5) +
								 1 * isbn.charAt(6) +
								 3 * isbn.charAt(7) +
								 1 * isbn.charAt(8) +
								 3 * isbn.charAt(9) +
								 1 * isbn.charAt(10) +
								 3 * isbn.charAt(11)
								) % 10);

		if(checkDigit == 10) {
			return (isbn.charAt(12) == 0 ? true : false) ;
		} else {
			return (isbn.charAt(12) == checkDigit ? true : false);
		}
	}
}


// When the user clicks yes to add a book to a library, this function is called. First it check to see if the book is already in the library. If it isn't, 1) the book is added to the user's library and 2) the user's library on the bottom of the page is updated in real time by appending an additional row to the condensed table.
function addBook() {
	$("add_to_collection").fade();
	if (!addingBook) {
		addingBook = true;
		new Ajax.Request('../txscholar/web_services/add_book.php', {
				method : 'post', 
				asynchronous : true, 
				parameters : {
					id : userid, 
					isbn13 : book.getIsbn13() 
				}, 
				onSuccess : function (ajax_one) {
					var response = ajax_one.responseText;
					if (response == 1) { // Success
					
						book.setHeader("Successfully added to your library!");
						$("book_info").innerHTML = book.createTable();
						$("book_info").highlight();
						
						x = $$(".condensed_user_book_table tbody");
						tr = document.createElement("tr");
						var td_isbn = document.createElement("td");
						td_isbn.innerHTML = book.getIsbn13();
						var td_title = document.createElement("td");
						td_title.innerHTML = book.getTitle();
						var td_author = document.createElement("td");
						td_author.innerHTML = book.getAuthor();
						var td_remove = document.createElement("td");
						tr.appendChild(td_isbn);
						tr.appendChild(td_title);
						tr.appendChild(td_author);
						tr.appendChild(td_remove);
						x[0].appendChild(tr);
						BookExtension();
						
					} else if (response == 2) { // Failure
						book.setHeader("This book is already in your library!");
						$("book_info").innerHTML = book.createTable();
						$("book_info").highlight();
					}
					addingBook = false;
				}, 
				onException : function () {
					alert("Failed to add book!");
					addingBook = false;
				}, 
				onFailure : function () {
					alert("Failed to add book!");
					addingBook = false;
				}
			});
	}
}

// Ajax failure code. On failure hides the loading animation and the add book to library question text and button.
function ajaxFailure(ajax, exception) {
	setBookQuestion(false, "", "");
	alert("Error making Ajax request:" + 
		"\n\nServer status:\n" + ajax.status + " " + ajax.statusText + 
		"\n\nServer response text:\n" + ajax.responseText);
	if (exception) {
		throw exception;
	}
	$('loading').hide();
	runningQuery = false;
}

// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
function getInternetExplorerVersion() {
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}