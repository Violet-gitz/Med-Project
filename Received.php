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


      



    <div class="container-sm">
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Medicine Name</th>
                    <th>QTY</th>
                    <th>Price</th>
                    <th>Date order</th>
                    <th>Dealer</th>
                    <th>Staff</th>
                    <th>Status</th>
                    <th>Received</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                        $sql = 'SELECT tbl_orderdetail.OrderId,tbl_orderdetail.MedId,tbl_orderdetail.QTY,tbl_orderdetail.OrderPrice,tbl_order.OrderDate,tbl_order.OrderStatus,tbl_order.DealerId,tbl_order.StaffId,tbl_med.MedName
                        FROM tbl_orderdetail
                        INNER JOIN tbl_order ON tbl_orderdetail.OrderId = tbl_order.OrderId
                        INNER JOIN tbl_med ON tbl_orderdetail.MedId = tbl_med.MedId;';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $order){

                            $dealerid = $order["DealerId"];
                            $sqli ="SELECT * FROM tbl_dealer WHERE $dealerid = DealerId";
                            $result = $conn->query($sqli);
                            $data = array();
                                while($row = $result->fetch_assoc()) {
                                    $data[] = $row;   
                                }
                                foreach($data as $key => $dealer){

                                    $staffid = $order["StaffId"];
                                    $sqli ="SELECT * FROM tbl_staff WHERE $staffid = StaffId";
                                    $result = $conn->query($sqli);
                                    $data = array();
                                    while($row = $result->fetch_assoc()) {
                                    $data[] = $row;   
                                }
                                    foreach($data as $key => $staff){

                                        $buttonStatus;
                                        $OrderStatus = $order["OrderStatus"];
                ?>

                    <tr>
                        <td><?php echo $order["OrderId"]; ?></td>
                        <td><?php echo $order["MedName"]; ?></td>
                        <td><?php echo $order["QTY"]; ?></td>
                        <td><?php echo $order["OrderPrice"]; ?></td>
                        <td><?php echo $order["OrderDate"]; ?></td>
                        <td><?php echo $dealer["DealerName"]; ?></td>
                        <td><?php echo $staff["StaffName"]; ?></td>
                        <td><?php echo $order["OrderStatus"]; ?></td>
                        <!-- <td><a href="Receiveddata.php?Received_id=<?php echo $order["OrderId"];?>" class="btn btn-primary">Received</a></td> -->
                        <td>
                            <form method = "POST" action = "Receiveddata.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Received_id" class = "btn btn-primary"
                                    <?php
                                        if($OrderStatus == "Received")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                    ?>
                                    >Received
                                </button>
                            </form>
                        </td>
                        
                    </tr>

                    <?php } 
                    }
                }?>

                    

                
            </tbody>
        </table>
    </div>
    

    
    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>