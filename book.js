// The book class. Constructor takes an xml response from 'query_books_by_isbn' and parses it into the fields.
function Book(result) {
	var books = result.childNodes[0].childNodes;
	for (var i = 0; i < books.length; i++) {
		var bInfo = new Array();
		var index = 0;
		bInfo[index++] = books[i].attributes[0].nodeValue;
		bInfo[index++] = books[i].attributes[1].nodeValue;
		bookInfo = books[i].childNodes;
		for (var j = 0; j < bookInfo.length; j++) {
			bInfo[index++] = bookInfo[j].textContent;
		}
		this.isbn13 = bInfo[0];
		this.isbn10 = bInfo[1];
		this.title = bInfo[2];
		this.pubDate = "N/A";
		if (bInfo[3] != "") {
			this.pubDate = bInfo[3];
		}
		this.author = "N/A";
		if(bInfo[4] != "") {
			this.author = bInfo[4];
		}
		this.publisher = bInfo[5];
		
		if (bInfo[6] == "") {
			bInfo[6] = "Image Unavailable";
		}
		this.image_tag = '<img src="' + bInfo[6] + '" alt="' + "Image Unavailable" + '" /><br/>';
		this.image_src = bInfo[6];
		this.edition = bInfo[7];
		if (bInfo[7] == "") {
			this.edition = "N/A";
		}
		this.pages = bInfo[8];
		if (bInfo[8] == "") {
			this.pages = "N/A";
		}
		this.header = "Book Found!";
	}
}

// Uses the book fields to create a nice table. 
Book.prototype.createTable = function () {

	var large_title = "<h2 class='book_cover'><strong>" + this.title + "</strong></h2><hr>"
		var html = "<h1>" + this.header + "</h1><br/><table><tr><td width=170 align='center'>" + this.image_tag + "</td><td>";
	html += large_title;
	
	var innerTable = "<table align='left' width=360>" + 
		"<tr><td><strong>ISBN-13:</strong></td><td>" + this.isbn13 + "</td><tr>" + 
		"<tr><td><strong>ISBN-10:</strong></td><td>" + this.isbn10 + "</td><tr>" + 
		"<tr><td><strong>Author:</strong></td><td>" + this.author + "</td><tr>" + 
		"<tr><td><strong>Publisher:</strong></td><td>" + this.publisher + "</td><tr>" + 
		"<tr><td><strong>Date:</strong></td><td>" + this.pubDate + "</td><tr>" + 
		"<tr><td><strong>Edition:</strong></td><td>" + this.edition + "</td><tr>" + 
		"<tr><td><strong>Pages:</strong></td><td>" + this.pages + "</td><tr></table>";
	html += innerTable;
	html += "</td></tr></table>";
	return html;
};

Book.prototype.getIsbn13 = function () {
	return this.isbn13;
}

Book.prototype.getAuthor = function () {
	return this.author;
}

Book.prototype.getTitle = function () {
	return this.title;
}

Book.prototype.setHeader = function (header) {
	this.header = header;
}

Book.prototype.getImageSrc = function () {
	return this.image_src;
}

Book.prototype.getImageTag = function () {
	return this.image_tag;
}
 