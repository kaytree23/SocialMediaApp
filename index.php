<!-- index.php -->
 <?php
 $title = "Home";
 include(__DIR__ . '/public/header.php'); 
?>

<main>
    <section class="welcome-section">
        <h1>Welcome to Connect</h1>
        <p>Your hub to post, connect, and grow with your friends.</p>
    </section>

    <section class="features-section">
        <div class="feature">
            <h2>Login</h2>
            <p>Already a member? Sign in to stay Connected.</p>
            <a href="public/login.php" class="button">Login</a>
        </div>

        <div class="feature">
            <h2>Create an Account</h2>
            <p>New here? Join us and start connecting with friends.</p>
            <a href="public/register.php" class="button">Sign Up</a>
        </div>
    </section>
</main>

<?php include(__DIR__ . '/public/footer.php'); ?>
