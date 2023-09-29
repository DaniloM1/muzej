
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    require_once('funkcije.php')
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
              <a class="nav-link " aria-current="page" href="index.php">Početna</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="izlozbe.php">Izlozbe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="dogadjaji.php">Dogadjaji</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Moje_rezervacije.php">Moje rezervacije</a>
            </li>
            <li class="nav-item">
            <a   style='float:right' href="admin.php">Admin deo</a>
            </li>
            <!-- <li class="nav-item">
            <a   style='float:right' href="login.php">Login</a>
            </li> -->
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
   
</div>
<div>
<?php
$id_lokacije = $_GET['id_lokacije']; // Pretpostavljamo da dobijate ID lokacije putem GET parametra

// SQL upit za izlistavanje izložbi i eksponata za određenu lokaciju
$sql = "SELECT izlozba.id_izlozbe, izlozba.naziv_izlozbe, izlozba.datum_izlozbe,
               eksponati.naziv_eksponata, eksponati.img_eksponata, eksponati.opis_eksponata
        FROM izlozba
        LEFT JOIN eksponati ON izlozba.id_izlozbe = eksponati.id_izlozbe
        WHERE eksponati.id_lokacije = $id_lokacije";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<br>";
    echo "<br>"; echo "<br>";
   

    while ($row = $result->fetch_assoc()) {
        echo "<div class='card mb-4'>";
        echo "<img src='" . $row["img_eksponata"] . "' class='card-img-top' alt='Slika eksponata'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row["naziv_eksponata"] . "</h5>";
        echo "<p class='card-text'>Naziv Izložbe: " . $row["naziv_izlozbe"] . "</p>";
        echo "<p class='card-text'>Opis eksponata: " . $row["opis_eksponata"] . "</p>";
        echo "<p class='card-text'>Datum Izložbe: " . $row["datum_izlozbe"] . "</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "<div class='container'><p>Nema pronađenih izložbi i eksponata za Lokaciju ID: $id_lokacije.</p></div>";
}


$db->close();
?>

</div>
    
    </body>
    </html>