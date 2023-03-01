<?php
session_start();
if (!isset($_SESSION['stallId'])) {
    // header('location:../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debiting...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
</head>

<body>

<?php
    if ((isset($_POST['submit'])) && ($_SESSION['check'] == 0)) {
        // importing data from form
        $stallId = $_POST['stallId'];
        $custId = strtoupper($_POST['custId']);
        $itemId = $_POST['itemName'];
        $price = $_POST['itemPrice']; 
        // connection
        include './dbAPI.php';

        $fetchdata = "select balance from customer where custId='$custId'";
        $executefetchdata = mysqli_query($conn,$fetchdata);
        $customer = mysqli_fetch_assoc($executefetchdata);

        if ($customer['balance'] >= $price) {
            // setting query for debiting customer
            $updateResponse = "update customer set balance=balance-$price where custId='$custId'";
            $executeUpdate = mysqli_query($conn,$updateResponse);

            // setting query for crediting stall keeper
            $updateResStall = "update stall set inflow=inflow+$price where stallId='$stallId'";
            $executeResStall = mysqli_query($conn,$updateResStall);

            if ($executeUpdate && $executeResStall) {
                // Transaction Log
                $insertresponse = "INSERT INTO `transaction` (`stallId`, `custId`, `type`, `amount`) VALUES ('$stallId', '$custId', 'Debit', '$price')";
                $executeinsert = mysqli_query($conn,$insertresponse);
                $_SESSION['check'] = 1;
                // Message card
                if ($executeinsert) {
                    echo "
                        <script>
                        Swal.fire(
                            'Transaction Success!',
                            'Amount Credited To Your Account.',
                            'success'
                        ).then(function() {
                            window.location = '../stallAdmin.php';
                        });   
                        </script>    
                    ";
                    exit();
                } else {
                    echo "Error: " . $insertresponse . "<br>" . mysqli_error($conn);
                }
                
            }
        } else {
            // header('location: ../stallAdmin.php');
            echo "
                <script>
                Swal.fire(
                    'Transaction Failed!',
                    'Customer Balance Is Low.',
                    'error'
                ).then(function() {
                    window.location = '../stallAdmin.php';
                });
                </script>
            ";
        }
        
    } else {
        header("location: ../stallAdmin.php");
    }
?>
</body>
</html>