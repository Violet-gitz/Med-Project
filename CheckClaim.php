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

    if (isset($_REQUEST['Cancelclaim'])) 
    {
        $cliamid = $_REQUEST['Cancelclaim'];

        $sql = "UPDATE tbl_claim SET ClaimStatus  = 'Cancel' WHERE ClaimId = $cliamid";
        if ($conn->query($sql) === TRUE) {     
        } else {
        echo "Error updating record: " . $conn->error;
        }
    
        $sql = "SELECT * FROM tbl_claim WHERE ClaimId = '$cliamid'";
        $result = $conn->query($sql);
        $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $claim)
            {   
                $lotid = $claim["LotId"];    
                $claimqty = $claim["Qty"];

                 
                $sql = "UPDATE tbl_lot SET LotStatus = 'Available' , Qty = $claimqty WHERE LotId = $lotid";
                if ($conn->query($sql) === TRUE) {     
                } else {
                echo "Error updating record: " . $conn->error;
                }

                $medid = $claim["MedId"];
                $sql = "SELECT * FROM tbl_med WHERE MedId = '$medid'";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) 
                    {
                        $data[] = $row;  
                    }
                    foreach($data as $key => $med)
                    {
                        $medqty = $med["MedTotal"];
                        $claimqty = $claim["Qty"];
                        $sum = $medqty + $claimqty;
                       
                        $sql = "UPDATE tbl_med SET MedTotal = '$sum' WHERE MedId = $medid";
                        if ($conn->query($sql) === TRUE) {     
                        } else {
                        echo "Error updating record: " . $conn->error;
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
                        <form action="ClaimSearch.php" method="post">
                            <input type="text" name="textsearch" placeholder = "Search">
                            <input type="submit" name="submit" value="Search">
                        </form>
                    </div>
            </div>
        </div><br>

    <div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            List order claim
        </thead>
            <tr>
                <th>ClaimId</th>
                <th>Date Claim</th>
                <th>Status</th>
                <th>LotId</th> 
                <th>Qty</th>
                <th>Dealer</th>
                <th>Dealer Address</th>
                <th>Received</th>
                <th>Cancel</th>
                <th>Report</th>
            </tr>
        

        <tbody>
            <?php 
                    $sql = "SELECT tbl_claim.ClaimId,tbl_claim.LotId,tbl_claim.StaffId,tbl_claim.DealerId,tbl_claim.MedId,tbl_claim.Qty,tbl_claim.Reason,tbl_claim.ClaimDate,tbl_claim.ClaimStatus,tbl_dealer.DealerName,tbl_dealer.DealerAddress,tbl_staff.StaffName
                    FROM tbl_claim
                    INNER JOIN tbl_dealer ON tbl_dealer.DealerId = tbl_claim.DealerId
                    INNER JOIN tbl_lot ON tbl_lot.LotId = tbl_claim.LotId
                    INNER JOIN tbl_med ON tbl_med.MedId = tbl_claim.MedId
                    INNER JOIN tbl_staff ON tbl_staff.StaffId = tbl_claim.StaffId";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $claim){

                     
                                $ClaimStatus = $claim["ClaimStatus"];
                        
            ?>

                <tr>
                    <td><?php echo $claim["ClaimId"]; ?></td>
                    <td><?php echo $claim["ClaimDate"]; ?></td>
                    <td><?php echo $claim["ClaimStatus"]; ?></td>
                    <td><?php echo $claim["LotId"]; ?></td>
                    <td><?php echo $claim["Qty"]; ?></td>
                    <td><?php echo $claim["DealerName"]; ?></td>
                    <td><?php echo $claim["DealerAddress"]; ?></td>
                    <td>
                        <form method = "POST" action = "ReceivdClaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Claim_id" class = "btn btn-primary"
                                <?php
                                    if($ClaimStatus == "Received")
                                    {
                                        $buttonStatus = "Disabled";
                                        echo $buttonStatus;
                                    }
                                    else if($ClaimStatus == "Cancel")
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
                            <form method = "POST" action = "CheckClaim.php">
                                <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Cancelclaim" class="btn btn-danger"
                                    <?php
                                        if($ClaimStatus == "Available")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($ClaimStatus == "Received")
                                        {
                                            $buttonStatus = "Disabled";
                                            echo $buttonStatus;
                                        }
                                        else if($ClaimStatus == "Cancel")
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
                        <form method = "POST" action = "Reportclaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Report" class="btn btn-danger">Report</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $claim["ClaimId"];?>">
                        </form>
                    </td>
                    
                </tr>

                <?php 
            }?>

                

            
        </tbody>
    </table>
</div>

                        <form method = "POST" action = "Exportclaim.php">
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