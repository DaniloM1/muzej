<?php
require_once('funkcije.php')
// Povezivanje sa bazom podataka i ostale neophodne konfiguracije

if(isset($_POST['lokacija'])) {
    $lc = $_POST['lokacija']; 
    $sql = "SELECT * FROM EKSPONATI WHERE ID_LOKACIJE=$lc";
    $result = $db->query($sql)
    $contentt = '';
    while ($row = $result->fetch_assoc()) {
        $contentt .= '<option value="' . $row["ID_EKSPONATA"] . '">' . $row["NAZIV_EKSPONATA"] . '</option>';
    }
    echo $contentt;
}

// Zatvaranje veze sa bazom i ostali clean-up
?>