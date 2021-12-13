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
    <a href="Mainuser.php">Home</a>
    <a href="Approveuser.php">Approve</a>
  </div>
  <span style="font-size:30px;cursor:pointer;color: white;" onclick="openNav()">&#9776;</span>
  <script>
    var openSlidBar = false
    function openNav() 
    {
      if(openSlidBar == false){
        openSlidBar = true
        document.getElementById("mySidenav").style.width = "250px";
      }else{
        openSlidBar = false
        document.getElementById("mySidenav").style.width = "0";
      }
    }
  </script>
</body>
        