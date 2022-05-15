<?php
    $dsn = 'mysql:host=localhost;dbname=CTIS256_PROJECT;charset=utf8mb4' ;
    $user = 'root' ;
    $pass = 'root' ;
    try {
        $db = new PDO($dsn, $user, $pass) ;
    } catch (Exception $ex) {
        echo '<p>DB Connect Error : ' . $ex->getMessage() . '</p>' ;
        exit;
    }

    function addToCart($id) {
        global $db;

        // Checks if the same product is already in the cart
        $stmt = $db->prepare("SELECT * FROM cart WHERE id=?");
        $stmt->execute([$id]);  
        $check = $stmt->fetch();
        
        if($check) {
            $stmt = $db->prepare("UPDATE cart SET count=count+1 WHERE id=?");
            $stmt->execute([$id]);
        } else {
            $item = $db->query("SELECT * from products where id=$id")->fetch();
            $stmt = $db->prepare("INSERT INTO cart (id, title, count, normalPrice, expirationDate, expirationImage) VALUES
            (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$item['id'], $item['title'], 1, $item['normalPrice'], $item['expirationDate'], $item['expirationImage']]);
        }

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

    function gotoErrorPage() {
        header("Location: error.php") ;
        exit ;
    }

    function checkUser($email, $pass) {
        global $db ;
    
        $stmt = $db->prepare("select * from users where email=?") ;
        $stmt->execute([$email]) ;
        if ($stmt->rowCount()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
            return password_verify($pass, $user["hashPassword"]) ;
        }
        return false ;
    }
    
    function getUser($email) {
        global $db ;
        $stmt = $db->prepare("select * from users where email=?") ;
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ;
    }

    function getProduct($id) {
        global $db ;

        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?") ;
        $stmt->execute([$id]) ;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }