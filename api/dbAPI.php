
<?php
$conn = mysqli_connect(
    "{write ip address here}",
    "db username",
    "db Password",
    "db name"
);

if (!$conn) {
    die("Connection Error : ".mysqli_connect_error());
}
?>
