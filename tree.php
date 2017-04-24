<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions
include('functions.php');

// Get the treeID from the url
$treeID = get('treeID');

// Get a list of books from the database with the treeID passed in the URL
$sql = file_get_contents('sql/getTree.sql');
$params = array(
	'treeID' => $treeID
);
$statement = $database->prepare($sql);
$statement->execute($params);
$trees = $statement->fetchAll(PDO::FETCH_ASSOC);

// Set $tree equal to the first tree in trees
$tree = $trees[0];

// Get colors from database
$sql = file_get_contents('sql/getTreeColors.sql');
$params = array(
	'treeID' => $treeID
);
$statement = $database->prepare($sql);
$statement->execute($params);
$colors = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Tree</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1><?php echo $tree['type'] ?></h1>
		<p>
			Name: <?php echo $tree['name']; ?><br />
			Is alive: <?php echo $tree['alive']; ?><br />
			<?php echo $tree['name']; ?> is a tree.
		</p>
		
		<ul>
			<?php foreach($colors as $color) : ?>
				<li><?php echo $color['name'] ?></li>
			<?php endforeach; ?>
		</ul>
		<p><a href="index.php">back </a></p> 
			
	</div>
</body>
</html>