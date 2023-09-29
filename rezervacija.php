<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    session_start();
    require_once('funkcije.php');
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
              <a class="nav-link active" href="izlozbe.php">Izlozbe</a>
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
<div class='container'>
<div style='padding-top: 150px;'>
  <?php if (isset($_GET['id_izlozbe'])) {
    $izlozba_id = $_GET['id_izlozbe'];

    $sql_izlozba = "SELECT i.NAZIV_IZLOZBE, i.IMG_IZLOZBE, l.NAZIV_LOKACIJE
            FROM IZLOZBA i
            LEFT JOIN LOKACIJA l ON i.ID_LOKACIJE = l.ID_LOKACIJE
            WHERE i.ID_IZLOZBE = $izlozba_id";

    $result_izlozba = $db->query($sql_izlozba);

    // Proveri rezultate upita za izložbu
    if ($result_izlozba->num_rows > 0) {
        $row_izlozba = $result_izlozba->fetch_assoc();
        $naziv_izlozbe = $row_izlozba["NAZIV_IZLOZBE"];
        $img_src = $row_izlozba["IMG_IZLOZBE"];
        $lokacija = $row_izlozba["NAZIV_LOKACIJE"];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $ime = $_SESSION['ime'];
            $email = $_SESSION['email'];
            $id=$_SESSION['id'];
            $datum=$_POST['vreme'];
            $mesta=$_POST['mesta'];

            // Izvrši upit za dodavanje rezervacije u bazu
            $sql_insert = "INSERT INTO REZERVACIJA (ID_IZLOZBE, id_korisnika , ime, EMAIL, DATUM_REZERVACIJE, broj_mesta)
                VALUES ('$izlozba_id', '$id', '$ime', '$email', '$datum', '$mesta')";

            if ($db->query($sql_insert) === TRUE) {
                echo '<div class="alert alert-success" role="alert">Uspešno ste rezervisali izložbu!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Došlo je do greške prilikom rezervacije. Molimo vas pokušajte ponovo.</div>';
            }
        }
?>

        <div class="card mb-3">
            <img src="<?php echo $img_src; ?>" class="card-img-top" alt="<?php echo $naziv_izlozbe; ?>">
            <div class="card-body">
                <h5 class="card-title"><?php echo $naziv_izlozbe; ?></h5>
                <p class="card-text">Lokacija: <?php echo $lokacija; ?></p>
                <p class="card-text">Eksponati:</p>
                <ul class="list-group">
<?php
        // Izvrši upit za dohvatanje eksponata povezanih sa izložbom
        $sql_eksponati = "SELECT e.NAZIV_EKSPONATA
            FROM EKSPONATI e
            WHERE e.ID_IZLOZBE = $izlozba_id";

        $result_eksponati = $db->query($sql_eksponati);

        // Prikazi sve eksponate povezane sa izlozbo
        while ($row_eksponati = $result_eksponati->fetch_assoc()) {
            echo "<li class='list-group-item'>" . $row_eksponati["NAZIV_EKSPONATA"] . "</li>";
        }
?>
                </ul>
            </div>
        </div>
        <div class='container'>
        <h2>Rezervacija</h2>
        <form method="POST">
            <div class="form-group">
                <label for="broj">Izaberite broj karata</label>
                <input name='mesta' id='mesta' type='number' min='1' max='10' value='1';>
            </div>
            <div class="form-group">
                <label for="vreme">izaberite vreme </label>
                <input type="datetime-local" min="<?php echo date("Y-m-d h:i", strtotime('now')); ?>" class="form-control" id="vreme" name="vreme" required>
            </div>
            <button type="submit" class="btn btn-primary">Rezerviši</button>
        </form>
<?php
    } else {
        echo "Nema podataka o izložbi sa datim ID-jem.";
    }
} else { ispisivanjeIzlozbi($db);}?>
    
    </div>
</div>
</div>
    
</body>
</html>