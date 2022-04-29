<?php
session_start();
$_SESSION['address_email'] = null;
$_SESSION['first_name'] = null;
$_SESSION['remember_me'] = null;
$_SESSION['user_id'] = 0;
$address_email = '';
if (isset($_COOKIE['address_email'])) {
    $address_email = strip_tags($_COOKIE['address_email']);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HF Connxion</title>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="mcss/mcss.css"/>
        <link rel="stylesheet" href="css/fontawesome.min.css">
    </head>
    <body>
        <section class="container-fluid d-sm-flex align-items-sm-center justify-content-sm-center vh-100 vh--100 bg-image2">
            <div class="p-5 bg-light-transparent rounded-4">
                <div class="display-6" style="font-family: georgia; color: #06357a">
                    <img src="logo.png" alt="alt"/>Happy Food
                </div>
                <h1>Connectez-vous</h1>
                <form action="index.php" method="post">
                    <div class="mb-3">
                        <label for="address_email" class="form-label">Adresse Mail</label>
                        <input type="email" name="address_email" id="address_email" placeholder="Entrer votre Adresse Mail" value="<?php echo $address_email; ?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de Passe</label>
                        <input type="password" name="password" id="password" placeholder="Entrer votre mot de passe" class="form-control">
                    </div>
                    <div class="mb-4">
                        <input type="checkbox" name="remember_me" checked="checked" id="remember_me" class="form-check-input"><label for="remember_me" class="form-check-label">Se souvenir</label>
                    </div>
                    <?php
                    if (isset($_POST['connect'])) {
                        if (isset($_POST['address_email']) && isset($_POST['password'])) {
                            //On elève les balises html au cas il y en a
                            $address_email = strip_tags($_POST['address_email']);
                            $password = strip_tags($_POST['password']);

                            include_once 'include/connection.php';
                            //On vérie si l'adresse mail existe dans la base
                            $sqlQuery = 'SELECT COUNT(address_email) AS exist, user_id, first_name, password FROM users WHERE address_email = :address_email';
                            $prepare = $conn->prepare($sqlQuery);
                            $prepare->execute(['address_email' => $address_email]);
                            $result = $prepare->fetch();
                            if ($result['exist'] == 1) {
                                //Vérification du mot de passe
                                if (password_verify($password, $result['password'])) {
                                    $_SESSION['address_email'] = $address_email;
                                    $_SESSION['first_name'] = $result['first_name'];
                                    $_SESSION['user_id'] = $result['user_id'];

                                    if (isset($_POST['remember_me'])) {
                                        $_SESSION['remember_me'] = $_POST['remember_me'];
                                    }

                                    header('Location: home.php');
                                    exit();
                                } else {
                                    echo '<div class="alert alert-danger mb-3">Mot de passe incorrect</div>';
                                }
                            } else {
                                echo '<div class="alert alert-danger mb-3">Adresse Mail incorrect</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger mb-3">Veillez remplir les champs</div>';
                        }
                    }
                    ?>
                    <input type="submit" name="connect" value="Connexion" class="btn btn-primary">
                </form>
                <a href="inscription.php" class="link-info text-decoration-none">Vous n'avez pas de compte ? Cliquez pour en créer <img src="image/user-plus-solid.svg" alt="" width="25" height="25"></a>
            </div>
        </section>
        <footer class="text-center">
            <div>
                2021 - 2022  @_lilmoussis
            </div>
        </footer>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
