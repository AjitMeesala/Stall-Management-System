<?php
session_start();
if (isset($_SESSION['userid']) && (($_SESSION['access'] == 3) || ($_SESSION['access'] == 0))) {
    $stallId = $_SESSION['userid'];
    $_SESSION['check'] = '0';
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
    <title>Stall Admin</title>

    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body class="container">
    <div class="d-flex justify-content-center">
        <div>
            <h1><span class="badge bg-primary my-3">Stall Managment Portal</span></h1>
        </div>
        <div class="my-3 ms-3">
            <a href="./api/logoutAPI.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="2.5rem" height="2.5rem" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                    <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
                </svg>
            </a>
        </div>
    </div>
    <?php
    include './api/dbAPI.php';
    // to get menu
    $fetchdata = "SELECT * FROM menu where stallId='$stallId'";
    $executefetchdata = mysqli_query($conn,$fetchdata);
    $items = mysqli_fetch_all($executefetchdata,MYSQLI_ASSOC);
    // to get id's
    $fetchdata = "SELECT custId FROM customer";
    $executefetchdata = mysqli_query($conn,$fetchdata);
    $id = mysqli_fetch_row($executefetchdata);
    
    //$conn->close();    
    ?>
    <div>
        <form action="./api/custDebitAPI.php" method="post">
            <div>
                <label for="stallId" class="form-label">STALL ID</label>
                <input type="text" name="stallId" id="stallId" class="form-control mb-3" value="<?php echo $stallId ?>" readonly>
            </div>
            <div>
                <label for="custId" class="form-label">CUSTOMER ID</label>
                <input type="text" name="custId" id="custID" class="form-control mb-3 text-uppercase" maxlength="7" required>
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
            <div>
                <label for="itemName" class="form-label">ITEM NAME</label>
                <select name="itemName" id="itemName" class="form-select mb-3" aria-label=".form-select-lg Default example" required>
                    <option value="" disabled selected hidden>Choose option</option>
                    <?php
                    $eventInfo = [];
                    foreach ($items as $key) {
                        $ID = $key['itemId'];
                        $Name = $key['itemName'];
                        $Price = $key['itemPrice'];
                        $temp = [$ID,$Price];
                        array_push($eventInfo,$temp);
                    ?>
                    <option value="<?= $ID ?>"><?= $Name ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 w-25">
                <label for="quantity" class="form-label">QUANTITY</label>
                <input type="number" name="quantity" id="quantity" class="form-control" max="100" min="1" value="1"></div>
            </div>
            <div>
                <label for="itemPrice" class="form-label">PRICE</label>
                <input type="text" name="itemPrice" id="itemPrice" class="form-control mb-3" value="" readonly>
            </div>
            <div class="d-flex justify-content-center py-3">
                <input type="submit" value="Confirm Order" name="submit" class="btn btn-primary mx-3" id="submit" disabled>
            </div>
        </form>
    </div>

    <script>
        let quantity = document.getElementById('quantity');
        var eventInfo = <?php echo json_encode($eventInfo) ?>;
        var id = <?php echo json_encode($id) ?>;
        let name = document.getElementById('itemName');
        let price = document.getElementById('itemPrice');
        let itemPrice = null;
        // for setting price
        name.addEventListener("change",()=>{
            for (let i = 0; i < eventInfo.length; i++) {
                if (eventInfo[i][0] == name.value) {
                    itemPrice = eventInfo[i][1];
                    price.value = itemPrice  * quantity.value;
                    break;
                }
            }
        })
        // quantity to price
        quantity.addEventListener("change", ()=>{
            price.value = itemPrice * quantity.value;
        })
        // for customer validation
        let id_el = document.getElementById('custID');
        let btn = document.getElementById('submit');
        let alert = document.getElementById('alert');
        id_el.addEventListener("keyup",()=>{
            if (custID.value.length === 7) {
                for (let i = 0; i < id.length; i++) {
                    if (custID.value.toUpperCase() === id[i]) {
                        alert.style.display = 'none';
                        btn.disabled = false;
                        break;
                    } else {
                        alert.style.display = 'block';
                        btn.disabled = true;
                    }
                    
                }
            } else {
                alert.style.display = 'block';
                btn.disabled = true;
            }
        })
    </script>


<!-- Bootstrap script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
