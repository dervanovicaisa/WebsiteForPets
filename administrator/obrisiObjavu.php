<?php
include '../baza/konekcija.php';

$deleteId= $_GET['id'];
$query = "DELETE from objava where id=$deleteId";
$result = mysqli_query($con, $query);
if (isset($result)) {
    echo " <script> alert('Obrisali ste objavu.'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=../novosti.php' />";
} else {
    echo "<script> alert('Došlo je do greške!'); </script>";
    echo "<meta http-equiv='refresh' content='0;url=../novosti.php' />";
}

?>