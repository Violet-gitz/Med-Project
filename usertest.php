<?php
    include('Connect.php'); 
    session_start();
  
    $staff =  $_SESSION['StaffName'];
    $sql = "SELECT* FROM tbl_staff WHERE StaffName = '$staff'";
    $result = $conn->query($sql);
    $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $staff)
            $staffId = $staff["StaffId"];
        {      
            $DepartId = $staff['DepartId'];
            $sql = "SELECT * FROM tbl_department WHERE DepartId = '$DepartId'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $depart){} 
        }

    if (isset($_REQUEST['btn-Order'])) {   
        if(empty($_SESSION['usercart']))
        {
            $errorMsg = "ไม่มีสินค้า";
        }
        else
        {
        $WithStatus = "รอการอนุมัติ";
        date_default_timezone_set("Asia/Bangkok");
        $WithDate = date("Y-m-d");

        $sql = "INSERT INTO tbl_withdraw(StaffId, WithDate, WithStatus) VALUES ('$staffId', '$WithDate', '$WithStatus')";
        if ($conn->query($sql) === TRUE) { 
        } else {
        echo "Error updating record: " . $conn->error;
        }

        if(!empty($_SESSION['usercart']))
            {
                // unset($_SESSION['test']);
                foreach($_SESSION['usercart'] as $MedId=>$Quantity)
                {
                    $test = 0;
                    // echo $Quantity. "<br>";
                    $sql = "SELECT * FROM tbl_lot WHERE MedId ='$MedId' AND LotStatus != 'เคลม' AND LotStatus != 'ตัดจำหน่าย' AND LotStatus != 'ไม่สามารถใช้งานได้' AND LotStatus != 'จอง'";
                    $result = $conn->query($sql);
                    $data = array();
                            
                    while($row = $result->fetch_assoc()) 
                    {
                        $data[] = $row;  
                    }
                        foreach($data as $key => $lot)
                        {      
                            $MfdDate = $lot["Mfd"];
                            $ExpDate = $lot["Exd"];
                            $datemfd=date_create($MfdDate);
                            $dateexp=date_create($ExpDate);
                            $diff=date_diff($datemfd,$dateexp);
                                
                            // echo $lot["LotId"] . $diff->format('%R%a') . "qty ".$lot["Qty"]. "<br>";
                        
                            $lotid = $lot["LotId"];
                            $qtylot = $lot["Qty"];
                            $Reserve = $lot["Reserve"];
                            $qty = $qtylot - $Reserve;
                            if($test < $Quantity)
                            {
                                if($qty > ($Quantity-$test))
                                {
                                    $_SESSION['test'][$lotid][0]=$lotid;   
                                    $_SESSION['test'][$lotid][1]=(int)$qty;   //จำนวนทั้งหมดของ lot
                                    $_SESSION['test'][$lotid][2]=(int)$qty - ($Quantity - $test); //จำนวนคงเหลือ 
                                    $_SESSION['test'][$lotid][3]=(int)$Quantity - $test; //จำนวนที่ตัด ****
                                    $test += ($Quantity - $test);
                                }
                                else if($qty <= ($Quantity-$test))
                                {
                                    $_SESSION['test'][$lotid][0]=$lotid;   
                                    $_SESSION['test'][$lotid][1]=(int)$qty;   
                                    $_SESSION['test'][$lotid][2]=(int)$qty; 
                                    $_SESSION['test'][$lotid][3]=(int)$qty; 
                                    $test += $qty;
                                }
                            }  

                        }
                }
            }unset($_SESSION['usercart']);
            
        if(!empty($_SESSION['test']))
        {   
            $sum = 0;
            foreach($_SESSION['test'] as $value)
                {
                    $idlot = $value[0]; 
                    $Qty = $value[3];
                    $sql = 'SELECT * FROM tbl_lot WHERE LotId ='.$idlot.'';
                    $result = $conn->query($sql);
                    $data = array();
                    while($row = $result->fetch_assoc()) 
                    {
                        $data[] = $row;  
                    }
                    foreach($data as $key => $lot)
                    {
                    $query = "SELECT WithId FROM tbl_withdraw ORDER BY WithId DESC LIMIT 1";
                    $result = $conn->query($query); 
                    $row = mysqli_fetch_array($result);
                    $WithId  = $row["WithId"];

                    $MfdDate = $lot["Mfd"];
                    $ExpDate = $lot["Exd"];
                    {
                        $sql = "INSERT INTO tbl_withdrawdetail(WithId, MedId, LotId, Qty, Mfd, Exd) VALUES ('$WithId', '$MedId', '$idlot', '$Qty', '$MfdDate', '$ExpDate')";
                        // echo $sql;
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                        echo "Error updating record: " . $conn->error;
                        }
                        $sum = $sum + $value[3];
                        $sumReserve = $Reserve + $Qty;

                        $sql = "UPDATE tbl_lot SET Reserve = $sumReserve WHERE LotId = $idlot"; 
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                        echo "Error updating record: " . $conn->error;
                        }

                        $sql = "UPDATE tbl_withdraw SET Qtysum = $sum WHERE WithId = $WithId"; 
                        if ($conn->query($sql) === TRUE) { 
                        } else {
                        echo "Error updating record: " . $conn->error;
                        }
                    }
                    }
                }unset($_SESSION['test']);
                $insertMsg = "เบิกสำเร็จ...";
                header("refresh:1;Mainuser.php"); 
        }
    }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    </head>

