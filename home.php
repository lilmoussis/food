<?php
session_start();
if ($_SESSION['address_email'] != null && $_SESSION['first_name'] != null) {
    if ($_SESSION['remember_me'] == 'on') {
        setcookie(
                'address_email',
                $_SESSION['address_email'],
                [
                    'expires' => time() + 2 * 24 * 3600,
                    'secure' => true,
                    'httponly' => true
                ]
        );
        setcookie(
                'name',
                $_SESSION['first_name'],
                [
                    'expires' => time() + 2 * 24 * 3600,
                    'secure' => true,
                    'httponly' => true
                ]
        );
    }
    ?>
    <!doctype html>
    <html>
        <head>
        <script src="js/bootstrap.min.js"></script>
            <script src="js/jquery.js"></script>    
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/bootstrap.min.css"/>
            <link rel="stylesheet" href="style/style.css">
            <link rel="stylesheet" href="css/fontawesome.min.css">
            
            <title>Happy Food</title>
        </head>
        <body>
            <?php include_once './include/header.php'; ?>
            <div class="alert alert-success my-3" style="text-align: center;">Bienvenue <?php echo $_SESSION['first_name']; ?></div>
            <section class="container d-flex">
            <?php
                 include_once 'include/connection.php';
                 $query = $conn->prepare('SELECT * FROM recipes WHERE user_id = :user_id');
                 $query->execute(['user_id' => $_SESSION['user_id']]);
                 $result = $query->fetchAll();
                 foreach ($result as $donnee):
            ?>
            <div class="card  col-4">
                <div class="card-body">
                <div class="imgprix" >
                    <center>
                    <div class="img">
                        <img src="<?php echo $donnee['recipe_img']; ?>"  alt="plat_image" width=150px/>
                    </div>
                    </center>
                    <div class="prix text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary">Prix:</button>
                            <button type="button" class="btn btn-primary"><?php echo $donnee['price']; ?>Frcs CFA</button>
                        </div>
                    </div>
                    <div class="text-center" >
                        <a href="details.php">
                            <button type="button" class="btn btn-primary">
                                <img src="image/info-circle-solid.svg" alt="Détails" width="25" height="25">
                            </button>
                        </a>
                        <a href="">
                            <button type="button" class="btn btn-warning">
                                <img src="image/cart-plus-solid.svg" alt="Ajouter au panier" width="25" height="25">
                            </button>
                        </a>
                    </div>
                </div>
                </div>
            </div>
                
            <?php endforeach; ?>
             </section>
            <script src="js/bootstrap.min.js"></script>
        </body>
    </html>
    <?php
} else {
    header('Location: index.php');
} 