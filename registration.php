
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
    <div class="container" >
    <div  style='padding-bottom:10px; width:300px; height:40px'></div>
      <a href="login.php">Login</a>
        <div class="smanjiti">
        <img src="imghtml/logooo-removebg-preview.png" alt="" class="logo" style="padding:10px;" >
<form action="registration.php" method="post" >
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" name="ime" placeholder=""required>
  <label for="floatingInput">Ime</label>
</div>
<div class="form-floating mb-3">
  <input type="text" class="form-control" id="floatingInput" name="prezime" placeholder="" required>
  <label for="floatingInput">Prezime</label>
</div>
<div class="form-f">
 <div class="form-floating mb-3">
  <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
  <label for="floatingInput">Email address</label>
</div>
<div class="form-f">
 <div class="form-floating mb-3">
  <input type="phone" class="form-control" id="floatingInput" name="telefon" placeholder="+381 64 322 322 2" required>
  <label for="floatingInput">Broj telefona</label>
</div>

<div class="form-floating">
  <input type="password" class="form-control" id="floatingPassword" name="password"placeholder="Password">
  <label for="floatingPassword">Password</label>

</div>
<div class="d-grid gap-2" style='padding-bottom:10px;'>
  <button class="btn btn-primary" type="submit" name="btnreg" style="padding-top:10px; margin-top:10px;">Registruj se</button>
</div>
<div class="d-grid gap-2">

     </form>
     </div>
     </div>


     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

<?php
session_start();
if(isset($_SESSION['id']) and isset($_SESSION['email']) and isset($_SESSION['ime'])) header("Location: home.php");

if(isset($_POST['btnreg'])){
    $ime=$_POST['ime'];
    $prezime=$_POST['prezime'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $broj_telefona=$_POST['telefon'];
  




$query = "SELECT email FROM korisnik WHERE email='$email'";
$result = mysqli_query($db, $query);

if(mysqli_num_rows($result) > 0){
    echo "<div class='alert alert-danger'>Email postoji u bazi podataka";
}else{
    

$upit="INSERT INTO korisnik (ime, prezime, email, broj_telefona, status, password) VALUES('$ime', '$prezime', '$email', '$broj_telefona', 'korisnik','$password')";
$rez=mysqli_query($db, $upit) ;
echo "<div class='alert alert-success' >Uspesno ste se registrovali<br></div>";
echo "<div class='d-grid gap-2'>
<a class='btn btn-success'  name='log' href='login.php'>Uloguj se</a>
</div>";

   
};
}



?>