<style>
@media print 
{
   @page
   {
    size: 8.5in 5.5in;
    size: portrait;
  }
}

body{margin-top:20px;
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
    font-family: 'Sarabun', sans-serif;
}
.invoice-container {
    padding: 1rem;
}
.invoice-container .invoice-header .invoice-logo {
    margin: 0.8rem 0 0 0;
    display: inline-block;
    font-size: 1.6rem;
    font-weight: 700;
    color: #2e323c;
}
.invoice-container .invoice-header .invoice-logo img {
    max-width: 130px;
}
.invoice-container .invoice-header address {
    font-size: 1.3rem;
    margin: 0;
}
.invoice-container .invoice-details {
    margin: 1rem 0 0 0;
    padding: 1rem;
    line-height: 180%;

}
.invoice-container .invoice-details .invoice-num {
    text-align: right;
    font-size: 1.3rem;
}
.invoice-container .invoice-body {
    padding: 1rem 0 0 0;
}
.invoice-container .invoice-footer {
    text-align: center;
    font-size: 1.7rem;
    margin: 5px 0 0 0;
}

.invoice-status {
    text-align: center;
    padding: 1rem;
    background: #ffffff;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    margin-bottom: 1rem;
}
.invoice-status h2.status {
    margin: 0 0 0.8rem 0;
}
.invoice-status h5.status-title {
    margin: 0 0 0.8rem 0;

}
.invoice-status p.status-type {
    margin: 0.5rem 0 0 0;
    padding: 0;
    line-height: 150%;
}
.invoice-status i {
    font-size: 1.5rem;
    margin: 0 0 1rem 0;
    display: inline-block;
    padding: 1rem;
    background: #f5f6fa;
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
}
.invoice-status .badge {
    text-transform: uppercase;
}

@media (max-width: 767px) {
    .invoice-container {
        padding: 1rem;
    }
}


.custom-table {
    border: 1px solid #e0e3ec;
}
.custom-table thead {
    background: #007ae1;
}
.custom-table thead th {
    border: 0;
    color: #ffffff;
}
.custom-table > tbody tr:hover {
    background: #fafafa;
}
.custom-table > tbody tr:nth-of-type(even) {
    background-color: #ffffff;
}
.custom-table > tbody td {
    border: 1px solid #e6e9f0;
}


.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}

.text-success {
    color: #00bb42 !important;
}

.text-muted {
    color: #9fa8b9 !important;
}

