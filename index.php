<!DOCTYPE html>
<html lang="en">
<head>
<style>
  .card-img-top {
    width: 100%;
    height: 300px; 
    object-fit: cover;

  }
  H2{
    PADDING: 20px;
  }
  
</style>

<?php
session_start();
require_once('funkcije.php');

?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
</head>
<body>
  
<div id="mainNavigation">
      <nav role="navigation">
        <div class="py-3 text-center border-bottom">
          <a href="index.php"><img src="img/logo.png" alt="" class="invert" width='3%' height='3%' href='index.php'></a>
        </div>
      </nav>
      <div class="navbar-expand-md">
        <div class="navbar-dark text-center my-2">
          <button class="navbar-toggler w-75" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> <span class="align-middle">Menu</span>
          </button>
        </div>
        <div class="text-center mt-3 collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav mx-auto ">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Početna</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="izlozbe.php">Izlozbe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="dogadjaji.php">Dogadjaji</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="Moje_rezervacije.php">Moje rezervacije</a>
            </li>
            <li class="nav-item">
            <a   style='float:right' href="admin.php">Admin deo</a>
            </li>
            <?php if(isset($_SESSION['ime'])){
                      echo "</li>
                      <li class='nav-item'>
                      <a   style='float:right' href='login.php?odjava'>logout</a>
                      </li>";
                      }else{
                      echo "</li>
                      <li class='nav-item'>
                      <a   style='float:right' href='login.php?odjava'>login</a>
                      </li>";
                      }
    ?>
           
              
          
        </div>
      </div>
    </div>
    <div> <img src="img/bunner.jpg" class='bnr' alt="" style="width: 100%; height: 40%;">
</div>



<section class="thumbnails">
<div class="container ">
    <h2>LOKACIJE</h2>
    
    <hr>
    <div class="row">
            <?php
          $sql = "SELECT * FROM LOKACIJA";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $naziv = $row["NAZIV_LOKACIJE"];
        $opis = $row["OPIS"];
        $img_src = $row["IMG_LOKACIJE"];
        $id_lokacije=$row['ID_LOKACIJE'];
?>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card">
                    <img src="<?php echo $img_src; ?>" class="card-img-top" alt="<?php echo $naziv; ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $naziv; ?></h5>
                        <p class="card-text" style="text-align: justify;"><?php echo $opis; ?></p>
                        <a class='btn btn-primary' href="pretraga.php?id_lokacije=<?php echo $id_lokacije?>">DETALJNIJE</a>
                    </div>
                </div>
            </div>
    

<?php
    }
} else {
    echo "Nema dostupnih lokacija u bazi.";
}



?>
<h2>EKSPONATI </h2>
<HR>
<?php

$sql = "SELECT * FROM EKSPONATI";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $naziv = $row["NAZIV_EKSPONATA"];
        $img_src = $row["IMG_EKSPONATA"];
?>

            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card">
                    <img src="<?php echo $img_src; ?>" class="card-img-top" alt="<?php echo $naziv; ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $naziv; ?></h5>
                    </div>
                </div>
            </div>

<?php
    }
} else {
    echo "Nema dostupnih eksponata u bazi.";
}



?>
</div>
<h2>IZLOZBE</h2>
<hr>
<div class='container'>
<?php 
ispisivanjeIzlozbi($db);

$db->close();
?>
</div>
</div>





        

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
