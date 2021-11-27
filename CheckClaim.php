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
                <th>Report</th>
            </tr>
        

        <tbody>
            <?php 
                    $sql = "SELECT * FROM tbl_claim";
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $claim){

                        $dealerid = $claim["DealerId"];
                        $sql ="SELECT * FROM tbl_dealer WHERE DealerId = $dealerid";
                        $result = $conn->query($sql);
                        $data = array();
                            while($row = $result->fetch_assoc()) {
                                $data[] = $row;   
                            }
                            foreach($data as $key => $deal){
                                
                        $staffid = $claim["StaffId"];
                        $sql ="SELECT * FROM tbl_staff WHERE StaffId = $staffid";
                        $result = $conn->query($sql);
                        $data = array();
                            while($row = $result->fetch_assoc()) {
                                $data[] = $row;   
                            }
                            foreach($data as $key => $staff){
                                $ClaimStatus = $claim["ClaimStatus"];
                        
            ?>

                <tr>
                    <td><?php echo $claim["ClaimId"]; ?></td>
                    <td><?php echo $claim["ClaimDate"]; ?></td>
                    <td><?php echo $claim["ClaimStatus"]; ?></td>
                    <td><?php echo $claim["LotId"]; ?></td>
                    <td><?php echo $claim["Qty"]; ?></td>
                    <td><?php echo $deal["DealerName"]; ?></td>
                    <td><?php echo $deal["DealerAddress"]; ?></td>
                    <td>
                        <form method = "POST" action = "ReceivdClaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Claim_id" class = "btn btn-primary"
                                <?php
                                    if($ClaimStatus == "Received")
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
                        <form method = "POST" action = "Reportclaim.php">
                            <button type = "submit" value = "<?php echo $claim["ClaimId"]; ?>" name = "Report" class="btn btn-danger">Report</button>
                            <input type ="hidden" name = "valueid" value = "<?php echo $claim["ClaimId"];?>">
                        </form>
                    </td>
                    
                </tr>

                <?php 
            }}}?>

                

            
        </tbody>
    </table>
</div>

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    
</body>
</html>