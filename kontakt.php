<?php
include ("baza/konekcija.php");
session_start();

$name = $email =$subject = $message = "";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $sql = "INSERT INTO kontakt (email,imePrezime ,pitanje, poruka) values ('$email','$name','$subject','$message');";
    if ($con->query($sql)) {
        echo '<script>alert("Uspjesno ste poslali poruku! Pokuaćemo da odgovorimo što brže na nju.")</script>';
    }else{
        echo "Grska" . $con-> error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/kontakt.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <title>Kontakt</title>
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            if (name == "") {
                document.querySelector('.status').innerHTML = "Ime mora biti uneseno.";
                return false;
            }
            var email = document.getElementById('email').value;
            if (email == "") {
                document.querySelector('.status').innerHTML = "Email mora biti unesen.";
                return false;
            } else {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!re.test(email)) {
                    document.querySelector('.status').innerHTML = "Forma emila nije validna.";
                    return false;
                }
            }
            var subject = document.getElementById('subject').value;
            if (subject == "") {
                document.querySelector('.status').innerHTML = "Morate unijeti pitanje.";
                return false;
            }
            var message = document.getElementById('message').value;
            if (message == "") {
                document.querySelector('.status').innerHTML = "Morate napisati poruku.";
                return false;
            }
            document.querySelector('.status').innerHTML = "Šalje se...";
        }
    </script>
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
                    <?php }else if (isset($_SESSION['your_name']) && $_SESSION['your_name'] == 'admin@gmail.com'){ ?>
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
    <!-- Side bar -->
<div class="main">
    <div class="sideBar">
        <div class="text">
            <hr style="background-color: white;">
            <h1 class="text-center text-white">Informacije</h1>
            <hr style="background-color: white;">
            <p>
                - Lokacija: Ul. Slobode 56. <br>
                - E-mail: macke-m@gmail.com <br>
                - Broj telefona: 069 - 456 - 678 <br>
            </p>
            <hr style="background-color: white;">
            <img src="images/contactUs.png" alt="contact us">
        </div>
    </div>
    <div class="forma">
        <!--Section: Contact v.2-->

        <div>
            <div class="kontakt">
                <!--Section heading-->
                <h2 class="h1-responsive font-weight-bold text-center my-4">Kontaktirajte nas</h2>
                <!--Section description-->
                <p class="text-center w-responsive mx-auto mb-5"> Ako postoji kakav problem kod vaše mačke ili nešto
                    vezano za sajt tu smo da Vam ponudimo <br>
                    najbolji savjet i najbrže što možemo i rješimo vaš probeleme. <br>
                    Postavite vaše pitanje. <br>
                </p>
            </div>
        </div>
     <div>
    <section>
            <div class="row" style="margin-top:40%;width: 80%;">
                <!--Grid column-->
                <div class="formaKonatakt col-md-9 mb-md-0 mb-5" style="margin-top: -35%;">
                    <form id="contact-form" name="contact-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input type="text" id="name" name="name" placeholder="Ime i prezime" class="form-control">
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input type="text" id="email" name="email" placeholder="E-mail" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form mb-0">
                                    <input type="text" id="subject" name="subject" placeholder="Pitanje?" class="form-control">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="md-form">
                                    <textarea type="text" id="message" name="message" rows="5" class="form-control md-textarea" placeholder="Poruka"></textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-center text-md-left">
                            <button type="submit" name="submit" class="btn btn-primary" onclick="validateForm();">Pošalji</button>
                            <br> <br>
                            <div class="status"></div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
</div>
        <!--Section-->
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