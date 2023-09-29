<?php
//Konekcija na bazu
$server="localhost";// Server na kojem je MySQL baza podataka
$kor="root";// Korisničko ime za pristup bazi
$pas="";// Lozinka za pristup bazi, ostavljena prazna jer se radi na lokalnom serveru
$dbime="muzej";// Ime baze podataka kojoj želimo da pristupimo


$db=mysqli_connect($server, $kor, $pas, $dbime);

if ($db->connect_error) {
    die("Greška pri povezivanju sa bazom podataka: " . $db->connect_error);
} else {
}



function odjava()
{
//Ako se korisnik odjavljuje, uništavaju se promenljive sesije, sesija i kolačići
setcookie("id", "", time()-1);
setcookie("email", "", time()-1);
setcookie("ime", "", time()-1);
setcookie("status", "", time()-1);
unset($_SESSION['id']);
unset($_SESSION['email']);
unset($_SESSION['ime']);
unset($_SESSION['status']);

session_destroy();
}
function prijava()
{
//Ako korisnik nije prijavljen odmah se prosleđuje na stranicu za prijavu
if(!isset($_SESSION['id'])) header("Location: login.php");
}


function proveraKolacica()
{
//Ako kolačići postoje generišu se promenljive sesije za dalji rad
if(isset($_COOKIE['id']) and isset($_COOKIE['email']) and isset($_COOKIE['ime'])and isset($_COOKIE['status']))
{
$_SESSION['id']=$_COOKIE['id'];
$_SESSION['email']=$_COOKIE['email'];
$_SESSION['ime']=$_COOKIE['ime'];
$_SESSION['status']=$_COOKIE['status'];

}
}
 function ispisivanjeIzlozbi($db){
    $sql = "SELECT i.ID_IZLOZBE, i.NAZIV_IZLOZBE, i.IMG_IZLOZBE, e.NAZIV_EKSPONATA, l.NAZIV_LOKACIJE
        FROM IZLOZBA i
        LEFT JOIN EKSPONATI e ON i.ID_IZLOZBE = e.ID_IZLOZBE
        LEFT JOIN LOKACIJA l ON i.ID_LOKACIJE = l.ID_LOKACIJE
        ORDER BY i.ID_IZLOZBE";

    $result = $db->query($sql);

// Proveri rezultate upita i generiši HTML za prikazivanje izložbi i eksponata
if ($result->num_rows > 0) {
    $current_izlozba = null;

    while ($row = $result->fetch_assoc()) {
      $id_izlozbe=$row["ID_IZLOZBE"];
        $izlozba = $row["NAZIV_IZLOZBE"];
        $img_src = $row["IMG_IZLOZBE"];
        $eksponat = $row["NAZIV_EKSPONATA"];
        $lokacija = $row["NAZIV_LOKACIJE"];

        if ($current_izlozba !== $izlozba) {
            // Prikazujemo karticu sa slikom izložbe, nazivom i lokacijom samo jednom, kada se promeni izložba
?>

            <div class="card mb-3">
                <img src="<?php echo $img_src; ?>" class="card-img-top" alt="<?php echo $izlozba; ?>">
                <span class="card-body">
                    <h5 class="card-title"><?php echo $izlozba; ?></h5>
                    <a href="rezervacija.php?id_izlozbe=<?php echo $id_izlozbe?>">REZERVISI</a>
                    <a href="izlozbe.php?id_izlozbe=<?php echo $id_izlozbe?>">OPSIRNIJE</a>
                    <p class="card-text">Lokacija: <?php echo $lokacija; ?></p>
                    <p class="card-text">Eksponati:</p>
                    </span>
                    <ul class="list-group">
                        <li class="list-group-item"><?php echo $eksponat; ?></li>
<?php
            $current_izlozba = $izlozba;
        } else {
            
?>
                        <li class="list-group-item"><?php echo $eksponat; ?></li>
<?php
        }
    }
?>
                    </ul>
                </div>
            </div>
            </div>

<?php
} else {
    echo "Nema dostupnih podataka o izložbama i eksponatima.";
}  


 }

?>