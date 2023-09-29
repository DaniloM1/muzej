
<!DOCTYPE html>
<html lang="en">
<head>
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

    </body>
    </html>
<?php
require_once('funkcije.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv = $_POST["naziv"];
    $vreme = date("Y-m-d H:i", strtotime($_POST["vreme"])); 
    $trajanje = date("Y-m-d H:i", strtotime($_POST["trajanje"]));
    $lokacija = $_POST["lokacija"];
    $eksponati = $_POST['eksponati'];
    if(strtotime($vreme)>strtotime($trajanje)){
        echo "morate izabrati vreme posle vremena pocetka";
        echo "<br>";
        echo "<a href='dodavanje_dogadjaja.php'>nazad</a>";
    }else{

    // Dohvatanje selektovanih eksponata kao niza
   
     $upit3 = "INSERT INTO `dogadjaj`(`NAZIV_DOGADJAJA`, `VREME_DOGADJAJA`, `TRAJANJE_DOGADJAJA`, `LOKACIJA_DOGADJAJA`) 
                VALUES ('$naziv','$vreme','$trajanje','$lokacija')";
    mysqli_query($db, $upit3);
    $doisteka=strtotime($trajanje)-strtotime($vreme);
    echo $doisteka;
    $trenutno_vreme=strtotime('now');
    
    // Dobijte ID poslednjeg umetnutog događaja
    $idDogadjaja = mysqli_insert_id($db);

    // Ažurirajte eksponate sa novim ID događaja
    foreach ($eksponati as $idEksponata) {
        $izlozba="SELECT ID_IZLOZBE FROM EKSPONATI WHERE ID_EKSPONATA=$idEksponata";
        $result = $db->query($izlozba);
        while ($row = $result->fetch_assoc()) {
            $id_izlozbe=$row['ID_IZLOZBE'];
        }
        
        $upit1="INSERT INTO `predhodne_vrednosti`(`ID_EKSPONATA`, `ID_IZLOZBE`) VALUES ('$idEksponata','$id_izlozbe')";
        $upit = "UPDATE eksponati SET id_dogadjaja = $idDogadjaja, id_izlozbe=null WHERE id_eksponata = $idEksponata";
        mysqli_query($db, $upit1);
        mysqli_query($db, $upit);
        
    }
    
   echo '<div class="alert alert-success" role="alert">Uspešno ste dodali dogadjaj!!</div>';
   echo '<div class="btn"><a href="admin.php">NAZAD</a></div>';
}
}
    // $selektovani_eksponati sada sadrži niz ID-jeva selektovanih eksponata
    // Možete ga dalje koristiti za obradu ili unos u bazu podataka

?>