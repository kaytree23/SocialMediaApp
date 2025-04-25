<!-- forgot_password.php -->
<h2>Reset Your Password</h2>

<form action="forgot_password.php" method="post">
    <input type="hidden" name="user_action" value="reset_password">
    <label for="email">Email used to register:</label>
    <input type="email" id="email" name="email" required><br><br>

    <button type="submit" class="button">Send Reset Link</button>
</form>