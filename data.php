<?php

$data["enter_title"] = "U.W. Theta Xi Scholarship Center";
$data["enter_web_title"] = "Scholarship Center";
$data["enter_page_name"] = "enter.php";
$data["tx_logo_name"] = "../txscholar/images/coatofarms_small.jpg";
$data["access_denied_page_name"] = "access_denied.php";
$data["login_required_page_name"] = "login_required.php";
$data["contact_email"] = "forrest-coward@comcast.net";
$data["user_redirect"] = "home.php";
$data["base_url"] = "http://www.uwthetaxi.com/txscholar/";

// Overall website
$data["website_header"] = "Scholarship Center";
$data["website_banner"] = "../txscholar/images/TXLogo.png";

// Book Search Page
$data["book_search_title"] = "Add Books";
$data["book_search_url"] = "addbooks.php";
$data["book_search_url_full"] = $data["base_url"].$data["book_search_url"];

// Library
$data["library_url"] = "library.php";
$data["library_title"] = "Library Search";
$data["library_url_full"] = $data["base_url"].$data["library_url"];


// Statistics
$data["statistics_url"] = "statistics.php";
$data["statistics_title"] = "Statistics";
$data["statistics_url_full"] = $data["base_url"].$data["statistics_url"];

// Home
$data["home_url"] = "home.php";
$data["home_title"] = "Home";
$data["home_url_full"] = $data["base_url"].$data["home_url"];
$data["home_folder"] = "home";

$homenav = array("Home", $data["home_url_full"]."?page=0", $data["home_folder"]."/default.php",
				 "My Profile", $data["home_url_full"]."?page=1", $data["home_folder"]."/profile.php",
				 "Website Todo List", $data["home_url_full"]."?page=2", $data["home_folder"]."/todo.php",
				 "Study Tables (Autumn 2011)", $data["home_url_full"]."?page=3", $data["home_folder"]."/studytables.php",
				 "Sample ISBN Numbers", $data["home_url_full"]."?page=4", $data["home_folder"]."/sample_isbn.php");
				 

// Document Upload
$data["upload_path"] = '/home2/uwthetax/txscholar_data/documents/';
$data["pdf_upload_url"] = "pdf_upload.php";
$data["document_upload_url"] = "upload.php";
$data["document_upload_title"] = "Test Bank";
$data["document_upload_full"] = $data["base_url"].$data["document_upload_url"];

// Test Bank/Search
$data["test_search_url"] = "test_search.php";
$data["test_search_title"] = "Test Search";
$data["test_search_full"] = $data["base_url"].$data["test_search_url"];

// Navigation Bar (url/title)
$navbar = array($data["home_url"], $data["home_title"] ,$data["book_search_url"], "Add Books", $data["library_url"], "Library", $data["document_upload_url"], "Test Upload", $data["test_search_url"], "Test Bank", $data["statistics_url"], "Statistics");


?>