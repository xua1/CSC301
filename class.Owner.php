<?php
class{
//Define a owner
private $ownerID; 
private $ownerName;
private $databaseProperty;

//Implement a constructor 
function _construct($ownerID, $database){

$sql = file_get_contents('sql/getOwner.sql');
	$params = array(
		'ownerID' => $ownerID,
		'ownerName'=>$ownerName
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$stuff = $statement->fetchAll(PDO::FETCH_ASSOC);




//Set variables from the constructor function as class properties
$this->ownerID= $ownerID;
$this->databaseProperty=$database;
}

public function getName(){
	return $this->ownerName;
}


}
?>
