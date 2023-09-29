<?php
require_once('funkcije.php');

if(isset($_POST['lokacija_id'])) {
    $LOK = $_POST['lokacija_id'];

    $sql_izlozbe = "SELECT * FROM IZLOZBA WHERE id_lokacije = $LOK";
    $result_izlozbe = $db->query($sql_izlozbe);

    $content = '';
    while ($row_izlozbe = $result_izlozbe->fetch_assoc()) {
        $content .= '<option value="' . $row_izlozbe["ID_IZLOZBE"] . '">' . $row_izlozbe["NAZIV_IZLOZBE"] . '</option>';
    }
    echo $content;
}
?>

