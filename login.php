
<?php
require_once("funkcije.php");
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
</nav>
<li ><a href="index.php" >Pocetna</a></li>
    <div class="container" >
    
      <div  style='padding-bottom:10px; width:300px; height:180px '></div>
        <div class="smanjiti">
         
         
          <img src="img/logo.png" alt="" class="logo" width="100" height="100" style="padding:10px;" >

          
 <form action="login.php" method="post" >
 <div class="form-floating mb-3">
  <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
  <label for="floatingInput">Email address</label>
</div>
<div class="form-floating">
  <input type="password" class="form-control" id="floatingPassword" name="password"placeholder="Password">
  <label for="floatingPassword">Password</label>

</div>
<div class="chbx"> 
<input type="checkbox" value="1" name="prijava" id="prijava">  Zapamti me na
ovom računaru<br><br>
</div>
<div class="d-grid gap-2">
  <button class="btn btn-primary" type="submit" name="btn">Uloguj se</button>
</div>
<div class="d-grid gap-2">

     </form>
     <a href="registration.php" class="btn" style=" background-color: rgb(175, 175, 175); padding:5px;" name="btn2">Registruj se</a>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<?php

session_start();
if(isset($_GET['odjava'])) odjava();
if(isset($_SESSION['id']) and isset($_SESSION['email']) and isset($_SESSION['ime']) and isset($_SESSION['status'])) header("Location: admin.php");
if(isset($_POST["btn"])){
  $email=$_POST["email"];
  $pass=$_POST["password"];
 $query = "SELECT email FROM korisnik WHERE email='$email' and password='$pass'";
 $result = mysqli_query($db, $query);
 $querypass = "SELECT password FROM korisnik WHERE password='$pass' and email='$email'";
 $resultpass = mysqli_query($db, $querypass);

 if(mysqli_num_rows($result) > 0 and mysqli_num_rows($resultpass)>0 ){
  $sql = "SELECT id_korisnika, ime, status FROM korisnik WHERE email='$email'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()){ 
        
    $_SESSION['id']=$row["id_korisnika"];
    $_SESSION['email']= $email;
    $_SESSION['ime']=$row['ime'];
    $_SESSION['status']=$row['status'];
    if(isset($_POST['prijava']))
{
//Ako želi, generišu se kolačići

setcookie("id", $row["id"] , time()+60*60*24*30);
setcookie("email", $email, time()+60*60*24*30);
setcookie("ime", $row['ime'], time()+60*60*24*30);
setcookie("status", $row['status'], time()+60*60*24*30);
}
header("Location: index.php");
}
$db->close();

    }
}else{
  echo "<div class='alert alert-danger'>Neuspesno, proverite da li ste pravilno uneli sva polja</div>";
}
}


?>