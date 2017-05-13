<?php
if(isset($_POST['itemTarget'])){
	
	$itemTarget=$_POST['itemTarget'];
	$mFormName=$_POST['mFormName'];
	$mApproverNum=$_POST['mApproverNum'];
	$mDefPassword=$_POST['mDefPassword'];
	$mArrayName=$_POST['mArrayName'];
	$mArrayPassword=$_POST['mArrayPassword'];
	$mNumTextBox=$_POST['mNumTextBox'];
	$mArrayX=$_POST['mArrayX'];
	$mArrayY=$_POST['mArrayY'];
	$mArrayLenght=$_POST['mArrayLenght'];
	$mArrayOwner=$_POST['mArrayOwner'];
	$mArrayComment=$_POST['mArrayComment'];
	$mArrayType=$_POST['mArrayType'];	
	$jsonString = file_get_contents('jsonFile.json');
	$data = json_decode($jsonString, true);
	
	$data[$itemTarget]['iName'] = $mFormName;
	$data[$itemTarget]['iApproverNum'] = $mApproverNum;
	$data[$itemTarget]['iDefPassword'] = $mDefPassword;
	$data[$itemTarget]['iArrayName'] = $mArrayName;
	$data[$itemTarget]['iArrayPassword'] = $mArrayPassword;
	$data[$itemTarget]['iNumTextBox'] = $mNumTextBox;
	$data[$itemTarget]['iArrayX'] = $mArrayX;
	$data[$itemTarget]['iArrayY'] = $mArrayY;
	$data[$itemTarget]['iArrayLenght'] = $mArrayLenght;
	$data[$itemTarget]['iArrayOwner'] = $mArrayOwner;
	$data[$itemTarget]['iArrayComment'] = $mArrayComment;
	$data[$itemTarget]['iArrayType'] = $mArrayType;
	
	$data2= json_encode($data);
	file_put_contents('jsonFile.json', $data2);
	
	
}
?>