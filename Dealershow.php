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
        $sql = "DELETE FROM tbl_dealer where DealerId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
      
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
            <h1 class="navbar-brand">Dealer Data</h1>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="navbar1" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">

                        
                        <li class="nav-item">
                            <a class="nav-link"><?php echo $_SESSION['StaffName'] ?></a>                
                        </li>  &nbsp;&nbsp;&nbsp;&nbsp;

                        <li class="nav-item">
                            <a href="Dealeradd.php" class="btn btn-success">Add+</a>
                        </li> &nbsp;&nbsp;&nbsp;&nbsp;

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
                <tr>
                    <th>DealerId</th>
                    <th>DealerName</th>
                    <th>DealerAddress</th>
                    <th>DealerPhone</th>
                    <th>ContractStart</th>
                    <th>ContractEnd</th>
                    <th>Edit </th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                    //$select_stmt = ;
                    // $result = mysqli_query($conn, "SELECT * FROM tbl_staff");
                    

                    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        // echo $row;
                        $sql = 'SELECT * FROM tbl_dealer';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $dealer){               
                ?>

                    <tr>
                        <td><?php echo $dealer["DealerId"]; ?></td>
                        <td><?php echo $dealer["DealerName"]; ?></td>
                        <td><?php echo $dealer["DealerAddress"]; ?></td> 
                        <td><?php echo $dealer["DealerPhone"]; ?></td> 
                        <td><?php echo $dealer["ContractStart"]; ?></td> 
                        <td><?php echo $dealer["ContractEnd"]; ?></td> 
                        <td><a href="Dealeredit.php?update_id=<?php echo $dealer["DealerId"];?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $dealer["DealerId"]; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>

                    <?php } ?>

                    

                
            </tbody>
        </table>
    </div>
    

    
    

    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>