
<?php
$conn = mysqli_connect(
    "103.21.58.5",
    "stepcone",
    "Hawking@1234",
    "stepcone"
);

if (!$conn) {
    die("Connection Error : ".mysqli_connect_error());
}

// $host="102.21.58.5";
// $port=3306;
// $socket="";
// $user="root";
// $password="";
// $dbname="stepcone2023";

// $conn = new mysqli($host, $user, $password, $dbname, $port, $socket);
// if (!$conn) {
//     die ('Could not connect to the database server' . mysqli_connect_error());
// }
?>