<?php

session_start();
require_once ("funkcije.php");
proveraKolacica();
prijava();
if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {

} else {
  
  header("Location: index.php");
  exit(); // Opciono, zaustaviti dalje izvršavanje skripta
}
echo "<div class='container'>Dobro došao, ".$_SESSION['ime']."<br>";
echo "<a href='login.php?odjava'>Odjava</a><br>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
</head>
</head>
<body>
    <h2> admin deo</h2>
    <a href="dodaj_eksponat.php" class="btn btn-primary">Dodavanje eksponata</a>
<a href="dodaj_izlozbu.php" class="btn btn-primary">Dodavanje Izlozbe</a>
<a href="premestanje_eksponata.php" class="btn btn-primary">Premestanje eksponata</a>
<a href="dodavanje_dogadjaja.php" class="btn btn-primary">Dodaj dogadjaj</a>
 
<div class='container'>
<?php
$sql='SELECT * FROM IZLOZBA, LOKACIJA WHERE IZLOZBA.ID_LOKACIJE=LOKACIJA.ID_LOKACIJE';
$result=$db->query($sql);
if ($result->num_rows > 0) {
    echo "<table class='table'>";
    echo "<tr><th>Naziv predstave</th><th>Trajanje predstave</th><th>Lokacija</th></tr>";
    while ($row = $result->fetch_assoc()) {
     echo " <form action='admin.php' method='get' >";
        echo "<tr class='thead-dark'>";
        echo "<td>" . $row["NAZIV_IZLOZBE"] . "</td>";
        echo "<td>" . $row["OPIS_IZLOZBE"] . "</td>";
        echo "<td>" . $row["NAZIV_LOKACIJE"] . "</td>";
        echo "<td><button class='btn btn-primary'><a style='color:black;' href='admin.php?id_izlozbe=".$row["ID_IZLOZBE"]."'>Pogledajte rezervacije</a></button></td>";
        echo "</tr>";
       
    }
    echo "</table>";
   
    echo "</form>";
} else {
    echo "Nema rezultata.";
}
?>

<?php

if(isset($_GET['id_izlozbe'])){
    $id_izlozbe=$_GET['id_izlozbe'];
  
  
      $sqll = "SELECT ime, email, naziv_izlozbe, datum_rezervacije FROM REZERVACIJA, IZLOZBA WHERE REZERVACIJA.ID_IZLOZBE=IZLOZBA.ID_IZLOZBE AND REZERVACIJA.ID_IZLOZBE=$id_izlozbe";
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
    //   echo"<form  method='get' >";
    //   echo "<td>"."<button name='Izbrisi' value='".$row['id_rezervacije']."'_*?href='home.php?id_izlozbe=".$id_izlozbe."'>Izbrisi</button>"."</td>";
    //   //echo "<td>" . $row["suma"] . "</td>";
    //   echo "</tr>";
    //   echo "</form>";
  
   }
  }else{
    echo '<div class="alert alert-danger" role="alert">Nema rezultata za prosledjenu izlozbu</div>';
  }
   }
//   if(isset($_GET['Izbrisi'])){
//     $id_izbrisi=$_GET['Izbrisi'];
//    $q="DELETE FROM `rezervacija` WHERE id_rezervacije='$id_izbrisi'";
//    $resultat= $db->query($q);
//    echo "Uspesno ste obrisali rezervaciju";
//   }

?>
</div>

</body>
</html>