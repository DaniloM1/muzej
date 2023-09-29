<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once('funkcije.php')?>
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
              <a class="nav-link active" href="izlozbe.php">Izlozbe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="dogadjaji.php">Dogadjaji</a>
            </li>
            <li class="nav-item">
              <a class="nav-link  " href="Moje_rezervacije.php">Moje rezervacije</a>
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
<div class='container'>
<div style='padding-top: 150px;'>
<?php 
if (isset($_GET['id_izlozbe'])) {
    $izlozba_id = $_GET['id_izlozbe'];

    // Izvrši upit za dohvatanje informacija o izložbi po ID-ju
    $sql = "SELECT i.NAZIV_IZLOZBE, i.IMG_IZLOZBE, i.OPIS_IZLOZBE, e.NAZIV_EKSPONATA, l.NAZIV_LOKACIJE
    FROM IZLOZBA i
    LEFT JOIN EKSPONATI e ON i.ID_IZLOZBE = e.ID_IZLOZBE
    LEFT JOIN LOKACIJA l ON i.ID_LOKACIJE = l.ID_LOKACIJE
    WHERE i.ID_IZLOZBE = $izlozba_id";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $izlozba = $row["NAZIV_IZLOZBE"];
        $img_src = $row["IMG_IZLOZBE"];
        $opis = $row["OPIS_IZLOZBE"];
        $lokacija = $row["NAZIV_LOKACIJE"];
?>

 
<div class="card mb-3" >
                <img src="<?php echo $img_src; ?>" class="card-img-top" alt="<?php echo $izlozba; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $izlozba; ?></h5>
                    <p class="card-text">Lokacija: <?php echo $lokacija; ?></p>
                    <p class="card-text">Opis: <?php echo $opis; ?></p>
                    <p class="card-text">Eksponati:</p>
                    <ul class="list-group">
<?php
        // Dohvatanje svih eksponata za tu izložbu
        $eksponati_sql = "SELECT NAZIV_EKSPONATA FROM EKSPONATI WHERE ID_IZLOZBE = $izlozba_id";
        $eksponati_result = $db->query($eksponati_sql);

        if ($eksponati_result->num_rows > 0) {
            while ($eksponat_row = $eksponati_result->fetch_assoc()) {
                echo "<li class='list-group-item'>" . $eksponat_row["NAZIV_EKSPONATA"] . "</li>";
            }
        } else {
            echo "<li class='list-group-item'>Nema dostupnih eksponata.</li>";
        }
?>
                    </ul>
                </div>
                <a href="rezervacija.php?id_izlozbe=<?php echo $izlozba_id?>">REZERVISI</a>
            </div>

<?php
    } else {
        echo "Nema podataka o izložbi sa datim ID-jem.";
    }
} else {ispisivanjeIzlozbi($db);}?>
    
?>
<?php
// Zatvori konekciju s bazom
$db->close();?>
</div>
</div>
    </div>
    </div>
</body>
</html>