<?php
$server = 'localhost';
$user = 'root';
$pass = '';
$baza = 'macke';

$con = new mysqli($server, $user, $pass, $baza);


if (!$con->connect_error && !empty($con)) {
    return true;
} else {
    die("Došlo je do greške u konekciji" . $con->connect_error);
}
