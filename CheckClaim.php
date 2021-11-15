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

        <?php
            include('slidebar.php');
        ?>

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
                        <form method = "POST" action = "Receiveddata.php">
                            <button type = "submit" value = "<?php echo $order["OrderId"]; ?>" name = "Received_id" class = "btn btn-primary"
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
                    
                </tr>

                <?php 
            }}}?>

                

            
        </tbody>
    </table>
</div>
    
</body>
</html>