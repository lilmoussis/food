<?php
session_start();
if ($_SESSION['address_email'] != null && $_SESSION['first_name'] != null) {
    ?>
    <!doctype html>
    <html>
        <head>
            <title>Recipe</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="http://localhost/food/css/bootstrap.min.css"/>
            <link rel="stylesheet" href="http://localhost/food/style/style.css"/>
        </head>
        <body>
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a href="recipe.php" class="btn btn-link"><img src="image/back.png" width="30"  alt="back"/></a>
            </nav>
            <section class="my-5 container col-sm-4">
                <h1 class="display-6 text-center my-5 fw-bold text-dark">Enrégistrer un nouveau Produit</h1>
                <form action="add_recipe.php"method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="name" placeholder="Entrer le nom de votre produit" required="required" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Propriétaire</label>
                        <input type="text" class="form-control" name="autor" placeholder="Entrer le nom du propriétaire" required="required" id="autor">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix</label>
                        <input type="number" class="form-control" name="price" placeholder="Entrer le prix" required="required" id="price">
                    </div>
                    <div class="">
                        <label for="recipe" class="form-label">Photo</label>
                        <input type="file" class="form-control" name="recipe" required="required" id="recipe">
                    </div>
                    <?php
                    if (isset($_POST['save'])) {
                        if (isset($_POST['name']) && isset($_POST['autor']) && isset($_FILES['recipe']) && isset ($_POST['price'])){
                            $name = strip_tags($_POST['name']);
                            $autor = strip_tags($_POST['autor']);
                            $recipe = $_FILES['recipe'];
                            $price = strip_tags($_POST['price']);

                            if ($recipe['error'] == 0) {
                                if ($recipe['size'] <= 8000000) {
                                    $fileInfo = pathinfo($recipe['name']);
                                    $extension = $fileInfo['extension'];
                                    $allExtension = ['png', 'jpeg', 'jpg', 'gif', 'jfif'];
                                    
                                    if (in_array($extension, $allExtension)) {
                                        $lien = 'recipe_image   /' . $name . '.' . $extension;
                                        
                                        include_once 'include/connection.php';
                                        
                                        $sqlQuery = 'INSERT INTO recipes(recipe_nom, autor, recipe_img,price, user_id) VALUES(:recipe_nom, :autor, :recipe_img,:price, :user_id)';
                                        $prepare = $conn->prepare($sqlQuery);
                                        $isOK = $prepare->execute([
                                            'recipe_nom' => $name,
                                            'autor' => $autor,
                                            'recipe_img' => $lien,
                                            'price' => $price,
                                            'user_id' => $_SESSION['user_id']
                                        ]);

                                        if ($isOK == 1) {
                                            move_uploaded_file($recipe['tmp_name'], 'recipe_image/' . $name . '.' . $extension);
                                            header('Location: recipe.php');
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger mt-3">Ce fichier n\'est pas un fichier image</div>';
                                    }
                                }
                            } else {
                                echo '<div class="alert alert-danger mt-3">Echec de chargement du fichier</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger mt-3">Veuillez remplir tous les champs</div>';
                        }
                    }
                    ?>
                    <input type="submit" name="save" value="Enrégistrer" class="btn btn-primary col-12 mt-4">
                </form>
            </section>
        </body>
    </html>
    <?php
} else {
    header('Location: http://localhost/food/index.php');
}

