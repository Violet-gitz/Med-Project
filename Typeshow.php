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
     
        $sql = "DELETE FROM tbl_type where TypeId = '".$id."'";
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
                                
                            <li class="nav-item">
                                    <td><a href="Typeadd.php" class ="btn btn-success">Add</a></td>
                                </li>

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

    <div class="container-sm">
    
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>TypeId</th>
                    <th>TypeName</th>
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
                        $sql = 'SELECT * FROM tbl_type';
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $type){               
                ?>

                    <tr>
                        <td><?php echo $type["TypeId"]; ?></td>
                        <td><?php echo $type["TypeName"]; ?></td>
                        <td><a href="Typeedit.php?update_id=<?php echo $type["TypeId"];?>" class="btn btn-warning">Edit</a></td>
                        <td><a href="?delete_id=<?php echo $type["TypeId"]; ?>" class="btn btn-danger">Delete</a></td>
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