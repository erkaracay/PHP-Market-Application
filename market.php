<?php

    require_once "db.php" ;

    // Read all
    try {
        $rs = $db->query("select * from products") ;
        $products = $rs->fetchAll(PDO::FETCH_ASSOC) ;
    } catch( PDOException $ex) {
         gotoErrorPage();
    }

    // Delete operation
    if ( isset($_GET["delete"])) {
        $id = $_GET["delete"] ;
        $product = getProduct($id) ;
        try {
           $stmt = $db->prepare("DELETE FROM products where id = ?") ;
           $stmt->execute([$id]) ;
           $msg = "{$product["title"]} deleted" ;
        } catch(PDOException $ex) {
             gotoErrorPage();
        } 
    }

    // Edit message
    // if ( isset($_GET["edit"])) {
    //     $game = getProduct($_GET["edit"]) ;
    //     $msg = "{$product["title"]} updated." ;
    // }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market's Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid mx-auto row my-1 justify-content-between">
        <div class=" p-4 bg-dark col-1 border-danger text-light text-center">
            LOGO
        </div>
        <form class="col-2 align-self-center d-flex">
            <input type="search" name="search" placeholder="Search for products...">
            <button type="submit" class="mx-1 rounded-pill btn-dark">Search</button>
        </form>
        <div class="row col-1 align-self-center">
            <button type="button" class="btn bg-transparent border-0"><img class="rounded-circle img-fluid" src="assets/img/blank-profile-picture-973460.svg"></button>
        </div>
    </div>
    <div class="container-fluid mx-auto row">
        <h2 class="m-0 p-0">Product List</h2>
        <a href="add-product.php"><button type="button" class="btn col-1 btn-info mb-2">ADD</button></a>
        <table class="table table-dark table-borderless">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Stock</th>
                <th scope="col">Normal Price</th>
                <th scope="col">Discounted Price</th>
                <th scope="col">Expiration Date</th>
                <th scope="col">Actions</th>
            </tr>
            <?php foreach($products as $product) : ?>
            <tr>
                <th><?= $product["id"] ?></th>
                <td><?= $product["title"] ?></td>
                <td><?= $product["stock"] ?></td>
                <td><?= $product["normalPrice"] ?></td>
                <td><?= getDiscountedPrice($product["id"]) ?></td>
                <td><?= $product["expirationDate"] ?></td>
                <td>
                    <a href="edit.php?id=<?= $product["id"] ?>"> <button type="button" class="btn-warning rounded-circle mx-1">Edit</button></a>
                    <a href="?delete=<?= $product["id"] ?>"> <button type="button" class="btn-danger rounded-circle">Delete</button></a>
                </td>
            </tr>
            <?php endforeach ?> 
        </table>
    </div>
</body>
</html>