<?php
session_start();
include ("baza/konekcija.php");
//$email ="";
//if (isset($_SESSION['your_name'])){
//    $email =$_SESSION['your_name'];
//}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <title>Početna</title>
</head>

<body>

    <!--  Meni  -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <div class="logo float-left">
                <img src="images/cat-face.png" alt="navBar" style="width: 50px; height: 50px;">
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="meni float-right">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link text-white " href="početna.php">Početna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="novosti.php">Objave</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mačke</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="neudomljenemacke.php">Neudomljene mačke</a>
                                <a class="dropdown-item" href="macke.php">Mačke</a>
                            </div>
                        </li>
                        <?php if (isset($_SESSION['your_name']) && $_SESSION['your_name'] != 'admin@gmail.com'){ ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Korisnik
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="prijavise.php">Prijavi se</a>
                                <a class="dropdown-item" href="registrujse.php">Registruj se</a>
                              <?php if (isset($_SESSION['your_name'])){ ?>
                                <a class="dropdown-item" href="profil.php">Profil</a>
                                <?php }?>
                            </div>
                        </li>
                        <?php }else if (isset($_SESSION['your_name']) && $_SESSION['your_name']=='admin@gmail.com'){ ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Admin
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="administrator/dodajMacke.php">Dodaj mačke</a>
                                    <a class="dropdown-item" href="administrator/dodajObjavu.php">Dodaj objavu</a>
                                    <a class="dropdown-item" href="administrator/dodajLokaciju.php">Dodaj lokaciju</a>
                                    <a class="dropdown-item" href="administrator/obrisiKorisnika.php">Onemogući korisnika</a>
                                    <a class="dropdown-item" href="prijavise.php">Prijavi se</a>
                                    <a class="dropdown-item" href="registrujse.php">Registruj se</a>
                                    <a class="dropdown-item" href="profil.php">Profil</a>
                                </div>
                            </li>
                        <?php }else{?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Korisnik
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="prijavise.php">Prijavi se</a>
                                    <a class="dropdown-item" href="registrujse.php">Registruj se</a>
                                </div>
                            </li>
                        <?php }?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="kontakt.php">Kontakt</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!--
        Slika
    -->

    <div class="image">
        <img src="images/cat.png" style="width: 100%;margin-top: -1.4%;" alt="cats">
    </div>

    <!--
        Objave
    -->
    <div class="containerObjave w-100 h-100">
        <div class="text w-100 h-30  text-center">
            <h1 class="m-4 p-4" style="font-family: 'Georgia', 'Times New Roman', 'Times, serif';">
                <hr style="width: 50%;"> Objave
                <hr style="width: 50%;">
            </h1>
        </div>
        <div class="objave p-5 rounded" style="width: 80%; height: 70%; margin-left: 10%; background-color: #FCF0BD; margin-bottom: 10%; margin-top: 4%;">
            <div class="row">
            <?php $results = mysqli_query($con, "SELECT * FROM objava LIMIT 3");
            while ($row = mysqli_fetch_array($results)) { ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-4">
        <div class="card-deck p-5">
                <div class="card mb-3">
                    <img src=" <?php echo $row['url'];  ?>" class="card-img-top">
                    <div class="card-body" >
                        <h3 class="card-title text-center"><?php echo $row['naslov']; ?></h3>
                        <textarea class="card-text" cols="30" rows="10" disabled > <?php echo $row['opis']; ?></textarea>
                        <button type="button" name="btn" class="btn-dark btn-sm float-right pt-2" onclick="window.open('novosti.php');" >Kliknite za više</button>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><?php echo $row['datum'] . " , " . $row['vrsta']; ?> </small>
                    </div>
                </div>

            </div>
                </div>
    <?php } ?>
            </div>
        </div>
    </div>


    <!-- Site footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h6>O nama</h6>
                    <p class="text-justify">Mačke &#128049; <i>je sajt namjenjen za sve ljubitelje mački. </i> Sajt služi kako bi pomogao
                        ljudima da se bolje upoznaju sa ovom životinjom. Dnevno se postavljaju objave koju se vezane za njihov način
                        življenja kao i pružanje savjeta njihovim vlasnicima.</p>
                </div>

                <div class="col-xs-6 col-md-3">
                    <h6>Kategorije</h6>
                    <ul class="footer-links">
                        <li><a href="novosti.php">Objave</a></li>
                        <li><a href="macke.php">Mačke</a></li>
                        <li><a href="neudomljenemacke.php">Neudomljene mačke</a></li>
                    </ul>
                </div>

                <div class="col-xs-6 col-md-3">
                    <h6>Linkovi</h6>
                    <ul class="footer-links">
                        <li><a href="početna.php">Početna</a></li>
                        <li><a href="prijavise.php">Prijavi se</a></li>
                        <li><a href="registrujse.php">Registruj se</a></li>
                        <li><a href="registrujse.php">Kontakt</a></li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2020 Sva prava zdržana su od strane sajta
                        <a href="početna.php">Mačke &#128049; </a>.
                    </p>
                </div>
            </div>
        </div>
    </footer>



    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</body>

</html>