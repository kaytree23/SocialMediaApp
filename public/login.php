<!-- login.php -->
<?php
session_start(); // Start the session to use session variables

include("app/controllers/Login.php"); // Include the Login class
include("config/db.php"); // Include the database connection file

$login = new Login(); // Create an instance of the Login class
$error = ""; // Initialize an error variable

// handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['user_action'] === 'user_login') 
{
    $error = $login->evaluate($_POST);

    if ($error === "") 
    {
        // Redirect to the home page or dashboard after successful login
        header("Location: index.php");
        exit;
    } 
}

$title = "Login"; // Set the page title
include(__DIR__ . '/../shared/header.php');
?>

<div class = "login-container">
    <h2>Login to Connect</h2>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="user_action" value="user_login">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" class="button">Login</button>
    </form>

    <?php if ($error): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class = "links">
        <a href = "forgot_password.php">Forgot your password?</a>
        <a href = "register.php">Don't have an account? Register here</a>
    </div>
</div>

<?php include(__DIR__ . '/../shared/footer.php'); ?>
