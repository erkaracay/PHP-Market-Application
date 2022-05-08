<?php
    require_once "db.php";
    $Cart = $db->query("select * from Cart")->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    $total = 0;

    //Delete Operation
    if (isset($_GET["del"])) {
        $id = $_GET["del"] ;
        $pr = $db->query("SELECT * from Cart where id=$id")->fetch();
        try {
            $stmt = $db->prepare("UPDATE Cart SET count=count-1 WHERE id=?") ;
            $stmt->execute([$id]) ;
            if ($pr["count"] <= 1) {
                $stmt = $db->prepare("DELETE from Cart where id = ?");
                $stmt->execute([$id]);
            }
            header("Location: cart.php");
        } catch(PDOException $ex) {
        } 
    }
    
    //Add Operation 
    if (isset($_GET["add"])) {
        $id = $_GET["add"] ;

        try {
            $stmt = $db->prepare("UPDATE Cart SET count=count+1 WHERE id=?") ;
            $stmt->execute([$id]) ;
            header("Location: cart.php");

        } catch(PDOException $ex) {
        } 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .anchor {
            text-decoration: none;
            color: #000;
        }
        .px-c {
            padding-right: 0.6rem!important;
            padding-left: 0.6rem!important;
        }
    </style>
</head>
<body>
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
    <div class="row container-fluid">
        <div class="d-flex justify-content-between">
            <h2>Shopping Cart</h2>
            <a class="col-1 mx-3 " href="customerHome.php"><button type="button" class="btn btn-primary mb-2">HOME</button></a>
        </div>
    </div>
    <div class="row container-fluid">
        <div class="col-10 px-2 border-end border-dark">
            <table class="table table-dark table-borderless">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Quantitiy</th>
                    <th scope="col">Normal Price</th>
                    <th scope="col">Discounted Price</th>
                    <th scope="col">Expiration Date</th>
                    <th scope="col"></th>
                </tr>
                <?php foreach($Cart as $product): ?>
                    <?php
                        $date = new DateTime($product["expirationDate"]);
                        $date = $date->format('d-m-Y');
                        $total += $product["normalPrice"] * $product["count"];
                    ?>
                    <tr>
                        <th scope="row"><?= $i++ ?></th>
                        <td><?= $product["title"] ?></td>
                        <td><?= $product["count"] ?></td>
                        <td><?= round($product["normalPrice"], 2) ?> ₺</td>
                        <td><?= getDiscountedPrice($product["id"]) ?> ₺</td>
                        <td><?= $date?></td>
                        <td class="d-flex justify-content-evenly">
                            <a href="?del=<?=$product["id"]?>"><button type="button" class="btn-danger text-black rounded-circle px-c">-</button></a>
                            <span class="mx-1"><?= $product["count"] ?></span>
                            <a href="?add=<?=$product["id"]?>"><button type="button" class="btn-warning rounded-circle px-2">+</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="col-2 d-flex flex-column justify-content-center align-items-center">
            <h2 class="my-3"> <?= $total ?> ₺</h2>
            <button type="button" class="btn p-3 px-5 btn-warning fs-3 fw-bold">BUY</button>
        </div>
    </div>
</body>
</html>