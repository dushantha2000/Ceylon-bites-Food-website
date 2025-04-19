<?php
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$database = "ck";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session
session_start();

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $cartItemId = $_POST['cart_id'];

    // Delete the item from the cart table using prepared statement
    $deleteQuery = "DELETE FROM cart WHERE cart_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("s", $cartItemId);

    if ($deleteStmt->execute()) {
        echo '<p>Item deleted from the cart successfully.</p>';
        // Reload the page after deletion
        header("Location: cart.php");
        exit();
    } else {
        echo '<p>Error deleting item from the cart: ' . $conn->error . '</p>';
    }

    // Close the statement
    $deleteStmt->close();
}

// Fetch data from the cart table for the logged-in user
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$sql = "SELECT * FROM cart WHERE user_id = $userId";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cart.css">
    <title>Cart</title>
</head>
<body style="font-family: 'Arial', sans-serif; margin: 0; padding: 0; background: linear-gradient(to right,#320088, #021025);">

    <div class="cart-container">
        <div class="cart-section">
            <h1 class="cart-title">Ordered Items</h1>
            <div class="ordered-items">
                <?php
               
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $imagePath = 'images/' . $row['item_name'] . '.jpg';
                        echo '<div class="ordered-item">';
                        echo '<img style = "width:100px;height:80px"class="detail-img" src="' . $imagePath . '" alt="' . $row['item_name'] . '">';
                        echo '<p>Quantity: ' . $row['quantity'] . '</p>';
                        echo '<p>Item Name: ' . $row['item_name'] . '</p>';
                        echo '<p>Unit Price: Rs. ' . $row['price'] . '</p>';
                        echo '<p>Total Price: Rs. ' . ($row['quantity'] * $row['price']) . '</p>';
                        echo '<form method="post" action="">';
                        echo '<input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">';
                        echo '<button type="submit" name="delete" class="delete-button">Delete</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No items in the cart.</p>';
                }

                // Close the connection
                $conn->close();
                ?>
            </div>
        </div>

        <div class="cart-summary">
            <h2>Order Summary</h2>
            <?php
            // Re-establish the database connection
            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the cart table for the logged-in user
            $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
            $sql = "SELECT SUM(quantity * price) AS total, GROUP_CONCAT(cart_id) AS cart_ids FROM cart WHERE user_id = $userId";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalAmount = $row['total'];
                $cartIds = $row['cart_ids'];
                echo '<p>Total Payable Amount: Rs. ' . $totalAmount . '</p>';
            } else {
                echo '<p>No items in the cart.</p>';
            }
            ?>

            <form method="post" action="">
                <label for="payment">Select Payment Method:</label>
                <select name="payment" id="payment">
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
                <button type="submit" name="submitPayment" style = "background-color: #ff4500;">Confirm Payment</button>
                <a href="logged.php"><button type="button" style = "background-color: #ff4500;">Back To Home</button></a>
                
                
            </form>

            <?php
            // Handle payment submission
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitPayment"])) {
                $selectedPaymentMethod = $_POST['payment'];

                // Insert payment data into the payment table using prepared statement
                $insertPaymentQuery = "INSERT INTO payment (user_id, cart_id, total_payment, payment_type) 
                                       VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($insertPaymentQuery);
                $stmt->bind_param("ssss", $userId, $cartIds, $totalAmount, $selectedPaymentMethod);

                if ($stmt->execute()) {
                    echo '<p>Payment successful!</p>';

                    // Delete existing cart items using prepared statement
                    $deleteCartItemsQuery = "DELETE FROM cart WHERE user_id = ?";
                    $deleteStmt = $conn->prepare($deleteCartItemsQuery);
                    $deleteStmt->bind_param("s", $userId);

                    if ($deleteStmt->execute()) {
                        echo '<p>Cart items deleted successfully.</p>';
                    } else {
                        echo '<p>Error deleting cart items: ' . $conn->error . '</p>';
                    }

                    // Redirect to cart.php
                    header("Location: cart.php");
                    exit();
                } else {
                    echo '<p>Error inserting payment data: ' . $conn->error . '</p>';
                }

                // Close the statement
                $stmt->close();
                $deleteStmt->close();
            }

            // Close the connection after the payment query
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>



