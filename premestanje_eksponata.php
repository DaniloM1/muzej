<!DOCTYPE html>
<html>
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
    <title>Premesti Eksponat</title>
    <!-- Uključivanje potrebnih stilova i skripti -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
require_once('funkcije.php');
                  $sql='SELECT * FROM EKSPONATI';
                  $result_eksponati = $db->query($sql);
                  $sql_lokacija='SELECT * FROM LOKACIJA';
                  $result_lokacija=$db->query($sql_lokacija);

                ?>
<div class="container mt-4">
    <h2>Premesti Eksponat</h2>
    <a href="admin.php">Nazad</a>
    <form id="forma_premesti" method="post">
        <div class="form-group">
            <label for="eksponat">Izaberite Eksponat:</label>

            <select class="form-control" id="eksponat" name="eksponat" required>
            <option value="" >----Izaberite eksponat-----</option>
                <?php
                  while ($row = $result_eksponati->fetch_assoc()) {
                    echo '<option value="' . $row["ID_EKSPONATA"] . '">' . $row["NAZIV_EKSPONATA"] . '</option>';
                }

                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="okacija">Nova Lokacija:</label>
            <select class="form-control" id="lokacija" name="lokacija" required>
            <option value="" >----Izaberite lokaciju-----</option>
                <?php
                  while ($row_lokacija = $result_lokacija->fetch_assoc()) {
                    echo '<option value="' . $row_lokacija["ID_LOKACIJE"] . '">' . $row_lokacija["NAZIV_LOKACIJE"] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="izlozba">Nova Izložba:</label>
            <select class="form-control" id="izlozba" name="izlozba" required>
                <!-- Ovde će biti automatski generisane opcije za nove izložbe -->
                <?php
                    // Ovde treba da se dohvate i prikažu opcije za izložbe iz baze
                    // Primer: SELECT * FROM IZLOZBA
                    // Treba da se popuni select sa opcijama
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="premesti">Premesti Eksponat</button>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_eksponata=$_POST['eksponat'];
    $lokacija = $_POST["lokacija"];
    $id_izlozbe=$_POST['izlozba'];

    $sql_premesti_eksponat = "UPDATE `eksponati` SET `ID_LOKACIJE`='$lokacija',`ID_IZLOZBE`='$id_izlozbe' WHERE ID_EKSPONATA=$id_eksponata";
    if ($db->query($sql_premesti_eksponat) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Uspešno premesten eksponat</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Došlo je do greške prilikom premestanaja eksponata.</div>';
    }
}
?>
<script>
$(document).ready(function() {
    $("#lokacija").on("change", function() {
        var lokacija = $(this).val();

        $.ajax({
            url: "obrada_premesti.php",
            type: "POST",
            data: { lokacija: lokacija },
            success: function(response) {
                $("#izlozba").html(response);
            }
        });
    });
});
</script>

</body>
</html>
