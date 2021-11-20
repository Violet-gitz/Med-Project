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
        $sql = "DELETE FROM tbl_med where MedId = '".$id."'";
        if($conn->query($sql) == TRUE){
          echo "<script type='text/javascript'>alert('ลบข้อมูลสำเร็จ');</script>";
        }else{
          echo "<script type='text/javascript'>alert('ลบข้อมูลไม่สำเร็จ');</script>";
        }
        header("refresh:1;Medshow.php");
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
            <form action="" method="post">
                <input type="text" name="search" placeholder = "search">
                <input type="submit" name="submit" value="Search">
            </form>
        </div>
  </div>
</div><br>


    <div class="container-sm">
    
        <table class="table table-bordered">

            <tbody>
                <?php 
                    if (isset($_REQUEST['detail_id'])) {  
                        $id = $_REQUEST['detail_id'];
                        $sql ="SELECT * FROM tbl_med WHERE $id = MedId";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Med){               
                ?>

                
                    <tr>    
                    <div class="product-item">
                        <form action="Order.php" method="post">
                            <div class="product-image"><?php echo '<img src="upload/'. $Med['MedPath']; ?>"></div>
                            <div class="product-tile-footer">
                            <div class = "Product-title"><?php echo "Name : " . $Med["MedName"]; ?></div>
                            <div class = "Product-title"><?php echo "Category : " . $Med["MedCate"]; ?></div>
                            <div class = "Product-title"><?php echo "Volumn : " . $Med["MedVolumn"]; ?></div>
                            <div class = "Product-title"><?php echo "Unit : " . $Med["MedUnit"]; ?></div>
                            <div class = "Product-title"><?php echo "Unit Per Pack : " . $Med["MedPack"] . " Unit"; ?></div>
                            <div class = "Product-price"><?php echo "Price Per Pack : " . $Med["MedPrice"] . " Bath"; ?></div>
                            <a href = "Mededit.php?update_id=<?php echo $Med["MedId"];?>" class = "btn btn-info">Edit</a>
                            <!-- <div class = "Product-title"><a href="?delete_id=<?php echo $Med["MedId"];; ?>" class="btn btn-danger">Delete</a></div> -->
                            <input type="number" name="quantity" min="1" max="1000" value= "1">
                            <input type ="hidden" name = "MedId" value = "<?php echo $Med["MedId"];?>">
                            <input type ="hidden" name = "act" value = "add">
                            <input type="submit" class = "btn btn-info" value = "Add to cart">
                            <a href="Medshow.php" class="btn btn-secondary">Back</a>   
                        </form>
                    </div>
                    </tr>
                    <?php }} ?>

            </tbody>
        </table>
    </div>
    
    
    <script src="js/slim.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>