<heaed>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="bootstrap/bootstrap.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #343a40;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}

.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 25px;
  color: #ffffff;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}

.logo {
  margin: auto;
  font-size: 20px;
  background: white;
  padding: 5px 13px;
  border-radius: 50% 50%;
  color: #000000b3;
}
</style>
       
        <div id="mySidenav" class="sidenav">
          <a href="main.php">หน้าหลัก</a>

          <a href="home1.php">จัดการข้อมูลพื้นฐาน</a> 
         
            <!-- <a href="Departmentshow.php">Department</a> -->
          
          <a href="home3.php">จัดการข้อมูลยา</a>
          <a href="home2.php">จัดการข้อมูล</a> 
            <!-- <a href="Typeshow.php">Type</a>
            <a href="Cateshow.php">Category</a>
            <a href="Volumnshow.php">Volumn</a>
            <a href="Unitshow.php">Unit</a>
            <a href="Medshow.php">Medicine</a> -->

          <a href="Orders.php">จัดซื้อ</a>

          <a href="CheckReceived.php">การรับยา</a>
            <!-- <a href="CheckOrder.php">รับยา</a>
            <a href="CheckClaim.php">รับยาเคลม</a> -->

          

          <a href="Approve.php">รายการเบิกยา</a>

          <a href="Writeoffshow.php">การตัดจำหน่าย</a>
          <a href="Lot.php">ล็อตยา</a>

          <!-- <a href="main.php">Home</a>
          <a href="Staffshow.php">Staff</a>
          <a href="Departmentshow.php">Department</a>
          <a href="Dealershow.php">Dealer</a>
          <a href="Typeshow.php">Type</a>
          <a href="Cateshow.php">Category</a>
          <a href="Volumnshow.php">Volumn</a>
          <a href="Unitshow.php">Unit</a>
          <a href="Medshow.php">Medicine</a>
          <a href="Orders.php">Order</a>
          <a href="CheckOrder.php">List order buy</a>
          <a href="CheckReceived.php">Received</a>
          <a href="Lot.php">Lot</a>
          <a href="Approve.php">Approve</a>
          <a href="CheckClaim.php">List order Claim</a>
          <a href="ClaimReceived.php">Received Claim</a>
          <a href="Writeoffshow.php">Writoff List</a> -->
          
          
        </div>
        <span style="font-size:30px;cursor:pointer;color: white;" onclick="openNav()">&#9776;</span>
  <script>
    var openSlidBar = false
    function openNav() 
    {
      if(openSlidBar == false){
        openSlidBar = true
        document.getElementById("mySidenav").style.width = "280px";
      }else{
        openSlidBar = false
        document.getElementById("mySidenav").style.width = "0";
      }
    }
    </script>
</body>
        