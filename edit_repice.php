<?php
session_start();
if ($_SESSION['address_email'] != null && $_SESSION['first_name'] != null) {
?>
    <!doctype html>
    <html>
        <head>
            <title>Modifier Produit</title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <meta name="edit_viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="http://localhost/food/css/bootstrap.min.css"/>
            <link rel="stylesheet" href="http://localhost/food/style/style.css"/>
        </head>
        <body>
            <?php
            if (isset($_GET['id'])):
                $id = (int) $_GET['id'];
             include_once 'include/connection.php';
             $query = $conn->prepare('SELECT * FROM recipes WHERE recipe_id = :recipe_id');
             $query->execute(['recipe_id' => $id]);
             $donnee = $query->fetch();
            ?>
            <nav class="navbar navbar-expand navbar-light bg-light">
                <a href="recipe.php" class="btn btn-link"><img src="image/back.png" width="30"  alt="back"/></a>
            </nav>
            <section class="my-5 container col-sm-4">
                <h1 class="display-6 text-center my-5 fw-bold text-dark">Modifier le Produit</h1>
                <form action="edit_repice.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?php echo $donnee['recipe_id'] ?>" name="recipe_id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="edit_name" value="<?php echo $donnee['recipe_nom']; ?>"  id="edit_name">
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Propriétaire</label>
                        <input type="text" class="form-control" name="edit_autor" value="<?php echo $donnee['recipe_nom']; ?>"  id="edit_autor">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Prix</label>
                        <input type="text" class="form-control" name="edit_price" value="<?php echo $donnee['price']; ?>"  id="edit_price">
                    </div>
                    <input type="submit" name="edit_save" value="Enrégistrer" class="btn btn-primary col-12 mt-4">
                </form>
                <?php endif; ?>
            </section>
        </body>
    </html>
    <?php } ?>
    <?php
    include_once 'include/connection.php';
    if (isset($_POST['edit_save'])) {
        if ( isset( $_POST['edit_name'])&& isset( $_POST['edit_autor'])&& isset( $_POST['edit_price'])  && isset($_POST['recipe_id'])){
            $name = strip_tags($_POST['edit_name']);
            $autor = strip_tags($_POST['edit_autor']);
            $price = strip_tags($_POST['edit_price']);
            $id=$_POST['recipe_id'];

            $sql_query = "UPDATE recipes SET recipe_nom = '$name', autor = '$autor', price = '$price' WHERE recipe_id = '$id' ;";

            $prepare=$conn->prepare($sql_query);
            $prepare->execute();
            
                header('location:recipe.php');
                
            
        } else {
            echo 'Modification échoué';
        }
    }
    ?>