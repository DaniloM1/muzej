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
              <a class="nav-link" href="izlozbe.php">Izlozbe</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="dogadjaji.php">Dogadjaji</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active " href="Moje_rezervacije.php">Moje rezervacije</a>
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
<div class='container' style='padding-top: 150px;'>
    <?php
    $id=$_SESSION['id'];
$sqll = "SELECT ime, email, naziv_izlozbe, datum_rezervacije, id_rezervacije, rezervacija.id_izlozbe FROM REZERVACIJA, IZLOZBA WHERE REZERVACIJA.ID_IZLOZBE=IZLOZBA.ID_IZLOZBE AND id_korisnika=$id";
  $resultt= $db->query($sqll);
  
  // Prikaz rezultata u HTML formatu
  if (!empty($resultt) && $resultt->num_rows > 0) {
      echo "<table class='table'>";
      echo "<tr><th>Ime</th> <th>Email</th>  <th>Naziv predstave</th>><th>Datum rezervacije</th></tr>";
   while ($roww = $resultt->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $roww["ime"] . "</td>";
      echo "<td>" . $roww["email"] . "</td>";
      echo "<td>" . $roww["naziv_izlozbe"] . "</td>";
      echo "<td>" . date('Y-m-d H:i:s.', strtotime($roww["datum_rezervacije"])) . "</td>";
     echo"<form  method='get' >";
      echo "<td>"."<button name='Izbrisi' value='".$roww['id_rezervacije']."'_*?href='moje_rezervacije.php?id_izlozbe=".$roww['id_izlozbe']."'>Izbrisi</button>"."</td>";
      echo "</tr>";
      echo "</form>";
  
   }
  }else{
    echo '<div class="alert alert-danger" role="alert">Nemte rezervisanih izložbi</div>';
  }
  if(isset($_GET['Izbrisi'])){
  $id_izbrisi=$_GET['Izbrisi'];
 $q="DELETE FROM `rezervacija` WHERE id_rezervacije='$id_izbrisi'";
 $resultat= $db->query($q);
 echo '<div class="alert alert-success" role="alert style="padding-top: 150px;"">Uspešno ste obrisali izlozbu</div>';
 header("Location: moje_rezervacije.php");
}
  ?>
</div>
</div>
    
</body>
</html>