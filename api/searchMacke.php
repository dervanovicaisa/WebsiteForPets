<?php
require_once '../baza/konekcija.php';
$output='';
$q =$_POST["query"];
try {
    if (isset($q)) {
        $search = mysqli_real_escape_string($con, $q );
        $query = "
    SELECT * FROM macke 
    WHERE rasa LIKE '%" . $search . "%'";
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
      <td><img src="'.$row['url'].'" style="width: 110px; height: 50px;"></td>>|
    <td ><a class="text-white" href="#'.$row["id"].'">' . $row["rasa"] . '</a></td>
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

