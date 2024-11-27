<?php
session_start();

include("../db/connection.php");
include("../db/function.php");

$sql2 = "SELECT users.*, order_tbl.* FROM users INNER JOIN order_tbl ON users.id = order_tbl.user_id";
$statement2 = $pdo->prepare($sql2);
$statement2->execute();

$result2 = $statement2->fetchAll();

include('../db/filter.php');

$user_data = check_login($pdo);
if ($user_data['user_type'] !== 2) {
    // Redirect to a different page or display an error message
    header("Location: ../logout.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<nav class="navbar bg-dark  navbar-expand-lg border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">MyStore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Order</a>
                    </li>
                </ul>
                <span class="navbar-text">
                <a href="../logout.php" type="submit" class="">Logout</a>
                </span>
            </div>
        </div>
    </nav>
    
<div class="container">
<table class="table table-bordered table-dark mt-2">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>

            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($result2 as $row) {
            ?>
                <tr>
                    <td><?= $row['full_name']; ?></td>
                    <td><?= $row['product_name']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td><?= $row['price']; ?></td>

                    
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
