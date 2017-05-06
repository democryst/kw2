<?php
require_once('../connect.php');
if (isset($_POST['data'])) {
    $dataparse = $_POST['data'];
    $groupid0 = $dataparse['groupid'];
    $priorityid0 = $dataparse['priorityid'];
    $username0 = $dataparse['username'];
    $password0 = $dataparse['password'];
    $name0 = $dataparse['name'];
    $surname0 = $dataparse['surname'];

    $q_s_userid_0 = "SELECT UserID FROM user WHERE UserName='$username0', Password='$password0', Name='$name0', Surname='$surname0' ";
    $result_s_userid_0 = $mysqli->query($q_s_userid_0);
    if ($result_s_userid_0 && $result_s_userid_0->num_rows>=1 ) {
      echo json_encode(0);
      exit();
    }else {
      $q_i_user = "INSERT INTO `user`(`UserName`, `Password`, `Name`, `Surname`) VALUES ('$username0','$password0','$name0','$surname0')";
      $mysqli->query($q_i_user);

      $q_s_userid = "SELECT UserID FROM `user` WHERE `UserName`='$username0' AND `Password`='$password0' AND `Name`='$name0' AND `Surname`='$surname0' ";
      $result_s_userid = $mysqli -> query($q_s_userid);

        $row_s_userid = $result_s_userid -> fetch_array();
        $UserID =  $row_s_userid['UserID'];

        $q_i_usergroup = "INSERT INTO `usergroup`(`UserID`, `GroupID`) VALUES ('$UserID','$groupid0')";
        $mysqli->query($q_i_usergroup);

        $q_i_userpriority = "INSERT INTO `userpriority`(`UserID`, `PriorityID`) VALUES ('$UserID','$priorityid0')";
        $mysqli->query($q_i_userpriority);

        echo json_encode(1);
        exit();
    }

    // $q_i_user = "INSERT INTO `user`(`UserName`, `Password`, `Name`, `Surname`) VALUES ('$username','$password','$name','$surname')";
    // $mysqli->query($q_i_user);

    // $q_s_userid = "SELECT UserID FROM user WHERE UserName='$username', Password='$password', Name='$name', Surname='$surname' ";
    // $result_s_userid = $mysqli->query($q_s_userid);
    // if ($result_s_userid && $result_s_userid->num_rows==1 ) {
    //   $row_s_userid = $result_s_userid->fetch_array();
    //   $UserID =  $row_s_userid['UserID'];
    //
    //   $q_i_usergroup = "INSERT INTO `usergroup`(`UserID`, `GroupID`) VALUES ('$UserID','$groupid')";
    //   $mysqli->query($q_i_usergroup);
    //
    //   $q_i_userpriority = "INSERT INTO `userpriority`(`UserID`, `PriorityID`) VALUES ('$UserID','$priorityid')";
    //   $mysqli->query($q_i_userpriority);
    //
    //   die('Register Successfully!');
    //
    // }


}else{
  echo json_encode(-1);
  exit();
}
?>
