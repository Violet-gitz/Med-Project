<?php
    include('Connect.php'); 
    if (isset($_REQUEST['Report'])) 
    {
      
        $withdrawid = $_REQUEST["valueid"];
       
        $sql = "SELECT * FROM tbl_withdraw WHERE WithId = '$withdrawid'";
        $result = $conn->query($sql);
        $data = array();
        while($row = $result->fetch_assoc()) 
        {
            $data[] = $row;  
        }
        foreach($data as $key => $with)
        {      
            $staffid = $with["StaffId"];
            $sql = "SELECT * FROM tbl_staff WHERE StaffId = '$staffid'";
            $result = $conn->query($sql);
            $data = array();
            while($row = $result->fetch_assoc()) 
            {
                $data[] = $row;  
            }
            foreach($data as $key => $staff)
            {
                $departid = $staff["DepartId"];
                $sql = "SELECT * FROM tbl_department WHERE DepartId = '$departid'";
                $result = $conn->query($sql);
                $data = array();
                while($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;  
                }
                foreach($data as $key => $depart){}
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

    <script language="javascript" type="text/javascript">
    function printWindow()
    {
    var printReadyEle = document.getElementById("printContent");
    var shtml = '<HTML>\n<HEAD>\n';
    if (document.getElementsByTagName != null)
    {
        var sheadTags = document.getElementsByTagName("head");
        if (sheadTags.length > 0)
            shtml += sheadTags[0].innerHTML;
        }
        shtml += '</HEAD>\n<BODY onload="window.print();">\n';
        if (printReadyEle != null)
        {
        shtml += '<form name = frmform1>';
        shtml += printReadyEle.innerHTML;
        }
        shtml += '\n</form>\n</BODY>\n</HTML>';
        var printWin1 = window.open();
        printWin1.document.open();
        printWin1.document.write(shtml);
        printWin1.document.close();

    }
</script>
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
<div class="container">
<div class="row gutters" id="printContent">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-body p-0">
					<div class="invoice-container">
						<div class="invoice-header">

						
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
                                            echo "ใบเบิกที่ : #" .$with["WithId"] . "<br>";
                                            echo "วันที่เบิก  : ". $with["WithDate"] . "<br>";
                                        ?>
										</address>
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
                                                      $WithId = $with['WithId'];
                                                      $sql = "SELECT* FROM tbl_withdrawdetail WHERE WithId = $WithId";
                                                      $result = $conn->query($sql);
                                                      $data = array();
                                                      while($row = $result->fetch_assoc()) {
                                                      $data[] = $row;  
                                                      }
                                                      foreach($data as $key => $withde){
                                      
                                                          $MedId = $withde["MedId"];
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
													<td><?php echo $withde["Qty"];?></td>
													
												</tr>
                                                    <?php
                                                            }}
                                                    ?>
										
												<tr>
													<td colspan="2">
														<p>
															<!-- Subtotal<br>
															Tax (7%)<br> -->
                                                            <h5 class="text-success"><strong>จำนวนทั้งหมด</strong></h5>
														</p>
														
													</td>			
                                                    <td><h5 class="text-success"><strong><?php echo $with["Qtysum"]. "<br>". "<br>";?></strong></h5></td>
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
</div>
</body>


            <div class="form-group text-center">
                <div class="col-md-12 mt-3">
                <input type="button" value="ปริ้น" class="btn btn-primary" onclick="window.printWindow()" /> 
                    <a href="Approveuser.php" class="btn btn-danger">กลับ</a>
                </div>
            </div>
</html>