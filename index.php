user

<?php
session_start();
include("../db/connection.php");
include("../db/function.php");

$sql2 = "SELECT * FROM product_tbl INNER JOIN category_tbl on product_tbl.category = category_tbl.id";
$statement2 = $pdo->prepare($sql2);
$statement2->execute();

$result = $statement2->fetchAll();


$user_data = check_login($pdo);
if ($user_data['user_type'] !== 1) {
    // Redirect to a different page or display an error message
    header("Location: ../logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>

<body>
    <nav class="navbar bg-dark  navbar-expand-lg border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ursalstore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mycart.php">My Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myorder.php">Order</a>
                    </li>
                </ul>
                <span class="navbar-text">
                <a href="../logout.php" type="submit" class="">Logout</a>
                </span>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="border border-dark mt-3">
            <div class="product">
                <div class="container">
                    <div class="row justify-content-center">
                        <?php
                        foreach ($result as $row) {
                        ?>
                            <div class="col-md-4 d-flex justify-content-center mb-4 mt-3">
                                <div class="card" style="width: 18rem;">
                                    <form action="../db/crud.php" method="POST">
                                        <input type="hidden" name="id" value="<?=$_SESSION['id']?>">
                                        <input type="hidden" name="product" value="<?= $row['product_name'] ?>">
                                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $row['product_name'] ?> (<?= $row['category_name'] ?>)</h5>
                                            <p class="card-text">Price: <b>$<?= $row['price'] ?></b>
                                                <br>
                                                Stack: <b> <?= $row['quantity'] ?> </b>
                                            </p>
                                            Quantity<input type="number" name="qty" class="form-control w-25" value="1">
                                            <button href="#" name="add_cart" class="btn btn-primary mt-3">Add to cart</button>
                                    </form>
                                </div>
                            </div>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
