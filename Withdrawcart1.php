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

    if (isset($_REQUEST['btn_lotcallback'])) {
                
            $Lotid = $_REQUEST['lotcallback'];
            $sql = "SELECT* FROM tbl_receiveddetail WHERE LotId=$Lotid";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) {
            $data[] = $row;  
            }
            foreach($data as $key => $Lot){
            
            
                $idmed = $Lot["MedId"];
                $sql ="SELECT * FROM tbl_med WHERE $idmed = MedId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $med){
                    }
    
                $idrec = $Lot["RecId"];
                $sql ="SELECT * FROM tbl_received WHERE $idrec = RecId";
                $result = $conn->query($sql);
                $data = array();
                    while($row = $result->fetch_assoc()) {
                        $data[] = $row;   
                    }
                    foreach($data as $key => $rec){
                }
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

        <?php
            include('slidebar.php');
        ?>


<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container">
            <h1 class="navbar-brand">Medicine Withdraw</h1>
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
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>Wrong! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    

    <?php 
         if (isset($updateMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>Success! <?php echo $updateMsg; ?></strong>
        </div>
    <?php } ?>

    
    
    
    <div class="container mt-5">
    <form action = "Withdrawcart.php" method="post">
            <div class="row">
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Lot Id</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_LotId" class="form-control" value="<?php echo $Lot["LotId"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Id</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RedId" class="form-control" value="<?php echo $Lot["RecId"]; ?>" readonly>
                    </div>
                </div>
            </div>
        
            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Date</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RecDate" class="form-control" value="<?php echo $rec["RecDate"]; ?>" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group text-center">
                <div class="row">
                    <label for="Tel" class="col-sm-3 control-label">Received Name</label>
                        <div class="col-sm-7">
                            <input type="text" name="txt_RecName" class="form-control" value="<?php echo $rec["RecDeli"]; ?>" readonly>
                    </div>
                </div>
            </div>

                <?php 
                        $Lot = $Lot["LotId"];
                        $sql = "SELECT* FROM tbl_receiveddetail WHERE LotId=$Lot";
                        $result = $conn->query($sql);
                        $data = array();
                        while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                        }
                        foreach($data as $key => $Lot)

                        

                        {         
                            $MedId = $Lot["MedId"];
                            $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                            $result = $conn->query($sqli);
                            $data = array();
                            while($row = $result->fetch_assoc()) {
                            $data[] = $row;   
                            }
                            
                            foreach($data as $key => $Med){             
                ?>

                            
                    <div class="col-md-4">
                    <form action = "Withdrawcart.php" method="post">
                            <div>
                                <div> <?php echo '<img style = "width:325px;height:325px"  src="upload/'. $Med["MedPath"]; ?>"> </div> 
                            </div>
                            <div>
                                <!-- <h5><?php echo "Med Id " . $Med["MedId"]; ?></h5>  -->
                                <h5><?php echo "Name  " . $Med["MedName"]; ?></h5> 
                                <h5><?php echo "Description  " . $Med["MedDes"]; ?></h5> 
                                <h5><?php echo "Category  " . $Med["MedCate"]; ?></h5> 
                                <h5><?php echo "Volumn  " . $Med["MedVolumn"]; ?></h5> 
                                <h5><?php echo "Unit  " . $Med["MedUnit"]; ?></h5> 
                                <h5><?php echo "Unit Per Pack  " . $Med["MedPack"] . " Unit"; ?></h5> 
                                <h5><?php echo "Price Per Pack  " . $Med["MedPrice"] . " Bath"; ?></h5> 
                                <input type="number" name="quantity" min="1" max="1000" value= "1"></p>
                                <input type ="hidden" name = "testMedId" value = "<?php echo $Med["MedId"];?>">
                                <input type ="hidden" name = "act" value = "add">
                                <input type="submit" class = "btn btn-info" value = "Add to cart"> 
                                <input type ="hidden" name = "valueid" value = "<?php echo $Lot["LotId"];?>">
                            </div>
                            </form>
                    </div>
                
                              
                    <?php }} ?>
            </div>
        </div>


        <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                   
                    <a href="Lot.php" class="btn btn-danger">Back</a>
                </div>
            </div>
                                
    </form>
</body>
</html>