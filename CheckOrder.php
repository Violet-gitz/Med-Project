<?php 
     include('Connect.php'); 

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

    if (isset($_REQUEST['Cancel_id'])) 
    {
        $orderid = $_REQUEST['Cancel_id'];
        $status = "Cancel";
        $sql = "UPDATE tbl_order SET OrderStatus = 'Cancel' WHERE OrderId = $orderid";
        if ($conn->query($sql) === TRUE) {     
        } else {
          echo "Error updating record: " . $conn->error;
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
            <h1 class="navbar-brand">Received Medicine</h1>
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


    <div class="container-sm">
    
        <table class="table table-bordered">
            <thead>
                List order buy
            </thead>
                <tr>
                    <th>Order</th>
                    <th>Date order</th>
                    <th>Status</th>
                    <th>Price</th>   
                    <th>Dealer</th>
                    <th>Staff</th>
                    <th>Received</th>
                    <th>Cancel</th>
                </tr>
            

            <tbody>
                <?php 
                        $sql = "SELECT tbl_order.OrderId,tbl_order.OrderDate,tbl_order.OrderStatus,tbl_order.OrderPrice,tbl_order.OrderPrice,tbl_order.OrderTotal,tbl_order.StaffName,tbl_dealer.DealerName,tbl_dealer.DealerAddress
                        FROM tbl_order
                        INNER JOIN tbl_dealer ON tbl_order.DealerId = tbl_dealer.DealerId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $order){
                            $OrderStatus = $order["OrderStatus"];
                            
                ?>

                    <tr>
                        <td><?php echo $order["OrderId"]; ?></td>
                        <td><?php echo $order["OrderDate"]; ?></td>
                        <td><?php echo $order["OrderStatus"]; ?></td>
                        <td><?php echo $order["OrderTotal"]; ?></td>
                        <td><?php echo $order["DealerName"]; ?></td>
                        <td><?php echo $order["StaffName"]; ?></td>
                        <td>
                            <form method = "POST" action = "Receiveddata.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Received_id" class = "btn btn-primary"
                                    <?php
                                        if($OrderStatus == "Received")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($OrderStatus == "Cancel")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                    ?>
                                    >Received
                                </button>
                            </form>
                        </td>

                        <td>
                            <form method = "POST" action = "CheckOrder.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Cancel_id" class="btn btn-danger"
                                    <?php
                                        if($OrderStatus == "Received")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($OrderStatus == "Cancel")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                    ?>
                                    >Cancel
                                </button>
                            </form>
                        </td>
                        
                    </tr>

                    <?php 
                }?>

                    

                
            </tbody>
        </table>
    </div>



  
    
</body>
</html>