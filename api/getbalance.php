<?php
require('./dbAPI.php');
$json = file_get_contents('php://input');
$data = json_decode($json);
$custID = $data->custID;
$fetchDetails = "select * from customer where custId='".$custID."'";
$detailsfetched = mysqli_query($conn,$fetchDetails);

while($row = mysqli_fetch_assoc($detailsfetched)){
$details = $row['balance'];
}
echo json_encode($details);
?>