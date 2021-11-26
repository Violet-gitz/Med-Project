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

    // if (isset($_REQUEST['Report'])) 
    // {
    //     require_once __DIR__ . '/vendor/autoload.php';
    //     $mpdf = new \Mpdf\Mpdf();

    //     $orderid = $_REQUEST["valueid"];
       
    //     $mpdf->WriteHTML
    //     (
    //        "Test" . $orderid

    //             );
    //     // Output a PDF file directly to the browser
    //     $mpdf->Output();
    // }

    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT * FROM tbl_staff WHERE StaffName = '$staff'";
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

        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form action="OrderSearch.php" method="post">
                            <input type="text" name="textsearch" placeholder = "Search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
            </div>
        </div><br>


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
                    <th>Report</th>
                    
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

                        <td>
                            <form method = "POST" action = "Reportorder.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Report" class="btn btn-danger">Report</button>
                                <input type ="hidden" name = "valueid" value = "<?php echo $order["OrderId"];?>">
                            </form>
                        </td>
                        
                    </tr>

                    <?php 
                }?>

                    

                
            </tbody>
        </table>
    </div>


    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
  
    
</body>
</html>