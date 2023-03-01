<?php
session_start();
if (isset($_SESSION['userid']) && ($_SESSION['access'] == 0)) {
    $deskId = $_SESSION['userid'];
}
else {
    header("location: ./");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DashBoard</title>
</head>
<body>
    <a href="./rechargeAdmin.php">Recharge Desk Admin</a><br>
    <a href="./stallAdmin.php">Stallkeeper Admin</a><br>
    <a href="./api/logoutAPI.php">Logout</a>
</body>
</html>