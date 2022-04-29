<?php
session_start();
$_SESSION['address_email'] = null;
$_SESSION['first_name'] = null;
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HF Inscription</title>
        <link rel="stylesheet" href="style/style.css"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="mcss/mcss.css"/>
        <link rel="stylesheet" href="css/fontawesome.min.css">
    </head>
    <body class="bg-image2">
        <h1 class="text-center mt-4 fs-3">Inscrivez vous maintenant</h1>
        <div class=" container my-5 col-sm-8 d-sm-flex bg-light">
            <div class="title d-flex align-items-center justify-content-center w-75 m-auto">
                <img src="logo.png" alt="logo"/>
                Happy Food
            </div>
            <div class="w-100 p-4">
                <form action="inscription.php" method="post">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Prénom</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Entrer votre prénom" required="required" id="first_name">
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Entrer votre nom" required="required" id="last_name">
                    </div>
                    <div class="mb-3">
                        <label for="address_email" class="form-label">Adresse Mail</label>
                        <input type="email" class="form-control" name="address_email" placeholder="Entrer votre Adresse Mail" required="required" id="address_email">
                    </div>
                    <div class="mb-3">
                        <label for="Password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" placeholder="Entrer votre mot de passe" required="required" id="password">
                    </div>
                    <?php
                    if (isset($_POST['save'])) {
                        if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['address_email']) && isset($_POST['password'])) {
                            $first_name = strip_tags($_POST['first_name']);
                            $last_name = strip_tags($_POST['last_name']);
                            $address_email = strip_tags($_POST['address_email']);
                            $password = strip_tags($_POST['password']);

                            include_once './include/connection.php';

                            $prepare = $conn->prepare('SELECT COUNT(address_email) AS exist FROM users WHERE address_email = :address_email');
                            $prepare->execute([
                                'address_email' => $address_email
                            ]);
                            $result = $prepare->fetch();

                            if ($result['exist'] == 0) {
                                $prepare = $conn->prepare('INSERT INTO users(first_name, last_name, address_email, password) '
                                        . 'VALUES(:first_name, :last_name, :address_email, :password)');
                                $isOK = $prepare->execute(
                                        [
                                            'first_name' => $first_name,
                                            'last_name' => $last_name,
                                            'address_email' => $address_email,
                                            'password' => password_hash($password, PASSWORD_DEFAULT)
                                        ]
                                );

                                if ($isOK == 1) {
                                    $_SESSION['address_email'] = $address_email;
                                    $_SESSION['first_name'] = $first_name;

                                    header('Location: index.php');
                                }
                            } else {
                                echo '<div class="alert alert-danger mb-3">Adresse Mail déja utilisé</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger mb-3">Veuillez remplir tous les champs</div>';
                        }
                    }
                    ?>
                    <input type="submit" name="save" value="Inscription" class="btn btn-primary rounded-pill col-3">
                </form>
                <a href="index.php" class="link-info text-decoration-none">Vous avez un compte ? Cliquez pour vous connecter</a>
            </div>
        </div>
        <footer class="text-center">
            <div>
                2021 - 2022  @_lilmoussis
            </div>
        </footer>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
