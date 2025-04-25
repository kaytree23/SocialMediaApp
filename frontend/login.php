<!-- login.php -->

<h2>Login to Connect</h2>

<form action="login.php" method="post">
    <input type="hidden" name="user_action" value="user_login">
    <label for="username">Username:</label>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <button type="submit" class="button">Login</button>
</form>

<!--Forgot password link-->
<p style="margin-top: 20px;">
    <a href="forgot_password.php">Forgot your password?</a>
</p>