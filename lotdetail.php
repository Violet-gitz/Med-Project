
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
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POSt" action="Staffedit.php">
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

        <form method="post" class="form-horizontal mt-5" name="myform">

        <?php 
         if (isset($_REQUEST['detail'])) 
         {
                 $lotid = $_REQUEST['detail'];
                 $sql ="SELECT * FROM tbl_lot WHERE LotId = $lotid";
                 $result = $conn->query($sql);
                 $data = array();
                 while($row = $result->fetch_assoc()) {
                     $data[] = $row;   
                 }
                 foreach($data as $key => $lot)
                 {
                     $checkclaim = $lot["RecClaimid"];
                     if(is_null($checkclaim))
                     {
     
                         $sqli ="SELECT * FROM tbl_receiveddetail WHERE LotId = $lotid";
                         $result = $conn->query($sqli);
                         $data = array();
                             while($row = $result->fetch_assoc()) {
                                 $data[] = $row;   
                             }
                             foreach($data as $key => $recedetail)
                             {
                                 $recid = $recedetail["RecId"];
     
                                 $sql ="SELECT * FROM tbl_received WHERE RecId = $recid";
                                 $result = $conn->query($sql);
                                 $data = array();
                                     while($row = $result->fetch_assoc()) {
                                         $data[] = $row;   
                                     }
                                     foreach($data as $key => $rec)
                                     {
                                         
                                         $orderid = $rec["OrderId"];
                                         $sql ="SELECT * FROM tbl_order WHERE OrderId = $orderid";
                                         $result = $conn->query($sql);
                                         $data = array();
                                             while($row = $result->fetch_assoc()) {
                                                 $data[] = $row;   
                                             }
                                             foreach($data as $key => $Order)
                                             {
     
                                                 $DealerId = $Order["DealerId"];
                                                 $sql ="SELECT * FROM tbl_dealer WHERE $DealerId = DealerId";
                                                 $result = $conn->query($sql);
                                                 $data = array();
                                                     while($row = $result->fetch_assoc()) {
                                                         $data[] = $row;   
                                                     }
                                                     foreach($data as $key => $Dealer)
                                                     {

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Order Id</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Order["OrderId"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Order Date</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Order["OrderDate"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Name </label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerName"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Address</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerAddress"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Phone</label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerPhone"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';

            echo '<div class="form-group text-center">'; 
            echo    '<div class="row">';
            echo        '<label for="Tel" class="col-sm-3 control-label">Delivery name </label>';
            echo            '<div class="col-sm-7">';
            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$rec["RecDeli"].'" readonly>';
            echo            '</div>';
            echo    '</div>';
            echo '</div>';
                                                        }
                                        
                                                }   
                                        }
                                }
                // $i = 0;
                // $orderid = $recedetail['OrderId'];
                // $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                // $result = $conn->query($sql);
                // $data = array();
                // while($row = $result->fetch_assoc()) {
                // $data[] = $row;  
                // }
                // foreach($data as $key => $orderdetailid)
                // {

                    $MedId = $recedetail["MedId"];
                    $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                    $result = $conn->query($sqli);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    
                    foreach($data as $key => $med)
                    {
                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Lot</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$lot["LotId"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label"></label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<div><img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"].'"> </div>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Medicine</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedName"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Quantity</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$recedetail["Qty"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Unit/Pack</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedPack"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Price/Pack</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedPrice"].' ฿" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';
                                           
                }
            }

            else if(!empty($checkclaim))
            {
                
                $sql ="SELECT * FROM tbl_recclaim WHERE $checkclaim = RecClaimid";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) {
                $data[] = $row;   
                }
                foreach($data as $key => $recclaim)
                {
                    $claimid = $recclaim["ClaimId"];
                    $sql ="SELECT * FROM tbl_claim WHERE $claimid = ClaimId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    foreach($data as $key => $claim)
                    {
                        $dealerid = $claim["DealerId"];

                        $sql ="SELECT * FROM tbl_dealer WHERE $dealerid = DealerId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                        }
                        foreach($data as $key => $Dealer)
                        {
                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Claim Id</label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$claim["ClaimId"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';

                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Claim Date</label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$claim["ClaimDate"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';

                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Name </label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerName"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';

                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Address</label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerAddress"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';

                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Dealer Phone</label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$Dealer["DealerPhone"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';

                            echo '<div class="form-group text-center">'; 
                            echo    '<div class="row">';
                            echo        '<label for="Tel" class="col-sm-3 control-label">Delivery name </label>';
                            echo            '<div class="col-sm-7">';
                            echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$recclaim["RecClaimName"].'" readonly>';
                            echo            '</div>';
                            echo    '</div>';
                            echo '</div>';
                        }
                    }

                    $MedId = $claim["MedId"];
                    $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                    $result = $conn->query($sqli);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                    $data[] = $row;   
                    }
                    
                    foreach($data as $key => $med)
                    {
                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Lot</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$lot["LotId"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label"></label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<div><img style = "width:325px;height:325px"  src="upload/'. $med["MedPath"].'"> </div>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Medicine</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedName"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Quantity</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$claim["Qty"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Unit/Pack</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedPack"].'" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';

                        echo '<div class="form-group text-center">'; 
                        echo    '<div class="row">';
                        echo        '<label for="Tel" class="col-sm-3 control-label">Price/Pack</label>';
                        echo            '<div class="col-sm-7">';
                        echo                '<input type="text" name="txt_OrderId" class="form-control" value="'.$med["MedPrice"].' ฿" readonly>';
                        echo            '</div>';
                        echo    '</div>';
                        echo '</div>';
                }
            }
        }
            
         }
        }
            ?>

    

            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    
                    <a href="Lot.php" class="btn btn-danger">Back</a>
                </div>
            </div>

            
        </form>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
