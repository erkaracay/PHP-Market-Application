<?php
    require_once "db.php";
    
    if(isset($_POST["submit"])) {
        extract($_POST);
        $inputTerms = isset($_POST["inputTerms"]) ? true : false;

        $users = $db->query("select * from users")->fetchAll(PDO::FETCH_ASSOC);

        $error = [];
        
        if($inputTerms || !isset($inputEmail, $inputPassword, $inputName, $inputRePassword, $inputAddress, $inputDistrict, $inputCity, $inputCustType) ){
            $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
            $stmt->execute([$inputEmail]);  
            $check = $stmt->fetch();
            if ($check) { // email exists
                $error[] = "email";
            } else { // email does not exist
                if ($inputPassword != $inputRePassword || $inputPassword == "") {
                    $error[] = "password";
                }
            } 
        } else {
                $error[] = "field";
        }

        if (empty($error)) {
            $hashPassword = password_hash($inputPassword, PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO users (email, hashPassword, name, address, district, city, userType) VALUES
                                (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$inputEmail, $hashPassword, $inputName, $inputAddress, $inputDistrict, $inputCity, $inputCustType]);
    
            header("Location: login.php");
        } else {
            $errorString = "?" . implode("&", $error);
            
            header("Location: register.php". $errorString);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Register</title>
</head>
<body>
    <form method="POST" class="rounded row gx-3 gy-2 mt-5 mx-auto col-6 p-3 border border-dark shadow">
        <div class="form-group col-md-6">
            <label for="inputEmail">E-mail</label>
            <input type="email" class="form-control" name="inputEmail" id="inputEmail" placeholder="E-mail">
        </div>

        <div class="form-group col-md-6">
            <label for="inputName">Fullname / Market Name</label>
            <input type="text" class="form-control" name="inputName" id="inputName" placeholder="Name">
        </div>

        <div class="col-md-6">
          <label for="inputPassword" class="form-label">Password</label>
          <input type="password" class="form-control" name="inputPassword" id="inputPassword" placeholder="Type password">
        </div>

        <div class="col-md-6">
            <label for="inputRePassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="inputRePassword" id="inputRePassword" placeholder="Re-type Password">
          </div>

        <div class="col-12">
          <label for="inputAddress" class="form-label">Address</label>
          <input type="text" class="form-control" name="inputAddress" id="inputAddress" placeholder="Akdeniz St. No:31">
        </div>

        <div class="col-md-6">
            <label for="inputCity" class="form-label">District</label>
            <input type="text" class="form-control" name="inputDistrict" id="inputDistrict" placeholder="Yücetepe">
          </div>

        <div class="col-md-6">
          <label for="inputCity" class="form-label">City</label>
          <input type="text" class="form-control" name="inputCity" id="inputCity" placeholder="Ankara">
        </div>

        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">I'm a</legend>
            <div class="col-sm-10">
              <div class="form-check">
                    <input class="form-check-input" type="radio" name="inputCustType" id="gridRadio1" value="customer" checked>
                    <label class="form-check-label" for="gridRadio1">Consumer</label>
              </div>
              <div class="form-check">
                    <input class="form-check-input" type="radio" name="inputCustType" id="gridRadio2" value="marketStaff">
                    <label class="form-check-label" for="gridRadio2">Market Staff</label>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="inputTerms" id="inputTerms">
            <label class="form-check-label" for="inputTerms">
                I agree to the <a href="terms.html" target="_blank">Terms and Conditions</a>.
            </label>
          </div>
        </div>
        <button type="submit" name="submit" class="col-12 btn btn-primary">Register</button>
        <div class="text-center">
            <a href="login.php" class="text-decoration-none">Already have an account?</a>
        </div>
    </form>

    <div class="alert alert-danger col-6 mx-auto my-2 d-none" id="fieldError">
        <strong>Error!</strong> Please fill every field and agree to the <a href="terms.html" target="_blank">Terms and Conditions</a>.!
    </div>
    <div class="alert alert-danger col-6 mx-auto my-2 d-none" id="emailError">
        <strong>Error!</strong> This E-mail already exists in the system!
    </div>
    <div class="alert alert-danger col-6 mx-auto my-2 d-none" id="passwordError">
        <strong>Error!</strong> The entered passwords don't match!
    </div>

    <?php
        if(isset($_GET["email"])) {
            echo "<script>
            document.getElementById('emailError').classList.remove('d-none');
            </script>";
        } 
        if(isset($_GET["password"])) {
            echo "<script>
            document.getElementById('passwordError').classList.remove('d-none');
            </script>";
        }
        if(isset($_GET["field"])) {
            echo "<script>
            document.getElementById('fieldError').classList.remove('d-none');
            </script>";
        }
    ?>
</body>
</html>