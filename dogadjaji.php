<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start();
require_once ("funkcije.php");
proveraKolacica();
prijava();



    
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
              <a class="nav-link active " href="dogadjaji.php">Dogadjaji</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="Moje_rezervacije.php">Moje rezervacije</a>
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
<?php 

    $sql = "SELECT dogadjaj.id_dogadjaja, dogadjaj.naziv_dogadjaja AS event_name, 
              GROUP_CONCAT(eksponati.id_eksponata) as ideks, GROUP_CONCAT(eksponati.naziv_eksponata) as exhibit_name, vreme_dogadjaja, trajanje_dogadjaja, lokacija_dogadjaja
        FROM dogadjaj
        LEFT JOIN eksponati ON dogadjaj.id_dogadjaja = eksponati.id_dogadjaja GROUP BY dogadjaj.id_dogadjaja";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h1 class='mt-5 mb-4' style='padding-top: 100px;'>Lista prestojećih dogadjaja</h1>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='thead-dark'>";
    echo "<tr><th> ID dogadjajaj</th><th>NAZIV DOGADJAJA</th><th>ID EKSPONATA</th><th>NAZIV EKSPONATA</th><th>DATUM I VREME POČETKA</th><th>DATUM I VREME ZAVRSETKA</th><th>LOKACIJA</th></tr>";
    echo "</thead><tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id_dogadjaja"] . "</td>";
        echo "<td>" . $row["event_name"] . "</td>";
        echo "<td>" . $row["ideks"] . "</td>";
        echo "<td>" . $row["exhibit_name"] . "</td>";
        echo "<td>" . $row["vreme_dogadjaja"] . "</td>";
        echo "<td>" . $row["trajanje_dogadjaja"] . "</td>";
        echo "<td>" . $row["lokacija_dogadjaja"] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
    echo "</div>";
} else {
    echo "<div class='container'><p>No events or exhibits found.</p></div>";
}


?>
</body>
</html>