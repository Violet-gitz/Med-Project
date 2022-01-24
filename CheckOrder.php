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

    if (isset($_GET['Cancel_id'])) 
    {
        $orderid = $_GET['Cancel_id'];

        $sql = "UPDATE tbl_order SET OrderStatus = 'Cancel' WHERE OrderId = $orderid";
        if ($conn->query($sql) === TRUE) {     
        } else {
          echo "Error updating record: " . $conn->error;
        }
        
    }


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <title>Document</title>

    <script>
      function CancelFunction(id) {
      event.preventDefault(); // prevent form submit
      var form = document.forms["myForm"]; // storing the form
      swal({
             title: "Are you sure?",
             text: "คุณต้องการยกเลิกข้อมูลนี้ใช่ไหม",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((isConfirm) => {

        if (isConfirm) {
            window.location.href="CheckOrder.php?Cancel_id="+id;

        } else {
            swal("ยกเลิกสำเร็จ");
        }
    });

    }
    </script>

    
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
 
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
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

<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="OrderSearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "search">
                    <input type="submit" name="submit" value="Search">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportorder.php" style='display: flex;justify-content: end;'>
        <select name="Year" class='mr-2'>
            <option value="2021-">2021</option>
            <option value="2022-">2022</option>
            <option value="2023-">2023</option>
            <option value="2024-">2024</option>
            <option value="2025-">2025</option>
        </select> 
        <select name="Month" class='mr-2' >
            <option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary mr-2">Report</button>
    </form>
 
    <table class="table table-striped">
         <div style='margin-bottom: 15px;'>
                List order buy
        </div>
        <thead>
                <tr>
                    <th>Order</th>
                    <th>Date order</th>
                    <th>Status</th>
                    <th>Price</th>   
                    <th>Dealer</th>
                    <th>Staff</th>
                    <th>Received</th>
                    <th>Report</th>
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
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Received_id" class = "btn btn-success"
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
                            <form method = "POST" action = "Reportorder.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Report" class="btn btn-primary">Report</button>
                                <input type ="hidden" name = "valueid" value = "<?php echo $order["OrderId"];?>">
                            </form>
                        </td>

                        <td>
                            <form method = "POST" action = "CheckOrder.php">
                                <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Cancel_id" class="btn btn-danger" onclick ="CancelFunction(`<?php echo $order['OrderId']; ?>`)"
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

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
  
    
</body>
</html>