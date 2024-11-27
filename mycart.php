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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Product</title>
    <style>
        /* Body & Navbar Styles */
        body {
            background-image: url('https://source.unsplash.com/1600x900/?store,shopping'); /* Background image */
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .navbar {
            background-color: rgba(52, 58, 64, 0.9); /* Semi-transparent dark background */
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
        }

        .navbar-text a {
            color: #fff;
            font-weight: 500;
        }

        .navbar-text a:hover {
            color: #ffc107;
        }

        /* Card Styling */
        .card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.85); /* Semi-transparent background for card */
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            text-align: center;
            padding: 25px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #343a40;
        }

        .card-text {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .card-text b {
            color: #000;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Grid layout */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
            padding-bottom: 50px;
        }

        /* Footer Styles */
        footer {
            background-color: rgba(52, 58, 64, 0.9);
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #ffc107;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Make sure the content section doesn't get too long */
        .container {
            z-index: 1;
            position: relative;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
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
                    <a href="../logout.php" class="btn btn-outline-light">Logout</a>
                </span>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="product-grid">
            <?php
            foreach ($result as $row) {
            ?>
                <div class="card">
                    <form action="../db/crud.php" method="POST">
                        <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>">
                        <input type="hidden" name="product" value="<?= $row['product_name'] ?>">
                        <input type="hidden" name="price" value="<?= $row['price'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['product_name'] ?> (<?= $row['category_name'] ?>)</h5>
                            <p class="card-text">
                                Price: <b>$<?= $row['price'] ?></b>
                                <br>
                                Stock: <b><?= $row['quantity'] ?></b>
                            </p>
                            Quantity: <input type="number" name="qty" class="form-control w-50 mx-auto" value="1" min="1" max="<?= $row['quantity'] ?>">
                            <button type="submit" name="add_cart" class="btn btn-primary mt-3">Add to Cart</button>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Ursalstore | <a href="#">Privacy Policy</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
