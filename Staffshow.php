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


        // Delete an original record from db
        //$sql = 'DELETE FROM tbl_Staff WHERE StaffId' =.$id);
        $sql = "DELETE FROM tbl_Staff WHERE StaffId = '".$id."'";
        if($conn->query($sql) == TRUE){
            echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
            echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
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

                                <li class="nav-item">
                                    <td><a href="Staffadd.php" class ="btn btn-info">Add</a></td>
                                </li>

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

    <div class="container-sm">
        
        <table class="table table-bordered">
            
                <tr>
                    <th>StaffID</th>
                    <th>Name</th>
                    <th>Telephone</th>
                    <th>Email</th> 
                    <th>Department</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            

            <tbody>
                <?php 
                    //$select_stmt = ;
                    // $result = mysqli_query($conn, "SELECT * FROM tbl_staff");
                    

                    // $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        // echo $row;
                        $sql = 'SELECT * FROM tbl_staff';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) 
                        {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $staff){

                            $Depart = $staff["DepartId"];
                                $sql ="SELECT * FROM tbl_department WHERE $Depart = DepartId";
                                $result = $conn->query($sql);
                                $data = array();
                                    while($row = $result->fetch_assoc()) 
                                    {
                                        $data[] = $row;   
                                    }
                                    foreach($data as $key => $de){           
                ?>

                    <tr>
                        <td><?php echo $staff["StaffId"]; ?></td>
                        <td><?php echo $staff["StaffName"]; ?></td>
                        <td><?php echo $staff["StaffTel"]; ?></td>
                        <td><?php echo $staff["StaffEmail"]; ?></td>
                        <td><?php echo $de["DepartName"]; ?></td>
                        <td><a href="Staffedit.php?update_id=<?php echo $staff["StaffId"];?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $staff["StaffId"];; ?>" class="btn btn-danger">Delete</a></td>
                    </tr>

                    <?php } }?>

                    

                
            </tbody>
        </table>
    </div>
    
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>