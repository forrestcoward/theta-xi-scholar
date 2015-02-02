<h1>Todo List</h1>

<p> There are still a lot of things to get done... (created 8/30/2011) </p>
<div>

	<h2>Site Security and Input Validation</h2>
	<p>
		- Prevent any possible SQL injection in any query string or search box. I'm sure I'm missing it somewhere.
		<br/>
		- If you know what this is and how it works, try to break the site and report to me.
		<br/>
		- Validate all user input and catch things like empty strings and negative numbers.
	</p>

	<h2>Enter Page</h2>
	<p>
		<?php greenCheck(); ?>Restyle the enter page to fit with the styling of the rest of the site. (Completed 8/31/2011)
	<p>
	
	<h2>User Profile Page</h2>
	<p>
		- Allow users to edit information about themselves including phone, email, and a small bio, as well as pieces of information.
		<br/>
		- User profile should display their books and uploaded documents.
		<br/>
		- Users should be able to alter information about tests they upload for a month after they are uploaded.
		<br/>
		<?php greenCheck(); ?> Clicking on a user name on the site like the 'Owned By' column should go to that user's profile page. (Completed 8/31/2011)
		<br/>
	</p>
	
	<h2>Books</h2>
	<p>
	    <?php greenCheck(); ?> Make sure ISBN validation is working properly. (Completed 8/31/2011)
		<br/>
	    <?php greenCheck(); ?> For each book, allow user to click on that book to link to a more detailed page on that book. (Completed 8/31/2011)
		<br/>
		<?php greenCheck(); ?> Add recent book activity on left side of add books page. (Completed 8/31/2011)
	</p>
	
	<h2>Tests</h2>
	<p>
		- If a user tries to upload a test that already exists (same year, type, quarter etc.), disallow this.
		<br/>
		- Add professor input box.
		<br/>
		- Allow more detailed search by difficulty, professor etc. 
	</p>
	
	<h2>Statistics Page</h2>
	<p>
		- Add content to this page.
		<br/>
		- Grade history of Theta Xi.
	</p>
	
	<h2>Admin</h2>
	<p>
		<?php greenCheck(); ?> There needs to be a special admin login with special capabilities on the site. (Completed 9/1/2011)
		<br/>
		- Delete tests, books, and edit profiles easily if things get inappropriate.
		<br/>
		<?php greenCheck(); ?> ISBN mass enter tool should display for admin only. (Completed 9/1/2011)
	</p>
	
	<h2>Other Ideas</h2>
	<p>
		- Create a wall where users can write. The 10 most recent messages are displayed.
		<br/>
		- Allows users to submit answers attached to test documents.
		<br/>
		- Create a website hit counter.
		<br/>
	</p>
	
	<h2>Bugs and Other Fixes</h2>
	<p>
		- Book loader gif not appearing in Chrome when searching for a book.
		<br/>
		- Websites other than Firefox and Chrome do not fully function to my knowledge.
		<br/>
		- This is because I'm making some javascript calls not supported in all browsers.
		<br/>
		- Text box CSS resizing on hover issues.
		<br/>
		- Text box resizing issues in general.
		<br/>
	    <?php greenCheck(); ?> Adding additional pdfs display needs formatting on test upload page. (Completed 8/31/2011)
	</p>	
</div>