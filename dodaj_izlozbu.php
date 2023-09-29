<?php

session_start();
require_once ("funkcije.php");
proveraKolacica();
prijava();
if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {

} else {
  
  header("Location: index.html");
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>


<!DOCTYPE html>
<html>
<head>
    <title>Unos Izložbe</title>
</head>
<body>
<div class="container mt-4">
<a href="admin.php">Nazad</a>
<?php

$sql_lokacije = "SELECT * FROM LOKACIJA";
$result_lokacije = $db->query($sql_lokacije);
?>

<form  method="post">
    <div class="form-group">
        <label for="naziv_izlozbe">Naziv Izložbe</label>
        <input type="text" class="form-control" id="naziv_izlozbe" name="naziv_izlozbe" required>
    </div>

    <div class="form-group">
        <label for="opis_izlozbe">Opis Izložbe</label>
        <textarea class="form-control" id="opis_izlozbe" name="opis_izlozbe" required></textarea>
    </div>

    <div class="form-group">
        <label for="img_izlozbe">Img Putanja Izložbe</label>
        <input type="text" class="form-control" id="img_izlozbe" name="img_izlozbe" required>
    </div>
    <div>
        <label for="datum_izlozbe">Datum Izložbe:</label>
        <input type="date" id="datum_izlozbe" name="datum_izlozbe" required>
    </div>

    <div class="form-group">
        <label for="lokacija">Izaberi Lokaciju</label>
        <select class="form-control" id="lokacija" name="lokacija" required>
        <option value="" >----Izaberite lokaciju-----</option>
                    <?php
                    while ($row_lokacija = $result_lokacije->fetch_assoc()) {
                        echo '<option value="' . $row_lokacija["ID_LOKACIJE"] . '">' . $row_lokacija["NAZIV_LOKACIJE"] . '</option>';
                    }
                    ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Dodaj Izložbu</button>
</form>



<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naziv_izlozbe = $_POST["naziv_izlozbe"];
    $opis_izlozbe = $_POST["opis_izlozbe"];
    $datum_izlozbe = $_POST["datum_izlozbe"];
    $img_izlozbe = $_POST["img_izlozbe"];
    $lokacija = $_POST["lokacija"];

    $sql_insert_izlozba = "INSERT INTO IZLOZBA (ID_LOKACIJE, NAZIV_IZLOZBE, OPIS_IZLOZBE, DATUM_IZLOZBE, IMG_IZLOZBE) VALUES ('$lokacija', '$naziv_izlozbe' , '$opis_izlozbe', '$datum_izlozbe', '$img_izlozbe')";
    if ($db->query($sql_insert_izlozba) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Uspešno dodata izlozba.</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Došlo je do greške prilikom dodavanja izlozbe.</div>';
    }
}
?>
</div>
</body>
</html>





<!-- Ostatak vašeg admin panela -->

</body>
<script>

$(document).ready(function(){
$("#lokacija").on("change", function() {
        var loc = $(this).val();

        $.ajax({
            url: "obradaa.php",
            type: "POST",
            data: { lokacija: loc },
            success: function(response) {
                $("#eksponati_ids").html(response);
            }
        });
    });

})
</script>
</html>