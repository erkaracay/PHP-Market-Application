<?php













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
        <button type="button" class="btn col-1 btn-info mb-2">ADD</button>
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
            <tr>
                <th scope="row">1</th>
                <td>Toblerone 100g</td>
                <td>25</td>
                <td>20 ₺</td>
                <td>15₺</td>
                <td>22-05-2022</td>
                <td>
                    <button type="button" class="btn-warning rounded-circle mx-1">Edit</button>
                    <button type="button" class="btn-danger rounded-circle">Delete</button>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Toblerone 100g</td>
                <td>25</td>
                <td>20 ₺</td>
                <td>15₺</td>
                <td>22-05-2022</td>
                <td>
                    <button type="button" class="btn-warning rounded-circle mx-1">Edit</button>
                    <button type="button" class="btn-danger rounded-circle">Delete</button>
                </td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Toblerone 100g</td>
                <td>25</td>
                <td>20 ₺</td>
                <td>15₺</td>
                <td>22-05-2022</td>
                <td>
                    <button type="button" class="btn-warning rounded-circle mx-1">Edit</button>
                    <button type="button" class="btn-danger rounded-circle">Delete</button>
                </td>
            </tr>
            <tr>
                <th scope="row">4</th>
                <td>Toblerone 100g</td>
                <td>25</td>
                <td>20 ₺</td>
                <td>15₺</td>
                <td>22-05-2022</td>
                <td>
                    <button type="button" class="btn-warning rounded-circle mx-1">Edit</button>
                    <button type="button" class="btn-danger rounded-circle">Delete</button>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>