<?php
session_start();
if ($_SESSION['user_id'] != null && $_SESSION['first_name'] != null) {
    ?>
    <!doctype html>
    <html>
        <head>
            <title>Recipe</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="http://localhost/food/css/bootstrap.min.css"/>
            <link rel="stylesheet" href="http://localhost/food/style/style.css"/>
            <link rel="stylesheet" href="css/fontawesome.min.css">
        </head>
        <body>
            <?php include_once './include/header.php'; ?>
            <section class="my-5 container m-auto">
                <div>
                    <a href="http://localhost/food/add_recipe.php"><button class="btn btn-primary rounded rounded-pill">Ajouter un produit</button></a>
                </div>
                <table class="table my-4 table-light table-borderless">
                    <thead class="">
                        <tr>
                            <th class="fw-bold fs-5">#</th>
                            <th class="fw-bold">Nom</th>
                            <th class="fw-bold">Propriétaire</th>
                            <th class="fw-bold">Photo</th>
                            <th class="fw-bold">Prix</th>
                            <th class="fw-bold text-center" colspan="1">Actions</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'include/connection.php';
                        $query = $conn->prepare('SELECT * FROM recipes WHERE user_id = :user_id');
                        $query->execute(['user_id' => $_SESSION['user_id']]);
                        $result = $query->fetchAll();
                        $i = 0;
                        foreach ($result as $donnee):
                            $i++;
                            ?>
                            <tr class="text-dark">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $donnee['recipe_nom']; ?></td>
                                <td><?php echo $donnee['autor']; ?></td>
                                <td><img src="<?php echo $donnee['recipe_img']; ?>" alt="plat_image" width="50"/></td>
                                <td><?php echo $donnee['price']; ?> Frcs CFA</td>
                                <td><a href="supp_repice.php?id=<?php echo $donnee['recipe_id'];?>" class="btn btn-light" name=supp_repice><img src="image/delete.png" alt="alt" width="20"/></a></td>
                                <td><a href="edit_repice.php?id=<?php echo $donnee['recipe_id'];?>" class="btn btn-link"><img src="image/detail.png" alt="alt" width="20"/></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </body>
    </html>
    <?php
} else {
    header('Location: http://localhost/food/index.php');
}

