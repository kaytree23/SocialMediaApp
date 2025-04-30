<!-- forgot_password.php -->

<?php
session_start(); // Start the session to use session variables

include("config/db.php"); // Include the database connection file

$success = "";
$error = ""; 

//password reset logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['user_action'] === 'reset_password') 
{
    $email = trim($_POST['email']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $error = "Enter a valid email address.";
    }

    else
        // Check if the email exists in the database
        {
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $DB = new Database();
            $result = $DB->read($query);
            
            if ($result)
            {
                $success = "A password reset link has been sent to your email.";
            }
            else
            {
                $error = "Email not found.";
            }

        }
}
$title = "Forgot Password";
include(__DIR__ . '/../shared/header.php');
?>

<div class = "login-container">
    <h2>Reset Your Password</h2>

    <form action="forgot_password.php" method="post">
        <input type="hidden" name="user_action" value="reset_password">
        <label for="email">Email used to register:</label>
        <input type="email" id="email" name="email" required><br><br>            
        
        <button type="submit" class="button">Send Reset Link</button>
    </form>

        <?php if ($error): ?>
            <p class = "error-message"><?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p style="color:green;"><?php echo $success; ?></p>
        <?php endif; ?>
    </div>
<?php include(__DIR__ . '/../shared/footer.php'); ?>