# theta-xi-scholar
Fraternity website for uploading and querying university exam documents (and more)

This is code I wrote years ago in college after I promised to create a website for my fraternity. 

This was my first time writing html, css, php, javascript, and was my first experience managing a live website.

The website has two main functionalities:

1. Users can upload test documents (midterms, final exams etc.), which can then be queried (and downloaded) based on class or professor etc. Multiple page documents, once submitted, are merged together into one pdf for download. Prior to this tool, the fraternity had a large storage cabinet filled with test documents. This was not ideal because only one person could use each document at a time (and come finals, everybody wants the same document), and you coulddnot access the documents remotely for studying, say, from the library.

2. Users can add textbooks to their book collection so other members of the fraternity know which textbooks everybody owns. This helps members discover textbooks they could borrow instead of buy. Books are added by their ISBN number, and I wrote a service to scrape relevant book information (cover image, author etc.) based on the ISBN, which I upload to a books database.
