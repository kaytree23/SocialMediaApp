<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'Connect' ?></title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="goals.php">My Goals</a></li>
            <li><a href="forum.php">Forum</a></li>
        </ul>

        <div class="user-controls">
            <?php
                if (isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
                    echo '<span class="welcome-message">Welcome back, ' . htmlspecialchars($_COOKIE['user']) . '!</span>';

                    // Logout form
                    echo '<form action="login.php" method="post" style="display:inline;">';
                    echo '<input type="hidden" name="user_action" value="user_logout">';
                    echo '<button type="submit" class="button">Logout</button>';
                    echo '</form>';
                } else {
                    echo '<span class="welcome-message">Welcome, Guest!</span>';

                    // Login form
                    echo '<form action="login.php" method="post" style="display:inline;">';
                    echo '<input type="hidden" name="user_action" value="show_login_form">';
                    echo '<button type="submit" class="button">Login</button>';
                    echo '</form>';
                }
            ?>
        </div>
    </nav>
</header>
