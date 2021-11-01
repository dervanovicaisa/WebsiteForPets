<?php
require_once '../baza/konekcija.php';
session_start();
if (isset($_POST['limit']) && isset($_POST['start'])) {
    $sql = "SELECT * FROM macke ORDER BY id DESC LIMIT " . $_POST["start"] . ", " . $_POST["limit"];
    $result = mysqli_query($con, $sql);
    //$json_array = array();
    while ($row = mysqli_fetch_array($result)) {
        // $json_array[] = $row;
        $id = $row['id'];
        if (isset($_SESSION['your_name']) != 'admin@gmail.com') {
            echo "
             <div class='card-group col-md-10'>                  
                  <div class='card' id='" . $row['id'] . "'>
                          <img class='card-img-top' src=" . $row['url'] . " alt='Card image cap'>
                          <div class='card-body'>
                                <h3 class='card-title text-center'>" . $row['rasa'] . "</h3>
                               <textarea class='card-text'  cols='61' rows='15' disabled>" . $row['opis'] . "</textarea>
                             <p class='card-text'> <small class='text-muted'>" . $row['rasa'] . "," . $row['autor'] . "</small></p>
                          </div>
                     </div>
                     </div>
                   <div id='load_more' ></div>
                     ";
        } else if (isset($_SESSION['your_name'])== 'admin@gmail.com') {
            echo "
        <form action=" . $_SERVER["PHP_SELF"] . " method='post'>
             <div class='card-group col-md-10'>                  
                  <div class='card' id='" . $row['id'] . "'>
                          <img class='card-img-top' src=" . $row['url'] . " alt='Card image cap'>
                          <div class='card-body'>
                                <h3 class='card-title text-center'>" . $row['rasa'] . "</h3>
                               <textarea class='card-text' cols='61' rows='15' disabled>" . $row['opis'] . "</textarea>
                             <p class='card-text'> <small class='text-muted'>" . $row['rasa'] . "</small></p>
                          <button type='button' id='btnDelete'class='btn btn-dark float-right'><a class='text-white' href='./administrator/obrisiMacke.php?id=" . $id . "'>Obriši</a></button> <button type='button' id='btnEdit' class='btn btn-dark float-right'><a class='text-white' href='./administrator/urediMacke.php?id=" . $id . "'>Uredi</a></button>
                          </div>
                     </div>
                     </div>
        </form>
                   <div id='load_more' ></div>
                     ";
        }

    }
}
//    echo json_encode($json_array);
?>