<?php

// Create and include a configuration file with the database connection
include('config.php');

// Include functions for application
include('functions.php');

// Get type of form either add or edit from the URL (ex. form.php?action=add) using the newly written get function
$action = $_GET['action'];

// Get the tree id from the URL if it exists using the newly written get function
$treeID = get('treeID');

// Initially set $tree to null;
$tree = null;

// Initially set $tree_colors to an empty array;
$tree_colors = array();

// If treeID is not empty, get tree record into $tree variable from the database
//     Set $tree equal to the first tree in $tree
// 	   Set $tree_categories equal to a list of colors associated to a tree from the database
if(!empty($treeID)) {
	$sql = file_get_contents('sql/getTree.sql');
	$params = array(
		'treeID' => $treeID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$trees = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$tree = $trees[0];
	
	// Get tree color
	$sql = file_get_contents('sql/getTreeColors.sql');
	$params = array(
		'treeID' => $treeID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$tree_colors_associative = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($tree_colors_associative as $color) {
		$tree_colors[] = $color['colorID'];
	}
}

// Get an associative array of colors
$sql = file_get_contents('sql/getColor.sql');
$statement = $database->prepare($sql);
$statement->execute();
$colors = $statement->fetchAll(PDO::FETCH_ASSOC); 

// If form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$treeID = $_POST['treeID'];
	$type = $_POST['tree-type'];
	$tree_color = $_POST['tree-colors'];
	$name = $_POST['tree-name'];
	$alive = $_POST['tree-alive'];
	
	if($action == 'add') {
		// Insert Tree
		$sql = file_get_contents('sql/insertTree.sql');
		$params = array(
			'treeID' => $treeID,
			'type' => $type,
			'name' => $name,
			'alive' => $alive
		);
	
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		// Set colors for tree
		$sql = file_get_contents('sql/insertTreeColor.sql');
		$statement = $database->prepare($sql);
		
		foreach($tree_colors as $tree_color) {
			$params = array(
				'treeID' => $treeID,
				'colorID' => $colorID
			);
			$statement->execute($params);
		}
	}
	
	elseif ($action == 'edit') {
		$sql = file_get_contents('sql/updateTree.sql');
        $params = array( 
            'treeID' => $treeID,
            'type' => $type,
            'name' => $name,
            'alive' => $alive
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        //remove current color info 
        $sql = file_get_contents('sql/removeColors.sql');
        $params = array(
            'treeID' => $treeID
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        //set color for tree
        $sql = file_get_contents('sql/insertTreeColor.sql');
        $statement = $database->prepare($sql);
        
        foreach($tree_colors as $color) {
            $params = array(
                'treeID' => $treeID,
                'colorID' => $colorID
            );
            $statement->execute($params);
        };	
	}
	
	// Redirect to index
	header('location: index.php');
}

// In the HTML, if an edit form:
	// Populate textboxes with current data of tree selected 

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Manage Tree</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div class="page">
		<h1>Manage Tree</h1>
		<form action="" method="POST">
			<div class="form-element">
				<label>TREE ID:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="treeID" class="textbox" value="<?php echo $tree['treeID'] ?>" />
				<?php else : ?>
					<input readonly type="text" name="treeID" class="textbox" value="<?php echo $tree['treeID'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>TYPE:</label>
				<input type="text" name="tree-type" class="textbox" value="<?php echo $tree['type'] ?>" />
			</div>
			<div class="form-element">
				<label>COLOR:</label>
				<?php foreach($colors as $color) : ?>
					<?php if(in_array($color['colorID'], $tree_colors)) : ?>
						<input checked class="radio" type="checkbox" name="tree-colors[]" value="<?php echo $color['colorID'] ?>" /><span class="radio-label"><?php echo $color['name'] ?></span><br />
					<?php else : ?>
						<input class="radio" type="checkbox" name="tree-colors[]" value="<?php echo $color['colorID'] ?>" /><span class="radio-label"><?php echo $color['name'] ?></span><br />
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
			<div class="form-element">
				<label>NAME:</label>
				<input type="text" name="tree-name" class="textbox" value="<?php echo $tree['name'] ?>" />
			</div>
			<div class="form-element">
				<label>IS ALIVE:</label>
				<input type="text" step="any" name="tree-alive" class="textbox" value="<?php echo $tree['alive'] ?>" />
			</div>
			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</form>
	</div>
</body>
</html>