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


     if (isset($_GET['logout'])) {
            session_destroy();
            unset($_SESSION['StaffUsername']);
            header('location: login.php');
        }

    if (isset($_REQUEST['Cancel_id'])) 
        {
            $withid = $_REQUEST['Cancel_id'];
    
            $sql = "UPDATE tbl_withdraw SET WithStatus = 'Cancel' WHERE WithId = $withid";
            if ($conn->query($sql) === TRUE) {     
            } else {
              echo "Error updating record: " . $conn->error;
            }
            
            $sql = "SELECT * FROM tbl_withdraw WHERE WithId = '$withid'";
            $result = $conn->query($sql);
            $data = array();
                while($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;  
                }
                foreach($data as $key => $withdraw)
                {      

                    $withdrawId = $withdraw["WithId"];
                    $sql = "SELECT * FROM tbl_withdrawdetail WHERE WithId = '$withid'";
                    $result = $conn->query($sql);
                    $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;  
                        }
                        foreach($data as $key => $withdrawdetail)
                        {   
                            $lotid = $withdrawdetail["LotId"];
                            $sql = "SELECT * FROM tbl_lot WHERE LotId = '$lotid'";
                            $result = $conn->query($sql);
                            $data = array();
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;  
                                }
                                foreach($data as $key => $lot)
                                {
                                    $withqty = $withdrawdetail["Qty"];
                                    $Reserve = $lot["Reserve"];
                                    $sum = $Reserve - $withqty;

                                    $sql = "UPDATE tbl_lot SET Reserve = '$sum' WHERE LotId = $lotid";
                                    if ($conn->query($sql) === TRUE) {     
                                    } else {
                                      echo "Error updating record: " . $conn->error;
                                    }

                                }

                        }
                }
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
            <div style='margin-right: 15px'>           
            <?php
                include('slidebar.php');      
            ?></div>
                <a href="main.php" class="navbar-brand">Home Page</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse" style="justify-content: end;">
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
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

<div class="container">

<div class="container-sm">
    <div class="row mb-5">
            <div class="col-md-4 ms-auto " style="text-align: end;">
                <form action="ApproveSearch.php" method="post">
                    <input type="text" name="textsearch" placeholder = "search">
                    <input type="submit" name="submit" value="Search">
                </form>
            </div>
    </div>
    <form method = "POST" action = "Exportapprove.php" style='display: flex;justify-content: end;'>
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
            List Approve
           </div>
            <thead >
                <th>WithId</th>
                <th>StaffId</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>WithDate</th>
                <th>Action</th>
                <th>Report</th>
                <th>Cancel</th>        
        </thead>
        <tbody>
            <?php 
                    $sql = "SELECT * FROM tbl_withdraw";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $with){

                        $staffid = $with["StaffId"];
                        $sql = "SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $staff){
                            $withstatus = $with["WithStatus"];
                      
            ?>

                <tr>
                    <td><?php echo $with["WithId"]; ?></td>
                    <td><?php echo $staff["StaffName"]; ?></td>
                    <td><?php echo $with["Qtysum"]; ?></td>
                    <td><?php echo $with["WithStatus"]; ?></td>
                    <td><?php echo $with["WithDate"]; ?></td>
                    <td>
                            <form method = "POST" action = "Approvedetaill.php?">
                                <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Approve" class = "btn btn-success"
                                    <?php
                                        if($withstatus == "Approved")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($withstatus == "Cancel")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                       
                                    ?>
                                    >Approve
                                </button>
                            </form>
                    </td>

                    <td>
                        <form method = "POST" action = "Reportwithdraw.php">
                            <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-primary">Report</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $with["WithId"]; ?>">
                        </form>
                    </td>

                    <td>
                            <form method = "POST" action = "Approve.php">
                                <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Cancel_id" class="btn btn-danger"
                                    <?php
                                        if($withstatus == "Approved")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($withstatus == "Cancel")
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

                <?php } } ?>
            
            
        </tbody>
    </table>
    </div>

                       

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

  
</body>
</html>