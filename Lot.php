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

        /*if (isset($_GET['delete'])) {
            $id = $_GET['delete'];


        // Delete an original record from db
        //$sql = 'DELETE FROM tbl_Staff WHERE StaffId' =.$id);


        $sql = "DELETE FROM tbl_lot WHERE LotId = '".$id."'";
        if($conn->query($sql) == TRUE){
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
            echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
    }*/
    
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
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  
                            &nbsp;&nbsp;
                        <li class="nav-item">
                            <td><a href="index.php?logout='1'" class ="btn btn-warning">Logout</a></td>
                        </li>

                    </ul>
                </div>
            </div>
        </nav> 
  

</head>


<body>

    <?php
            include('slidebar.php');
            
    ?>


  

<body>


<div class="container-sm">
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Lot Id</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Withdraw</th>
                <th>Write off </th>
                <th>Claim</th> 
            </tr>
        </thead>

        <tbody>
            <?php 
                
                    $sql = "SELECT * FROM tbl_lot";

                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $lot){ 
                         
                            
            ?>

                <tr>
                    <td><?php echo $lot["LotId"]; ?></td>
                    <td><?php echo $lot["Qty"]; ?></td>
                    <td><?php echo $lot["LotStatus"]; ?></td>
                    
                    <td>
                        <form method="POST" action="Withdraw.php">
                            <button type="submit" value = "<?php echo $lot["LotId"]; ?>" name = "withdraw" class = "btn btn-success"
                                <?php 
                                    // if ($Qty<=0)
                                    // {
                                    //     $buttonStatus = "disabled";
                                    //     echo $buttonStatus;
                                    // }
                                    // else if ($LotStatus == "Writeoff")
                                    // {
                                    //     $buttonStatus = "disabled";
                                    //     echo $buttonStatus;
                                    // }
                                ?> 
                            >Withdraw</button>    
                        </form>
                    </td>

                 
                    <!-- <td>
                        <form method = "POST" action ="Writeoff.php">
                            <button type = "submit" value ="<?php echo $lot["LotId"]; ?>" name = "Write" class = "btn btn-success"
                                <?php
                                    if ($LotStatus == "Writeoff")
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($Qty<=0)
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                ?>
                            >Write-off</button>
                        </form>
                    </td> -->
<!-- 
                    <td>
                        <form method = "POST" action = "Claim.php">
                            <button type ="submit" value = "<?php echo $lot["LotId"]; ?>" name = "Claim" class = "btn btn-warning"
                                <?php
                                    if ($Qty<=0)
                                    {
                                        $buttonStatus = "disabled";
                                        echo $buttonStatus;
                                    }
                                    else if ($LotStatus == "Claim")
                                    {
                                        $buttonStatus = "disable";
                                        echo $buttonStatus;
                                    }
                                ?>
                            >Claim</button>
                        </form>
                    </td> -->

                </tr>

                <?php }  ?>
            
            
        </tbody>
    </table>
</div>


  
</body>
</html>