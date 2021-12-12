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

    if (isset($_REQUEST['submit'])) {
        $search = $_REQUEST['textsearch'];

       
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
                        <form action="ClaimReceivedSearch.php" method="post">
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
                    <th>Claim ID</th>
                    <th>Lot Id</th>
                    <th>Quantity</th>
                    <th>Reason</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Delivery Name</th>
                    <th>Edit</th>
                    <th>Report</th>                   
                </tr>

            <tbody>
                <?php 
                        $sql = "SELECT tbl_claim.ClaimId,tbl_claim.Qty,tbl_claim.Reason,tbl_claim.ClaimStatus,tbl_claim.LotId,tbl_claim.StaffId,tbl_claim.DealerId,tbl_claim.MedId,tbl_staff.StaffName,tbl_recclaim.RecClaimid,tbl_recclaim.ClaimId,tbl_recclaim.RecClaimName,tbl_recclaim.RecClaimdate
                        FROM tbl_recclaim
                        INNER JOIN tbl_claim ON tbl_recclaim.ClaimId = tbl_claim.ClaimId
                        INNER JOIN tbl_staff ON tbl_recclaim.StaffId = tbl_staff.StaffId 
                        WHERE RecClaimdate LIKE '%{$search}%' || ClaimStatus LIKE '%{$search}%'";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $claim){
       
                ?>

                    <tr>
                        <td><?php echo $claim["ClaimId"]; ?></td>
                        <td><?php echo $claim["LotId"]; ?></td>
                        <td><?php echo $claim["Qty"];?></td>
                        <td><?php echo $claim["Reason"];?></td>
                        <td><?php echo $claim["RecClaimName"]; ?></td>
                        <td><?php echo $claim["ClaimStatus"]; ?></td>
                        <td><?php echo $claim["RecClaimdate"]; ?></td>
                        <td>
                            <form method = "POST" action = "Receivededitclaim.php">
                                <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Edit" class = "btn btn-primary"
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
                                <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Cancel_id" class="btn btn-danger"
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
                        <form method = "POST" action = "Reportreceivedclaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Report" class="btn btn-danger">Report</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $claim["ClaimId"]; ?>">
                        </form>
                    </td>
                        
                    </tr>

                    <?php 
                }?>
          
            </tbody>
        </table>
    </div>

    <form method = "POST" action = "Exportreceivedclaim.php">
        <select name="Year">
            <option value="2021-">2021</option>
            <option value="2022-">2022</option>
            <option value="2023-">2023</option>
            <option value="2024-">2024</option>
            <option value="2025-">2025</option>
        </select>
        <select name="Month">
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
            <button type = "submit" value = "<?php echo $with["WithId"]; ?>" name = "Report" class="btn btn-danger">Report</button>
    </form>


    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
  
    
</body>
</html>