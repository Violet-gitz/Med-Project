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
                <tr>
                    <th>Order</th>
                    <th>Date order</th>
                    <th>Status</th>
                    <th>Price</th>   
                    <th>Staff</th>
                    <th>Received</th>
                    <th>Cancel</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                            echo $search;
                            $sql = "SELECT * FROM tbl_order WHERE OrderId  LIKE '%{$search}%' || OrderDate  LIKE '%{$search}%' ";
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
                        <td><?php echo $staff["StaffName"]; ?></td>
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

                    <?php } ?>

            </tbody>
        </table>
    </div>
    
        <?php

            // $q = intval($_GET['q']);

            // $sql="SELECT * FROM tbl_lot WHERE MedId = '".$q."'";
            // $result = $conn->query($sql);
            // $data = array();
            // while($row = $result->fetch_assoc()) {
            // $data[] = $row;   
            // }
            // foreach($data as $key => $Lot){
            //     $medid = $Lot["MedId"];
            //     $sql="SELECT * FROM tbl_med WHERE MedId = '".$q."'";
            //     $result = $conn->query($sql);
            //     $data = array();
            //     while($row = $result->fetch_assoc()) {
            //     $data[] = $row;   
            //     }
            //     foreach($data as $key => $Med){
            // echo "<table>";
            // echo "<tr>";
            // echo "<td>" . $Med['MedName'] . "</td>";

            // echo "</tr>";
            // }}
            // echo "</table>";           
        ?>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>