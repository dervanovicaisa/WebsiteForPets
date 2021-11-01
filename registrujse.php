<?php
session_start();

include('./baza/konekcija.php');

if (isset($email)) {
    header('Location: početna.php');
}

$name =  $email = $godine = $pass = $emailErr = $nameErr  = $godineErr = $passwordErr = "";
$check = true;

if (isset($_POST['signup'])) {


    if (strlen($_POST['name']) >= 3) {
        $name = htmlspecialchars($_POST['name']);
        $check = true;
    } else {
        $nameErr = "Ime ne smije biti prazno i mora imati vise od 3 slova";
        $check = false;
    }

    if (!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = htmlspecialchars($_POST['email']);
        $check = true;
    } else {
        $emailErr = 'E-mail je prazan ili nije pravilno unesen!';
        $check = false;
    }
    if ($_POST['godine'] > 0) {
        $godine = $_POST['godine'];
        $check = true;
    } else {
        $check = false;
    }

    if (!empty($_POST['pass']) && isset($_POST['pass'])) {
        $pass = $_POST['pass'];
        $check = true;
    } else {
        $passwordErr = "Sifra mora biti unesena i ne smije imati ispod 8 karaktera.";
        $check = false;
    }

    $passHesh = password_hash($pass, PASSWORD_DEFAULT);

//    $user_check_query = "SELECT * FROM korisnik WHERE email='$email' OR lozinka ='$pass' LIMIT 1";
//    $result = mysqli_query($con, $user_check_query);
//    $user = mysqli_fetch_assoc($result);


    if ($check == true) {
        $sql = "INSERT INTO korisnik (imePrezime, email, lozinka, godine) values ('$name', '$email', '$passHesh', '$godine');";
        if ($con->query($sql)) {
            echo '<script language="javascript"> alert("Uspjesno ste se registrovali")</script>';
            header("Location: prijavise.php");
        }
    } else {
        echo '<script language="javascript">alert("Niste dobro unijeli podatke")</script>';
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/registrujse.css">
    <title>Registruj se</title>
    <script>
        function validateName() {
            var nameLastname = document.getElementById('name').value;
            if (nameLastname == "") {
                document.getElementById('message').innerHTML = "Ime ne smije biti null ili prazno."
                document.getElementById('message').style.color = "red";
                return false;
            } else {
                document.getElementById('message').innerHTML = "Ime je dobro unešeno."
                document.getElementById('message').style.color = "green";
                return true;
            }
        }

        function validateEmail() {
            var email = document.getElementById('email').value;
            if (email == "") {
                document.getElementById('message').innerHTML = "Ne smije biti email prazan.";
                document.getElementById('message').style.color = "red";
                return false;
            } else {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (!re.test(email)) {
                    document.getElementById('message').innerHTML = "Forma emila nije validna.";
                    document.getElementById('message').style.color = "red";
                    return false;
                } else {
                    document.getElementById('message').innerHTML = "E-mail je dobro unešen."
                    document.getElementById('message').style.color = "green";
                    return true;
                }
            }
        }

        function validateGodine() {
            var godine = document.getElementById('godine').value;
            if (godine == "") {
                document.getElementById('message').innerHTML = "Godine se moraju unijeti.";
                document.getElementById('message').style.color = "red";
                return false;
            } else {
                document.getElementById('message').innerHTML = "Godine su dobro unešene."
                document.getElementById('message').style.color = "green";
                return true;
            }
        }

        function validatePass() {

            var pass = document.getElementById('pass').value;
            var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;
            if (!pattern.test(pass) || pass == "") {
                document.getElementById('message').innerHTML = "Lozinka mora da bude do 8 karaketra i da sadrzi  mala i velika slova kao i brojeve. Lozinka se mora unijeti.";
                document.getElementById('message').style.color = "red";
                return false;
            } else {
                document.getElementById('message').innerHTML = "Lozinka je dobro unešena."
                document.getElementById('message').style.color = "green";
                return true;
            }
        }
    </script>
</head>

<body style="background-color: #FCF0BD;">

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
                                <a class="dropdown-item" href="administrator/dodajeObjavu.php">Dodaj objavu</a>
                                <a class="dropdown-item" href="administrator/dodajeLokaciju.php">Dodaj lokaciju</a>
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
    <!-- Sign up form -->
    <section class="signup">
        <div class="containerSignUp">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Registruj se</h2>
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="register-form" name="register-form" id="register-form">
                        <div id="message"></div>
                        <div class="form-group">
                            <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                            <input type="text" name="name" id="name" placeholder="Ime i prezime" onkeyup="validateName();" />
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="zmdi zmdi-email"></i></label>
                            <input type="email" name="email" id="email" placeholder="E-mail" onkeyup="validateEmail();" />
                        </div>
                        <div class="form-group">
                            <label for="godine"><i class="zmdi zmdi-lock"></i></label>
                            <input type="number" name="godine" id="godine" placeholder="Godine" onkeyup="validateGodine();" />
                        </div>
                        <div class="form-group">
                            <label for="pass"><i class="zmdi zmdi-lock-outline"></i></label>
                            <input type="password" name="pass" id="pass" placeholder="Lozinka" onkeyup="validatePass();" />
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Registruj se" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                    <a href="prijavise.php" class="signup-image-link">Već imam nalog</a>
                </div>
            </div>
        </div>
    </section>



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