<?php
    session_start();
    $dsn = 'mysql:host=localhost;dbname=CTIS256_PROJECT;charset=utf8mb4' ;
    $user = 'root' ;
    $pass = 'root' ;
    try {
        $db = new PDO($dsn, $user, $pass) ;
    } catch (Exception $ex) {
        echo '<p>DB Connect Error : ' . $ex->getMessage() . '</p>' ;
        exit;
    }

    function addToCart($id, $count) {
        global $db;
        $item = $db->query("SELECT * from products where id=$id")->fetch();
        $stmt = $db->prepare("INSERT INTO cart (id, title, count, normalPrice, expirationDate, expirationImage) VALUES
        (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$item['id'], $item['title'], $count, $item['normalPrice'], $item['expirationDate'], $item['expirationImage']]);
    }

    function getDiscountedPrice($id) {
        global $db;
        $item = $db->query("SELECT * from products where id=$id")->fetch();
        $dayDiff = (new DateTime())->diff(new DateTime($item["expirationDate"]))->days;

        if ($dayDiff <= 50) {
            $discountedPrice = $item["normalPrice"] * 0.75;
        } else {
            $discountedPrice = $item["normalPrice"];
        }

        return round($discountedPrice, 2);
    }

    function isDiscounted($id) {
        global $db;
        $item = $db->query("SELECT * from products where id=$id")->fetch();
        $dayDiff = (new DateTime())->diff(new DateTime($item["expirationDate"]))->days;

        return $dayDiff <= 50;
    }

    function getProduct($id) {
        global $db ;

        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?") ;
        $stmt->execute([$id]) ;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
      
    function gotoErrorPage() {
        header("Location: error.php") ;
        exit ;
    }

