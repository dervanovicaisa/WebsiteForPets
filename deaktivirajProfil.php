<?php
include 'baza/konekcija.php';

$deleteId= $_GET['id'];
$query = "UPDATE korisnik SET isActive = 1 WHERE id = $deleteId";
$result = mysqli_query($con, $query);
if (isset($result)) {
    echo " <script> alert('Deaktivirali ste svoj račun.'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=registrujse.php' />";
} else {
    echo "<script> alert('Došlo je do greške!'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=profil.php' />";
}

?>