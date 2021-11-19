<?php 
    include('connect.php');
    session_start();

    
    if (!isset($_SESSION['StaffName'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['StaffName']);
        header('location: login.php');
    }


    if (isset($_REQUEST['update_id'])) {
        try {
            $id = $_REQUEST['update_id'];
            $sql ="SELECT * FROM tbl_dealer WHERE $id = DealerId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $dealer){}
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    if (isset($_REQUEST['btn_update'])) {
        $DealerName = $_REQUEST['txt_DealerName'];
        $DealerAddress = $_REQUEST['txt_DealerAddress'];
        $DealerPhone = $_REQUEST['txt_DealerPhone'];
        $ContractStart = $_REQUEST['ContractStart'];
        $ContractEnd = $_REQUEST['ContractEnd'];
        

        if (empty($DealerName)) {
            $errorMsg = "Please Enter Dealer Name";
        } else if (empty($DealerAddress)) {
            $errorMsg = "Please Enter Dealer Address";
        } else if (empty($DealerPhone)) {
            $errorMsg = "please Enter Dealer Phone";
        } else if (empty($ContractStart)) {
            $errorMsg = "please Enter Dealer Contract Start";
        } else if (empty($ContractEnd)) {
            $errorMsg = "please Enter Dealer Contract End";
        } else {
            try {
                if (!isset($errorMsg)) {
                    $update_stmt = $db->prepare("UPDATE tbl_dealer SET DealerName = :1name, DealerAddress = :2name, DealerPhone = :3name, ContractStart = :4name, ContractEnd = :5name WHERE DealerId = :DealerId");
                    $update_stmt->bindParam(':1name', $DealerName);
                    $update_stmt->bindParam(':2name', $DealerAddress);
                    $insert_stmt->bindParam(':3name', $DealerPhone);
                    $insert_stmt->bindParam(':4name', $ContractStart);
                    $insert_stmt->bindParam(':5name', $ContractEnd);
                    $update_stmt->bindParam(':DealerId', $id);

                    if ($update_stmt->execute()) {
                        $updateMsg = "Record update successfully...";
                        header("refresh:1;Dealershow.php");
                    }
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    
</head>
<body>

        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Dealer Edit</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        
                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>

        <?php
            include('slidebar.php');
        ?>

    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>


    
        <form method="post" class="form-horizontal mt-5">
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="DealerName" class="col-sm-3 control-label">Dealer Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_DealerName" class="form-control" placeholder="<?php echo $dealer["DealerName"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="DealerAddress" class="col-sm-3 control-label">Dealer Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_DealerAddress" class="form-control" placeholder="<?php echo $dealer["DealerAddress"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="DealerAddress" class="col-sm-3 control-label">Dealer Phone</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_DealerPhone" class="form-control" placeholder="<?php echo $dealer["DealerPhone"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="DealerAddress" class="col-sm-3 control-label">Contract Start</label>
                    <div class="col-sm-7">
                        <input type="text" name="ContractStart" class="form-control" placeholder="<?php echo $dealer["ContractStart"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="DealerAddress" class="col-sm-3 control-label">Contract End</label>
                    <div class="col-sm-7">
                        <input type="text" name="ContractEnd" class="form-control" placeholder="<?php echo $dealer["ContractEnd"]; ?>">
                    </div>
                </div>
            </div>



            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_update" class="btn btn-success" value="Update">
                    <a href="Dealershow.php" class="btn btn-danger">Back</a>
                </div>
            </div>


        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>