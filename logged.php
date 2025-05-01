<?php
session_start();

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    // Redirect to the login page if the username is not set
    header("Location: login.php");
    exit();
}
// Assuming you have a database connection established
$servername = "localhost";
$username = "root";
$password = "";
$database = "ck";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission for order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["order"])) {
    // Get the form data
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $unit_price = $_POST['unit_price'];
    $quantity = $_POST['quantity'];
    $total_price = $unit_price * $quantity;

    // Fetch user_id based on the username from the user 
    $username = $_SESSION['username'];
    $userQuery = "SELECT user_id FROM user WHERE first_name = '{$_SESSION['username']}'";
    $userResult = $conn->query($userQuery);

    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $user_id = $userData['user_id'];

        // Insert data into the cart table
        $insertQuery = "INSERT INTO cart (user_id, item_id, item_name, quantity, price) VALUES ('$user_id', '$item_id', '$item_name', '$quantity', '$unit_price')";

        if ($conn->query($insertQuery) === TRUE) {
            header("location: logged.php");
        } else {
            echo '<p>Error adding item to the cart: ' . $conn->error . '</p>';
        }
    } else {
        echo '<p>Error fetching user data.</p>';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["book_table"])) {

        // Insert data into a table named "reservation"
        $tableName = "reservation";

        // Retrieve values from the form using $_POST
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $numberOfGuests = $_POST['guests'];

        $sql = "INSERT INTO $tableName (name, email, phone_number, number_of_guests, date_of_reservation, time_of_reservation)
                VALUES ('$name', '$email', '$phone_number', '$numberOfGuests', '$date', '$time')";

        if ($conn->query($sql) === TRUE) {
            echo "We have successfully reserved your table!";
        } else {
            echo "Error inserting data: " . $conn->error;
        }
}    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/384012e869.js" crossorigin="anonymous"></script>
    <title>CeylonBites</title>
</head>
<body>
    <div class="container">
        <header>
            <h1 style="font-family: 'Playfair Display', serif;;font-size: 50px;">Ceylon Bites</h1>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#menu">Menu</a></li>
                    <li><a href="index.php">Logout</a></li>
                    <li><a href="cart.php">My Cart  <i class="fas fa-shopping-cart"></i></a></li>
                </ul>
            </nav>
        </header>

        <section id="home" class="hero">
            <div class="hero-content">
                <h2>Welcome to Our Online Restaurant</h2>
                <p>Discover the finest dishes prepared with love and passion.</p>
                <a href="#menu" class="cta-button">Explore Menu</a>
            </div>
        </section>
        <h2 style="color: white;text-align: center;margin-top: 80px;">Our Menu</h2>
        
        <section id="menu">
         
                <?php
            // Fetch food items from the database
            $sql = "SELECT * FROM menu";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $currentCategory = ''; // Variable to keep track of the current category

                while ($row = $result->fetch_assoc()) {
                    // Check if the category has changed
                    if ($currentCategory !== $row['category']) {
                        // If yes, close the previous category and start a new one
                        if ($currentCategory !== '') {
                            echo '</div>'; // Close the previous category
                        }

                        // Start a new category
                        echo '<div class="menu-category">';
                        echo '<h3>' . $row['category'] . '</h3>';
                        $currentCategory = $row['category'];
                    }

                    // Generate image path based on food name
                    $imagePath = 'images/' . $row['item_name'] . '.jpg';

                    // Display each food item using a loop
                    echo '<div class="menu-card">';
                    echo '<img src="' . $imagePath . '" alt="' . $row['item_name'] . '" style="width: 100%; height:200px">';
                    echo '<div class="menu-card-content">';
                    echo '<h3>' . $row['item_name'] . '</h3>';
                    echo '<p>' . $row['item_description'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<form method="post" action="" style="margin-top: 10px; display: flex; align-items: center;">';
                    echo '<input type="hidden" name="item_id" value="' . $row['item_id'] . '">';
                    echo '<input type="hidden" name="item_name" value="' . $row['item_name'] . '">';
                    echo '<input type="hidden" name="unit_price" value="' . $row['price'] . '">';
                    echo '<label for="quantity" style="margin-right: 10px;">Quantity:</label>';
                    echo '<input type="number" name="quantity" value="1" min="1" style="width: 60px; padding: 5px; text-align: center; border: 1px solid #ccc; border-radius: 3px;">';
                    echo '<button type="submit" name="order" class="btn-order" style="margin-left: 10px; padding: 8px 15px; background-color: #ff4500; color: white; border: none; border-radius: 5px; cursor: pointer;">Add to Cart</button>';
                    echo '</form>';
                }

                // Close the last category
                echo '</div>';
            } else {
                echo '<p>No food items available.</p>';
            }

            $conn->close();
        ?>



<!-- 

            <div class="menu-category">
                <h3>Appetizers</h3>
                <div class="menu-card">
                    <img src="food.jpg" alt="Food1">
                    <div class="menu-card-content">
                        <h3>Food Name</h3>
                        <p>Description.</p>
                    </div>
                </div>
            </div> -->
        </section>          
       

        <section id="about">
            <h2>About Us</h2>
            <p>
                Welcome to Ceylon Bites, where we bring the authentic flavors of Sri Lanka to your table.
                Our culinary journey is a celebration of the rich heritage and diverse spices that make
                Sri Lankan cuisine truly unique. Every dish is crafted with passion and love, ensuring
                a memorable dining experience for our valued customers.
            </p>
        </section>


        <section id="book-table">
            <h2>Book Your Table</h2>
            <form action="" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
        
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
        
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required>
        
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" required>
        
                <label for="time">Select Time:</label>
                <input type="time" id="time" name="time" required>
        
                <label for="guests">Number of Guests:</label>
                <select id="guests" name="guests" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
        
                </select>
        
                <button type="submit" name = "book_table">Book Now</button>
            </form>
        </section>

        <footer>
            <p>&copy; 2023 Ceylon Bites Restaurant</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>
