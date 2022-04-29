<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_db";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = "DELETE FROM recipes WHERE recipe_id=:recipe_id";
  $prepare=$conn->prepare($sql);
  $prepare->execute(array('recipe_id' => $_GET["id"]));
  header("location:recipe.php");

} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
