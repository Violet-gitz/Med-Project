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


    if (isset($_REQUEST['Received_id'])) {
        
            $id = $_REQUEST['Received_id'];
            $sql ="SELECT * FROM tbl_orderdetail WHERE $id = OrderId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Orderde)

            {
                $MedId = $Orderde["MedId"];
                $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                $result = $conn->query($sqli);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}

                $OrderId = $Orderde["OrderId"];
                $sql ="SELECT * FROM tbl_Order WHERE $OrderId = OrderId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Order){

                $DealerId = $Order["DealerId"];
                $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $Dealer){}
            
                }
        }

        
    }

    if (isset($_REQUEST['btn_received'])) {

        $orderid = $_REQUEST['txt_OrderId'];
        $sql ="SELECT * FROM tbl_orderdetail WHERE $orderid = OrderId";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) {
            $data[] = $row;   
        }
        foreach($data as $key => $Orderde)

        {
            $MedId = $Orderde["MedId"];
            $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
            $result = $conn->query($sqli);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $med){

            $OrderId = $Orderde["OrderId"];
            $sql ="SELECT * FROM tbl_Order WHERE $OrderId = OrderId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $Order){

            $DealerId = $Order["DealerId"];
            $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                }
                foreach($data as $key => $Dealer){

                }
        
            }
        }
    }



        $OrderId = $_REQUEST['txt_OrderId'];
        $RecName = $_REQUEST['RecName'];
        $RecTime = date("Y-m-d h:i:sa");
        $Qty = $_REQUEST['qtymed'];
        $RecDeli = $_REQUEST['txt_delivery'];
        $MfdDate = $_REQUEST['Mfddate'];
        $ExpDate = $_REQUEST['Expdate'];
        $OrderStatus = "Received";
        $Total = $med["MedTotal"];

        $MedTotal = $Total + $Qty;

        $LotStatus = "Avialable";

        $datemfd=date_create($MfdDate);
        $dateexp=date_create($ExpDate);
        $diff=date_diff($datemfd,$dateexp);
        
        
        if($diff->format("%R%a days")<=0)
        {
            $errorMsg ="Error,Please enter a new expiration date. ";
        }
        
         if (empty($OrderId)) {
            $errorMsg = "Please Enter Lot Id";
        } else if (empty($RecName)) {
            $errorMsg = "Please Enter Received Name";
        } else if (empty($Qty)) {
            $errorMsg = "Please Enter Medicine Quantity";
        } else if (empty($RecDeli)) {
            $errorMsg = "Please Enter Received Delivery";
        }else if (empty($MfdDate)) {
            $errorMsg = "Please Enter Manufactured Date";
        }else if (empty($ExpDate)) {
            $errorMsg = "Please Enter Expiration Date";
        }  else 

                   /* {

                        $sql = "INSERT INTO tbl_received(OrderId, MedId, RecName, RecTime, RecDeli, Qty, MfdDate, ExpDate) VALUES ('$OrderId', '$MedId', '$RecName', '$RecTime', '$RecDeli', '$Qty', '$MfdDate', '$ExpDate')";
                        $result = mysql_query($sql,$conn);

                        $lastid = mysql_insert_id($conn);
                        mysql_free_result($result);

                        $sql = "INSERT INTO tbl_lot(RecId, Qty, LotStatus) VALUES ('$lastid', '$Qty', '$LotStatus')";
                        $result = mysql_query($sql,$conn);
                        mysql_free_result($result);


                        
                        $sql = "UPDATE tbl_order SET OrderStatus = 'Received' WHERE $OrderId=OrderId";
                        if ($conn->query($sql) === TRUE) {
                            
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }

                        $sql = "UPDATE tbl_med set MedTotal = '$MedTotal' WHERE $MedId=MedId";
                        if ($conn->query($sql) === TRUE) {
                            
                        } else {
                        echo "Error updating record: " . $conn->error;
                        }
                        
                        if ($insert_stmt->execute()) {
                            $insertMsg = "Insert Successfully...";

                        $user_id = mysql_insert_id( $conn );
                            header("refresh:1;main.php");
                    }*/

            
                if (!isset($errorMsg)) {
                    

                    $sql = "INSERT INTO tbl_received(OrderId, MedId, RecName, RecTime, RecDeli, Qty, MfdDate, ExpDate) VALUES ('$OrderId', '$MedId', '$RecName', '$RecTime', '$RecDeli', '$Qty', '$MfdDate', '$ExpDate')";
                    if ($conn->query($sql) === TRUE) {   
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                     
                    $query = "SELECT RecId FROM tbl_received ORDER BY RecId DESC LIMIT 1";
                    $result = mysqli_query($conn, $query); 
                    $row = mysqli_fetch_array($result);
                    $RecId = $row["RecId"];
                
                    
                    $sql = "INSERT INTO tbl_lot(RecId, Qty, LotStatus) VALUES ('$RecId', '$Qty', '$LotStatus')";
                    if ($conn->query($sql) === TRUE) { 
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $sql = "UPDATE tbl_order SET OrderStatus = 'Received' WHERE $OrderId=OrderId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }

                    $sql = "UPDATE tbl_med SET MedTotal = '$MedTotal' WHERE $MedId=MedId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }
                      
                    //if ($insert_stmt->execute()) {
                       // $insertMsg = "Insert Successfully...";
                        header("refresh:1;main.php");
                    }
                
            } //catch (PDOException $e) {
                //echo $e->getMessage();
                    
            
 

   

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>




    
</head>

<body>



        <?php
            include('slidebar.php');
        ?>


<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Received Data</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li> 

                        <li class ="nav-itm">
                            <a  onload="startTime()"></a>
                            <div id="time"></div>
                        </li> 
                        
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


      
        
    
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

    

        <form method="post" class="form-horizontal mt-5" name="myform">

        



            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Order </label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderId" class="form-control" value="<?php echo $Orderde["OrderId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Order Date</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderDate" class="form-control" value="<?php echo $Order["OrderDate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Dealer Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_DealerName" class="form-control" value="<?php echo $Dealer["DealerName"]; ?>" readonly>
                    </div>
                </div>
            </div>
            
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Dealer Address</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_OrderDate" class="form-control" value="<?php echo $Dealer["DealerAddress"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Medicine</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine pack" class="col-sm-3 control-label">Unit/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Price/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Quantity" class="col-sm-3 control-label">Quantity/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" id="quantity" name="qtymed"  class="form-control" value="<?php echo $Orderde["Qty"]?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Cost</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Cost" class="form-control" value="<?php echo $Orderde["OrderPrice"]?>" >
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label class="col-sm-3 control-label">Received Name</label>
                        <div class="col-sm-1">
                            <select name="RecName">       
                                <?php 
                                    $sql = 'SELECT * FROM tbl_staff';
                                    $result = $conn->query($sql);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) 
                                        {
                                            $data[] = $row;   
                                        }
                                        foreach($data as $key => $staff){                  
                                ?>
                                    <option value ="<?php echo $staff["StaffId"];?>"><?php echo $staff["StaffName"];?></option>
                                <?php } ?>      
                            </select><br>
                        </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Delivery man </label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_delivery" class="form-control"  placeholder="Please enter delivery name..">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">MFD Date</label>
                    <div class="col-sm-1">
                    <input type="date"  name="Mfddate"
                                        value="<?php echo date('Y-m-j'); ?>" required
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">EXP Date</label>
                    <div class="col-sm-1">
                    <input type="date"  name="Expdate"
                                        value="<?php echo date('Y-m-j'); ?>" required
                                        min="2021-3-22" max="2030-12-31">
                    </div>
                </div>
            </div>

            
            

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_received" class="btn btn-success" value="Received">
                    <a href="Received.php" class="btn btn-danger">Back</a>
                </div>
            </div>

           

        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>