<?php
    require_once "db.php";

    if (isset($_POST["submit"])) {
        $email = $_POST["inputEmail"];
        $password = $_POST["inputPassword"];
        $user = $db->query("select * from users where email = '$email'")->fetch(PDO::FETCH_ASSOC);
        $hashPassword = $user["hashPassword"];
        $verify = password_verify($password, $hashPassword);
        if ($verify) {
            if ($user["userType"] == "customer") {
                header("Location: customerHome.php");
            } else {
                header("Location: market.php");
            }
        } else {
            echo "Wrong email or password";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="POST" class="col-3 mx-auto mt-4 p-3 rounded border border-success shadow">
        <div class="mb-3">
            <label for="inputEmail" class="form-label">E-mail Address</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll share your email with everyone. Trust us.</div>
        </div>
        <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword">
        </div> 

        <button type="submit" name="submit" class="col-12 btn btn-primary mb-1">Sign in</button>
        <div class="text-center">
            <a href="register.php" class="text-decoration-none">Don't have an account yet?</a>
        </div>
    </form>
</body>
</html>