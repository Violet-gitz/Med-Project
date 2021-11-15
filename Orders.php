<?php
        include('connect.php');
        session_start();
        // echo '<pre>';
        // print_r($_SESSION);
        // echo '<pre>';
        // $MedId = !empty($MedId) ? 0 : $_REQUEST['MedId'];
        // $act = !empty($act) ? 0 : $_REQUEST['act'];
        // $Quantity = !empty($Quantity) ? 0 : $_REQUEST['quantity'];
    
        // if($act=='add' && !empty($MedId))
        // {
        //     if(isset($_SESSION['cart'][$MedId]))
        //     {
        //         $_SESSION['cart'][$MedId]+=(int)$Quantity;    
        //     }
        //     else
        //     {
        //         $_SESSION['cart'][$MedId]+=(int)$Quantity;  
        //     }
        // }
     
        // else if($act=='remove' && !empty($MedId))
        // {
        //     unset($_SESSION['cart'][$MedId]);
        // }
     
        /*if($act=='update')
        {
            $price_array = $_POST['MedPrice'];
            foreach($price_array as $MedId=>$MedPrice)
            {
                $_SESSION['cart'][$MedId]=$MedPrice;
            }
        }*/
        
        if (isset($_REQUEST['btn-Order'])) 
        {
            date_default_timezone_set("Asia/Bangkok");
            $OrderDate = date("Y-m-d h:i:sa");
            $OrderStatus = "Ordering";
            $OrderPrice = $_REQUEST['total'];
            $OrderTotal = ($OrderPrice * 0.07)+$OrderPrice;
            $DealerId = $_REQUEST['selDealer'];
            $StaffName = $_SESSION['StaffName'];
            
                if (empty($_SESSION['cart']))
                {
                $errorMsg = "Please Select Medicine";
                header("refresh:1;Medshow.php");
                }else 
                    if (!isset($errorMsg)) 
                    {
                        $sql = "INSERT INTO tbl_order(OrderDate, OrderStatus, OrderPrice, OrderTotal, DealerId, StaffName ) VALUES ('$OrderDate', '$OrderStatus', '$OrderPrice','$OrderTotal', '$DealerId', '$StaffName')";
                        if ($conn->query($sql) === TRUE) {} 
                        else {echo "Error updating record: " . $conn->error;}

                        foreach($_SESSION['cart'] as $MedId=>$Quantity)
                            {
                                $query = "SELECT OrderId FROM tbl_order ORDER BY OrderId DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $OrderId = $row["OrderId"];

                                $sql ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                                $result = $conn->query($sql);
                                $data = array();
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;       
                                }
                                foreach($data as $key => $Med)
                                {
                                    $Medsum = $Quantity*$Med["MedPrice"];
                                    $sql = "INSERT INTO tbl_orderdetail(OrderId, MedId, Qty, Price) VALUES ('$OrderId', '$MedId', '$Quantity','$Medsum')";
                                    if ($conn->query($sql) === TRUE) {unset($_SESSION['cart']);} 
                                    else {echo "Error updating record: " . $conn->error;}
                                }
                            }
                            header("refresh:1;main.php");
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
            <h1 class="navbar-brand">Order list</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  &nbsp;&nbsp;

                        <li class="nav-item">
                            <td><a href="Shipping.php" class ="btn btn-info">Cart</a></td>
                        </li>&nbsp;&nbsp;&nbsp;&nbsp;

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

        <div class="container mt-5">
            <div class="row">
                <?php 
                    
                        $sql ="SELECT * FROM tbl_med";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med)
                        
                        {         
                                  
                ?>
                    <div class="col-md-4">
                    <form action = "Order.php" method="post">
                            <div>
                                <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $Med["MedPath"]; ?>"> </div> 
                            </div>
                            <div>
                                <h5><?php echo "Name  " . $Med["MedName"]; ?></h5> 
                                <h5><?php echo "Description  " . $Med["MedDes"]; ?></h5> 
                                <h5><?php echo "Category  " . $Med["MedCate"]; ?></h5> 
                                <h5><?php echo "Volumn  " . $Med["MedVolumn"]; ?></h5> 
                                <h5><?php echo "Unit  " . $Med["MedUnit"]; ?></h5> 
                                <h5><?php echo "Unit Per Pack  " . $Med["MedPack"] . " Unit"; ?></h5> 
                                <h5><?php echo "Price Per Pack  " . $Med["MedPrice"] . " Bath"; ?></h5> 
                                <input type="number" name="quantity" min="<?php echo $Med["MedLow"]; ?>" max="1000" value= "<?php echo $Med["MedLow"]; ?>"></p>
                                <input type ="hidden" name = "MedId" value = "<?php echo $Med["MedId"];?>">
                                <input type ="hidden" name = "act" value = "add">
                                <input type="submit" class = "btn btn-info" value = "Add to cart"> 
                            </div>
                    </form>
                    </div>
                
            
                    <?php } ?>
            </div>
        </div>
    </form>
    </body>
    </html>