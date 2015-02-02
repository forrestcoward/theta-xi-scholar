<?php 
	include 'access_control.php';
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?php $data['document_upload_title']?></title>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<script src="../txscholar/required_scripts/prototype_1.61.js" type="text/javascript"></script>
		<script src="../txscholar/required_scripts/scriptaculous.js" type="text/javascript"></script>
		<script src="pdf_file_add.js" type="text/javascript"></script>
		<script type="text/javascript">
			var userid = "<?php echo $id; ?>";
		</script>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen,projection" />
</head>
 
<body>

<div id="wrapper">
<div id="innerwrapper">

		<div id="header">
				<img src="<?php echo $data['website_banner']; ?>" alt="TXLogo" /><br />
				<h1><?php echo $data['website_header']; ?></h1>
				
				<ul id="nav">
					<?php generateNav($navbar, 3); ?>
				</ul>
				
				<ul id="subnav">
					<?php checkOnline(); ?>
				</ul> 
		</div>
		
		<div id="sidebar">
		
		<h3>Upload Integrity</h3><br /><br />
		<div> This portion of the site allows you to upload pdfs into the test bank. Please, please, please, use integrity when using this tool. I cannot monitor everything that is uploaded and nothing is stopping you from uploading bogus documents. It is up to you to make this tool useful.
		
		<br/><br/>
		<strong>Note: </strong>Once your document has been uploaded, you will not have power to edit or remove it.
		</div><br /> 
		
		<h3>Combining PDFs</h3><br /><br />
		<div> I have provided a pdf merging tool to combine scans of different test pages. Click the plus button to add more pdfs. The final pdf you upload is the combination of documents you provide in order. <br />
		</div><br />
		
		<h3>Other PDF Concatenation Tools: </h3><br />
			<ul class="subnav">
					<li><a href="http://www.pdfmerge.com/"><b>&raquo;</b>- pdfMerge.com</a></li>
					<li><a href="http://foxyutils.com/mergepdf/"><b>&raquo;</b>- FoxyUtils pdf merge</a></li>
					<li><a href="http://www.pdfsam.org/"><b>&raquo;</b>- pdfsam.org</a></li>
					<li><a href="http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/"><b>&raquo;</b>- PDKTK (CLI pdf merger)</a></li>	
			</ul>
	
		</div>
	
		<div id="contentnorightbar">
			
			<h1><?php echo $data['document_upload_title']; ?></h1>
			<br/>
			<br/>
			
			<!-- Upload form. -->
			<h2>File Upload</h2>
			<form id="file_upload" onsubmit="" action="<?php echo $data["pdf_upload_url"]; ?>" method="post" enctype="multipart/form-data" >
			
			<div>
				Select pdfs to concatenate into a single pdf:
				<table id="upload_table">
				<tr><td>pdf 1:</td><td><input size="50" type="file" name="userfile1"/></td></tr>
				</table>
			</div>
			
			<!--
			<div>
				Select pdfs to concatenate into single pdf:
				<div id="upload">
				pdf 1: <input size="50" type="file" name="userfile1"/><br />
				</div>
			</div>
			-->
			
			<div>
				<a id="moreFiles"><img id="plusIcon" src="../txscholar/images/plus_button.jpg" alt="+" width="15" height="15" /> Add Additional Files</a><br/><br/>
			</div>
			
			<table>
			<tr>
				<td>Course Department:</td>
				<td>
				<select name="course" class="major" size="1">
					<?php include '../txscholar/web_services/department_selector.php'; ?>

				</select> 
				</td>
			<tr>
			
			<tr>
				<td>Course Number:</td>
				<td>
				<input id="course_num" name="course_num" type="text"/>
				</td>
			</tr>
			
			<tr>
				<td>Year:</td>
				<td>
				<select name="year" class="test_bank_menu" size="1">
					<?php include '../txscholar/web_services/year_selector.php'; ?>
				</select>
				</td>
			</tr>
			
			<tr>
				<td>Document Type:</td>  
				<td>
				<select name="doctype" class="test_bank_menu" size="1">
					<option value="final">Final</option>
					<option value="midterm">Midterm</option>
					<option value="quiz">Quiz</option>
					<option value="other">Other</option>
				</select>
				</td>
			</tr>
			
			<tr>
				<td>Term:</td>
				<td>
				<select name="term" class="test_bank_menu" size="1">
					<option value="autumn">Autumn</option>
					<option value="winter">Winter</option>
					<option value="spring">Spring</option>
					<option value="summer">Summer</option>
					<option value="none">Unknown</option>
				</select>
				</td>
			</tr>
			
			<tr>
				<td>Difficulty:</td>
				<td>
				<select name="difficulty" class="test_bank_menu" size="1">
					<option value="0">Unknown</option>
					<option value="1">1 - Very Easy</option>
					<option value="2">2</option>
					<option value="3">3 - Average</option>
					<option value="4">4</option>
					<option value="5">5 - Very Difficult</option>
				</select>
				</td>
			</tr>
			
			<tr>
				<td>Blank document?</td>
				<td>
				<select name="completed" class="test_bank_menu" size="1">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</tr>
			</table><br />
			
			<div>
				Comments (professor, allotted time, your grade, average grade, corrections, etc): <br />
				<textarea name="comments" rows="10" cols="80"></textarea><br/>
			<br />
			</div>
			
			<div>
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input id="submit" type="submit" value="Submit"/> <br />  
			</div>
			
			</form>  

		</div>
		
		<div id="footer">
		 	<?php generateFooter(); ?>
		</div>
		
</div>
</div>


</body>
</html>