<?php
include 'baza/konekcija.php';

$deleteId= $_GET['id'];
$query = "DELETE from korisnik k, prijavilutajucumacku p,neudomljenemacke n, objava o
  where k.id= '$deleteId' and p.idKorisnika = '$deleteId'  and n.idKorisnika = '$deleteId' and o.idKorisnika = '$deleteId'";
$result = mysqli_query($con, $query);
if (isset($result)) {
    echo " <script> alert('Obrisali ste svoj račun.'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=registrujse.php' />";
} else {
    echo "<script> alert('Došlo je do greške!'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=profil.php' />";
}

?>
