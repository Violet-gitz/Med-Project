<?php
    include('Connect.php'); 
    session_start();
    error_reporting(0);
    if (isset($_REQUEST['Order'])) 
    {
        $DealerId = $_REQUEST['selDealer'];
        $sql = "SELECT * FROM tbl_dealer WHERE DealerId = '$DealerId'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $dealer){} 

        $StaffId = $_REQUEST['StaffId'];
        $sql = "SELECT * FROM tbl_staff WHERE StaffId = '$StaffId'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $staff){}    
        
        foreach($_SESSION['cart'] as $MedId=>$Quantity)
        {
            $sql ="SELECT * FROM tbl_med WHERE $MedId = MedId";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;       
            }
            foreach($data as $key => $Med)
            {

            }
        }
    }

    if (isset($_REQUEST['btn-Order'])) {

            date_default_timezone_set("Asia/Bangkok");
            $OrderDate = date("d")."-".date("m")."-".(date("Y")+543);

            $OrderStatus = "สั่งซื้อ";
            $OrderPrice = $_REQUEST["total"];
            $OrderTotal = ($OrderPrice * 0.07)+$OrderPrice;
            $DealerId = $_REQUEST['selDealer'];
            $StaffName = $_SESSION['StaffName'];
            
                if (empty($_SESSION['cart'])){
                $errorMsg = "ไม่มีสินค้าในตะกร้า";
                header("refresh:1;Orders.php");
                }else if (empty($DealerId)) {
                    $errorMsg = "กรุณาเลือกตัวแทนจำหน่าย";
                }else 
                    if (!isset($errorMsg)) 
                    {
                        $sql = "INSERT INTO tbl_order(OrderDate, OrderStatus, OrderPrice, OrderTotal, DealerId, StaffName ) VALUES ('$OrderDate', '$OrderStatus', '$OrderPrice','$OrderTotal', '$DealerId', '$StaffName')";
                        if ($conn->query($sql) === TRUE) {} 
                        else {echo "Error updating record: " . $conn->error;}

                        foreach($_SESSION['cart'] as $MedId=>$Quantity)
                            {
                                $query = "SELECT OrderId FROM tbl_order ORDER BY OrderId DESC LIMIT 1";
                                $result = mysqli_query($conn, $query); 
                                $row = mysqli_fetch_array($result);
                                $OrderId = $row["OrderId"];

                                $sql ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                                $result = $conn->query($sql);
                                $data = array();
                                while($row = $result->fetch_assoc()) 
                                {
                                    $data[] = $row;       
                                }
                                foreach($data as $key => $Med)
                                {
                                    $Medsum = $Quantity*$Med["MedPrice"];
                                    $sql = "INSERT INTO tbl_orderdetail(OrderId, MedId, Qty, Price) VALUES ('$OrderId', '$MedId', '$Quantity','$Medsum')";
                                    if ($conn->query($sql) === TRUE) {unset($_SESSION['cart']);} 
                                    else {echo "Error updating record: " . $conn->error;}
                                }
                            }
                            header("refresh:1;CheckOrder.php");
                            $insertMsg = "เพิ่มข้อมูลสำเร็จ...";
                    }
                
        }
          
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase order</title>
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
.sig-box {
    float:right;
    border:1px solid black;
    padding : 30px 20px 10px;
    text-align: center;
    margin-right: 20px;
}
</style>

<body>
<?php 
         if (isset($errorMsg)) {
    ?>
        <div class="alert alert-danger">
            <strong>ไม่สำเร็จ! <?php echo $errorMsg; ?></strong>
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
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
									
                                        <?php 
                                            echo "<h3>รายการสั่งซื้อ </h3>";
                                        ?>

								</div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
									<address class="text-right">
                                        38 ถ. เพชรเกษม แขวง บางหว้า <br>
										เขตภาษีเจริญ กรุงเทพมหานคร 10160.<br>
										02 867 8088

									</address>
								</div>
                            </div>
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
										<?php 
                                            echo "ตัวแทนจำหน่าย : " .$dealer["DealerName"] . "<br>";
                                            echo "ที่อยู่ : " .$dealer["DealerAddress"] . "<br>";
                                            echo "เบอร์โทรศัพท์ : ". $dealer["DealerPhone"] . "<br>";
                                            date_default_timezone_set("Asia/Bangkok");
                                            
                                            $RecTime = date("Y-m-d");
                                            $day = substr($RecTime,5,9);
                                            $year = substr($RecTime,0,4);
                                            $test = $year + 543;
                                            echo "วันที่เบิก ".$day. "-".$test;
                                            // echo "วันที่เบิก  : ". $RecTime;
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
                                                    <th>รหัสสินค้า</th>
													<th>รายการสั่งซื้อ</th>	
													<th>จำนวน</th>
													<th style = "text-align:right">บาท</th>
												</tr>
											<!-- </thead> -->
											<tbody>
                                                <?php
                                                    $sum = 0;
                                                    $sumvax = 0;
                                                    foreach($_SESSION['cart'] as $MedId=>$Quantity)
                                                        {
                                                            $sql ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                                                            $result = $conn->query($sql);
                                                            $data = array();
                                                            while($row = $result->fetch_assoc()) 
                                                            {
                                                                $data[] = $row;       
                                                            }
                                                            foreach($data as $key => $Med)
                                                            {
                                                                $Medsum = $Quantity*$Med["MedPrice"];
                                                                $vax = $Medsum * 0.07;
                                                                $sum += $Medsum;
                                                                $sumvax += $vax;
                                                ?>
												<tr>
                                                    <td><?php echo "#".$Med["MedId"];?></td>
													<td><?php echo $Med["MedName"];?></td>													
													<td><?php echo $Quantity;?></td>
													<td style="text-align:right"><?php echo number_format($Medsum, 2);?></td>
												</tr>
                                                    <?php
                                                            }}
                                                    ?>
										
												<tr>
													<td colspan="3" >
														<p>
															ราคารวม<br>
															ภาษี (7%)<br>
														</p>
														<h5 class="text-success"><strong>ราคารวมภาษี</strong></h5>
													</td>			
													<td style="text-align:right">
														<p>
                                                            <?php echo number_format($sum, 2). "<br>";?>
															<?php echo number_format($sumvax, 2). "<br>";?>

															
														</p>
														<h5 class="text-success"><strong><?php $sumall = $sum + $sumvax; echo number_format($sumall, 2). "<br>";?></strong></h5>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>

                        <div class="row">
                            <div class="sig-box">
                                <div class="col-md-12 identity">
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
                    <input type ="submit" name = "btn-Order" class = "btn btn-info" value = "สั่งซื้อ">
                    <input type ="hidden" name = "total" value = "<?php echo $sum;?>">
                    <input type ="hidden" name = "selDealer" value = "<?php echo $DealerId;?>">
                    <a href="Order.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
        </form>
</html>