.custom-actions-btns {
    margin: auto;
    display: flex;
    justify-content: flex-end;
}

.custom-actions-btns .btn {
    margin: .3rem 0 .3rem .3rem;
}

.container {
    width: 786px;
}
</style>

<body>
    <?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>ผิดพลาด! <?php echo $errorMsg; ?></strong>
        </div>
    <?php } ?>
    
    <?php 
         if (isset($insertMsg)) {
    ?>
        <div class="alert alert-success">
            <strong>สำเร็จ! <?php echo $insertMsg; ?></strong>
        </div>
    <?php } ?>

<div class="container">
<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">

							<!-- Row start -->
							<!-- <div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
									<div class="custom-actions-btns mb-5">
										<a href="#" class="btn btn-primary">
											<i class="icon-download"></i> Download
										</a>
										<a href="#" class="btn btn-secondary">
											<i class="icon-printer"></i> Print
										</a>
									</div>
								</div>
							</div> -->
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									
                                        <?php 
                                            echo "<h3>ใบเบิก</h3><br>";
                                        ?><br>

								</div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
									<address class="text-right">
								        38 ถ. เพชรเกษม แขวง บางหว้า <br>
										เขตภาษีเจริญ กรุงเทพมหานคร 10160.<br>
										02 867 8088

									</address>
								</div>
				
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
                                            <?php 
                                                date_default_timezone_set("Asia/Bangkok");
                                                $RecTime = date("d")."-".date("m")."-".(date("Y")+543);
                                                echo "วันที่เบิก  : ". $RecTime;
                                            ?>
										</address>
									</div>
								</div>
                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<div class="invoice-num">
                                           
										</div>
									</div>													
								</div>
                            </div>
							
							<!-- Row end -->
						</div>
						<div class="invoice-body">
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<div class="table-responsive">
										<table class="table custom-table m-0">
											<!-- <thead> -->
												<tr>
													<th>รายการเบิก</th>
													<th>รหัสสินค้า</th>
													<th>จำนวน</th>		
												</tr>
											<!-- </thead> -->
											<tbody>
                                                <?php
                                                    $sum = 0;
                                                    if(!empty($_SESSION['usercart']))
                                                    {
                                                        foreach($_SESSION['usercart'] as $MedId=>$Quantity)
                                                        {
                                                            $sql = "SELECT* FROM tbl_Med WHERE MedId=$MedId";
                                                            $result = $conn->query($sql);
                                                            $data = array();
                                                            while($row = $result->fetch_assoc()) {
                                                            $data[] = $row;  
                                                            }
                                                            foreach($data as $key => $Med){
                                                                $sum = $sum + $Quantity;
                                                ?>
												<tr>
													<td><?php echo $Med["MedName"];?></td>
													<td><?php echo "#".$Med["MedId"];?></td>
													<td><?php echo $Quantity;?></td>
													
												</tr>
                                                    <?php
                                                            }}}
                                                    ?>
										
												<tr>
													<td colspan="2">
														<p>
															<!-- Subtotal<br>
															Tax (7%)<br> -->
                                                            <h5 class="text-success"><strong>จำนวนทั้งหมด</strong></h5>
														</p>
														
													</td>			
                                                    <td><h5 class="text-success"><strong><?php echo $sum;?></strong></h5></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>

                        <div class="row">
                            <div class="col-md-12 text-right identity">
                                <p><?php echo "แผนก : ".$depart["DepartName"];?><br></p>
                                <p><strong>.............</strong><br><?php echo $staff["StaffName"];?></p>
                            </div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>


            <form name="frmcart" method="post">
            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                    <input type ="submit" name = "btn-Order" class = "btn btn-info" value = "เบิก">
                    <input type ="hidden" name = "total" value = "<?php echo $sum;?>">
                    <input type ="hidden" name = "selDealer" value = "<?php echo $DealerId;?>">
                    <a href="cartuser.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
        </form>
</html>