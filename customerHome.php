<?php
    require_once "db.php";
    $products = $db->query("select * from Products")->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    $len = count($products);
    
    // Add to Cart Operation
    if (isset($_GET["addToCart"]) && isset($_GET["count"])) {
        $id = $_GET["addToCart"];
        $count = $_GET["count"];

        addToCart($id, $count);
        header("Location: customerHome.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer's Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/49131ae832.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/custHome.css">
    <style>
        .col-c {
            flex: 0 0 auto;
            width: 9.5%;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="container-fluid mx-auto row my-1 justify-content-between">
        <div class="p-4 bg-dark col-1 border-danger text-light text-center">
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
    <div class="row my-3 justify-content-end container-fluid">
        <a class="col-c " href="cart.php"><button type="button" class="btn btn-warning">Shopping Cart</button></a>
    </div>
    <!-- Products -->
    <section class="section-products">
        <div class="container">
            <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div style="background: url('assets/img/<?= $product["expirationImage"] ?>') no-repeat center; 
                            background-size:contain; height: 75%" class="single-product">
                    <div class="part-1">
                        <ul>
                            <li><a href="?addToCart=<?= $product["id"] ?>&count=1"><i class="fas fa-shopping-cart"></i></a></li>
                        </ul>
                    </div>
                    <div class="part-2">
                        <h3 class="product-title"><?= $product["title"] ?></h3>
                        <?php if(isDiscounted($product["id"])): ?>
                            <h4 class="product-old-price"><?= $product["normalPrice"] ?></h4>
                        <?php endif; ?>
                        <h4 class="product-price"><?= getDiscountedPrice($product["id"]) ?> ₺</h4>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <!-- <div class="container px-4">
            <?php foreach($products as $product): ?>
                <?php if ($i % 5 == 0 || $i == 1): ?>
                    <div class="row gx-3 my-3">
                <?php endif; ?>
                <div class="col">
                    <div class="p-3 border bg-light d-flex flex-column align-items-center">
                        <img src="assets/img/item.png" class="img-c">
                        <p class="fs-7 text-center m-0 mt-1 font-monospace text-"><?= $product["title"] ?></p>
                        <p class="fs-7 m-0 mt-1 font-monospace text-"><?= $product["normalPrice"] ?>₺</p>
                        <button type="button" class="btn btn-success">Add to Cart</button>
                    </div>
                </div>
                <?php if ($i % 4 == 0): ?>
                    </div>
                <?php endif; ?>
                <?php $i++; ?>
                <?php endforeach; ?>
            </div>
        </div> -->
            </div>
        </div>
    </section>
</body>
</html>