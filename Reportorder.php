<?php
    include('Connect.php'); 
    if (isset($_REQUEST['Report'])) 
    {
        require_once __DIR__ . '/vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();

        $orderid = $_REQUEST["valueid"];
       
        $sql = "SELECT * FROM tbl_order WHERE OrderId = '$orderid'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $order)
        $orderprice = $order["OrderPrice"];
        $ordertotal = $order["OrderTotal"];
        $ordertax = $ordertotal - $orderprice;
        {      
            $derlarid = $order["DealerId"];
            $sql = "SELECT * FROM tbl_dealer WHERE DealerId = '$derlarid'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $dealer)
            {

            }    
        }
    }

    ob_start();   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">
    </head>

<style>
body{margin-top:20px;
    color: #2e323c;
    background: #f5f6fa;
    position: relative;
    height: 100%;
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
    color: #9fa8b9;
    margin: 0;
}
.invoice-container .invoice-details {
    margin: 1rem 0 0 0;
    padding: 1rem;
    line-height: 180%;
    background: #f5f6fa;
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
    color: #9fa8b9;
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
</style>

<body>
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
									<a href="index.html" class="invoice-logo">
                                        <?php 
                                            echo $dealer["DealerName"] . "<br>";
                                        ?><br>
									</a>
								</div>
				
							<!-- Row end -->
							<!-- Row start -->
							<div class="row gutters">
								<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<address>
										<?php 
                                            echo "Address : " .$dealer["DealerAddress"] . "<br>";
                                            echo "Phone : ". $dealer["DealerPhone"] . "<br>";
                                        ?>
										</address>
									</div>
								</div>
								<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
									<div class="invoice-details">
										<div class="invoice-num">
                                            <?php 
                                                echo "Invoice : #" .$order["OrderId"] . "<br>";
                                                echo "Date Order : ". $order["OrderDate"] . "<br>";
                                            ?>
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
											<thead>
												<tr>
													<th>Items</th>
													<th>Product ID</th>
													<th>Quantity</th>
													<th>Sub Total</th>
												</tr>
											</thead>
											<tbody>
                                                <?php
                                                      $orderid = $order['OrderId'];
                                                      $sql = "SELECT* FROM tbl_orderdetail WHERE OrderId=$orderid";
                                                      $result = $conn->query($sql);
                                                      $data = array();
                                                      while($row = $result->fetch_assoc()) {
                                                      $data[] = $row;  
                                                      }
                                                      foreach($data as $key => $orderdetailid){
                                      
                                                          $MedId = $orderdetailid["MedId"];
                                                          $sqli ="SELECT * FROM tbl_med WHERE $MedId = MedId";
                                                          $result = $conn->query($sqli);
                                                          $data = array();
                                                          while($row = $result->fetch_assoc()) {
                                                          $data[] = $row;   
                                                          }
                                                          
                                                          foreach($data as $key => $med){
                                                ?>
												<tr>
													<td><?php echo $med["MedName"];?></td>
													<td><?php echo "#".$med["MedId"];?></td>
													<td><?php echo $orderdetailid["Qty"];?></td>
													<td><?php echo "฿".$orderdetailid["Price"];?></td>
												</tr>
                                                    <?php
                                                            }}
                                                    ?>
												<!-- <tr>
													<td>
														Maxwell Admin Template
														<p class="m-0 text-muted">
															As well as a random Lipsum generator.
														</p>
													</td>
													<td>#50000126</td>
													<td>5</td>
													<td>$100.00</td>
												</tr>
												<tr>
													<td>
														Unify Admin Template
														<p class="m-0 text-muted">
															Lorem ipsum has become the industry standard.
														</p>
													</td>
													<td>#50000821</td>
													<td>6</td>
													<td>$49.99</td>
												</tr> -->


												<tr>
													<td colspan="3">
														<p>
															Subtotal<br>
															Tax (7%)<br>
														</p>
														<h5 class="text-success"><strong>Grand Total</strong></h5>
													</td>			
													<td>
														<p>
                                                            <?php echo "฿".$order["OrderPrice"]. "<br>";?>
															<?php echo "฿".$ordertax. "<br>";?>
															
														</p>
														<h5 class="text-success"><strong><?php echo "฿".$order["OrderTotal"]. "<br>";?></strong></h5>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- Row end -->
						</div>
						<div class="invoice-footer">
							Thank you for your Business.
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<?php
    $html=ob_get_contents();
    $mpdf->WriteHTML($html);
    $mpdf->Output("MyReport.pdf");
    ob_end_flush();
?>
</html>