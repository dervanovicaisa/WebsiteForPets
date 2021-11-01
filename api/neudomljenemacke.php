<?php
require_once '../baza/konekcija.php';
$sql = "SELECT * FROM neudomljenemacke";
$result = mysqli_query($con, $sql);
$json_array = array();
while ($row = mysqli_fetch_assoc($result)) {
    $json_array[] = $row;
}

echo json_encode($json_array);
