<?php
require_once '../baza/konekcija.php';
$output='';
try {
    if (isset($_POST["query"])) {
        $search = mysqli_real_escape_string($con, $_POST["query"]);
        $query = "
SELECT * FROM objava 
  WHERE naslov LIKE '%" . $search . "%'";
    } else {
        throw  new Exception("Nema podataka");
    }
} catch (Exception $e){
    echo 'Message: ' .$e->getMessage();
}
try {
    $result = mysqli_query($con, $query);
    if (empty($query)){
        throw  new Exception("Upit nije postavljen.");
    }
    if (mysqli_num_rows($result) > 0) {
        $output .= '
  <div class="table-responsive">
   <table class="table table bordered text-white">
 ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
   <tr>
    <td ><a class="text-white" href="#'.$row["id"].'">' . $row["naslov"] . '</a></td>
    <td>' . $row["vrsta"] . '</td>
   </tr>
  ';
        }
        echo $output;
    } else {
        throw  new Exception("Nema podataka");
    }
}catch (Exception $e){
    echo 'Message: ' .$e->getMessage();
}

?>

