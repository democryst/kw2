<?php
if(isset($_POST['itemName'])){
	$itemName=$_POST['itemName'];
	$itemTarget=$_POST['itemTarget'];
	$gFormName=$_POST['gFormName'];
	$gApproverNum=$_POST['gApproverNum'];
	$gDefPassword=$_POST['gDefPassword'];
	$gArrayName=$_POST['gArrayName'];
	$gArrayPassword=$_POST['gArrayPassword'];
	$gNumTextBox=$_POST['gNumTextBox'];
	$gArrayX=$_POST['gArrayX'];
	$gArrayY=$_POST['gArrayY'];
	$gArrayLenght=$_POST['gArrayLenght'];
	$gArrayOwner=$_POST['gArrayOwner'];
	$gArrayComment=$_POST['gArrayComment'];
	$gArrayType=$_POST['gArrayType'];	
	$gArrayInputSave=$_POST['gArrayInputSave'];	
	
	$jsonString = file_get_contents('jsonFile.json');
	$data = json_decode($jsonString, true);
	
	$data[$itemTarget]['iName'] = $itemName;


	$data[$itemTarget]['iApproverNum'] = $gApproverNum;
	$data[$itemTarget]['iDefPassword'] = $gDefPassword;
	$data[$itemTarget]['iArrayName'] = $gArrayName;
	$data[$itemTarget]['iArrayPassword'] = $gArrayPassword;
	$data[$itemTarget]['iNumTextBox'] = $gNumTextBox;
	$data[$itemTarget]['iArrayX'] = $gArrayX;
	$data[$itemTarget]['iArrayY'] = $gArrayY;
	$data[$itemTarget]['iArrayLenght'] = $gArrayLenght;
	$data[$itemTarget]['iArrayOwner'] = $gArrayOwner;
	$data[$itemTarget]['iArrayComment'] = $gArrayComment;
	$data[$itemTarget]['iArrayType'] = $gArrayType;
	$data[$itemTarget]['iArrayInputSave'] = $gArrayInputSave;
	
	$data2= json_encode($data);
	file_put_contents('jsonFile.json', $data2);
	
	
}
?>