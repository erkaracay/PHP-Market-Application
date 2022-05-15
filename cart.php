<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }
    require_once "db.php";
    $Cart = $db->query("SELECT * FROM cart")->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    $total = 0;

    //Delete Operation
    if (isset($_GET["del"])) {
        $id = $_GET["del"] ;
        $pr = $db->query("SELECT * from cart where id=$id")->fetch();

        $stmt = $db->prepare("UPDATE cart SET count=count-1 WHERE id=?") ;
        $stmt->execute([$id]) ;
        if ($pr["count"] <= 1) {
            $stmt = $db->prepare("DELETE from cart where id = ?");
            $stmt->execute([$id]);
        }
        header("Location: cart.php"); 
    }
    
    //Add Operation 
    if (isset($_GET["add"])) {
        $id = $_GET["add"] ;

        try {
            $stmt = $db->prepare("UPDATE cart SET count=count+1 WHERE id=?") ;
            $stmt->execute([$id]) ;
            header("Location: cart.php");

        } catch(PDOException $ex) {
        } 
    }

    // Search Operation
    if (!empty($_POST)) {
        $searchKey = $_POST["searchKey"];

        if($searchKey == "") {
            $Cart = $db->query("SELECT * FROM cart")->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $Cart = $db->query("SELECT * FROM cart WHERE title LIKE lower('%$searchKey%')")->fetchAll(PDO::FETCH_ASSOC);
        }

        $_SESSION["cartSearchKey"] = $searchKey;
    }

    // Buy Operation
    $buy = isset($_GET["buy"]) ? $_GET["buy"] : null;
    if ($buy === "1") {
        $toDelete = $db->query("SELECT * FROM cart")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($toDelete as $del) {
            $product = $db->query("SELECT * from products where id=".$del["id"])->fetch();
            if ($product["stock"] <= $del["count"]) {
                $stmt = $db->prepare("DELETE FROM products WHERE id=?");
                $stmt->execute([$del["id"]]);
            } else {
                $stmt = $db->prepare("UPDATE products SET stock=stock-".$del["count"]." WHERE id=?");
                $stmt->execute([$del["id"]]);
            }
        }
        $db->exec("DELETE from cart");
        header("Location: cart.php");
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
    <script src="https://kit.fontawesome.com/49131ae832.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/headers.css">
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
    <!-- SVG Symbol Packet -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="bootstrap" viewBox="0 0 118 94">
            <title>Bootstrap</title>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
        </symbol>
        <symbol id="people-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
        </symbol>
    </svg>
    <!-- Header -->
    <header>
        <div class="px-3 py-2 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="#" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                        <div class="fas fa-shopping-cart"></div>
                    </a>
                    <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                        <li>
                            <a href="profile.php" class="nav-link text-white hover">
                                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"/></svg>
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container-fluid row px-3 py-2 border-bottom mb-3 d-flex flex-wrap align-items-center justify-content-center mb-2">
            <div class="col-4">
                <form method="post" class="col-8 d-flex">
                    <input type="search" class="form-control" name="searchKey" value="<?= isset($_SESSION["cartSearchKey"]) ? $_SESSION["cartSearchKey"] : "" ?>" placeholder="Search..." aria-label="Search">
                    <button type="submit" class="mx-3 btn btn-dark fas fa-search"></button>
                </form>
            </div>
                <div class="col-4 d-flex justify-content-center align-items-center">
                <h3 class="m-0">Shopping Cart</h3>
            </div>
                <div class="col-4 d-flex align-items-center justify-content-end container-fluid">
                <a href="customerHome.php"><button type="button" class="btn btn-dark">Products</button></a>
            </div>
        </div>
    </header>
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
            <a href="cart.php?buy=1"><button type="button" class="btn p-3 px-5 btn-warning fs-3 fw-bold">BUY</button></a>
        </div>
    </div>
</body>
</html>