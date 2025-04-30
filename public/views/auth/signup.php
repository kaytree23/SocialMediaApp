<?php 
session_start(); // Start the session to use session variables

include("config/db.php"); // Include the database connection file

$error = ""; // Initialize an error variable
$success = ""; // Initialize a success variable

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['user_action'] === 'user_register') {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $DB = new Database();

        // Check if email is already taken
        $check = $DB->read("SELECT * FROM users WHERE email = '$email' LIMIT 1");
        if ($check) {
            $error = "This email is already registered.";
        } else {
            // Hash the password and insert user
            $hashed_password = sha1($password);
            $userid = rand(10000000000000000, 99999999999999999); // simulate a unique ID like in your DB

            $query = "INSERT INTO users (userid, first_name, last_name, email, password, gender, profile_image, cover_image, date, online, url_address, likes, about, tag_name)
                      VALUES ('$userid', '$first_name', '$last_name', '$email', '$hashed_password', '', '', '', YEAR(CURDATE()), 0, '', 0, '', '')";

            if ($DB->run($query)) {
                $success = "Account created! You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}

$title = "Sign Up"; // Set the page title
include(__DIR__ . '/../shared/header.php');
?>
<div class="login-container">
    <h2>Create an Account</h2>

    <form action="signup.php" method="post">
        <input type="hidden" name="user_action" value="user_register">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="button">Sign Up</button>
    </form>

    <?php if ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p class="success-message"><?php echo $success; ?></p>
    <?php endif; ?>

    <div class="links">
        <a href="login.php">Already have an account? Log in here</a>
    </div>
</div>

<?php include(__DIR__ . '/../shared/footer.php');
