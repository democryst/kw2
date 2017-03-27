<?php
require_once('../connect.php');
$data_parse = $_POST['data_obj'];
$WFrqDetail_ID = $data_parse['WFrqDetail_ID'];
$Parent_ID = $data_parse['Parent_ID'];
$WFrqDoc_ID = $data_parse['WFrqDoc_ID'];

$q_SELECT_group = "SELECT * FROM `ugroup` WHERE `GroupID` != '0' AND `GroupID` != '1' AND `GroupID` != '2' AND `GroupID` != '3' AND `GroupID` != '7'";
$data = array();
$result_SELECT_group=$mysqli->query($q_SELECT_group);
while( $row_SELECT_group=$result_SELECT_group->fetch_array() ){
  array_push($data, $row_SELECT_group);
}
echo json_encode($data);

?>
