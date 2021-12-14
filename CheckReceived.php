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
                                
                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
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
<div class="container">

<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="Receivedsearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "search">
                    <input type="submit" name="submit" value="Search">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportreceived.php" style='display: flex;justify-content: end;'>
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
                List order received
                </div>
            <thead>
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
    </thead>        
                </tr>
            

            <tbody>
                <?php 
                        $sql = "SELECT tbl_received.RecId,tbl_received.RecDate,tbl_received.RecDeli,tbl_order.OrderId,tbl_order.OrderStatus,tbl_order.OrderPrice,tbl_order.OrderTotal,tbl_staff.StaffName 
                        FROM tbl_received
                        INNER JOIN tbl_order ON tbl_received.OrderId = tbl_order.OrderId
                        INNER JOIN tbl_staff ON tbl_received.StaffId = tbl_staff.StaffId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $rec){     
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
                                <button type = "submit" value = "<?php echo $rec["RecId"]; ?>" name = "Edit" class = "btn btn-warning">Edit</button>
                            </form>
                        </td>

                        <td>
                            <form method = "POST" action = "Reportreceived.php">
                                <button type = "submit" value = "<?php echo $rec["RecId"]; ?>" name = "Report" class="btn btn-primary">Report</button>
                                <input type ="hidden" name = "valueid" value = "<?php echo $rec["RecId"]; ?>">
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