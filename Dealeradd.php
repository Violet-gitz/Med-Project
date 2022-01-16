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


    if (isset($_REQUEST['btn_insert'])) {
        $DealerName = $_REQUEST['txt_DealerName'];
        $DealerAddress = $_REQUEST['txt_DealerAddress'];
        $DealerPhone = $_REQUEST['txt_DealerPhone'];
        $ContractStart = $_REQUEST['ContractStart'];
        $ContractEnd = $_REQUEST['ContractEnd'];

        if (empty($DealerName)) {
            $errorMsg = "Please enter Desler Name";
        } else if (empty($DealerAddress)) {
            $errorMsg = "please Enter Dealer Address";
        } else if (empty($DealerPhone)) {
            $errorMsg = "please Enter Dealer Phone";
        } else if (empty($ContractStart)) {
            $errorMsg = "please Enter Dealer Contract Start";
        } else if (empty($ContractEnd)) {
            $errorMsg = "please Enter Dealer Contract End";
        } else {
            $query = "SELECT * FROM tbl_dealer WHERE DealerName = '$DealerName'  LIMIT 1";
            $result = mysqli_query($conn, $query); 
            $row = mysqli_fetch_array($result);
            if($row["DealerName"] === $DealerName) {
                $errorMsg =  "DealerName already exists";
            }
            else {
            $sql = "INSERT INTO tbl_dealer(DealerName,DealerAddress,DealerPhone,ContractStart,ContractEnd) VALUES ('$DealerName', '$DealerAddress', '$DealerPhone', '$ContractStart', '$ContractEnd')";
            if ($conn->query($sql) === TRUE){
                $insertMsg = "Insert Successfully...";
                header("refresh:1;Dealershow.php");
            }
                else {echo "Error updating record: " . $conn->error;}
            }
        }
    }

    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT* FROM tbl_staff WHERE StaffName = '$staff'";
    $result = $conn->query($sql);
    $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $staff){      

        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
                <div style='margin-right: 15px'>
                    <?php
                    include('slidebar.php');   
                    ?>
                </div>
                <div> 
                  <a href="main.php" class="navbar-brand">Home Page</a>
                </div>

                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="Staffedit.php">
                                            <a class="dropdown-item" href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
                                            <input type="hidden" name ='update_id' value ="<?php echo $staff["StaffId"]; ?>">
                                        </from>

                                        <form method="POST" action="index.php">
                                            <a class="dropdown-item" href="index.php?logout='1'">Logout</a>
                                            <input type ="hidden" name ='logout' value ="1">
                                        </form>

                                    </div>                               
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav> 


</head>
<body>


    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

        <form method="post" class="form-horizontal mt-5">
            <div class="container">
                <div class="form-group text-center">
                    <div class="row">
                        <label for="DealerName" class="col-sm-3 control-label">Dealer Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerName" class="form-control" placeholder="Enter Dealer Name...">
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="DealerAddress" class="col-sm-3 control-label">Dealer Address</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerAddress" class="form-control" placeholder="Enter Dealer Address...">
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="DealerAddress" class="col-sm-3 control-label">Dealer Phone</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerPhone" class="form-control" placeholder="Enter Dealer Phone...">
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Price" class="col-sm-3 control-label">Dealer Contract Start</label>
                        <div class="col-sm-1">
                        <input type="date"  name="ContractStart"
                                            value="<?php echo date('Y-m-j'); ?>" required 
                                            min="2021-3-22" max="2030-12-31">
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <div class="row">
                        <label for="Medicine Price" class="col-sm-3 control-label">Dealer Contract End</label>
                        <div class="col-sm-1">
                        <input type="date"  name="ContractEnd"
                                            value="<?php echo date('Y-m-j'); ?>" required 
                                            min="2021-3-22" max="2030-12-31">
                        </div>
                    </div>
                </div>

                

                <div class="form-group text-center">
                    <div class="col-md-12 mt-3">
                        <input type="submit" name="btn_insert" class="btn btn-success" value="Insert">
                        <a href="Dealershow.php" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>