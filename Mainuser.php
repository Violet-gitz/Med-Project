
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
                    include('slidebaruser.php');   
                    ?>
                </div>
                <div> 
                  <a href="Mainuser.php" class="navbar-brand">Home Page</a>
                </div>

                <!-- <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
                <div id="navbar1" class="collapse navbar-collapse" style='justify-content: end;'>
                    <div class="dropdown">

                        <div id="navbar1" class="collapse navbar-collapse">
                            <ul class="navbar-nav ms-auto">

                                <li class="nav-item" style='margin-right: 15px;'>
                                    <td><a href="cartuser.php" class ="btn btn-success">Cart</a></td>
                                </li>

                                <button class="btn btn-info  dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                ><?php echo $_SESSION['StaffName'] ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <form method="POST" action="edituser.php">
                                            <a class="dropdown-item" href="edituser.php?update_id=<?php echo $staff["StaffId"];?>">Edit</a>
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

    

    <div class="container-sm">
    
        <table class="table table-striped" style='margin-top:4rem;'>
            <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Quantity</th>
                    <th>Withdraw</th>

                   
                </tr>
            </thead>

            <tbody>
                <?php                    
                        $sql = 'SELECT * FROM tbl_med';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){
                            $sumReserve = 0;
                            $medtotal = $Med["MedTotal"];
                            $medid = $Med["MedId"];

                            $sql = "SELECT * FROM tbl_lot WHERE MedId = '$medid'";
                            $result = $conn->query($sql);
                            $data = array();
                            while($row = $result->fetch_assoc()) {
                                $data[] = $row;   
                            }
                            foreach($data as $key => $lot)
                            {
                                $lotReserve = $lot["Reserve"];
                                $sumReserve = $sumReserve + $lotReserve;
                                $sum = $medtotal - $sumReserve;
                            }
                ?>

                    <tr>
                        <form action = "cartuser.php" method="post">
                        <td><?php echo '<img src="upload/'.$Med['MedPath'].'" height = "80" widht = "80"/>';?></td>
                        <td><?php echo $Med["MedName"]; ?></td>
                        <td><?php echo $Med["MedDes"]; ?></td>
                        <td><?php echo $sum; ?></td>
                        <td><input type="number" name="quantity" min="1" max="<?php echo $sum; ?>" value= "1"></td>
                        <td><input type="submit" class = "btn btn-info" value = "Add to cart"></td>
                        <input type ="hidden" name = "testMedId" value = "<?php echo $Med["MedId"]; ?>">
                        <input type ="hidden" name = "act" value = "add">
                        </form>
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