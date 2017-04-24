<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// Get search term from URL using the get function
$term = get('search-term');

// Get a list of trees using the searchTrees function
// Print the results of search results

$trees = searchTrees($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Trees</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<img src="tree.png" alt="Smiley face" height="42" width="42">
	<div class="page">
		<h1>Trees</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" />
		</form>
		<?php foreach($trees as $tree) : ?>
			<p>
				Type: <?php echo $tree['type']; ?><br />
				Name: <?php echo $tree['name']; ?> <br />
				Is this tree alive: <?php echo $tree['alive']; ?> <br />
				<a href="form.php?action=edit&treeID=<?php echo $tree['treeID'] ?>">Edit Tree</a><br />
				<a href="tree.php?treeID=<?php echo $tree['treeID'] ?>">View Tree</a>
			</p>
		<?php endforeach; ?>
		
		
		
		
		<!-- A link to the logout.php file -->
		<p>
			<a href="logout.php">Log Out</a>
		</p>
	</div>
</body>
</html>