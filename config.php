<?php

// Connecting to the MySQL database
$user = 'xua1';
$password = 'KVXYQBqp';

$database = new PDO('mysql:host=localhost;dbname=db_spring17_xua1', $user, $password);

function my_autoloader($class){
		include 'classes/class.' . $class . '.php';
	}
	spl_autoload_register('my_autoloader');

// Start the session
session_start();

$current_url = basename($_SERVER['REQUEST_URI']);


	
	


// if ownerID is not set in the session and current URL not login.php redirect to login page
if (!isset($_SESSION["ownerID"]) && $current_url != 'login.php') {
    header("Location: login.php");
}

// Else if session key ownerID is set get $customer from the database
elseif (isset($_SESSION["ownerID"])) {
	$sql = file_get_contents('sql/getOwner.sql');
	$params = array(
		'ownerID' => $_SESSION["ownerID"]
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$owners = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	
	$owner = $owners[0];
}