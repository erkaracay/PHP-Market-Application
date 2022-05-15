<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }
    require_once "db.php";

    if (!empty($_POST)) {
        extract($_POST) ;
        $stmt = $db->prepare("UPDATE products SET title=?, normalPrice=?, stock=?, expirationDate=? WHERE id=?") ;
        $stmt->execute([$title, $normalPrice, $stock, $expirationDate, $id]);
            
        try {
            $stmt = $db->prepare("SELECT * FROM products WHERE id=?") ;
            $stmt->execute([$id]) ;
            $product = $stmt->fetch(PDO::FETCH_ASSOC) ;
        } catch( PDOException $ex) {
            echo "<p>DB Error: " . $ex->getMessage() . "</p>";
        }   
        header("Location: market.php?edit=$id");
    }

    $id = $_GET["id"];
    $product = getProduct($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="assets/addProduct.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="post" action="edit.php" class="rounded row gx-3 gy-2 mt-5 mx-auto col-6 p-3 border border-dark shadow">
        <div class="row form-group col-6 mx-auto">
            <label for="id">ID</label>
            <input type="text" class="form-control text-center" name="id" id="id" value="<?= $product["id"] ?>">
        </div>
        <div class="form-group col-7">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?= $product["title"] ?>">
        </div>
        <div class="form-group col-3">
            <label for="inputPrice">Normal Price</label>
            <input type="text" class="form-control" id="inputPrice" name="normalPrice" placeholder="₺" value="<?= $product["normalPrice"] ?>">
        </div>
        <div class="form-group col-2">
          <label for="inputStock">Stock</label>
          <input type="text" class="form-control" id="inputStock" name="stock" value="<?= $product["stock"] ?>">
        </div>
        <div class="form-group col-6">
            <label for="inputExDate">Expiration Date</label>
            <input type="date" class="form-control" id="inputExDate" name="expirationDate" value="<?= $product["expirationDate"] ?>">
        </div>
        <div class="form-group col-6">
            <label for="inputImg">Image of the Product</label>
            <input type="file" id="inputImg" class="form-control">
        </div>
        <input type="submit" name="submit" value="Edit Product" class="col-12 btn btn-primary">
    </form>
</body>
</html>