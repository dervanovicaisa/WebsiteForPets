<?php
session_start();
include ("baza/konekcija.php");

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $_SESSION['id'] = $id;
        if (isset($_POST['name'], $_POST['comment'], $_POST['submit'], $_POST['commentId'], $_SESSION['your_name'])) {
            $parent_id = $_POST['commentId'];
            $name = $_POST['name'];
            $comment = $_POST['comment'];
            $sql = mysqli_query($con, "INSERT INTO komentar(parent_id,idObjave,ime,komentar) VALUES ('$parent_id','$id','$name','$comment')") or die("database error: " . mysqli_error($con));
            $message = '<label class="text-success">Comment posted Successfully.</label>';
            $status = array(
                'error' => 0,
                'message' => $message
            );
        } else {
            $message = '<label class="text-danger"> * Morate se logovati da bi ste postavili komentar ! * </label>';
            $status = array(
                'error' => 1,
                'message' => $message
            );
        }
        json_encode($status);

        $sql = mysqli_query($con, "SELECT * FROM objava WHERE id = '$id'");
        $red = $sql->fetch_assoc();

    } else {
        exit('No page ID specified!');
    }



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="script" href="comments.html">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <title>Objava</title>
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
    Objava
-->

<div class="container rounded" style="background-color:#FCF0BD;padding-top: 5%;height: 1884px; margin-top: 8%; ">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">


        <div class="row" style="background-color: white; width: 90%; margin-left: 5%;padding-top: 2%;">
            <div class="w-50 mx-auto">
                <img class="img-fluid" alt="slika" src="<?php echo $red['url']; ?>" />
                <h1 class="text-center"><?php echo $red['naslov']; ?></h1>

                <p><?php echo $red['opis']; ?></p>
                <br>
                <p> <b>Autor:</b> <?php echo $red['autor'] ?> , <?php echo $red['datum']; ?> </p>
                <br>
            </div>
    </form>
    </div>

        <div class="container">
            <div class="rounded" style="margin-top: 5%; background-color: white; padding-top: 4%; padding-bottom: 2%;margin-left:-5% ;"><h2 class="text-center" style="margin-top: -2%;">Ostavite komentar</h2></div>
            <form method="POST" id="commentForm" style="width: 50%; margin-top: 5%; margin-left: 20%;">
                <?php echo $message; ?>
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required />
                </div>
                <div class="form-group">
                    <textarea name="comment" id="comment" class="form-control" placeholder="Enter Comment" rows="5" required></textarea>
                </div>
                <span id="message"></span>
                <div class="form-group">
                    <input type="hidden" name="commentId" id="commentId" value="0" />
                    <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Post Comment" />
                </div>
            </form>
            <div id="showComments" style="margin-top: 14%;">
                <div id="bodydesc" style="margin-left:auto; margin-right:auto; width:960px; height: 200px; overflow-y: scroll;">

                    <div id="desc" style="float:left;color: #666666; width:700px; font-family: Candara,Trebuchet MS,sans-serif; font-size: 12px; font-weight: bold; border-right: thin dotted #666666; line-height: 18px;">
                        <?php include "api/show_comments.php";  ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
<div>

<!-- Site footer -->
<footer class="site-footer" style="margin-top: 24%;">
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