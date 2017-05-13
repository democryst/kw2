<?php
if(isset($_POST['itemTarget	'])){

	$itemTarget=$_POST['itemTarget'];

	
	$jsonString = file_get_contents('jsonFile.json');
	$data = json_decode($jsonString, true);
	
	$data[$itemTarget] = $itemTargetNew;



	
	
	
	
	$data2= json_encode($data);
	file_put_contents('jsonFile.json', $data2);
	
	
}
?>