<?php
include_once("baza/konekcija.php");
if (isset($_SESSION['id'])) {
    $idObjave = $_SESSION['id'];
    $commentQuery = "SELECT * FROM komentar WHERE idObjave = '$idObjave' ORDER BY id DESC";
    $commentsResult = mysqli_query($con, $commentQuery) or die("database error:" . mysqli_error($con));
    $commentHTML = '';
    while ($comment = mysqli_fetch_assoc($commentsResult)) {
        $commentHTML .= '
<div class="panel panel-primary">
<div class="panel-heading">By <b>' . $comment["ime"] . '</b> on <i>' . $comment["datum"] . '</i></div>
<div class="panel-body">' . $comment["komentar"] . '</div>
</div> ';
    }
    echo $commentHTML;
}
?>