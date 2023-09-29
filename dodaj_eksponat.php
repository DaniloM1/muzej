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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
</head>
<body>
<?PHP
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv_eksponata = $_POST["naziv_eksponata"];
    $opis_eksponata = $_POST["opis_eksponata"];
    $lokacija_id = $_POST["lokacija_id"];
    $img_eksponata = $_POST["img_eksponata"];
    $izlozba=$_POST['izlozbe'];

    // Dodatne validacije i sigurnosne provere moguće

    // Upload slike na server
    // $target_dir = "img/eksponati/";
    // $target_file = $target_dir . basename($img_eksponata);
    // move_uploaded_file($_FILES["img_eksponata"]["tmp_name"], $target_file);

    // Izvrši upit za dodavanje novog eksponata
    $sql_insert_eksponat = "INSERT INTO EKSPONATI (ID_LOKACIJE, NAZIV_EKSPONATA, OPIS_EKSPONATA, IMG_EKSPONATA, ID_IZLOZBE)
        VALUES ('$lokacija_id', '$naziv_eksponata', '$opis_eksponata', '$img_eksponata', '$izlozba')";

    if ($db->query($sql_insert_eksponat) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Uspešno dodat eksponat.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Došlo je do greške prilikom dodavanja eksponata.</div>';
    }
}

// Izvrši upit za dohvatanje svih lokacija
$sql_lokacije = "SELECT * FROM LOKACIJA";
$result_lokacije = $db->query($sql_lokacije);
$sql_izlozbe="SELECT * FROM IZLOZBA";
$result_izlozbe=$db->query($sql_izlozbe);
?>

        <h2>Dodaj Eksponat</h2>
        <a href="admin.php">Nazad</a>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="naziv_eksponata">Naziv Eksponata</label>
                <input type="text" class="form-control" id="naziv_eksponata" name="naziv_eksponata" required>
            </div>
            <div class="form-group">
                <label for="opis_eksponata">Opis Eksponata</label>
                <textarea class="form-control" id="opis_eksponata" name="opis_eksponata" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="lokacija_id">Izaberi Lokaciju</label>
                <select class="form-control" id="lokacija_id" name="lokacija_id" required>
                    <option value="" >----Izaberite lokaciju-----</option>
                    <?php
                    while ($row_lokacija = $result_lokacije->fetch_assoc()) {
                        echo '<option value="' . $row_lokacija["ID_LOKACIJE"] . '">' . $row_lokacija["NAZIV_LOKACIJE"] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_izlozbe">Izaberi Izlozbu</label>
             <select name="izlozbe" id="izlozbe" required></select>
            </div>
            <div class="form-group">
                <label for="img_eksponata">Slika Eksponata</label>
                <input type="text"  id="img_eksponata" name="img_eksponata"  required>
            </div>
            <button type="submit" class="btn btn-primary">Dodaj Eksponat</button>
        </form>
</body>

<script>
$(document).ready(function() {
    $("#lokacija_id").on("change", function() {
        var selectedOption = $(this).val();

        $.ajax({
            url: "obrada.php",
            type: "POST",
            data: { lokacija_id: selectedOption },
            success: function(response) {
                $("#izlozbe").html(response);
            }
        });
    });
});
</script>
</html>