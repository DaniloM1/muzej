<?php

session_start();
require_once ("funkcije.php");
proveraKolacica();
prijava();
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
<div class="container mt-4">
    <h2>Dodaj Događaj</h2>

    <form id="forma_dogadjaj" method="post" action="dogadjaj_obrada.php">
        <div class="form-group">
            <label for="naziv">Naziv Događaja:</label>
            <input type="text" class="form-control" id="naziv" name="naziv" required>
        </div>

        <div class="form-group">
            <label for="vreme">Vreme Događaja:</label>
            <input type="datetime-local" min="<?php echo $today; ?>" class="form-control" id="vreme" name="vreme" required>
        </div>

        <div class="form-group">
            <label for="trajanje">Trajanje Događaja:</label>
            <input type="datetime-local" min="<?php echo $today; ?>" class="form-control" id="trajanje" name="trajanje" required>
        </div>

        <div class="form-group">
            <label for="lokacija">Lokacija Događaja:</label>
            <input type="text" class="form-control" id="lokacija" name="lokacija" required>
        </div>

        <div class="form-group">
            <label for="eksponati">Izaberite Eksponate:</label>
            <select class="form-control" multiple id="eksponati" name="eksponati[]">
               
                <?php
                   $sql='SELECT * FROM EKSPONATI where id_dogadjaja is null';
                   $result=$db->query($sql);
                   while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["ID_EKSPONATA"] . '">' . $row["NAZIV_EKSPONATA"] . '</option>';
                }

                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="dodaj_dogadjaj">Dodaj Događaj</button>
    </form>
</div>
<?php

?>

<!-- Uključivanje Bootstrap JS-a (opciono) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
// $(document).ready(function(){
// $("#eksponati").on("change", function() {
//         var eksponati = $(this).val();

//         $.ajax({
//             url: "dogadjaj_obrada.php",
//             type: "POST",
//             data: { lokacija: loc },
//             success: function(response) {
//                 $("#eksponati_ids").html(response);
//             }
//         });
//     });

// })
</script>



</body>
</html>