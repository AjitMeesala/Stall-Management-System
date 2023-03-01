<?php
session_start();
if (isset($_SESSION['userid']) && (($_SESSION['access'] == 2) || ($_SESSION['access'] == 0))) {
    $deskId = $_SESSION['userid'];
}
else {
    header("location: ./");
}
?>
<?php
include './api/dbAPI.php';
// to get id's
$fetchdata = "SELECT custId,mobile FROM customer";
$executefetchdata = mysqli_query($conn,$fetchdata);
$id = mysqli_fetch_all($executefetchdata,MYSQLI_NUM);
// $fetchdata = "select Mail from userdetails";
// $executefetchdata = mysqli_query($conn,$fetchdata);
// $mail = mysqli_fetch_all($executefetchdata);

//$conn->close();    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recharge Desk</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body class="container">
    <?php
    include './api/dbAPI.php';
    ?>
     <div class="d-flex justify-content-center">
        <div>
            <h1><span class="badge bg-primary my-3">Recharge Desk</span></h1>
        </div>
        <div class="my-3 ms-3">
            <a href="./api/logoutAPI.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="2.5rem" height="2.5rem" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                    <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                </svg>
            </a>
        </div>
    </div>
    <hr>
    <div class="mb-3">
        <label for="adminId" class="form-label">ADMIN ID</label>
        <input type="text" name="adminId" id="adminId" class="form-control mb-3" value="<?php echo $deskId ?>" readonly>
    </div>
    <hr>
    <div>
        <div>
            <label for="custId" class="form-label">CUSTOMER ID</label>
            <input type="text" name="custId" id="custId" class="form-control mb-3 text-uppercase" maxlength="7">
            <div id="alert" style="display: none;">
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <div>
                        INVALID CUSTOMER ID
                    </div>
                </div>
            </div>
        </div>
        <div id="searchDiv" style="display: block;">
            <button id="search" class="btn btn-primary" disabled>Search</button>
            <button type="button" class="btn btn-primary ms-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add User</button>
        </div>
        <div id="closeDiv" style="display: none;">
            <button id="close" class="btn btn-primary">Close</button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Registration...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./api/addUser.php" method="post">
                    <!-- <div class="mb-3">
                        <label for="Mail" class="form-label">REGISTERED MAIL ID</label>
                        <input type="email" class="form-control" name="Mail" id="Mail" required>
                        <div id="alert-modal" style="display: none;">
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    INVALID CUSTOMER ID
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile Number</label>
                        <input type="number" name="mobile" id="mobile" class="form-control" required maxlength="10">
                        <div id="alert-modal" style="display: none;">
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                </svg>
                                <div>
                                    Mobile Number Already Exists!!!
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="initamount" class="form-label">INITIAL BALANCE</label>
                        <input type="number" class="form-control" name="initamount" value="0" min="0" id="initamount" required>
                    </div> -->
                
            </div>
            <div class="modal-footer">
                <input type="reset" value="Reset" class="btn btn-danger">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <input type="submit" id="adduser" value="Add" name="submit" class="btn btn-primary" data-bs-dismiss="modal" disabled>
                <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    <hr>
    <div>
        <label for="balance" class="form-label">BALANCE</label>
        <input type="text" name="balance" id="balance" value="" class="form-control mb-3" readonly>
    </div>
    <hr>
    <div id="transDiv" style="display: none;">
        <div class="mb-3">
            <label for="creditBal" class="form-label">CREDIT</label>
            <input type="text" name="creditBal" id="creditBal" class="form-control mb-3">
            <button id="credit" class="btn btn-primary">Credit</button>
        </div>
        <div class="mb-3">
            <label for="debitBal" class="form-label">DEBIT</label>
            <input type="text" name="debitBal" id="debitBal" class="form-control mb-3">
            <button id="debit" class="btn btn-primary">Debit</button>
        </div>
    </div>
    <script>
        let id = document.getElementById('custId');
        let search = document.getElementById('search');
        let close = document.getElementById('close');
        let bal_el = document.getElementById('balance');
        let custId = null;
        let transDiv = document.getElementById('transDiv');
        let searchDiv = document.getElementById('searchDiv');
        let closeDiv = document.getElementById('closeDiv');
        // for customer validation
        var data = <?php echo json_encode($id) ?>;
        let alert = document.getElementById('alert');
        id.addEventListener("keyup",()=>{
            if (id.value.length === 7) {
                for (let i = 0; i < data.length; i++) {
                    if (id.value.toUpperCase() === data[i][0]) {
                        alert.style.display = 'none';
                        search.disabled = false;
                        break;
                    } else {
                        alert.style.display = 'block';
                        search.disabled = true;
                    }
                    
                }
            } else {
                alert.style.display = 'block';
                search.disabled = true;
            }
        })
        // Add user validation
        // let mailel = document.getElementById('Mail');
        let mobile = document.getElementById('mobile');
        let addbtn = document.getElementById('adduser');
        // var mail = <?php //echo json_encode($mail) ?>;
        let alertModal = document.getElementById('alert-modal');
        mobile.addEventListener("keyup",()=>{
            if (mobile.value.length === 10) {
                for (let i = 0; i < mail.length; i++) {
                    if (mobile.value === data[i][1]) {
                        alertModal.style.display = 'none';
                        addbtn.disabled = false;
                        break;
                    } else {
                        alertModal.style.display = 'block';
                        addbtn.disabled = true;
                    }
                    
                }
            } else {
                alertModal.style.display = 'block';
                addbtn.disabled = true;
            }
            
        })
        // To get balance and enable credit and debit
        search.addEventListener("click",(e)=>{
            e.preventDefault();
            custId = id.value;
            // To get Balance
            fetch("./api/getbalance.php", {
            method: "POST",
            headers: {
            "Content-Type": "application/json",
            },
            body: JSON.stringify({
            custID: custId
            }),
            })
            .then((response) => response.json())
            .then((data) => {
                bal_el.value=data;
            })
            transDiv.style.display = 'block';
            searchDiv.style.display = 'none';
            closeDiv.style.display = 'block';
        })
        // To switch from close to search
        close.addEventListener("click",(e)=>{
            e.preventDefault();
            transDiv.style.display = 'none';
            searchDiv.style.display = 'block';
            closeDiv.style.display = 'none';
            id.value = null;
            bal_el.value = null;
            credit_bal.value = null;
            debit_bal.value = null;
            search.disabled = true;
        })
        // credit the customer
        let credit = document.getElementById('credit');
        let credit_bal = document.getElementById('creditBal');
        let deskId = '<?php echo $deskId; ?>';
        credit.addEventListener("click",(e)=>{
            e.preventDefault();
            custId = id.value;
            if (credit_bal.value > 0) {
                fetch("./api/creditBalance.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        deskID: deskId,
                        custID: custId,
                        credit_bal: credit_bal.value
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    bal_el.value=data;
                    credit_bal.value = null;
                })
            }
        })
        // debit the customer
        let debit = document.getElementById('debit');
        let debit_bal = document.getElementById('debitBal');
        debit.addEventListener("click",(e)=>{
            e.preventDefault();
            custId = id.value;
            if (debit_bal.value <= bal_el.value) {
                fetch("./api/debitBalance.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        deskID: deskId,
                        custID: custId,
                        debit_bal: debit_bal.value
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    bal_el.value=data;
                    debit_bal.value = null;
                })
            }
        })
    </script>

<!-- Bootstrap script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>