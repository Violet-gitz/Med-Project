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


    if (isset($_POST['Order'])) {
        
            $id = $_POST['Order'];
            $sql ="SELECT * FROM tbl_order WHERE $id = OrderId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Order)

            {
                $idmed = $Order["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}
            }

    }

    if (isset($_REQUEST['btn_Buy'])) {

            $id = $_REQUEST['txt_OrderId'];
            $sql ="SELECT * FROM tbl_order WHERE $id = OrderId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
                $data[] = $row;   
            }
            foreach($data as $key => $Order)

            {
                $idmed = $Order["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){}
            }    


        $OrderId = $_REQUEST['txt_OrderId'];
        $Qty = $_REQUEST['qtymed'];
        $Price = $_REQUEST['txt_Cost'];
        
        $OrderStatus = "Buy";
        
         if (empty($OrderId)) {
            $errorMsg = "Please Enter Order Id";
        } else if (empty($idmed)) {
            $errorMsg = "Please Enter Medicine Id";
        } else if (empty($Qty)) {
            $errorMsg = "Please Enter Medicine Quantity";
        } else if (empty($Price)) {
            $errorMsg = "Please Enter Price";
        }  else {
            try {
                if (!isset($errorMsg)) {
                    
                    $insert_stmt = $db->prepare("INSERT INTO tbl_orderdetail(OrderId, MedId, Qty, Orderprice ) VALUES (:1name, :2name, :3name, :4name)");
                    
                    $insert_stmt->bindParam(':1name', $OrderId);
                    $insert_stmt->bindParam(':2name', $idmed);
                    $insert_stmt->bindParam(':3name', $Qty);
                    $insert_stmt->bindParam(':4name', $Price);

                    $sql = "UPDATE tbl_order SET OrderStatus = '$OrderStatus' WHERE $id=OrderId";
                    if ($conn->query($sql) === TRUE) {
                        
                    } else {
                      echo "Error updating record: " . $conn->error;
                    }


                    if ($insert_stmt->execute()) {
                        $insertMsg = "Insert Successfully...";
                        header("refresh:1;Order.php");
                    }
                }
            } catch (PDOException $e) {
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

    <script>
            
            function calculate() {
    if (isNaN(document.forms["myform"]["txt_MedPrice"].value) || document.forms["myform"]["txt_MedPrice"].value == "") {
        var text1 = 0;
    } else {
        var text1 = parseInt(document.forms["myform"]["txt_MedPrice"].value);
    }
    if (isNaN(document.forms["myform"]["qtymed"].value) || document.forms["myform"]["qtymed"].value == "") {
        var text2 = 0;
    } else {
        var text2 = parseFloat(document.forms["myform"]["qtymed"].value);
    }
    document.forms["myform"]["txt_Cost"].value = (text1*text2)+((text1 * text2)*0.07);
}
                   
                
    </script>
    
    
</head>

<body>

        <?php
            include('slidebar.php');
        ?>


<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Medicine Buy</h1>
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
                            <input type="text" name="txt_OrderId" class="form-control" value="<?php echo $Order["OrderId"]; ?>">
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Medicine</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_MedName" class="form-control" value="<?php echo $med["MedName"]; ?>">
                    </div>
                </div>
            </div>
            

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Category" class="col-sm-3 control-label">Category</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedCate" class="form-control" value="<?php echo $med["MedCate"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Volumn" class="col-sm-3 control-label">Volumn</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedVolumn" class="form-control" value="<?php echo $med["MedVolumn"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Unit" class="col-sm-3 control-label">Unit</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedUnit" class="form-control" value="<?php echo $med["MedUnit"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine pack" class="col-sm-3 control-label">Unit/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPack" class="form-control" value="<?php echo $med["MedPack"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Price/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_MedPrice" class="form-control" value="<?php echo $med["MedPrice"]; ?>">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Quantity" class="col-sm-3 control-label">Quantity/Pack</label>
                    <div class="col-sm-7">
                        <input type="text" id="quantity" name="qtymed"  class="form-control" onkeyup="calculate()">
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Medicine Price" class="col-sm-3 control-label">Cost</label>
                    <div class="col-sm-7">
                        <input type="text" name="txt_Cost" class="form-control" >
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type="submit" name="btn_Buy" class="btn btn-success" value="Buy">
                    <a href="Order.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            

        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>