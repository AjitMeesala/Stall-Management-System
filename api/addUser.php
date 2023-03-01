<?php

use function PHPSTORM_META\type;

session_start();
if (isset($_SESSION['userid']) && (($_SESSION['access'] == 2) || ($_SESSION['access'] == 0))) {}
else {
    header("location: ../");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
</head>

<body>

<?php

if (isset($_POST['submit'])) {
    // get data
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    // $initamount = $_POST['initamount'];

    // db connection
    include './dbAPI.php';

    // get last id
    $fetchdata = "select right(custId,4) from customer order by custId desc limit 1";
    $executefetchdata = mysqli_query($conn,$fetchdata);
    $lastId = mysqli_fetch_row($executefetchdata);
    $lastId = (int)$lastId[0];
    $lastId += 1;
    $lastId = str_pad("$lastId",4,'0',STR_PAD_LEFT);
    $newId = "23C"."$lastId";

    // insert query
    $insert = "INSERT INTO `stepcone`.`customer` (`custId`, `name`, `mobile`, `balance`) VALUES ('$newId', '$name', '$mobile', 0')";
    $executeinsert = mysqli_query($conn,$insert);

    // clarify message
    echo "
        <script>Swal.fire(
            'Success!',
            'Registered successfully!!!<br><br>The Customer ID: $newId<br>',
            'success'
            ).then(function() {
            window.location = '../rechargeAdmin.php';
        });   
        </script>    
    ";
}

?>