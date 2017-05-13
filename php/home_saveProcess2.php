<?php
if(isset($_POST['itemName'])){
	$itemName=$_POST['itemName'];
	$itemTarget=$_POST['itemTarget'];
	$homeTablePath=$_POST['homeTablePath'];
	$homeTablePathWrite =$_POST['homeTablePathWrite '];
	
	$myFile = "homeTable.json";
	$fh = fopen($myFile, 'w+') or die("can't open file");
	$data = json_decode($fh, true);
	
	
	
	$dataFinalize= json_encode($data);
	fwrite($fh, $dataFinalize);
	//fclose($fh)
		
	
	
	echo $itemName;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//$json = file_get_contents($homeTablePath, FILE_USE_INCLUDE_PATH);
	//
	//$data = json_decode($json, true);
	
	
	//$data['item1']['iName']="Ham";

	
	//Encode the array back into a JSON string.
	//$dataFinalize= json_encode($data);
	
	
	//chmod('/jsonData/homeTable.json', 777);
	//Save the file.
	
	//file_put_contents('./jsonData/homeTable.json',$dataFinalize);
	//file_put_contents('http://localhost/kw1TempServer/Senior%20Project%20KW%20Demo/jsonData/homeTable.json',$dataFinalize);
	//file_put_contents('http://localhost/kw1TempServer/Senior%20Project%20KW%20Demo/jsonData/lol.json',$dataFinalize);
	//echo $data['item1']['iName'];
	
	//fopen($homeTablePath,'w+');
	//fwrite($homeTablePath, $json);
    //fclose($homeTablePath);

	
	

}
?>