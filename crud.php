<?php
session_start();
include("connection.php");

// $pdonection = new Connection();
// $pdo = $pdonection->OpenConnection(); // Initialize $pdo

if (isset($_POST['register'])) { {
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $date = $_POST['date'];
        $gender = $_POST['gender'];


        //if user and email already exist
        $query = "INSERT INTO users(user,pass,full_name,address,gender,birthdate, user_type) 
        VALUES (:user, :pass, :name, :address, :gender, :date, :usertype)";
        $query_run = $pdo->prepare($query);

        $data = [
            ':user' => $user,
            ':pass' => $pass,
            ':name' => $name,
            ':address' => $address,
            ':gender' => $gender,
            ':date' => $date,
            ':usertype' => '1',
        ];
        $query_execute = $query_run->execute($data);

        if ($query_execute) {
            $_SESSION['Status1'] = "Register Successfully";
            header('Location: ../signup.php');
            die;
        }
        $_SESSION['Status'] = " Failed to register";
        header('Location: ../signup.php');
        die;
    }
}


if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];
    $date = $_POST['date'];


    //if user and email already exist
    $query = "INSERT INTO product_tbl(product_name,category,price,quantity,product_availability,date) 
    VALUES (:product_name, :category, :price, :quantity, :availability, :date)";
    $query_run = $pdo->prepare($query);

    $data = [
        ':product_name' => $product_name,
        ':category' => $category,
        ':price' => $price,
        ':quantity' => $quantity,
        ':availability' => $availability,
        ':date' => $date,
    ];
    $query_execute = $query_run->execute($data);

    if ($query_execute) {
        $_SESSION['message'] = "Inserted Successfully";
        header('Location: index.php');
        die;
    }
    $_SESSION['message'] = "Not Inserted";
    header('Location: index.php');
    die;
}


if (isset($_POST['update_product'])) { // Check if the form was submitted
    $product_id = $_POST['product_id']; // Assuming you have a hidden input for product ID
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $availability = $_POST['availability'];
    $date = $_POST['date'];

    // Prepare the update query
    $query = "UPDATE product_tbl SET 
                product_name = :product_name,
                category = :category,
                price = :price,
                quantity = :quantity,
                product_availability = :availability,
                date = :date
              WHERE id = :product_id"; // Make sure 'id' matches your primary key field name

    $query_run = $pdo->prepare($query);

    // Bind parameters to the query
    $data = [
        ':product_name' => $product_name,
        ':category' => $category,
        ':price' => $price,
        ':quantity' => $quantity,
        ':availability' => $availability,
        ':date' => $date,
        ':product_id' => $product_id, // Bind the product ID
    ];

    // Execute the query
    $query_execute = $query_run->execute($data);

    // Check if the update was successful
    if ($query_execute) {
        $_SESSION['message'] = "Updated Successfully";
        header('Location: index.php');
        exit; // Use exit instead of die
    } else {
        $_SESSION['message'] = "Update Failed";
        header('Location: index.php');
        exit; // Use exit instead of die
    }
}




if (isset($_POST['delete_product'])) { // Check if the delete button was pressed
    $product_id = $_POST['product_id']; // Assuming you have a hidden input for product ID

    // Prepare the delete query
    $query = "DELETE FROM product_tbl WHERE id = :product_id"; // Make sure 'id' matches your primary key field name

    $query_run = $pdo->prepare($query);

    // Bind the product ID parameter
    $data = [
        ':product_id' => $product_id, // Bind the product ID
    ];

    // Execute the query
    $query_execute = $query_run->execute($data);

    // Check if the delete was successful
    if ($query_execute) {
        $_SESSION['message'] = "Deleted Successfully";
        header('Location: index.php');
        exit; // Use exit instead of die
    } else {
        $_SESSION['message'] = "Deletion Failed";
        header('Location: index.php');
        exit; // Use exit instead of die
    }
}

if (isset($_POST['add_category'])) { // Check if the delete button was pressed
    $category_name = $_POST['category_name']; // Assuming you have a hidden input for product ID

    // Prepare the delete query
    $query = "INSERT INTO category_tbl(category_name) VALUES (:category_name)"; // Make sure 'id' matches your primary key field name

    $query_run = $pdo->prepare($query);

    // Bind the product ID parameter
    $data = [
        ':category_name' => $category_name, // Bind the product ID
    ];

    // Execute the query
    $query_execute = $query_run->execute($data);

    // Check if the delete was successful
    if ($query_execute) {
        $_SESSION['message'] = "Add Successfully";
        header('Location: index.php');
        exit; // Use exit instead of die
    } else {
        $_SESSION['message'] = "Add Failed";
        header('Location: index.php');
        exit; // Use exit instead of die
    }
}

if (isset($_POST['add_cart'])) {
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $product = $_POST['product'];
    $user_id = $_POST['id'];

    $sql = "SELECT quantity FROM product_tbl WHERE product_name = :product_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':product_name' => $product]);

    // Fetch the result as an associative array
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        var_dump($result['quantity']);
        var_dump($qty);
    }
    if ($result['quantity'] >= $qty) {
        $newQty = $result['quantity'] - $qty;

        $sql2 = "UPDATE product_tbl SET quantity = :newQty WHERE product_name = :prod";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([':newQty' => $newQty, ':prod'=> $product]);
        

        $query = "INSERT INTO cart_tbl(product, quantity, price, user_id) VALUES (:product, :qty, :price, :user_id)";
        $query_run = $pdo->prepare($query);

        $data = [
            ':product' => $product,
            ':qty' => $qty,
            ':price' => $price,
            ':user_id' => $user_id,
        ];

        $query_execute = $query_run->execute($data);

        // Check if the delete was successful
        if ($query_execute) {
            $_SESSION['message'] = "Add Cart Successfully";
            header('Location: ../user/index.php');
            exit; // Use exit instead of die
        } else {
            $_SESSION['message'] = "Add Cart Failed";
            header('Location: ../user/index.php');
            exit; // Use exit instead of die
        }
    }else{
        $_SESSION['message'] = "Not enough quantity";
        header('Location: ../user/index.php');
        exit; // Use exit instead of die
}
}

if (isset($_POST['add_order'])) {
    $user_id = $_POST['user_id'];

    // Loop through each cart item
    foreach ($_POST['product'] as $index => $product) {
        $price = $_POST['price'][$index];
        $qty = $_POST['qty'][$index];
        $prod_id = $_POST['prod_id'][$index];

        // Update cart_tbl status to 1 for each product ordered
        $sql2 = "UPDATE cart_tbl SET status = 1 WHERE id = :prod_id";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute([':prod_id' => $prod_id]);

        // Insert into order_tbl
        $query = "INSERT INTO order_tbl(product, quantity, price, user_id) VALUES (:product, :qty, :price, :user_id)";
        $query_run = $pdo->prepare($query);

        $data = [
            ':product' => $product,
            ':qty' => $qty,
            ':price' => $price,
            ':user_id' => $user_id,
        ];

        $query_run->execute($data);
    }

    $_SESSION['message'] = "Order Added Successfully";
    header('Location: ../user/index.php');
    exit;
}
