<?php
include ("baza/konekcija.php");
session_start();
if (isset($_POST['submit'], $_POST['name'], $_POST['location'])) {
    if (isset($_SESSION['your_name'])) {
        $email = $_SESSION['your_name'];
        $sql = mysqli_query($con, "select * from korisnik where email='$email'");
        $r = $sql->fetch_assoc();
        $ime = $r['imePrezime'];
        $userName = explode(" ", $ime);
        $id = $r['id'];

        $location = $_POST['location'];
        $sql = mysqli_query($con, "insert into prijavilutajucumacku (idKorisnika,nazivLokacije) values ('$id','$location')") or die("database error: " . mysqli_error($con));
            echo '<script> alert("Uspješno ste poslali prijedlog lokacije. Zahvaljujemo na vašoj prijavi! "); </script>';
    }else{
        echo '<script> alert("Morate se logovati!"); </script>';
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
    <link rel="stylesheet" href="css/neudomljenemacke.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Neudomljene mačke</title>



    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJBYV-2jnL_xTRIBX6utKEDggbbcmfmlI"></script>
    <script type="text/javascript">
        var locations = [
            // ['Stari Grad', 42.433424, 19.257292, 2],
            // ['Pejton', 42.433816, 19.260766, 3],
            // ['Ulica 4. Proleterske', 42.440474, 19.270715, 4],
            // ['Blok 9', 42.452402, 19.236656, 5],
            // ['Blok 5', 42.446535, 19.240293, 6]
        ];
        <?php
        $query = mysqli_query($con,"select * from neudomljenemacke;");
       while($row = mysqli_fetch_array($query)){
        ?>
        locations.push(['<?php echo $row['lokacija']; ?>', <?php echo $row['latitude'];?>, <?php echo $row['longitude'];?>, <?php echo $row['id'];?>]);
        <?php } ?>

        function InitMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: new google.maps.LatLng(42.4321061, 19.1858383),
                mapTypeId: google.maps.MapTypeId.ROADMAP
                // icon: "https://www.gstatic.com/earth/images/stockicons/190201-2016-animal-paw_4x.png"
            });
            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });
                marker.setIcon('https://www.gstatic.com/earth/images/stockicons/190201-2016-animal-paw_4x.png');
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);

                    }
                })(marker, i));
            }
        }
    </script>

</head>

<body onload="InitMap();">

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
    <!--Tekts-->

    <div class="main">
        <div class="header">
            <hr>
            <h1 class="text-center">Lokacija</h1>
            <hr>
        </div>
        <div class="tekst">
            <p class="text-center">
                Ova stranica služi za lociranje neudomljenih mački kojima možete <br>
                ostavite hranu.
                <br>

            </p>
        </div>
    </div>

    <!--Lokacija-->
    <!-- <div class="mapa">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d85451.45649158765!2d19.193160371313308!3d42.43646004173552!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x134de8079606867d%3A0x6bf78a76ea588ae9!2sPodgorica%2C%20Montenegro!5e0!3m2!1sen!2s!4v1601552066449!5m2!1sen!2s"
            width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
            tabindex="0">
        </iframe>
    </div> -->

    <div id="map" style="height: 500px; width: 70%;margin-top: 5%; margin-left: 16%;">
    </div>

<div class="container">
    <div class="inputLocation" style="margin-top: 10%;">
        <hr style="width: 50%;">
        <h2 class="text-center">Unesite lokaciju</h2>
        <hr style="width: 50%;">

        <div class="tekst">
            <p class="text-center">
                U ovom polju možete da unesete naziv mjesta/lokacije na kojoj ste <br>
                uvidjeli neku lutajuću ili neudmoljenu mačku.
                <br>

            </p>
        </div>
    </div>
    <form method="POST" id="form" action="<?php $_SERVER['PHP_SELF']; ?>" style="width: 50%; margin-top: 5%; margin-left: 25%">
        <div class="form-group">
            <input type="text" name="name" id="name" class="form-control" placeholder="Ime" required />
        </div>
        <div class="form-group">
            <input type="text" name="location" id="location" class="form-control" placeholder="Naziv lokacije" required/>
        </div>
        <div class="form-group">
            <input type="submit" name="submit" id="submit" class="btn btn-primary float-right" value="Submit" />
        </div>
        <span id="message" class="position-center"> <lottie-player  src="https://assets9.lottiefiles.com/temp/lf20_EVDaJ0.json" background="transparent"  speed="1"  style="width: 300px; height: 300px; margin-left: 19%;" loop controls autoplay/> </span>
    </form>
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

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"/>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</body>

</html>