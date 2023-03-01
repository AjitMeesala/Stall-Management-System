<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.1/dist/sweetalert2.all.min.js"></script>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
</head>
    <body>
    <?php

    if (isset($_POST["Login"])) {

    // ============ DataBase Connection ======================//
    include "./dbAPI.php";


    // ============ Retreive Values from the form ============//
    $user = strtoupper(trim($_POST['user']));
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admin WHERE userid = '$user' and password = '$password'";
    $executesql = mysqli_query($conn, $sql);
    $resSet = mysqli_num_rows($executesql);
    if ($resSet == 1) {
        
        $row = mysqli_fetch_assoc($executesql);
        $userVerify = $row['userid'];
        $userPassword = $row['password'];
        $access = $row['access'];
        session_start();
        $_SESSION['userid'] = $user;
        $_SESSION['access'] = $access;
        if (strtoupper($userVerify) == strtoupper($user) && $userPassword == $password && $access == 0) {
            header("Location: ../admin.php");
        }
        elseif (strtoupper($userVerify) == strtoupper($user) && $userPassword == $password && $access == 2) {
            header("Location: ../rechargeAdmin.php");
        }
        elseif (strtoupper($userVerify) == strtoupper($user) && $userPassword == $password && $access == 3) {
            header("Location:../stallAdmin.php");
        }
        else {
            session_destroy();
            echo "
                    <script> 
                    Swal.fire({
                    icon: 'error',
                    title: 'Invalid Credentials...',
                    text: 'Please re-check & Try again!',
                    }).then(function() {
                        window.location = '../index.php';
                    });
                        </script>    
                ";
        }
    }
    else {
        echo "
                    <script> 
                    Swal.fire({
                    icon: 'error',
                    title: 'Invalid Credentials...',
                    text: 'Please re-check & Try again!',
                    }).then(function() {
                        window.location = '../index.php';
                    });
                        </script>    
                ";
    }
    }
    ?>
    </body>
</html>