<?php
require("./dbAPI.php");
$json = file_get_contents('php://input');
$data = json_decode($json);
$deskID = $data->deskID;
$custID = strtoupper($data->custID);
$creditBal = $data->credit_bal;
$update = "UPDATE customer SET balance = balance+${creditBal} WHERE custId = '$custID'";
$executeupdate = mysqli_query($conn,$update);
$fetchdata = "select balance from customer where custId='$custID'";
$executefetchdata = mysqli_query($conn,$fetchdata);
$balance = mysqli_fetch_assoc($executefetchdata);
// $balance = ;

// Transaction Log
$insertresponse = "INSERT INTO `transaction` (`stallId`, `custId`, `type`, `amount`) VALUES ('$deskID', '$custID', 'Credit', '$creditBal')";
$executeinsert = mysqli_query($conn,$insertresponse);

echo json_encode($balance['balance']);
?>