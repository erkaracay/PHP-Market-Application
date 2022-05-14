<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="assets/addProduct.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <form method="post" action="add-product.php" enctype="multipart/form-data" class="rounded row gx-3 gy-2 mt-5 mx-auto col-6 p-3 border border-dark shadow">
        <div class="form-group col-7">
            <label for="title">Title</label>
            <input type="email" class="form-control" id="title" placeholder="Enter title">
        </div>
        <div class="form-group col-3">
            <label for="inputPrice">Normal Price</label>
            <input type="text" class="form-control" id="inputPrice" placeholder="₺">
        </div>
        <div class="form-group col-2">
          <label for="inputStock">Stock</label>
          <input type="text" class="form-control" id="inputStock">
        </div>
        <div class="form-group col-6">
            <label for="inputExDate">Expiration Date</label>
            <input type="date" class="form-control" id="inputExDate">
        </div>
        <div class="form-group col-6">
            <label for="inputImg">Image of the Product</label>
            <input type="file" id="inputImg" class="form-control">
        </div>
        <input type="submit" name="submit" value="Add Product" class="col-12 btn btn-primary">
    </form>
    <?php
        $target_dir = "assets/img/";
        $target_file = $target_dir . basename($_FILES["inputImg"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["inputImg"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        }

        // Check file size
        // if ($_FILES["inputImg"]["size"] > 500000) {
        //   echo "Sorry, your file is too large.";
        //   $uploadOk = 0;
        // }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

        // if everything is ok, try to upload file
        } else {
        if (move_uploaded_file($_FILES["inputImg"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename( $_FILES["inputImg"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
        }

        //Add a product
        if ( !empty($_POST)) {
            extract($_POST) ;
            try {
             $stmt = $db->prepare("INSERT INTO products (title, stock, normalPrice, expirationDate) VALUES (?,?,?,?)" ) ;
             $stmt->execute([$title, $stock, $normalPrice, $expirationDate]) ;
             $msg = "$title (" . $db->lastInsertId() . ") added" ; 
            } catch(PDOException $ex) {
              gotoErrorPage();
            }
        }
    ?>
</body>
</html>