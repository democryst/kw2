<?php
if(isset($_POST['itemTarget'])){
	
	$itemTarget=$_POST['itemTarget'];
	$urlToSave=$_POST['urlToSave'];
	
	$formName=$_POST['formName'];
	$approverNum=$_POST['approverNum'];
	$defPassword=$_POST['defPassword'];
	$arrayName=$_POST['arrayName'];
	$arrayPassword=$_POST['arrayPassword'];
	$numTextBox=$_POST['numTextBox'];
	$arrayX=$_POST['arrayX'];
	$arrayY=$_POST['arrayY'];
	$arrayLenght=$_POST['arrayLenght'];
	$arrayOwner=$_POST['arrayOwner'];
	$arrayComment=$_POST['arrayComment'];
	
	$arrayType=$_POST['arrayType'];
	$arrayInput=$_POST['arrayInput'];
	
	$jsonString = file_get_contents($urlToSave);
	$data = json_decode($jsonString, true);
	
	
	
	//$data[$itemTarget]['iName'] = $itemName;
	//$data[$itemTarget]['iPassword']['p3'] = 'ccc';
	
	$data[$itemTarget]['fName'] = $formName;
	$data[$itemTarget]['fApproverNum'] = $approverNum;
	$data[$itemTarget]['fDefPassword'] = $defPassword;
	$data[$itemTarget]['fArrayName'] = $arrayName;
	$data[$itemTarget]['fArrayPassword'] = $arrayPassword;
	$data[$itemTarget]['fNumTextBox'] = $numTextBox;
	$data[$itemTarget]['fArrayX'] = $arrayX;
	$data[$itemTarget]['fArrayY'] = $arrayY;
	$data[$itemTarget]['fArrayLenght'] = $arrayLenght;
	$data[$itemTarget]['fArrayOwner'] = $arrayOwner;
	$data[$itemTarget]['fArrayComment'] = $arrayComment;
	
	
	$data[$itemTarget]['fArrayType'] = $arrayType; //added after
	$data[$itemTarget]['fArrayInputSave'] = $arrayInput;
	
	$data2= json_encode($data);
	file_put_contents($urlToSave, $data2);
	
	
}
?>