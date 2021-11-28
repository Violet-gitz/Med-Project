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

    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];


        //Delete an original record from db
        //$sql = 'DELETE FROM tbl_Med WHERE MedId' =.$id);
        $sql = "DELETE FROM tbl_med where MedId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
    }

    if (isset($_REQUEST['submit'])) {
        $search = $_REQUEST['textsearch'];

       
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

        <div class="container">
            <div class="row">
                    <div class="col-md-4 ms-auto">
                        <form action="Receivedsearch.php" method="post">
                            <input type="text" name="textsearch" placeholder = "Search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
            </div>
        </div><br>

        <div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            List order received
        </thead>
            <tr>
                <th>Received ID</th>
                <th>Order Id</th>
                <th>Price</th>
                <th>Order status</th>
                <th>Date</th>
                <th>Staff</th>
                <th>Delivery Name</th>
                <th>Edit</th>
                <th>Report</th>
                
            </tr>
        

        <tbody>
            <?php 
                    $sql = "SELECT tbl_received.RecId,tbl_received.RecDate,tbl_received.RecDeli,tbl_order.OrderId,tbl_order.OrderStatus,tbl_order.OrderPrice,tbl_order.OrderTotal,tbl_staff.StaffName 
                    FROM tbl_received
                    INNER JOIN tbl_order ON tbl_received.OrderId = tbl_order.OrderId
                    INNER JOIN tbl_staff ON tbl_received.StaffId = tbl_staff.StaffId 
                    WHERE RecId  LIKE '%{$search}%' || RecDate  LIKE '%{$search}%' ";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $rec){

                        // $OrderStatus = $order["OrderStatus"];
                       
                        
            ?>

                <tr>
                    <td><?php echo $rec["RecId"]; ?></td>
                    <td><?php echo $rec["OrderId"]; ?></td>
                    <td><?php echo $rec["OrderPrice"];?></td>
                    <td><?php echo $rec["OrderStatus"];?></td>
                    <td><?php echo $rec["RecDate"]; ?></td>
                    <td><?php echo $rec["StaffName"]; ?></td>
                    <td><?php echo $rec["RecDeli"]; ?></td>
                    <td>
                        <form method = "POST" action = "Receivededit.php">
                            <button type = "submit" value = "<?php echo $rec["RecId"]; ?>" name = "Edit" class = "btn btn-primary"
                                <?php
                                    // if($OrderStatus == "Received")
                                    // {
                                    //     $buttonStatus = "Disabled";
                                    //     echo $buttonStatus;
                                    // }
                                    // else if($OrderStatus == "Cancel")
                                    // {
                                    //     $buttonStatus = "Disabled";
                                    //     echo $buttonStatus;
                                    // }
                                ?>
                                >Edit
                            </button>
                        </form>
                    </td>

                    <!-- <td>
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
                    </td> -->

                    <td>
                        <form method = "POST" action = "Reportreceived.php">
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